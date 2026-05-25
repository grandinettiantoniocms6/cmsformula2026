<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\PluginProductImportCrudController;
use App\Models\PluginProductImportRun;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
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
        $this->startStep($run, 'import');

        try {
            $response = (new PluginProductImportCrudController())->processQueuedImport($run);
            $data = $response->getData(true);

            if ($response->getStatusCode() >= 400) {
                throw new \RuntimeException($data['message'] ?? 'Errore durante l\'elaborazione del file.');
            }

            if ($data['cancelled'] ?? false) {
                $this->markCancelled($run);
                return;
            }

            $this->completeStep($run, 'import');
            if ($this->cancellationRequested($run)) {
                $this->markCancelled($run);
                return;
            }

            $this->runProductsSearchStep($run);
            if ($this->cancellationRequested($run)) {
                $this->markCancelled($run);
                return;
            }

            $this->runCategoriesSearchStep($run);

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
            $run->steps()->where('status', 'processing')->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => mb_substr($exception->getMessage(), 0, 1000),
            ]);
            $run->steps()->where('status', 'queued')->update([
                'status' => 'cancelled',
                'completed_at' => now(),
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
            $run->steps()->where('status', 'processing')->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => mb_substr($exception->getMessage(), 0, 1000),
            ]);
            $run->steps()->where('status', 'queued')->update([
                'status' => 'cancelled',
                'completed_at' => now(),
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
        $run->steps()->whereIn('status', ['queued', 'processing', 'cancelling'])->update([
            'status' => 'cancelled',
            'completed_at' => now(),
            'error_message' => null,
        ]);
        Storage::disk('public_plugin_products')->delete($run->file_path);
    }

    private function runProductsSearchStep(PluginProductImportRun $run)
    {
        $this->startStep($run, 'products_search');
        $ids = json_decode((string) $run->fresh()->imported_product_ids, true) ?: [];
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));

        if (count($ids) > 0) {
            $exitCode = Artisan::call('set:products_search', [
                'id' => 0,
                '--ids' => implode(',', $ids),
            ]);
        } else {
            $exitCode = Artisan::call('set:products_search', ['id' => 0]);
        }

        if ($exitCode !== 0) {
            throw new \RuntimeException('Aggiornamento indice prodotti terminato con errore.');
        }

        $this->completeStep($run, 'products_search');
    }

    private function runCategoriesSearchStep(PluginProductImportRun $run)
    {
        $this->startStep($run, 'categories_search');
        $exitCode = Artisan::call('set:products_categories_search');
        if ($exitCode !== 0) {
            throw new \RuntimeException('Aggiornamento indice categorie terminato con errore.');
        }

        $this->completeStep($run, 'categories_search');
    }

    private function startStep(PluginProductImportRun $run, $type)
    {
        $attributes = [
            'status' => 'processing',
            'started_at' => now(),
            'error_message' => null,
        ];

        if ($type !== 'import') {
            $attributes['total_rows'] = 1;
            $attributes['processed_rows'] = 0;
        }

        $run->steps()->where('step_type', $type)->update($attributes);
    }

    private function completeStep(PluginProductImportRun $run, $type)
    {
        $attributes = [
            'status' => 'completed',
            'completed_at' => now(),
            'error_message' => null,
        ];

        if ($type !== 'import') {
            $attributes['total_rows'] = 1;
            $attributes['processed_rows'] = 1;
        }

        $run->steps()->where('step_type', $type)->update($attributes);
    }

    private function cancellationRequested(PluginProductImportRun $run)
    {
        return in_array($run->fresh()->status, ['cancelling', 'cancelled']);
    }
}
