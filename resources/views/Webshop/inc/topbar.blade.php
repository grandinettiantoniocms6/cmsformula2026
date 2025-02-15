@if($website->is_online == 0 && backpack_user() && !is_numeric(strpos(env('APP_URL'), "stage")))
    <div id="offline" class="bg-danger text-white text-center p-2"><strong>Il sito è in modalità Offline.</strong> Avviso solo per gli amministratori.</div>
@endif
<!--if(env('TOPBAR'))-->
@if($website->topbar_active == 1 && (env('TOPBAR')) )
<div id="topbar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md column-1">
                <nav class="nav nav-contacts align-items-center">
                    @if($website->topbar_contact_email)
                        <span class="nav-link contact_email"><i class="{{ $website->icon_topbar1 }} {{ $website->sizeicon }}"></i><span>{{ $website->topbar_contact_email }}</span></span>
                    @endif
                    @if($website->topbar_contact_mobile)
                        <a class="nav-link contact_mobile" href="tel:{{ $website->topbar_contact_mobile }}"><i class="{{ $website->icon_topbar2 }} {{ $website->sizeicon }}"></i><span>{{ $website->topbar_contact_mobile }}</span></a>
                    @endif
                        @if($website->topbar_scrolltext_active == 1 && (env('TOPBAR_SCORREVOLE')) )
                            @if($website->topbar_contact_description)
                                <span class="nav-link contact_description">
                                    <span><i class="{{ $website->icon_topbar3 }} {{ $website->sizeicon }}"></i><span>{{ $website->topbar_contact_description }}</span></span>
                                </span>
                            @endif
                        @endif
                </nav>
            </div>
            <div class="col-md-auto column-2">
                @include('Webshop.inc.socials')
            </div>
        </div>
    </div>
</div>
@endif
