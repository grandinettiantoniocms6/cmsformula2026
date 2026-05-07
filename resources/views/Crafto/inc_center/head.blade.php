<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="CMS-Formula 5.0 by Webisland.it" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Favicon -->
@if($website->favicon)
<link rel="shortcut icon" href="{{ url("$website->favicon") }}" />
@endif
<!-- font -->
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
@if((isset($website->h_family) && strpos($website->h_family, 'fonts.googleapis.com') !== false) || (isset($website->p_family) && strpos($website->p_family, 'fonts.googleapis.com') !== false))
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
@endif
@if($website->logo)
    <link rel="preload" as="image" href="{{ url($website->logo2 ?: $website->logo) }}" fetchpriority="high">
@endif
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" media="print" onload="this.onload=null;this.removeAttribute('media');">
<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"></noscript>
<!-- CSS -->
<link rel="preload"
      href="{{ url("templates/Crafto/css/vendors.min.css") }}"
      as="style"
      onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="{{ url("templates/Crafto/css/vendors.min.css") }}">
</noscript>
<link rel="preload"
      href="{{ url("templates/Crafto/css/icon.min.css") }}"
      as="style"
      onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="{{ url("templates/Crafto/css/icon.min.css") }}">
</noscript>
<link rel="stylesheet" href="{{ url("templates/Crafto/css/style.css") }}"/>
<link rel="preload"
      href="{{ url("templates/Crafto/css/responsive.css") }}"
      as="style"
      onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="{{ url("templates/Crafto/css/responsive.css") }}">
</noscript>

<!-- CSS Common Form contact -->
@if($website->form_contact)
    <script>
        window.addEventListener('load', function () {
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = '{{ url("$website->form_contact") }}';
            document.head.appendChild(link);
        });
    </script>
    <noscript><link rel="stylesheet" type="text/css" href="{{ url("$website->form_contact") }}" /></noscript>
@else
    <script>
        window.addEventListener('load', function () {
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = '{{ url("css_common/form_contact.css") }}';
            document.head.appendChild(link);
        });
    </script>
    <noscript><link rel="stylesheet" type="text/css" href="{{ url("css_common/form_contact.css") }}" /></noscript>
@endif
<!-- Responsive -->
@if($website->resposive_css)
    <link rel="stylesheet" type="text/css" href="{{ url("$website->responsive_css") }}" />
@endif

<!-- Prima vanno messi i css style e tipografy del tema e poi metto questa regola qui sotto che carica i Font Color Style css di Crafto da admin -->
@if($website->style_css || $website->custom_css)
    @if($website->style_css)
        <link rel="preload" href="{{ url("$website->style_css") }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" type="text/css" href="{{ url("$website->style_css") }}" /></noscript>
    @endif
    @if($website->custom_css)
        <link rel="preload" href="{{ url("$website->custom_css") }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" type="text/css" href="{{ url("$website->custom_css") }}" /></noscript>
    @endif
@endif

<!-- WhatsApp Widget -->
@if($website->wapp_css1)
    <link rel="preload" href="{{ url("$website->wapp_css1") }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" type="text/css" href="{{ url("$website->wapp_css1") }}" /></noscript>
@else
    <link rel="preload" href="{{ url("css_common/whatsapp/css/wapp.css") }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" type="text/css" href="{{ url("css_common/whatsapp/css/wapp.css") }}" /></noscript>
@endif
@if($website->wapp_css2)
    <link rel="preload" href="{{ url("$website->wapp_css2") }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" type="text/css" href="{{ url("$website->wapp_css2") }}" /></noscript>
@else
    <link rel="preload" href="{{ url("css_common/whatsapp/plugin/whatsapp-chat-support.css") }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" type="text/css" href="{{ url("css_common/whatsapp/plugin/whatsapp-chat-support.css") }}" /></noscript>
@endif

@if($website->h_family)
    <?php
    $temp = explode("family=", $website->h_family);
    if(key_exists(1, $temp)){
        $v_family = explode(":", $temp[1]);
    }
    ?>
    @if(key_exists(1, $temp))
        <?php
        $h_family_url = $website->h_family;
        if(is_string($h_family_url) && strpos($h_family_url, 'fonts.googleapis.com') !== false && strpos($h_family_url, 'display=') === false){
            $h_family_url .= (strpos($h_family_url, '?') === false ? '?' : '&') . 'display=swap';
        }
        ?>
        <link rel="stylesheet" href="{{ $h_family_url }}" media="print" onload="this.onload=null;this.removeAttribute('media');">
        <noscript><link rel="stylesheet" href="{{ $h_family_url }}"></noscript>
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
        <?php
        $p_family_url = $website->p_family;
        if(is_string($p_family_url) && strpos($p_family_url, 'fonts.googleapis.com') !== false && strpos($p_family_url, 'display=') === false){
            $p_family_url .= (strpos($p_family_url, '?') === false ? '?' : '&') . 'display=swap';
        }
        ?>
        <link rel="stylesheet" href="{{ $p_family_url }}" media="print" onload="this.onload=null;this.removeAttribute('media');">
        <noscript><link rel="stylesheet" href="{{ $p_family_url }}"></noscript>
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
