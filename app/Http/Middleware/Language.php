<?php
namespace App\Http\Middleware;

use App\Models\AdminLanguage;
use App\User;
use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Language
{
    public function handle($request, Closure $next)
    {
        $adminLang = AdminLanguage::where("is_active", 1)->get()->pluck("label", "name")->toArray();
        if (Session::has('applocale') AND array_key_exists(Session::get('applocale'), $adminLang)) {
            App::setLocale(Session::get('applocale'));
        }
        else { // This is optional as Laravel will automatically set the fallback language if there is none specified
            if(\Session::has('user_id')){
                $user = User::find(Session::get('user_id'));
                if($user){
                    if($user->country_id && $user->country_id != config('config.default_country_user_it')){
                        App::setLocale("en");
                        return $next($request);
                    }
                }
            }
          //  App::setLocale(Config::get('app.fallback_locale'));
        }
        return $next($request);
    }
}
