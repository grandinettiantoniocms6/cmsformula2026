<?php
$thema = env('TEMA');
$admin_template = \App\Models\AdminTemplate::where("name", $thema)->first();

$inc = "inc";
if($admin_template->inc){
    $inc = $admin_template->inc;
}

?>
@extends("$thema.layout")

@section('recaptcha')
    <?php
    $check_form = \App\Models\PageBlock::where("page_id", $page->id)
        ->whereIn("type", ["blockPluginForm", "blockPluginParking"])
        ->first();
    ?>
    @if($check_form)
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
    @include("$thema.$inc.head")
@endsection

@section('meta')
    @include("$thema.$inc.meta")
@endsection

@if($website->is_online == 1 || backpack_user() || is_numeric(strpos(env('APP_URL'), "stage")))
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    @section('topbar')
        @if($thema != "Crafto")
            @include("$thema.$inc.topbar")
        @endif
    @endsection

    @section('header_menu')
        @include("$thema.$inc.header_menu")
    @endsection

    @section('content_header')
        @include("$thema.$inc.content_header")
    @endsection

    @section('content')
        @include("$thema.$inc.content")
    @endsection

    @section('content_footer')
        @include("$thema.$inc.content_footer")
    @endsection
@else
    @section('topbar')
        @include("$thema.$inc.topbar")
    @endsection
    @section('content')
         @include("$thema.$inc.content_offline")
    @endsection
@endif


