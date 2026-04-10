<header class="{{ backpack_theme_config('classes.header') }}">
  {{-- Logo --}}
  <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
    <i class="la la-bars"></i>
  </button>

  <?php
  $website_setting = \App\Models\WebsiteSetting::first();
  $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
  $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();

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

    @if($isModernAdminTemplate02)
    .app-header {
      background:
        radial-gradient(520px 150px at 10% -30%, rgba(64, 156, 255, .2), transparent 70%),
        linear-gradient(180deg, #ffffff 0%, #f5f9ff 100%) !important;
      border-bottom: 1px solid #d8e5fb;
      box-shadow: 0 10px 24px rgba(20, 59, 126, .08);
    }

    .app-header .navbar-brand,
    .app-header .nav-link,
    .app-header .navbar-toggler {
      color: #2b436f !important;
    }

    .app-header .nav-link:hover {
      background: #eaf2ff;
      box-shadow: inset 0 0 0 1px #d5e6ff;
      border-radius: 12px;
    }
    @endif
  </style>
  @endif

  <a class="navbar-brand" href="{{ url(backpack_theme_config('home_link')) }}" title="{{ backpack_theme_config('project_name') }}">
    @if($adminLogoPath !== '')
      <img src="{{ asset($adminLogoPath) }}" height="55">
    @else
      <img src="{{ asset($defaultAdminLogoPath) }}" height="55" alt="Logo admin">
    @endif
  </a>

  <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
    <i class="la la-bars"></i>
  </button>

  @include(backpack_view('inc.menu'))
</header>
