<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="CMS-Formula 5.0 by Webisland.it" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!-- Favicon -->
@if($website->favicon)
<link rel="shortcut icon" href="{{ url("$website->favicon") }}" />
@endif
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- font -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
<!-- CSS -->
<link rel="stylesheet" href="{{ url("templates/Crafto/css/vendors.min.css") }}"/>
<link rel="stylesheet" href="{{ url("templates/Crafto/css/icon.min.css") }}"/>
<link rel="stylesheet" href="{{ url("templates/Crafto/css/style.css") }}"/>
<link rel="stylesheet" href="{{ url("templates/Crafto/css/responsive.css") }}"/>

<!-- CSS Common Form contact -->
@if($website->form_contact)
    <link rel="stylesheet" type="text/css" href="{{ url("$website->form_contact") }}" />
@else
    <link rel="stylesheet" type="text/css" href="{{ url("css_common/form_contact.css") }}" />
@endif
<!-- Responsive -->
@if($website->resposive_css)
    <link rel="stylesheet" type="text/css" href="{{ url("$website->responsive_css") }}" />
@endif

<!-- Prima vanno messi i css style e tipografy del tema e poi metto questa regola qui sotto che carica i Font Color Style css di Crafto da admin -->
@if($website->style_css || $website->custom_css)
    @if($website->style_css)
        <link rel="stylesheet" type="text/css" href="{{ url("$website->style_css") }}" />
    @endif
    @if($website->custom_css)
        <link rel="stylesheet" type="text/css" href="{{ url("$website->custom_css") }}" />
    @endif
@endif

<!-- WhatsApp Widget -->
@if($website->wapp_css1)
    <link rel="stylesheet" type="text/css" href="{{ url("$website->wapp_css1") }}" />
@else
    <link rel="stylesheet" type="text/css" href="{{ url("css_common/whatsapp/css/wapp.css") }}" />
@endif
@if($website->wapp_css2)
    <link rel="stylesheet" type="text/css" href="{{ url("$website->wapp_css2") }}" />
@else
    <link rel="stylesheet" type="text/css" href="{{ url("css_common/whatsapp/plugin/whatsapp-chat-support.css") }}" />
@endif

@if($website->h_family)
    <?php
    $temp = explode("family=", $website->h_family);
    if(key_exists(1, $temp)){
        $v_family = explode(":", $temp[1]);
    }
    $h_family_url = $website->h_family;
    if(is_string($h_family_url) && strpos($h_family_url, 'fonts.googleapis.com') !== false && strpos($h_family_url, 'display=') === false){
        $h_family_url .= (strpos($h_family_url, '?') === false ? '?' : '&') . 'display=swap';
    }
    ?>
    @if(key_exists(1, $temp))
        <link rel="stylesheet" href="{{ $h_family_url }}">
        <style>
            h1, h2, h3, h4, h5, h6 {
                font-family: '{{ $v_family[0] }}'/**, sans-serif; **/
            }
        </style>
    @endif
@endif

@if($website->p_family)
    <?php
    $temp = explode("family=", $website->p_family);
    if(key_exists(1, $temp)){
        $v_family = explode(":", $temp[1]);
    }
    $p_family_url = $website->p_family;
    if(is_string($p_family_url) && strpos($p_family_url, 'fonts.googleapis.com') !== false && strpos($p_family_url, 'display=') === false){
        $p_family_url .= (strpos($p_family_url, '?') === false ? '?' : '&') . 'display=swap';
    }
    ?>
    @if(key_exists(1, $temp))
        <link rel="stylesheet" href="{{ $p_family_url }}">
        <style>
            a, button, input, body, btn, btn-product, span, p {
                font-family: '{{ $v_family[0] }}'; /**, sans-serif; **/
                font-size: {{ $website->font_size }}!important;

            }
            p {
                font-size: {{ $website->font_size }}!important;
            }

        </style>
    @endif
@endif

<meta name="csrf-token" content="{{ csrf_token() }}">
