<!--if(env('WAPP'))-->
@if($website->whatsapp_active == 1 && (env('WAPP')) )
<!-- Wapp Widget -->
<div class="whatsapp_chat_support wcs_fixed_right" id="chat">
    <div class="wcs_button">
        <i class="fab fa-whatsapp"></i> {{ @$labelSite['titolo_pulsante_wapp'] }}
    </div>
    <div class="wcs_popup">
        <div class="wcs_popup_close">
            <i class="fas fa-times"></i>
        </div>
        <div class="wcs_popup_header">
            <span class="fab fa-whatsapp"></span>
            <strong>{{ @$labelSite['sottotitolo_pulsante_wapp'] }}</strong>
            <div class="wcs_popup_header_description">
                {{ @$labelSite['descrizione_pulsante_wapp'] }}
            </div>
        </div>
        <div class="wcs_popup_input" data-number="{{ @$website->cellulare_wapp1 }}" data-availability='{ "{{ @$website->sunday }}":"{{ @$website->hsustart }}-{{ @$website->hsuend }}", "{{ @$website->monday }}":"{{ @$website->hmostart }}-{{ @$website->hmoend }}", "{{ @$website->tuesday }}":"{{ @$website->htustart }}-{{ @$website->htuend }}", "{{ @$website->wednesday }}":"{{ @$website->hwestart }}-{{ @$website->hweend }}", "{{ @$website->thursday }}":"{{ @$website->hthstart }}-{{ @$website->hthend }}", "{{ @$website->friday }}":"{{ @$website->hfrstart }}-{{ @$website->hfrend }}", "{{ @$website->saturday }}":"{{ @$website->hsastart }}-{{ @$website->hsaend }}" }'>
            <input type="text" placeholder="{{ @$labelSite['placeholder_wapp'] }}" />
            <i class="fa fa-play"></i>
        </div>
        <div class="wcs_popup_avatar">
            @if($website->avatar_wapp1)
            <img src="{{ url("$website->avatar_wapp1") }}" alt="{{ @$labelSite['titolo_pulsante_wapp'] }}" width="50" height="50">
            @endif
        </div>
    </div>
</div>
@endif
