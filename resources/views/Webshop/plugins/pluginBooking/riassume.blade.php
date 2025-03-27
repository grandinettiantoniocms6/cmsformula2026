<?php
$thema = env('TEMA');
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
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

    @section('topbar_ecommerce')
        @include("$thema.inc.topbar_ecommerce")
    @endsection

    @section('header_menu')
        @include("$thema.inc.header_menu")
    @endsection

    @section('content')
        <section class="page-title-block image-wrapper bg-overlay bg-overlay-black-60 jarallax block-parallax py-5" @if($plugin->image_height) style="--page-title-height: {{ $plugin->image_height }}px;" @endif>
            @if($plugin->image)
                <img class="jarallax-img" src="{{ url($plugin->image) }}" alt="{{ $plugin->title }}" @if($plugin->image_height) height="{{ $plugin->image_height }}" @endif width="auto">
            @endif
            <div class="container-fluid container-2xl">
                <h1 class="page-title">{{ $plugin->title }}</h1>
                <div  class="page-subtitle">{{ $plugin->subtitle }}</div>
            </div>
        </section>

        <section class="page-shop">
            <div class="container-fluid container-2xl">
                <?php
                $start_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->start);

                $diff_day = 1;
                if($session->end){
                    $end_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->end);
                    $diff_day = $start_carbon->diffInDays($end_carbon);
                    if($diff_day == 0){
                        $diff_day = 1;
                    }
                }

                $type = \App\Models\PluginBookingType::find($session->type);
                if($type->id == env('ID_TIPOLOGIA_MIN_MAX_GIORNI')){
                    $diff_day = 1;
                }

                //$tot = $session->total * $diff_day;
                $tot = $session->total;
                ?>
                @include('Webshop.plugins.pluginBooking.inc.box_riassume')

                @include('Webshop.plugins.pluginBooking.inc.box_payments')

            </div>
        </section>
    @endsection

    @section('content_footer')
        <?php $page = \App\Models\Page::where("is_homepage", 1)->where("is_active", 1)->first(); ?>
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif

@section('after_scripts')
<script>
    function box_invoice(){
        $("#box_invoice").removeClass("d-none");
    }
</script>
@endsection
