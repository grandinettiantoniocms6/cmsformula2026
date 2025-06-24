<li class="nav-item dropdown pl-2 pr-3">
    <a class="nav-link avatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
    <span class="backpack-avatar-menu-container">
      {{backpack_user()->getAttribute('name') ? mb_substr(backpack_user()->name, 0, 1, 'UTF-8') : 'A'}}
    </span>
    </a>
    <div class="dropdown-menu shadow-sm py-2 {{ config('backpack.base.html_direction') == 'rtl' ? 'dropdown-menu-left' : 'dropdown-menu-right' }} mr-4">
        @if(config('backpack.base.setup_my_account_routes'))
            <a class="dropdown-item" href="{{ route('backpack.account.info') }}"><i class="la la-user"></i> {{ trans('backpack::base.my_account') }}</a>
        @endif
        @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
            <a class="dropdown-item" href="https://www.webisland.it/contatti" target="_blank"><i class="las la-headset"></i> Assistenza</a>
            @if(env('NASCONDI_FRONTEND') == 0)
                <a class="dropdown-item" href="/" target="_blank"><i class="las la la-chrome"></i> Anteprima sito</a>
            @endif
        @endif
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ backpack_url('logout') }}"><i class="la la-lock"></i> {{ trans('backpack::base.logout') }}</a>
    </div>
</li>
