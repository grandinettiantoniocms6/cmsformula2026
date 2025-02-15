@if($website->topbar_background)
    <div class="header-top" style="background-color: {{ $website->topbar_background }}">
@else
    <div class="header-top">
@endif
    @if($website->is_online == 0 && backpack_user())
        <div class="alert alert-danger text-center"><strong>Il sito è in modalità offline! Questo avviso lo vede solo l'amministratore</strong></div>
    @endif
        <div class="container">
            @if($website->topbar_contact_description)
                <div class="header-left">
                    <p class="welcome-msg">{{ $website->topbar_contact_description }} </p>
                </div>
            @endif
            <div class="header-right">
                @include('Shoppy.inc.switch_lang')
                <!-- End DropDown Menu -->
                <span class="divider"></span>
                <a href="#" class="contact d-lg-show"><i class="d-icon-map"></i>Contact</a>
                <a href="#" class="help d-lg-show"><i class="d-icon-info"></i> Need Help</a>
                <a class="login-link" href="#" data-toggle="login-modal"><i class="d-icon-user"></i>Sign in</a>
                <span class="delimiter">/</span>
                <a class="register-link ml-0" href="#" data-toggle="login-modal">Register</a>
                <!-- End of Login -->
            </div>
        </div>

</div>
