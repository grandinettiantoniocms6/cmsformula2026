<?php
$adminPluginProducts = \App\Models\AdminPlugin::where("name", "pluginProducts")
    ->where("version", 3)
    ->where("is_active", 1)
    ->first();


$adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();

if($adminPluginProducts){
    $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
}

if($adminPluginBooking){
    $labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
}
?>


<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h3>{{ @$labels['shop-myarea-mio-account'] }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="bi bi-chevron-left d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['shop-myarea-title-area-personale'] }}</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-4">
    <div class="container">

        <div class="row">
            <aside class="col-12 col-xl-3">
                @include("$thema.inc.myarea_menu")
            </aside>
            <div class="col-12 col-xl-9">
                <div class="card card-myarea">
                    <div class="card-header">
                        <h5>{{ @$labels['shop-tua-area-personale'] }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="py-4 text-center">
                            <div class="display-4 text-muted"><i class="fas fa-home"></i></div>
                            <h5 class="mb-4">{{ @$labels['shop-felice-di-rivederti'] }}</h5>

                            @if($adminPluginProducts)
                                <a class="btn btn-primary" href="{{ route('index') }}">{{ @$labels['shop-myarea-button-homepage'] }}</a>
                            @endif

                            @if($adminPluginBooking)
                                <a class="btn btn-primary" href="{{ route('index') }}">{{ @$labels['booking-myarea-prenota-la-tua-vacanza'] }}</a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
