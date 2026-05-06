<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Sentry\Laravel\Facade as Sentry;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        // Invia a Sentry solo se è un errore da riportare e Sentry è attivo
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            Sentry::captureException($exception);
        }

        if(env('LOCAL') == 0 && env('MAIL_PASSWORD') != ""){
            $vet = ["", "The GET method is not supported for this route. Supported methods: POST.",
                "The given data was invalid.", "CSRF token mismatch.",
                "The GET method is not supported for this route. Supported methods: PUT, DELETE.",
                "The POST method is not supported for this route. Supported methods: GET, HEAD."];

            if(!in_array(trim($exception->getMessage()), $vet)){
                if(!is_numeric(strpos($exception->getMessage(), "Supported methods"))
                    && !is_numeric(strpos($exception->getMessage(), "not supported"))
                    && !is_numeric(strpos($exception->getMessage(), "Unauthenticated"))
                    && !is_numeric(strpos($exception->getMessage(), "Autenticazione"))
                    && !is_numeric(strpos($exception->getMessage(), "Too many login"))
                    && !is_numeric(strpos($exception->getMessage(), "The route"))
                ){
                    try{
                        $errorAlertRecipients = $this->getErrorAlertRecipients();

                        if (!$errorAlertRecipients['enabled']) {
                            parent::report($exception);
                            return;
                        }

                        if (!$this->shouldSendErrorAlert($exception, $errorAlertRecipients['repeat_hours'])) {
                            parent::report($exception);
                            return;
                        }

                        \Mail::send('common.emails.error', ['error' => $exception->getMessage(), 'file' => $exception->getFile(), 'line' => $exception->getLine(), 'store' => "", 'trace' =>  $exception->getTraceAsString(), 'url' => \Request::url()], function ($m) use ($exception, $errorAlertRecipients) {
                            $m->from("info@cmsformula5.it", "CMSFORMULA 6");
                            $m->to($errorAlertRecipients['to'], 'Webisland')
                                ->subject("BUG CMSFORMULA 6 {$exception->getMessage()}");

                            if (count($errorAlertRecipients['cc'])) {
                                $m->cc($errorAlertRecipients['cc']);
                            }
                        });

                        $this->markErrorAlertAsSent($exception, $errorAlertRecipients['repeat_hours']);
                    }catch (\Throwable $e) {

                    }
                }
            }
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }

    private function getErrorAlertRecipients(): array
    {
        $recipients = [
            'to' => 'info@webisland.it',
            'cc' => [],
            'repeat_hours' => 4,
            'enabled' => true,
        ];

        try {
            if (!\Schema::hasTable('website_setting_extras')) {
                return $recipients;
            }

            $columns = ['error_alert_email', 'error_alert_cc'];
            if (\Schema::hasColumn('website_setting_extras', 'error_alert_repeat_hours')) {
                $columns[] = 'error_alert_repeat_hours';
            }
            if (\Schema::hasColumn('website_setting_extras', 'error_alert_enabled')) {
                $columns[] = 'error_alert_enabled';
            }

            $extra = \DB::table('website_setting_extras')
                ->orderBy('website_setting_id')
                ->first($columns);

            if (!$extra) {
                return $recipients;
            }

            if (filter_var($extra->error_alert_email, FILTER_VALIDATE_EMAIL)) {
                $recipients['to'] = $extra->error_alert_email;
            }

            $recipients['cc'] = collect(explode(',', (string) $extra->error_alert_cc))
                ->map(function ($email) {
                    return trim((string) $email);
                })
                ->filter(function ($email) {
                    return filter_var($email, FILTER_VALIDATE_EMAIL);
                })
                ->values()
                ->all();

            if (isset($extra->error_alert_repeat_hours) && (int) $extra->error_alert_repeat_hours > 0) {
                $recipients['repeat_hours'] = (int) $extra->error_alert_repeat_hours;
            }

            if (isset($extra->error_alert_enabled)) {
                $recipients['enabled'] = (bool) $extra->error_alert_enabled;
            }
        } catch (\Throwable $e) {
            return $recipients;
        }

        return $recipients;
    }

    private function shouldSendErrorAlert(Throwable $exception, int $repeatHours): bool
    {
        try {
            return !\Cache::has($this->errorAlertCacheKey($exception));
        } catch (\Throwable $e) {
            return true;
        }
    }

    private function markErrorAlertAsSent(Throwable $exception, int $repeatHours): void
    {
        try {
            \Cache::put($this->errorAlertCacheKey($exception), now()->toDateTimeString(), now()->addHours(max(1, $repeatHours)));
        } catch (\Throwable $e) {
        }
    }

    private function errorAlertCacheKey(Throwable $exception): string
    {
        return 'cmsformula_error_alert_sent_' . sha1(
            $exception->getMessage() . '|' . $exception->getFile() . '|' . $exception->getLine()
        );
    }
}
