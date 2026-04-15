@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();
@endphp
@if($isModernAdminTemplate)
<style>
    .topbar-user-dropdown .nav-link.avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        padding: 0 !important;
        border-radius: 999px;
        background: transparent;
        border: 1px solid rgba(255, 255, 255, .2);
        transition: all .2s ease;
    }

    .topbar-user-dropdown .nav-link.avatar:hover {
        background: rgba(255, 255, 255, .22);
        transform: translateY(-1px);
    }

    .topbar-user-dropdown .backpack-avatar-menu-container {
        width: 36px;
        height: 36px;
        border-radius: 999px !important;
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

    @if($isModernAdminTemplate02)
    .topbar-user-dropdown .nav-link.avatar {
        border-color: #d4e4ff;
        background: #f4f8ff;
        box-shadow: 0 8px 20px rgba(28, 73, 152, .12);
    }

    .topbar-user-dropdown .backpack-avatar-menu-container {
        background: linear-gradient(145deg, #3f7ae8, #4db6ff);
        box-shadow: 0 10px 18px rgba(46, 106, 202, .28);
    }

    .topbar-user-dropdown .dropdown-menu {
        border: 1px solid #d8e6fb;
        box-shadow: 0 16px 32px rgba(20, 62, 136, .14);
    }
    @endif
</style>
@endif

<li class="nav-item dropdown pl-2 pr-3 topbar-user-dropdown">
    <a class="nav-link avatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
    <span class="backpack-avatar-menu-container">
      {{backpack_user()->getAttribute('name') ? mb_substr(backpack_user()->name, 0, 1, 'UTF-8') : 'A'}}
    </span>
    </a>
    <div class="dropdown-menu {{ config('backpack.base.html_direction') == 'rtl' ? 'dropdown-menu-left' : 'dropdown-menu-right' }} mr-4">
        @if(config('backpack.base.setup_my_account_routes'))
            <a class="dropdown-item" href="{{ route('backpack.account.info') }}"><i class="la la-user"></i> {{ trans('backpack::base.my_account') }}</a>
        @endif
        @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
            <a class="dropdown-item" href="https://www.webisland.it/contatti" target="_blank"><i class="las la-headset"></i> Assistenza</a>
            @if(env('NASCONDI_FRONTEND') == 0)
                <a class="dropdown-item" href="/" target="_blank"><i class="las la la-chrome"></i> Anteprima sito</a>
            @endif
            @if(backpack_user()->roles[0]->id < 5)
                <a class="dropdown-item d-lg-none" href="#" id="topbar-news-toggle-mobile">
                    <i class="las la-bell"></i> News
                    <span id="topbar-news-badge-mobile" class="badge badge-pill badge-danger ml-auto d-none"></span>
                </a>
            @endif
        @endif
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ backpack_url('logout') }}"><i class="la la-lock"></i> {{ trans('backpack::base.logout') }}</a>
    </div>
</li>

<script>
  (function () {
    var mobileToggle = document.getElementById('topbar-news-toggle-mobile');
    if (!mobileToggle) return;

    var updateMobileBadge = function () {
      var desktopBadge = document.querySelector('#topbar-news-toggle .topbar-news-badge');
      var mobileBadge = document.getElementById('topbar-news-badge-mobile');
      if (!mobileBadge) return;

      if (desktopBadge) {
        mobileBadge.textContent = (desktopBadge.textContent || '').trim();
        mobileBadge.classList.remove('d-none');
      } else {
        mobileBadge.textContent = '';
        mobileBadge.classList.add('d-none');
      }
    };

    mobileToggle.addEventListener('click', function (event) {
      event.preventDefault();
      var desktopToggle = document.getElementById('topbar-news-toggle');
      if (desktopToggle) {
        desktopToggle.dispatchEvent(new MouseEvent('click', { bubbles: true, cancelable: true }));
      }
    });

    var desktopToggle = document.getElementById('topbar-news-toggle');
    if (desktopToggle && window.MutationObserver) {
      var observer = new MutationObserver(updateMobileBadge);
      observer.observe(desktopToggle, { childList: true, subtree: true, characterData: true });
    }

    updateMobileBadge();
  })();
</script>
