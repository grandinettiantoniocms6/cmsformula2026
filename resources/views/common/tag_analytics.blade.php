@if($website->analytics)
    <!-- Nuovo Google Analytics 4 -->
    @if(env('IUBENDA') == 1)
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async class="_iub_cs_activate" type="text/plain" data-suppressedsrc="https://www.googletagmanager.com/gtag/js?id={{ $website->analytics }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            // Per anonimizzare gli IP alla riga sotto ho aggiunto { 'anonymize_ip': true }
            gtag('config', '{{ $website->analytics }}', { 'anonymize_ip': true });
        </script>
    @else
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $website->analytics }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            // Per anonimizzare gli IP alla riga sotto ho aggiunto { 'anonymize_ip': true }
            gtag('config', '{{ $website->analytics }}', { 'anonymize_ip': true });
        </script>
    @endif
@endif

@if($website->googlegta)
    <!-- Google Tag Manager -->
    @if(env('IUBENDA') == 1)
        <!-- Google Tag Manager -->
        <script async class="_iub_cs_activate">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $website->googlegta }}');</script>
        <!-- End Google Tag Manager -->
    @else
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $website->googlegta }}');</script>
        <!-- End Google Tag Manager -->
    @endif
@endif


@if($website->googleads1)
    <!-- Se il Cliente attiva una ADS Google ecco il codice necessario -->
    <!-- Global site tag (gtag.js) - Google Ads: 10811879854 -->
    @if(env('IUBENDA') == 1)
        <script async class="_iub_cs_activate" type="text/plain" data-suppressedsrc="https://www.googletagmanager.com/gtag/js?id={{ $website->googleads1 }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ $website->googleads1 }}');
        </script>
    @else
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $website->googleads1 }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ $website->googleads1 }}');
        </script>
    @endif
@endif


@if($website->googleads2)
    @if(env('IUBENDA') == 1)
        <!-- Se il Cliente attiva una ADS Google ecco il codice necessario per la conversione -->
        <!-- Event snippet for Website traffic conversion page -->
        <script class="_iub_cs_activate" type="text/plain">
            gtag('event', 'conversion', {'send_to': '{{ $website->googleads2 }}'});
        </script>
    @else
        <!-- Se il Cliente attiva una ADS Google ecco il codice necessario per la conversione -->
        <!-- Event snippet for Website traffic conversion page -->
        <script>
            gtag('event', 'conversion', {'send_to': '{{ $website->googleads2 }}'});
        </script>
    @endif

@endif


@if($website->pixelfb)
    <!-- Se il Cliente attiva il Pixel di FB ecco il codice necessario -->


@endif
