@php($thema = config('theme.name'))

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
        @if(env('TEMA') == "Webshop")
            @include("$thema.plugins.pluginProducts.v3.recoveryPassword")
        @else
            @include("common.pluginProducts.recoveryPassword")
        @endif

        @include("$thema.inc.content")
    @endsection

    @section('content_footer')
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif


