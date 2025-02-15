<?php

namespace App\Http\Middleware;

use App\Models\AdminPlugin;
use App\Models\ShopSettings;
use App\User;
use Closure;

class CheckPluginBooking
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
        $adminPlugin = AdminPlugin::where("name", "pluginBookings")->first();
        if(!$adminPlugin){
            return redirect()->to("/");
        }

        if($adminPlugin->is_active == 0){
            return redirect()->to("/");
        }
        return $next($request);
    }
}
