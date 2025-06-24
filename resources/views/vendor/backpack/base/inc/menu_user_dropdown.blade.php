<li class="nav-item dropdown pr-4">
  <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
    <!-- rotta <img class="img-avatar" src="{{ backpack_avatar_url(backpack_auth()->user()) }}" alt="{{ backpack_auth()->user()->name }}">-->
        <img class="img-avatar" src="/img/icons/avatar.png" alt="{{ backpack_auth()->user()->name }}">
  </a>
  <div class="dropdown-menu {{ config('backpack.base.html_direction') == 'rtl' ? 'dropdown-menu-left' : 'dropdown-menu-right' }} mr-4 pb-1 pt-1">
    <a class="dropdown-item" href="{{ route('backpack.account.info') }}"><i class="la la-user"></i> {{ trans('backpack::base.my_account') }}</a>
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
