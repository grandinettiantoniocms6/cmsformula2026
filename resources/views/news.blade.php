<?php
$thema = env('TEMA');
$admin_template = \App\Models\AdminTemplate::where("name", $thema)->first();
if (!$admin_template && $thema) {
    $admin_template = \App\Models\AdminTemplate::whereRaw('LOWER(name) = ?', [strtolower($thema)])->first();
}
$theme_view = $admin_template ? $admin_template->name : $thema;

$inc = "inc";
if($admin_template && $admin_template->inc){
    $inc = $admin_template->inc;
}
?>
@extends("$theme_view.layout")

@section('head')
    @include("$theme_view.$inc.head")
@endsection

@if($website->is_online == 1 || backpack_user() || is_numeric(strpos(env('APP_URL'), "stage")))
    @section('topbar')
        @if($theme_view != "Crafto")
            @include("$theme_view.$inc.topbar")
        @endif
    @endsection

    @section('topbar_ecommerce')
        @include("$theme_view.$inc.topbar_ecommerce")
    @endsection

    @section('header_menu')
        @include("$theme_view.$inc.header_menu")
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
            @include("$theme_view.$inc.content_header")
        @endif

    @endsection

    @section('content')
        @include("$theme_view.news")
    @endsection

    @section('content_footer')
        @include("$theme_view.$inc.content_footer")
    @endsection
@else
    @include("$theme_view.$inc.content_offline")
@endif


