<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
        if(env('LOCAL') == 0 && env('MAIL_PASSWORD') != ""){
            $vet = ["", "The GET method is not supported for this route. Supported methods: POST.",
                "The given data was invalid.", "CSRF token mismatch.",
                "The GET method is not supported for this route. Supported methods: PUT, DELETE.",
                "The POST method is not supported for this route. Supported methods: GET, HEAD."];
            if(!in_array(trim($exception->getMessage()), $vet)){
                if(!is_numeric(strpos($exception->getMessage(), "Supported methods")) && !is_numeric(strpos($exception->getMessage(), "not supported")) && !is_numeric(strpos($exception->getMessage(), "Unauthenticated"))){
                    try{
                        \Mail::send('common.emails.error', ['error' => $exception->getMessage(), 'file' => $exception->getFile(), 'line' => $exception->getLine(), 'store' => "", 'trace' =>  $exception->getTraceAsString(), 'url' => \Request::url()], function ($m) use ($exception) {
                            $m->from("info@cmsformula5.it", "CMSFORMULA5");
                            $m->to('info@webisland.it', 'Webisland')
                                ->cc('keivantg@gmail.com', 'Webisland')
                                ->subject("Errore CMSFORMULA {$exception->getMessage()}");
                        });
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
}
