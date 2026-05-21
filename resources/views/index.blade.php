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

@section('recaptcha')
    <?php
    $check_form = \App\Models\PageBlock::where("page_id", $page->id)
        ->whereIn("type", ["blockContact", "blockPluginForm", "blockPluginParking"])
        ->first();
    ?>
    @if($check_form)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"/>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js" defer></script>
        @include('common.recaptcha')
    @endif
@endsection

@section('player_video')
    <?php
    $check_video = \App\Models\PageBlock::where("page_id", $page->id)
        ->whereIn("type", ["blockVideotut", "blockVideobg"])
        ->first();
    ?>
    @if($check_video)
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.3/plyr.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.3/plyr.min.js" defer></script>
    @endif
@endsection

@section('head')
    @include("$theme_view.$inc.head")
@endsection

@section('meta')
    @include("$theme_view.$inc.meta")
@endsection

@if($website->is_online == 1 || backpack_user() || is_numeric(strpos(env('APP_URL'), "stage")))
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    @section('topbar')
        @if($theme_view != "Crafto")
            @include("$theme_view.$inc.topbar")
        @endif
    @endsection

    @section('header_menu')
        @include("$theme_view.$inc.header_menu")
    @endsection

    @section('content_header')
        @include("$theme_view.$inc.content_header")
    @endsection

    @section('content')
        @include("$theme_view.$inc.content")
    @endsection

    @section('content_footer')
        @include("$theme_view.$inc.content_footer")
    @endsection
@else
    @section('topbar')
        @include("$theme_view.$inc.topbar")
    @endsection
    @section('content')
         @include("$theme_view.$inc.content_offline")
    @endsection
@endif


