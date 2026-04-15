<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ backpack_theme_config('html_direction') }}">

<head>
  @include(backpack_view('inc.head'))
  <link rel="stylesheet" type="text/css" href="{{ url("css/app.css") }}">
</head>

@php
  $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
  $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();
  $bodyClasses = trim(
    backpack_theme_config('classes.body')
    . ($isModernAdminTemplate ? ' admin-modern-template' : '')
    . ($isModernAdminTemplate02 ? ' admin-modern-template-02' : '')
  );
@endphp

<body class="{{ $bodyClasses }}">

  @include(backpack_view('inc.main_header'))

  <div class="app-body">

    @include(backpack_view('inc.sidebar'))

    <main class="main">

        <div class="container-fluid page-header">
            <div class="row align-items-end">
                <div class="col-auto">
                    @yield('header')
                </div>

                @yield('before_breadcrumbs_widgets')

                @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs'))

                @yield('after_breadcrumbs_widgets')
            </div>
        </div>

        <div class="container-fluid px-3">

          @yield('before_content_widgets')

          @yield('content')

          @yield('after_content_widgets')

        </div>

    </main>

  </div>{{-- ./app-body --}}

  <footer class="d-none {{ backpack_theme_config('classes.footer') }}">
    @include(backpack_view('inc.footer'))
  </footer>

  <button id="admin-scroll-top" type="button" aria-label="Torna su" title="Torna su">
    <i class="la la-angle-up" aria-hidden="true"></i>
  </button>

  <style>
    @if($isModernAdminTemplate)
    body.admin-modern-template .main table#crudTable,
    body.admin-modern-template .main .dataTables_wrapper table.dataTable,
    body.admin-modern-template .main .dataTables_wrapper .table {
      margin-top: 18px !important;
    }

    body.admin-modern-template .main #crudTable,
    body.admin-modern-template .main #crudTable tbody,
    body.admin-modern-template .main #crudTable tbody tr,
    body.admin-modern-template .main #crudTable tbody td {
      overflow: visible !important;
    }

    body.admin-modern-template .main #crudTable .dropdown-menu,
    body.admin-modern-template .main .dataTables_wrapper .dropdown-menu {
      z-index: 1100;
    }

    body.admin-modern-template .main .enhanced-crud-list-toolbar,
    body.admin-modern-template .main .blocks-list-toolbar,
    body.admin-modern-template .main .users-list-toolbar,
    body.admin-modern-template .main [class*="list-toolbar"] {
      margin-bottom: 14px !important;
    }

    body.admin-modern-template .main .row.mb-0 > .col-sm-6:first-child > .d-print-none {
      margin-bottom: 14px !important;
    }

    body.admin-modern-template .app-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
    }

    body.admin-modern-template .app-body {
      padding-top: 55px;
    }

    body.admin-modern-template .app-body > .sidebar {
      height: calc(100vh - 55px) !important;
      overflow-y: scroll !important;
      overflow-x: hidden;
      overscroll-behavior: contain;
      -webkit-overflow-scrolling: touch;
    }

    body.admin-modern-template .app-body > .sidebar .sidebar-nav {
      height: 100% !important;
      max-height: calc(100vh - 55px) !important;
      overflow-y: scroll !important;
      overflow-x: hidden;
      overscroll-behavior: contain;
      -webkit-overflow-scrolling: touch;
    }

    @media (min-width: 992px) {
      body.admin-modern-template .app-body > .sidebar {
        position: fixed;
        top: 55px;
        left: 0;
        bottom: 0;
        z-index: 1019;
        overflow-y: auto;
        overflow-x: hidden;
      }

      body.admin-modern-template .app-body > .main {
        min-height: calc(100vh - 55px);
      }
    }

    @media (max-width: 991.98px) {
      body.admin-modern-template .app-body > .sidebar {
        top: 55px;
        bottom: 0;
      }
    }

    body.admin-modern-template.admin-modern-crud-refresh .main .btn.btn-sm,
    body.admin-modern-template.admin-modern-crud-refresh .main a.btn.btn-sm {
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      min-height: 30px;
      padding: .28rem .64rem;
      border-radius: 999px;
      border: 1px solid #d7e2f3;
      background: #f6f9ff;
      color: #1f3d70;
      font-weight: 700;
      font-size: .75rem;
      line-height: 1;
      text-decoration: none;
      transition: all .16s ease;
    }

    body.admin-modern-template.admin-modern-crud-refresh .main .btn.btn-sm:hover,
    body.admin-modern-template.admin-modern-crud-refresh .main a.btn.btn-sm:hover {
      background: #eaf1ff;
      border-color: #bed0ef;
      color: #16335e;
      transform: translateY(-1px);
      text-decoration: none;
    }

    body.admin-modern-template.admin-modern-crud-refresh .main [data-button-type='update']:hover,
    body.admin-modern-template.admin-modern-crud-refresh .main .dropdown-item[data-button-type='update']:hover {
      background: linear-gradient(180deg, #2ea567 0%, #298f5a 100%) !important;
      border-color: #298f5a !important;
      color: #ffffff !important;
      text-decoration: none !important;
    }

    body.admin-modern-template.admin-modern-crud-refresh .main [data-button-type='delete']:hover,
    body.admin-modern-template.admin-modern-crud-refresh .main .dropdown-item[data-button-type='delete']:hover {
      background: linear-gradient(180deg, #d94b4b 0%, #c53c3c 100%) !important;
      border-color: #b93939 !important;
      color: #ffffff !important;
      text-decoration: none !important;
    }

    body.admin-modern-template.admin-modern-crud-refresh .main [data-button-type='update']:hover i,
    body.admin-modern-template.admin-modern-crud-refresh .main [data-button-type='delete']:hover i,
    body.admin-modern-template.admin-modern-crud-refresh .main .dropdown-item[data-button-type='update']:hover i,
    body.admin-modern-template.admin-modern-crud-refresh .main .dropdown-item[data-button-type='delete']:hover i,
    body.admin-modern-template.admin-modern-crud-refresh .main [data-button-type='update']:hover span,
    body.admin-modern-template.admin-modern-crud-refresh .main [data-button-type='delete']:hover span,
    body.admin-modern-template.admin-modern-crud-refresh .main .dropdown-item[data-button-type='update']:hover span,
    body.admin-modern-template.admin-modern-crud-refresh .main .dropdown-item[data-button-type='delete']:hover span {
      color: #ffffff !important;
    }

    body.admin-modern-template.admin-modern-crud-refresh .main .btn-success {
      border: 1px solid #2f9864;
      background: linear-gradient(180deg, #35b173 0%, #2f9f68 100%);
      color: #fff;
    }

    body.admin-modern-template.admin-modern-crud-refresh .main .btn-success:hover {
      background: linear-gradient(180deg, #2ea567 0%, #298f5a 100%);
      border-color: #298f5a;
      color: #fff;
    }

    @endif

    #admin-scroll-top {
      position: fixed;
      right: 18px;
      bottom: 18px;
      width: 42px;
      height: 42px;
      border: 0;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(140deg, var(--admin-topbar-bg, #1b2a4e), var(--admin-topbar-bg-light, #2b477f));
      color: var(--admin-topbar-text, #eef4ff);
      box-shadow: 0 10px 24px rgba(10, 20, 45, .24);
      cursor: pointer;
      opacity: 0;
      transform: translateY(12px);
      pointer-events: none;
      transition: opacity .2s ease, transform .2s ease, box-shadow .2s ease;
      z-index: 1050;
    }

    #admin-scroll-top.is-visible {
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
    }

    #admin-scroll-top:hover {
      box-shadow: 0 14px 26px rgba(10, 20, 45, .3);
    }
  </style>

  @yield('before_scripts')
  @stack('before_scripts')

  @include(backpack_view('inc.scripts'))
  @include(backpack_view('inc.theme_scripts'))

  <script>
    (function () {
      var btn = document.getElementById('admin-scroll-top');
      if (!btn) return;

      var threshold = 240;
      var onScroll = function () {
        if (window.scrollY > threshold) {
          btn.classList.add('is-visible');
        } else {
          btn.classList.remove('is-visible');
        }
      };

      btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });

      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();
    })();

    (function () {
      if (!document.body.classList.contains('admin-modern-template')) return;

      var modernCrudTargets = [
        'adminblock',
        'adminplugin',
        'admin-thumb',
        'adminlanguage',
        'usernavigation',
        'label',
        'block-page',
        'plugintutorial'
      ];
      var pathParts = (window.location.pathname || '').toLowerCase().split('/').filter(Boolean);
      var adminPrefix = '{{ trim(config('backpack.base.route_prefix'), '/') }}'.toLowerCase();
      var firstSegment = pathParts.length > 0 ? pathParts[0] : '';
      var secondSegment = pathParts.length > 1 ? pathParts[1] : '';
      if (firstSegment === adminPrefix && modernCrudTargets.indexOf(secondSegment) !== -1) {
        document.body.classList.add('admin-modern-crud-refresh');
      }

      var media = window.matchMedia('(min-width: 992px)');
      var sidebar = document.querySelector('.app-body > .sidebar');
      var main = document.querySelector('.app-body > .main');
      var sidebarNav = sidebar ? sidebar.querySelector('.sidebar-nav') : null;

      if (!sidebar || !main) return;

      if (sidebarNav) {
        sidebarNav.addEventListener('wheel', function (event) {
          event.stopPropagation();
        }, { passive: true });
        sidebarNav.addEventListener('touchmove', function (event) {
          event.stopPropagation();
        }, { passive: true });
      }

      var syncSidebarOffset = function () {
        if (!media.matches) {
          sidebar.style.width = '';
          main.style.marginLeft = '';
          main.style.width = '';
          return;
        }

        var isSidebarVisible = document.body.classList.contains('sidebar-lg-show')
          || document.body.classList.contains('sidebar-show');
        if (!isSidebarVisible) {
          sidebar.style.width = '';
          main.style.marginLeft = '0';
          main.style.width = '100%';
          return;
        }

        var sidebarWidth = Math.round(sidebar.getBoundingClientRect().width) || sidebar.offsetWidth || 0;
        if (sidebarWidth <= 0) return;

        sidebar.style.width = sidebarWidth + 'px';
        main.style.marginLeft = sidebarWidth + 'px';
        main.style.width = 'calc(100% - ' + sidebarWidth + 'px)';
      };

      window.addEventListener('resize', syncSidebarOffset);
      window.addEventListener('load', syncSidebarOffset);
      document.addEventListener('click', function (event) {
        if (event.target.closest('.sidebar-toggler')) {
          setTimeout(syncSidebarOffset, 220);
        }
      });
      var bodyClassObserver = new MutationObserver(syncSidebarOffset);
      bodyClassObserver.observe(document.body, { attributes: true, attributeFilter: ['class'] });
      syncSidebarOffset();
    })();
  </script>

  @yield('after_scripts')
  @stack('after_scripts')
</body>
</html>
