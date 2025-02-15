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

    @section('content_header')
        @include("$thema.inc.content_header")
    @endsection

    @section('content')
    <div class="container">
        <div class="row icon-5xl text-center">
            <h3>Ci sono {{ count($blocks) }} per la parola {{ $s }}</h3>
            <div class="col-12 col-md-12">
                @if($blocks)
                    @foreach($blocks as $block)
                        <p><a href="/{{ $block->slug_page['it'] }}">{{ $block->title_page['it'] }}</a></p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @endsection

    @section('content_footer')
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif


