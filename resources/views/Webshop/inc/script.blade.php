<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

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

<link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
<noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</noscript>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" fetchpriority="high"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" fetchpriority="high"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" fetchpriority="high" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" fetchpriority="high" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js" defer></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" defer></script>
<script src="{{ url('templates/Webshop/js/vendor/isotope.pkgd.min.js') }}" defer></script>
<script src="{{ url('templates/Webshop/js/vendor/imagesloaded.pkgd.min.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-countto/1.1.0/jquery.countTo.min.js" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jarallax/2.0.3/jarallax.min.js" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js" defer></script>


@yield('player_video')

<script  src="{{ url('templates/Webshop/js/script.js') }}" defer></script>
