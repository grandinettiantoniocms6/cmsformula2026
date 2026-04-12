<meta charset="UTF-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Favicon -->
@if($website->favicon)
<link rel="icon" type="image/x-icon" href="{{ url("$website->favicon") }}" />
@endif
<!-- font -->
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
<!-- css -->
<link rel="stylesheet" href="{{ url("templates/Corporate2/css/bootstrap.min.css") }}">
<link rel="stylesheet" href="{{ url("templates/Corporate2/css/fancybox.css") }}">
<link rel="stylesheet" href="{{ url("templates/Corporate2/css/swiper-bundle.min.css") }}">
<link rel="stylesheet" href="{{ url("templates/Corporate2/css/all.min.css") }}">
<link rel="stylesheet" href="{{ url("templates/Corporate2/css/jarallax.min.css") }}">
<link rel="stylesheet" href="{{ url("templates/Corporate2/css/nice-select.css") }}">
<link rel="stylesheet" href="{{ url("templates/Corporate2/css/jquery.datepicker.css") }}">
<link rel="stylesheet" href="{{ url("templates/Corporate2/css/jquery.timepicker.min.css") }}">
<link rel="stylesheet" href="{{ url("templates/Corporate2/css/style.css") }}">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

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
