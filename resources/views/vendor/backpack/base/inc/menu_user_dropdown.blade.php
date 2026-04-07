<style>
  .topbar-user-dropdown .nav-link.avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    padding: 0 !important;
    border-radius: 10px;
    background: transparent;
    border: 1px solid rgba(255, 255, 255, .2);
    transition: all .2s ease;
  }

  .topbar-user-dropdown .nav-link.avatar:hover {
    background: rgba(255, 255, 255, .12);
    transform: translateY(-1px);
  }

  .topbar-user-dropdown .backpack-avatar-menu-container {
    width: 36px;
    height: 36px;
    border-radius: 8px 16px 8px 8px !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    letter-spacing: .01em;
    color: #ffffff;
    background: linear-gradient(140deg, #00a65a, #0ec777);
    box-shadow: 0 6px 14px rgba(0, 166, 90, .28);
  }

  .topbar-user-dropdown .dropdown-menu {
    min-width: 250px;
    margin-top: .62rem;
    border: 0;
    border-radius: 14px;
    padding: .55rem;
    box-shadow: 0 16px 35px rgba(10, 23, 50, .18);
    background: #ffffff;
  }

  .topbar-user-dropdown .dropdown-item {
    display: flex;
    align-items: center;
    gap: .56rem;
    border-radius: 10px;
    padding: .58rem .68rem;
    color: #1a3465;
    font-weight: 600;
    transition: all .15s ease;
  }

  .topbar-user-dropdown .dropdown-item i {
    width: 18px;
    text-align: center;
    color: #2f67cc;
  }

  .topbar-user-dropdown .dropdown-item:hover {
    background: #eef4ff;
    color: #15366a;
  }

  .topbar-user-dropdown .dropdown-divider {
    margin: .45rem 0;
  }
</style>

<li class="nav-item dropdown pr-4 topbar-user-dropdown">
  <a class="nav-link avatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
    <span class="backpack-avatar-menu-container">
      {{backpack_user()->getAttribute('name') ? mb_substr(backpack_user()->name, 0, 1, 'UTF-8') : 'A'}}
    </span>
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
