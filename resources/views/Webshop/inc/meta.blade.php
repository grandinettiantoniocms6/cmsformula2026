@if($page)
    <title>@if($page && trim($page->meta_title != "")) {{ $website->title }} {{ $page->meta_title }} @else {{ $website->title }} @endif</title>

    <meta property="og:title" content="@if($page && trim($page->meta_title != "")) {{ $website->title }} {{ $page->meta_title }} @else {{ $website->title }} @endif" />
    <meta property="og:url" content="{{ env('APP_URL') }}<?php echo $_SERVER['REQUEST_URI'];?>" />

    @if($website->favicon)
        <meta property="og:image" content="{{ url("$website->favicon") }}" />
    @endif

    @if($page && trim($page->meta_description) != "")
        <meta name="description" content="{{ $page->meta_description }}">
        <meta property="og:description" content="{{ $page->meta_description }}" />
    @else
        <meta name="description" content="{{ $website->meta_description }}">
        <meta property="og:description" content="{{ $website->meta_description }}" />
    @endif
    @if($page && (trim($page->meta_keywords) != ""))
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @else
        <meta name="keywords" content="{{ $website->meta_keywords }}">
    @endif

    <meta property="og:type" content="website" />

@endif

@if(is_numeric(strpos(env('APP_URL'), "stage")) || is_numeric(strpos(env('APP_URL'), "dev")))
    <meta name="robots" content="noindex, nofollow">
@else
    <meta name="robots" content="index, follow">
@endif






