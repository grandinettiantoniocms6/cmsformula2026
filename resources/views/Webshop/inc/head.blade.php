<?php
//serve per leggere le label da amdin
$labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="CMS-Formula 5.0 by Webisland.it" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta property="og:locale" content="it_IT">
<meta property="og:site_name" content="Webshop" />
<meta property="fb:app_id" content="" />
@if($website->favicon)
    <link rel="shortcut icon" href="{{ url("$website->favicon") }}" />
@endif



<link href="{{ url("templates/Webshop/css/style.css") }}" rel="stylesheet">

@if($website->style_css || $website->custom_css)
    @if($website->style_css)
        <link rel="stylesheet" type="text/css" href="{{ url("$website->style_css") }}" />
    @endif
    @if($website->custom_css)
        <link rel="stylesheet" type="text/css" href="{{ url("$website->custom_css") }}" />
    @endif
@endif
