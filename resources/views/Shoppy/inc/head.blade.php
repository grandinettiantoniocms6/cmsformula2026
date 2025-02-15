<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="CMS-Formula.it" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<!-- Favicon -->
@if($website->favicon)
<link rel="icon" type="image/png" href="{{ url("uploads/$website->favicon") }}" />
@endif
<script>
    WebFontConfig = {
        google: { families: [ 'Poppins:300,400,500,600,700,800' ] }
    };
    ( function ( d ) {
        var wf = d.createElement( 'script' ), s = d.scripts[ 0 ];
        wf.src = '{{ url("templates/Shoppy/js/webfont.js") }}';
        wf.async = true;
        s.parentNode.insertBefore( wf, s );
    } )( document );
</script>
<!-- font -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
<link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/plugins/fontawesome-free/css/all.min.css") }}">
<link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/plugins/animate/animate.min.css") }}">
<!-- Plugins CSS File -->
<link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/plugins/magnific-popup/magnific-popup.min.css") }}">
<link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/plugins/owl-carousel/owl.carousel.min.css") }}">
<!-- Main CSS File -->
<link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/css/demo2.min.css") }}">

