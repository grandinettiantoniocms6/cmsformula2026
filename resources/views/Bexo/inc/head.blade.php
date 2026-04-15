<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="author" content="CMS-Formula 6.0 by Webisland.it" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Favicon -->
@if($website->favicon)
    <link rel="icon" type="image/x-icon" href="{{ url("$website->favicon") }}" />
@endif
<!-- font -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
<!-- css -->
<link rel="stylesheet" href="{{ url("templates/Bexo/assets/css/bootstrap.min.css") }}">
<link rel="stylesheet" href="{{ url("templates/Bexo/assets/css/font-awesome-pro.min.css") }}">
<link rel="stylesheet" href="{{ url("templates/Bexo/assets/css/animate.min.css") }}">
<link rel="stylesheet" href="{{ url("templates/Bexo/assets/css/bexon-icons.css") }}">
<link rel="stylesheet" href="{{ url("templates/Bexo/assets/css/nice-select.css") }}">
<link rel="stylesheet" href="{{ url("templates/Bexo/assets/css/swiper.min.css") }}">
<link rel="stylesheet" href="{{ url("templates/Bexo/assets/css/venobox.min.css") }}">
<link rel="stylesheet" href="{{ url("templates/Bexo/assets/css/odometer-theme-default.css") }}">
<link rel="stylesheet" href="{{ url("templates/Bexo/assets/css/meanmenu.css") }}">
<!-- Main uso static per saltare SCSS -->
<link rel="stylesheet" href="{{ url("templates/Bexo/assets/css/static/main.css") }}">

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

<!-- Prima vanno messi i css style e tipografy del tema e poi metto questa regola qui sotto che carica i Font Color Style css Selezionato da admin -->
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
        ?>
    @if(key_exists(1, $temp))
        <link rel="stylesheet" href="{{ $website->h_family }}">
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
        ?>
    @if(key_exists(1, $temp))
        <link rel="stylesheet" href="{{ $website->p_family }}">
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
