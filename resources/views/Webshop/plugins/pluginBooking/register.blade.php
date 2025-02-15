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



        <?php
        $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
        $labelsBook = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
        ?>
        <section class="page-login flex-grow-1">
            <div class="container-fluid container-2xl">
                <div class="row">

                    <div class="alert alert-warning text-center">
                        <div class="display-5"><i class="bi bi-info-circle"></i></div>
                        <h5 class="my-3 text text-black">{{ @$labelsBook['booking-controlla-email'] }}</h5>
                    </div>

                    <div class="col-lg-12 mx-auto">
                        <div class="card card-login">
                            <div class="card-body">
                                <h3 class="text-center mb-1">{{ @$labels['shop-title-login'] }}</h3>
                                <h6 class="text-center mb-4">{{ @$labels['shop-sottotitolo-login'] }}</h6>

                                @if ($errors->any())
                                    <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(session()->has('message'))
                                    <div class="alert alert-success text-center">
                                        <div class="display-4"><i class="bi bi-check"></i></div>
                                        <h5>{{ session()->get('message') }}</h5>
                                    </div>
                                @endif

                                @if(session()->has('noUser'))
                                    <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                        {{ session()->get('noUser') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form id="login-form" method="post" action="{{ route('index.loginProcess') }}" class="form-validate">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label for="email" class="form-label">{{ @$labels['shop-email-login'] }}</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-label">{{ @$labels['shop-password-login'] }}</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                                            <span class="input-group-text pointer bg-transparent"><i id="icon_password" class="fas fa-eye-slash" onclick="nascondi_password('#password', '#icon_password')"></i></span>
                                        </div>
                                    </div>

                                    <div class="form-group d-flex justify-content-between">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                                            <label class="form-check-label" for="remember">{{ @$labels['shop-ricorda-login'] }}</label>
                                        </div>
                                        <a href="{{ route('recovery_password') }}">{{ @$labels['shop-password-dimenticata'] }}</a>
                                    </div>

                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">{{ @$labels['shop-login'] }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
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

@endsection
