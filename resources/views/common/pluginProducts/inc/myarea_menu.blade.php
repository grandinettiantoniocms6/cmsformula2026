<?php
$shopSetting = \App\Models\ShopSettings::first();
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>

<nav class="nav flex-lg-column nav-sidebar">
    <a class="nav-link" href="{{ route('myarea.dashboard') }}">
        <i class="fa fa-user"></i>
        <span class="mx-2 d-none d-lg-inline">{{ @$labels['shop-myarea-mio-account'] }}</span>
    </a>
    <a class="nav-link" href="{{ route('myarea.orders') }}">
        <i class="fas fa-cart-arrow-down"></i>
        <span class="mx-2 d-none d-lg-inline">{{ @$labels['shop-myarea-ordini'] }}</span>
    </a>
    <a class="nav-link" href="{{ route('myarea.wishlist') }}">
        <i class="fas fa-heart"></i>
        <span class="mx-2 d-none d-lg-inline">{{ @$labels['shop-myarea-whishlist'] }}</span>
    </a>
    <a class="nav-link" href="{{ route('myarea.addresses') }}">
        <i class="fas fa-truck"></i>
        <span class="mx-2 d-none d-lg-inline">{{ @$labels['shop-myarea-indirizzi'] }}</span>
    </a>
    <a class="nav-link" href="{{ route('myarea.companies') }}">
        <i class="fas fa-file-invoice-dollar"></i>
        <span class="mx-2 d-none d-lg-inline">{{ @$labels['shop-myarea-fatturazione'] }}</span>
    </a>
    <a class="nav-link" href="{{ route('myarea.support') }}">
        <i class="fas fa-life-ring"></i>
        <span class="mx-2 d-none d-lg-inline">{{ @$labels['shop-myarea-assistenza'] }}</span>
    </a>
    <a class="nav-link" href="/logout">
        <i class="fas fa-sign-out-alt"></i>
        <span class="mx-2 d-none d-lg-inline">{{ @$labels['shop-myarea-esci'] }}</span>
    </a>
</nav>