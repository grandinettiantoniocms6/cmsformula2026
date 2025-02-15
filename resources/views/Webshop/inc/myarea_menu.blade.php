<?php
$shopSetting = \App\Models\ShopSettings::first();
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$adminPluginProducts = \App\Models\AdminPlugin::where("name", "pluginProducts")
    ->where("version", 3)
    ->where("is_active", 1)->first();
$adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();

if($adminPluginProducts){
    $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
}

if($adminPluginBooking){
    $labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
}

$role = \DB::table('model_has_roles')->where("model_id", \Auth::user()->id)->first();
?>

<nav class="nav nav-sidebar">
    <a class="nav-link" href="{{ route('myarea.dashboard') }}">
        <i class="bi bi-house"></i>
        <span>{{ @$labels['shop-myarea-title-area-personale'] }}</span>
    </a>

    @if($role)
        @if($role->role_id == 7)
            <a class="nav-link" href="/admin">
                <i class="bi bi-house"></i>
                <span>{{ @$labels['shop-myarea-title-area-riservata'] }}</span>
            </a>
        @endif
    @endif

    <a class="nav-link" href="{{ route('myarea.profile') }}">
        <i class="bi bi-person-fill"></i>
        <span>{{ @$labels['shop-myarea-mio-account'] }}</span>
    </a>
    @if($adminPluginProducts)
        <a class="nav-link" href="{{ route('myarea.orders') }}">
            <i class="bi bi-cart-check"></i>
            <span>{{ @$labels['shop-myarea-ordini'] }}</span>
        </a>

        @if($shopSetting->is_subscriptions)
            <a class="nav-link" href="{{ route('myarea.subscriptions') }}">
                <i class="bi bi-cart-check"></i>
                <span>{{ @$labels['shop-myarea-abbonamenti'] }}</span>
            </a>
        @endif

        <a class="nav-link" href="{{ route('myarea.wishlist') }}">
            <i class="bi bi-heart"></i>
            <span>{{ @$labels['shop-myarea-whishlist'] }}</span>
        </a>
        <a class="nav-link" href="{{ route('myarea.addresses') }}">
            <i class="bi bi-truck"></i>
            <span>{{ @$labels['shop-myarea-indirizzi'] }}</span>
        </a>
        <a class="nav-link" href="{{ route('myarea.companies') }}">
            <i class="bi bi-receipt"></i>
            <span>{{ @$labels['shop-myarea-fatturazione'] }}</span>
        </a>
        <a class="nav-link" href="{{ route('myarea.support') }}">
            <i class="bi bi-life-preserver"></i>
            <span>{{ @$labels['shop-myarea-assistenza'] }}</span>
        </a>

        <a class="nav-link" href="/logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>{{ @$labels['shop-myarea-esci'] }}</span>
        </a>
    @endif

    @if($adminPluginBooking)
        <a class="nav-link" href="{{ route('myarea.reservations') }}">
            <i class="bi bi-cart-check"></i>
            <span>{{ @$labels['booking-myarea-le-mie-prenotazioni'] }}</span>
        </a>

        <a class="nav-link" href="/logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>{{ @$labels['booking-myarea-esci'] }}</span>
        </a>
    @endif


</nav>
