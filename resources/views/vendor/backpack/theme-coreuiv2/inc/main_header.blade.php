<header class="{{ backpack_theme_config('classes.header') }}">
  {{-- Logo --}}
  <button class="navbar-toggler sidebar-toggler modern-sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
    <i class="la la-bars"></i>
  </button>

  <?php
  $website_setting = \App\Models\WebsiteSetting::first();
  $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
  $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();
  $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();

  $normalizeHex = static function (?string $color, string $fallback = '#1b2a4e'): string {
      $value = trim((string) $color);
      if ($value === '') {
          return $fallback;
      }

      if (preg_match('/^#?[0-9a-fA-F]{6}([0-9a-fA-F]{2})?$/', $value) !== 1) {
          return $fallback;
      }

      $value = ltrim(strtolower($value), '#');
      if (strlen($value) === 8) {
          $value = substr($value, 0, 6);
      }

      return '#' . $value;
  };

  $mixWithWhite = static function (string $hex, float $ratio = 0.12): string {
      $ratio = max(0, min(1, $ratio));
      $hex = ltrim($hex, '#');
      $r = hexdec(substr($hex, 0, 2));
      $g = hexdec(substr($hex, 2, 2));
      $b = hexdec(substr($hex, 4, 2));

      $r = (int) round($r + (255 - $r) * $ratio);
      $g = (int) round($g + (255 - $g) * $ratio);
      $b = (int) round($b + (255 - $b) * $ratio);

      return sprintf('#%02x%02x%02x', $r, $g, $b);
  };

  $luminance = static function (string $hex): float {
      $hex = ltrim($hex, '#');
      $r = hexdec(substr($hex, 0, 2)) / 255;
      $g = hexdec(substr($hex, 2, 2)) / 255;
      $b = hexdec(substr($hex, 4, 2)) / 255;
      return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
  };

  $topbarBase = $normalizeHex($website_setting->admin_topbar_background ?? null, '#1b2a4e');
  $leftbarBase = $normalizeHex($website_setting->admin_leftbar_background ?? null, '#1b2a4e');

  $topbarShade = $mixWithWhite($topbarBase, 0.14);
  $leftbarShade = $mixWithWhite($leftbarBase, 0.12);

  $topbarText = $luminance($topbarBase) > 0.58 ? '#162d58' : '#eef4ff';
  $topbarLinkHoverBg = $luminance($topbarBase) > 0.58 ? 'rgba(0, 0, 0, .06)' : 'rgba(255, 255, 255, .14)';

  $normalizePublicAssetPath = static function (?string $path): string {
      $value = trim((string) $path);
      if ($value === '') {
          return '';
      }

      $value = str_replace('\\', '/', $value);
      $value = preg_replace('#^/?public/#', '', $value) ?? $value;
      return ltrim($value, '/');
  };

  $adminLogoPath = $normalizePublicAssetPath($website_setting->logo_admin ?? '');
  $defaultAdminLogoPath = $normalizePublicAssetPath('public/img/commons/admin/logo-login.png');
  ?>

  @if($isModernAdminTemplate)
  <style>
    :root {
      --admin-topbar-bg: {{ $topbarBase }};
      --admin-topbar-bg-light: {{ $topbarShade }};
      --admin-topbar-text: {{ $topbarText }};
      --admin-topbar-hover-bg: {{ $topbarLinkHoverBg }};
      --admin-leftbar-bg: {{ $leftbarBase }};
      --admin-leftbar-bg-light: {{ $leftbarShade }};
    }

    .app-header {
      background: linear-gradient(140deg, var(--admin-topbar-bg), var(--admin-topbar-bg-light)) !important;
      border-bottom: 1px solid rgba(255, 255, 255, .18);
      box-shadow: 0 8px 20px rgba(8, 17, 44, .16);
    }

    .app-header .navbar-brand,
    .app-header .navbar-brand * {
      color: var(--admin-topbar-text) !important;
    }

    .app-header .nav-link,
    .app-header .navbar-toggler {
      color: var(--admin-topbar-text) !important;
    }

    .app-header .nav-link:hover {
      background: var(--admin-topbar-hover-bg);
    }

    .app-header .modern-sidebar-toggler {
      border: 0;
      width: 46px;
      height: 36px;
      border-radius: 12px;
      position: relative;
      transition: background-color .15s ease;
    }

    .app-header .modern-sidebar-toggler i {
      display: none;
    }

    .app-header .modern-sidebar-toggler::before,
    .app-header .modern-sidebar-toggler::after {
      content: '';
      position: absolute;
      left: 10px;
      right: 10px;
      height: 2.5px;
      border-radius: 99px;
      background: currentColor;
      transition: transform .15s ease, opacity .15s ease;
    }

    .app-header .modern-sidebar-toggler::before {
      top: 12px;
    }

    .app-header .modern-sidebar-toggler::after {
      top: 21px;
    }

    .app-header .modern-sidebar-toggler:hover {
      background: var(--admin-topbar-hover-bg);
    }

    @if($isModernAdminTemplate02)
    .app-header {
      background:
        radial-gradient(520px 150px at 10% -30%, rgba(255, 255, 255, .18), transparent 70%),
        linear-gradient(180deg, var(--admin-topbar-bg-light) 0%, var(--admin-topbar-bg) 100%) !important;
      border-bottom: 1px solid rgba(255, 255, 255, .24);
      box-shadow: 0 10px 24px rgba(8, 17, 44, .16);
    }

    .app-header .navbar-brand,
    .app-header .nav-link,
    .app-header .navbar-toggler {
      color: var(--admin-topbar-text) !important;
    }

    .app-header .nav-link:hover {
      background: var(--admin-topbar-hover-bg);
      box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .18);
      border-radius: 12px;
    }
    @endif
  </style>
  @endif

  @if($isFutureAdminTemplate)
  <style>
    :root {
      --admin-topbar-bg: {{ $topbarBase }};
      --admin-topbar-bg-light: {{ $topbarShade }};
      --admin-leftbar-bg: {{ $leftbarBase }};
      --admin-leftbar-bg-light: {{ $leftbarShade }};
    }

    body.admin-future-template .app-header {
      min-height: var(--future-header-height);
      padding-left: 14px;
      padding-right: 16px;
      align-items: center;
      flex-wrap: nowrap;
    }

    body.admin-future-template .app-header .navbar-nav {
      align-items: center;
      gap: .12rem;
    }

    body.admin-future-template .app-header .nav-item {
      display: inline-flex;
      align-items: center;
      min-height: var(--future-header-height);
    }

    body.admin-future-template .app-header .nav-link {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 40px;
    }

    .app-header .navbar-brand {
      width: var(--future-sidebar-width, 175px);
      min-width: var(--future-sidebar-width, 175px);
      max-width: var(--future-sidebar-width, 175px);
      justify-content: center;
      background: linear-gradient(160deg, #182654 0%, #101a3d 100%);
      border-right: 1px solid rgba(255, 255, 255, .08);
      border-bottom: 0 !important;
      box-shadow: none !important;
      outline: 0 !important;
      overflow: hidden;
      transition: width .2s ease, min-width .2s ease, max-width .2s ease, opacity .15s ease;
    }

    .app-header .navbar-brand img {
      max-height: 44px;
      width: auto;
      object-fit: contain;
    }

    @media (min-width: 992px) {
      body.admin-future-template .app-header .navbar-brand {
        width: 0;
        min-width: 0;
        max-width: 0;
        padding: 0;
        margin: 0;
        border-right: 0;
        opacity: 0;
      }

      body.admin-future-template.sidebar-lg-show .app-header .navbar-brand {
        width: var(--future-sidebar-width, 175px);
        min-width: var(--future-sidebar-width, 175px);
        max-width: var(--future-sidebar-width, 175px);
        opacity: 1;
        border-right: 1px solid rgba(255, 255, 255, .08);
      }
    }

    body.admin-future-template.sidebar-hide .app-header .navbar-brand,
    body.admin-future-template.sidebar-lg-hide .app-header .navbar-brand,
    body.admin-future-template.sidebar-minimized .app-header .navbar-brand,
    body.admin-future-template:not(.sidebar-lg-show) .app-header .navbar-brand {
      width: 0;
      min-width: 0;
      max-width: 0;
      padding: 0;
      margin: 0;
      border-right: 0;
      opacity: 0;
    }

    @media (max-width: 991.98px) {
      body.admin-future-template .app-header .navbar-brand {
        width: 0;
        min-width: 0;
        max-width: 0;
        padding: 0;
        margin: 0;
        border-right: 0;
        opacity: 0;
      }

      body.admin-future-template.sidebar-show .app-header .navbar-brand {
        width: var(--future-sidebar-width, 175px);
        min-width: var(--future-sidebar-width, 175px);
        max-width: var(--future-sidebar-width, 175px);
        opacity: 1;
      }
    }

    .app-header .modern-sidebar-toggler {
      border: 0;
      width: 40px;
      height: 40px;
      border-radius: 10px;
      position: relative;
      color: #2b4779 !important;
      transition: background-color .15s ease;
      margin-right: .55rem;
    }

    .app-header .modern-sidebar-toggler i {
      display: none;
    }

    .app-header .modern-sidebar-toggler::before,
    .app-header .modern-sidebar-toggler::after {
      content: '';
      position: absolute;
      left: 10px;
      right: 10px;
      height: 2.5px;
      border-radius: 99px;
      background: currentColor;
    }

    .app-header .modern-sidebar-toggler::before {
      top: 13px;
    }

    .app-header .modern-sidebar-toggler::after {
      top: 22px;
    }

    .app-header .modern-sidebar-toggler:hover {
      background: rgba(43, 71, 121, .08);
    }

    .future-header-status {
      display: inline-flex;
      align-items: center;
      border-radius: 999px;
      min-height: 24px;
      padding: .22rem .62rem;
      font-size: .67rem;
      font-weight: 800;
      letter-spacing: .03em;
      border: 1px solid #c8d8f3;
      margin-left: .35rem;
    }

    .future-header-status.online {
      background: #e9f7ea;
      color: #2f8b54;
    }

    .future-header-status.offline {
      background: #fff3ee;
      color: #b15437;
    }
  </style>
  @endif

  @unless($isFutureAdminTemplate)
    <a class="navbar-brand" href="{{ url(backpack_theme_config('home_link')) }}" title="{{ backpack_theme_config('project_name') }}">
      @if($adminLogoPath !== '')
        <img src="{{ asset($adminLogoPath) }}" height="55">
      @else
        <img src="{{ asset($defaultAdminLogoPath) }}" height="55" alt="Logo admin">
      @endif
    </a>
  @endunless

  <button class="navbar-toggler sidebar-toggler modern-sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
    <i class="la la-bars"></i>
  </button>

  @if($isFutureAdminTemplate && env('NASCONDI_FRONTEND') == 0)
    <span class="future-header-status {{ ((int)($website_setting->is_online ?? 0) === 1) ? 'online' : 'offline' }}">
      {{ ((int)($website_setting->is_online ?? 0) === 1) ? 'SITO ONLINE' : 'SITO OFFLINE' }}
    </span>
  @endif

  @include(backpack_view('inc.menu'))
</header>
