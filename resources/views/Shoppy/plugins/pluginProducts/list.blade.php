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

    @section('header_menu')
        @include("$thema.inc.header_menu")
    @endsection

    @section('content')
        <section class="page-title bg-overlay-black-30 parallax" data-jarallax="{&quot;speed&quot;: 0.6}"
                 @if($plugin->image)
                 style="background-image: url({{ url($plugin->image) }});"
                 @endif
        >
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title-name">
                            <h1>{{ $plugin->title }}</h1>
                            <p>{{ $plugin->subtitle }}</p>
                            @if($category)
                                <p>{{ $category->name }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="shop grid py-4 py-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3" id="sidebar-shop">
                        {{--@include("$thema.plugins.pluginProducts.inc.sidebar")--}}
                        @include("common.pluginProducts.inc.sidebar")
                    </div>
                    <div class="col-lg-9">
                        {{--@include("$thema.plugins.pluginProducts.inc.productList")--}}
                        @include("common.pluginProducts.inc.productList")

                        @include("$thema.plugins.pluginProducts.inc.brands")
                    </div>
                </div>
            </div>
        </section>
    @endsection

    @section('content_footer')
        <?php  $page = \App\Models\Page::where("is_homepage", 1)->where("is_active", 1)->first(); ?>
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif

@section('after_scripts')
@endsection
