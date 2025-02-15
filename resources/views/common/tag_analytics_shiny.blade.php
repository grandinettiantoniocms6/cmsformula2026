@if($website->shinystat)
    <!-- Inizio Codice ShinyStat -->
    <script class="_iub_cs_activate" type="text/plain" type="text/javascript" src="//codiceisp.shinystat.com/cgi-bin/getcod.cgi?USER={{ $website->shinystat }}" defer></script>
    <noscript>
        <a href="//www.shinystat.com/it/" title="Statistiche web" target="_top"><img src="//www.shinystat.com/cgi-bin/shinystat.cgi?USER={{ $website->shinystat }}" alt="Statistiche web" width="1" height="1"/></a>
    </noscript>
    <!-- Fine Codice ShinyStat -->
@endif
