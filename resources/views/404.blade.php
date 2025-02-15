<?php $thema = env('TEMA'); ?>
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
        <section class="p-0 cover-background wow animate__fadeIn" >
            <div class="container">

                <div class="row align-items-stretch justify-content-center full-screen">
                    <div class="col-12 col-xl-6 col-lg-7 col-md-8 text-center d-flex align-items-center justify-content-center flex-column">
                        <h6 class="alt-font text-fast-blue font-weight-600 letter-spacing-minus-1px margin-10px-bottom text-uppercase">Ooops!</h6>
                        <h1 class="alt-font text-extra-big font-weight-700 letter-spacing-minus-5px text-extra-dark-gray margin-6-rem-bottom md-margin-4-rem-bottom">
                            <img src="img/commons/front/404.jpg">
                        </h1>
                        <span class="alt-font font-weight-500 text-extra-dark-gray d-block margin-20px-bottom">Pagina non trovata!</span>
                        <a href="/" class="btn btn-large btn-gradient-sky-blue-pink">Torna alla home</a>
                    </div>
                </div>


            </div>
        </section>
    @endsection

    @section('content_footer')
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif


