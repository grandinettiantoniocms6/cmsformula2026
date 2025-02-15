<?php $thema = env('TEMA'); ?>
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
?>
@extends("$thema.layout")

@section('head')
    @include("$thema.inc.head")
@endsection

@section('meta')
    @include("$thema.inc.meta")
@endsection

@if($website->is_online == 1 || backpack_user() || is_numeric(strpos(env('APP_URL'), "stage")))
    @section('topbar')
        @include("$thema.inc.topbar")
    @endsection

    @section('header_menu')
        @include("$thema.inc.header_menu")
    @endsection

    @section('content_header')
        @if($page === null)
            <section class="page-title bg-overlay-black-60 parallax" data-jarallax='{"speed": 0.6}' style="background-image: url({{ url('img/header_vuota.jpg') }});">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-title-name">
                                <h2 class="text-extra-dark-gray alt-font font-weight-500 letter-spacing-minus-1px line-height-50 sm-line-height-45 xs-line-height-30 no-margin-bottom">News</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            @include("$thema.inc.content_header")
        @endif

    @endsection

    @section('content')
        @if($thema == "Webshop")
            @include("$thema.myarea.dashboard")
        @else
            @include("common.pluginProducts.myarea.dashboard")
        @endif

        @include("$thema.inc.content")
    @endsection

    @section('content_footer')
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif


