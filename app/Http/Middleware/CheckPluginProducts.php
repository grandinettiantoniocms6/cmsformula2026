<?php

namespace App\Http\Middleware;

use App\Models\AdminPlugin;
use App\Models\ShopSettings;
use App\User;
use Closure;

class CheckPluginProducts
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        if($adminPlugin->version == 3){
            $shopSetting = ShopSettings::first();
            if($shopSetting->visitors_buy == 0){
                if(!\Session::has('user_id')){
                    return redirect()->to("/");
                }
            }
        }
        return $next($request);
    }
}
