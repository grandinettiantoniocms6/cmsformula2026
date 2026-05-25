<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\PluginProductImportCrudController;
use App\Models\PluginProductImportRun;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProcessPluginProductImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 7200;

    private $runId;

    public function __construct($runId)
    {
        $this->runId = (int) $runId;
    }

    public function handle()
    {
        $run = PluginProductImportRun::find($this->runId);
        if (!$run) {
            return;
        }

        if (in_array($run->status, ['cancelling', 'cancelled'])) {
            $this->markCancelled($run);
            return;
        }

        $started = PluginProductImportRun::whereKey($run->id)->where('status', 'queued')->update([
            'status' => 'processing',
            'started_at' => now(),
            'error_message' => null,
        ]);
        if (!$started) {
            $run = PluginProductImportRun::find($this->runId);
            if (!$run) {
                return;
            }
            if (in_array($run->status, ['cancelling', 'cancelled'])) {
                $this->markCancelled($run);
            }
            return;
        }
        $run->refresh();

        try {
            $response = (new PluginProductImportCrudController())->processQueuedImport($run);
            $data = $response->getData(true);

            if ($response->getStatusCode() >= 400) {
                throw new \RuntimeException($data['message'] ?? 'Errore durante l\'elaborazione del file.');
            }

            if (($data['cancelled'] ?? false) || in_array($run->fresh()->status, ['cancelling', 'cancelled'])) {
                $this->markCancelled($run);
                return;
            }

            $run->refresh()->update([
                'status' => 'completed',
                'completed_at' => now(),
                'error_message' => null,
            ]);
            Storage::disk('public_plugin_products')->delete($run->file_path);
        } catch (Throwable $exception) {
            $run->refresh()->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => mb_substr($exception->getMessage(), 0, 1000),
            ]);

            throw $exception;
        }
    }

    public function failed(Throwable $exception)
    {
        $run = PluginProductImportRun::find($this->runId);
        if ($run && $run->status !== 'failed') {
            $run->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => mb_substr($exception->getMessage(), 0, 1000),
            ]);
        }
    }

    private function markCancelled(PluginProductImportRun $run)
    {
        $run->refresh()->update([
            'status' => 'cancelled',
            'completed_at' => now(),
            'error_message' => null,
        ]);
        Storage::disk('public_plugin_products')->delete($run->file_path);
    }
}
