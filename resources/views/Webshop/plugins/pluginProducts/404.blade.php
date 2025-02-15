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
        <section class="page-title bg-overlay-black-60 parallax" data-jarallax="{&quot;speed&quot;: 0.6}"
                @if($plugin->image)
                     style="background-image: url({{ url($plugin->image) }});"
                @endif
        >
            <div class="container-fluid container-2xl">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title-name">
                            <h1>{{ $plugin->title }}</h1>
                            <p>{{ $plugin->subtitle }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="shop grid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        {!! $plugin->no_results !!}
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


