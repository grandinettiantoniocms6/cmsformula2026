<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ backpack_theme_config('html_direction') }}">

<head>
  @include(backpack_view('inc.head'))
  <link rel="stylesheet" type="text/css" href="{{ url("css/app.css") }}">
</head>

@php
  $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
  $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();
  $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
  $bodyClasses = trim(
    backpack_theme_config('classes.body')
    . ($isModernAdminTemplate ? ' admin-modern-template' : '')
    . ($isModernAdminTemplate02 ? ' admin-modern-template-02' : '')
    . ($isFutureAdminTemplate ? ' admin-future-template' : '')
  );
@endphp

<body class="{{ $bodyClasses }}">

  @include(backpack_view('inc.main_header'))

  <div class="app-body">

    @include(backpack_view('inc.sidebar'))

    <main class="main">

        <div class="container-fluid page-header">
            <div class="row align-items-end">
                <div class="{{ $isFutureAdminTemplate ? 'col-12' : 'col-auto' }}">
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

    @if($isFutureAdminTemplate)
    body.admin-future-template {
      background: #f4f7fc;
      color: #223a67;
      --future-sidebar-width: 212px;
      --future-header-height: 70px;
    }

    body.admin-future-template .app-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      height: var(--future-header-height);
      min-height: var(--future-header-height);
      background: linear-gradient(180deg, #fafbfd 0%, #f3f6fb 100%) !important;
      border-bottom: 1px solid #e6edf8 !important;
      box-shadow: 0 8px 14px -14px rgba(18, 37, 72, .45) !important;
    }

    body.admin-future-template .app-header .nav-link,
    body.admin-future-template .app-header .navbar-toggler,
    body.admin-future-template .app-header .navbar-brand,
    body.admin-future-template .app-header .navbar-brand * {
      color: #2b4779 !important;
    }

    body.admin-future-template .app-body {
      padding-top: var(--future-header-height);
    }

    body.admin-future-template .app-body > .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      z-index: 1031;
      height: 100vh !important;
      overflow-y: auto !important;
      overflow-x: hidden;
      background: linear-gradient(180deg, #17244f 0%, #0f1a3f 100%) !important;
      border-top: 0 !important;
      border-bottom: 0 !important;
      border-right: 1px solid rgba(255, 255, 255, .1);
      width: var(--future-sidebar-width) !important;
      flex: 0 0 var(--future-sidebar-width) !important;
    }

    body.admin-future-template #saveActions {
      left: 0;
      width: 100%;
    }

    @media (min-width: 1200px) {
      body.admin-future-template.sidebar-lg-show #saveActions,
      body.admin-future-template.sidebar-show #saveActions {
        left: var(--future-sidebar-width) !important;
        width: calc(100% - var(--future-sidebar-width)) !important;
      }
    }

    body.admin-future-template .future-sidebar-brand {
      height: var(--future-header-height);
      min-height: var(--future-header-height);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: .35rem .5rem;
      border-bottom: 1px solid rgba(255, 255, 255, .18);
    }

    body.admin-future-template .future-sidebar-brand a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 100%;
    }

    body.admin-future-template .future-sidebar-brand img {
      max-height: 44px;
      width: auto;
      object-fit: contain;
    }

    body.admin-future-template .app-header::after,
    body.admin-future-template .app-header .navbar-brand::after,
    body.admin-future-template .app-body > .sidebar::before,
    body.admin-future-template .app-body > .sidebar::after {
      content: none !important;
      display: none !important;
      border: 0 !important;
      box-shadow: none !important;
    }

    body.admin-future-template .app-body > .sidebar .sidebar-nav {
      height: 100% !important;
      max-height: calc(100vh - var(--future-header-height)) !important;
      overflow-y: auto !important;
      overflow-x: hidden;
      width: 100% !important;
      max-width: 100% !important;
      padding: .6rem .55rem 1rem !important;
      gap: .35rem;
      border-top: 0 !important;
      box-shadow: none !important;
    }

    body.admin-future-template .sidebar .nav,
    body.admin-future-template .sidebar .sidebar-nav,
    body.admin-future-template .sidebar .sidebar-scroll {
      width: 100% !important;
      max-width: 100% !important;
      border-top: 0 !important;
      border-bottom: 0 !important;
      overflow-x: visible !important;
      box-shadow: none !important;
    }

    body.admin-future-template .sidebar .nav-link {
      position: relative;
      border-radius: 10px !important;
      background: transparent !important;
      color: rgba(241, 246, 255, .95) !important;
      border: 1px solid transparent;
      font-weight: 500 !important;
      letter-spacing: .01em;
      font-size: .81rem;
      margin: 0 .24rem .18rem .24rem !important;
      padding: .56rem .58rem !important;
      transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
      box-sizing: border-box;
      width: calc(100% - .48rem) !important;
      max-width: calc(100% - .48rem) !important;
      min-width: 0 !important;
    }

    body.admin-future-template .sidebar .nav-link .nav-icon {
      color: rgba(234, 242, 255, .84) !important;
    }

    body.admin-future-template .sidebar .nav-link:hover {
      background: rgba(80, 116, 200, .34) !important;
      color: #ffffff !important;
      border-color: rgba(255, 255, 255, .2);
    }

    body.admin-future-template .sidebar .nav-link.active {
      background: linear-gradient(150deg, #353a88 0%, #262f71 100%) !important;
      color: #ffffff !important;
      border-color: rgba(162, 182, 255, .42);
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, .12), 0 8px 16px rgba(9, 16, 44, .35);
    }

    body.admin-future-template .sidebar .nav-link:hover .nav-icon,
    body.admin-future-template .sidebar .nav-link.active .nav-icon {
      color: #ffffff !important;
    }

    body.admin-future-template .sidebar .nav-link.nav-dropdown-toggle {
      display: flex !important;
      align-items: center;
      gap: .5rem;
      padding-right: 1.65rem !important;
    }

    body.admin-future-template .sidebar .nav-dropdown-toggle::before {
      display: none !important;
    }

    body.admin-future-template .sidebar .nav-dropdown-toggle::after {
      content: "";
      margin-left: auto;
      width: 6px;
      height: 6px;
      border-right: 1.8px solid rgba(241, 246, 255, .98);
      border-bottom: 1.8px solid rgba(241, 246, 255, .98);
      transform: rotate(-45deg);
      opacity: 1 !important;
      visibility: visible !important;
      display: inline-block !important;
      pointer-events: none;
      flex: 0 0 6px;
    }

    body.admin-future-template .sidebar .nav-dropdown.open > .nav-link.nav-dropdown-toggle::after {
      transform: rotate(45deg);
    }

    body.admin-future-template .sidebar .nav-dropdown.open {
      background: transparent !important;
      border-radius: 0;
    }

    body.admin-future-template .sidebar .nav-dropdown.open > .nav-link {
      border-radius: 10px !important;
      overflow: hidden;
    }

    body.admin-future-template .sidebar .nav-dropdown-items {
      background: transparent !important;
    }

    body.admin-future-template .sidebar .nav-dropdown-items .nav-link {
      background: transparent !important;
      color: rgba(241, 246, 255, .95) !important;
      border-color: transparent !important;
      box-shadow: none !important;
      padding-left: 1.05rem !important;
    }

    body.admin-future-template .sidebar .nav-dropdown-items .nav-link .nav-icon {
      color: rgba(241, 246, 255, .92) !important;
    }

    body.admin-future-template .sidebar .nav-dropdown-items .nav-link:hover {
      background: transparent !important;
      color: #ffffff !important;
      border-color: transparent !important;
      box-shadow: none !important;
    }

    body.admin-future-template .sidebar .nav-dropdown-items .nav-link.active,
    body.admin-future-template .sidebar .nav-dropdown-items .nav-item.active > .nav-link {
      background: rgba(255, 255, 255, .18) !important;
      color: #ffffff !important;
      border-left: 3px solid rgba(255, 255, 255, .95);
      border-radius: 8px !important;
      padding-left: calc(1.05rem - 3px) !important;
      box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .10) !important;
      font-weight: 400 !important;
    }

    body.admin-future-template .sidebar .nav-dropdown-items .nav-link:hover .nav-icon,
    body.admin-future-template .sidebar .nav-dropdown-items .nav-link.active .nav-icon {
      color: #ffffff !important;
    }

    body.admin-future-template .app-header .navbar-brand,
    body.admin-future-template .app-body > .sidebar,
    body.admin-future-template .app-body > .sidebar .sidebar-nav {
      border-top: 0 !important;
      border-bottom: 0 !important;
      box-shadow: none !important;
      outline: 0 !important;
    }

    body.admin-future-template .main {
      background: transparent;
      min-height: calc(100vh - 56px);
    }

    body.admin-future-template .page-header {
      margin-bottom: 14px;
    }

    body.admin-future-template .card,
    body.admin-future-template .container-fluid .card {
      border: 1px solid #dbe6fb;
      border-radius: 14px;
      box-shadow: 0 10px 28px rgba(13, 34, 74, .08);
    }

    body.admin-future-template .main .btn {
      border-radius: 10px;
      font-weight: 700;
    }

    body.admin-future-template .main .btn.btn-sm,
    body.admin-future-template .main a.btn.btn-sm {
        border-radius: 999px;
        padding: .3rem .7rem;
        line-height: 1.1;
        font-size: .75rem;
    }

    body.admin-future-template.admin-future-uniform-buttons .main .btn:not(.page-block-action-btn):not(.dashboard-todo-icon-btn):not(.btn-link),
    body.admin-future-template.admin-future-uniform-buttons .main a.btn:not(.page-block-action-btn):not(.dashboard-todo-icon-btn):not(.btn-link) {
      border-radius: 999px !important;
      min-height: 32px;
      padding: .3rem .78rem;
      font-size: .76rem;
      line-height: 1.08;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: .35rem;
    }

    body.admin-future-template.admin-future-uniform-buttons .main .btn.btn-sm:not(.page-block-action-btn):not(.dashboard-todo-icon-btn):not(.btn-link),
    body.admin-future-template.admin-future-uniform-buttons .main a.btn.btn-sm:not(.page-block-action-btn):not(.dashboard-todo-icon-btn):not(.btn-link) {
      min-height: 30px;
      padding: .24rem .66rem;
      font-size: .88rem !important;
    }

    body.admin-future-template .main .btn-primary {
      border: 1px solid #346adb;
      background: linear-gradient(180deg, #3f79ee 0%, #2f66d7 100%);
      color: #ffffff;
    }

    body.admin-future-template .main .btn-success {
      border: 1px solid #2c9a64;
      background: linear-gradient(180deg, #35b173 0%, #2f9f68 100%);
      color: #ffffff;
    }

    body.admin-future-template .main .table,
    body.admin-future-template .main #crudTable {
      background: #ffffff;
      border-radius: 12px;
      overflow: hidden;
    }

    body.admin-future-template .main .table thead th {
      border-bottom: 1px solid #dbe5f8;
      color: #1f3e70;
      font-weight: 700;
    }

    body.admin-future-template .main .form-control,
    body.admin-future-template .main .custom-select,
    body.admin-future-template .main .select2-container--bootstrap .select2-selection {
      border-radius: 10px !important;
      border-color: #d5e1f5;
      min-height: 40px;
      background: #f9fbff;
    }

    body.admin-future-template .main .form-control:focus,
    body.admin-future-template .main .custom-select:focus {
      border-color: #89a6dc;
      box-shadow: 0 0 0 3px rgba(62, 111, 206, .13);
      background: #ffffff;
    }

    body.admin-future-template .main #crudTable .dropdown-menu,
    body.admin-future-template .main .dataTables_wrapper .dropdown-menu {
      z-index: 1100;
    }

    /* Prevent dropdown clipping in CRUD lists (eg. /admin/page actions menu). */
    body.admin-future-template .main .dataTables_wrapper,
    body.admin-future-template .main .table-responsive,
    body.admin-future-template .main #crudTable_wrapper,
    body.admin-future-template .main #crudTable,
    body.admin-future-template .main #crudTable tbody,
    body.admin-future-template .main #crudTable tbody tr,
    body.admin-future-template .main #crudTable tbody td {
      overflow: visible !important;
    }

    body.admin-future-template .main #crudTable .dropdown-menu {
      z-index: 1200 !important;
    }

    @media (min-width: 1200px) {
      body.admin-future-template .app-body > .sidebar {
        width: var(--future-sidebar-width) !important;
        flex: 0 0 var(--future-sidebar-width) !important;
      }

      body.admin-future-template .app-body > .main {
        margin-left: 0;
        width: 100%;
      }

      body.admin-future-template.sidebar-lg-show .app-header {
        left: var(--future-sidebar-width);
        width: calc(100% - var(--future-sidebar-width));
      }

      body.admin-future-template:not(.sidebar-lg-show) .app-header {
        left: 0;
        width: 100%;
      }

      body.admin-future-template.sidebar-lg-show .app-body > .main {
        margin-left: var(--future-sidebar-width) !important;
        width: calc(100% - var(--future-sidebar-width)) !important;
      }
    }

    @media (max-width: 1199.98px) {
      body.admin-future-template .app-body > .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        z-index: 1040;
        width: 240px !important;
        flex: 0 0 240px !important;
        transform: translateX(-100%) !important;
        transition: transform .22s ease !important;
      }

      body.admin-future-template.sidebar-show .app-body > .sidebar,
      body.admin-future-template.sidebar-lg-show .app-body > .sidebar {
        transform: translateX(0) !important;
      }

      body.admin-future-template .app-body > .main,
      body.admin-future-template.sidebar-lg-show .app-body > .main,
      body.admin-future-template.sidebar-show .app-body > .main {
        margin-left: 0 !important;
        width: 100% !important;
      }

      body.admin-future-template .app-header,
      body.admin-future-template.sidebar-lg-show .app-header {
        left: 0 !important;
        width: 100% !important;
      }

      body.admin-future-template.sidebar-show .app-body > .main,
      body.admin-future-template.sidebar-lg-show .app-body > .main {
        margin-left: 240px !important;
        width: calc(100% - 240px) !important;
      }

      body.admin-future-template.sidebar-show .app-header,
      body.admin-future-template.sidebar-lg-show .app-header {
        left: 240px !important;
        width: calc(100% - 240px) !important;
      }

      body.admin-future-template .app-body > .sidebar .sidebar-nav {
        height: 100% !important;
        max-height: calc(100vh - var(--future-header-height)) !important;
      }
    }
    @endif

    body .main .btn:not(.btn-link),
    body .main a.btn:not(.btn-link),
    body .main button.btn:not(.btn-link),
    body .main .dt-button,
    body .main .page-block-action-btn,
    body .main .dashboard-todo-icon-btn,
    body .main .future-new-note-btn,
    body .main .future-mini-tabs button,
    body .main .future-task-tabs button,
    body .modal .btn:not(.btn-link) {
      border-radius: 8px !important;
    }

    body .main [id="dropdownMenuButton"].btn {
      font-weight: 300 !important;
      font-size: .88rem !important;
    }

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
      var isModernTemplate = document.body.classList.contains('admin-modern-template');
      var isFutureTemplate = document.body.classList.contains('admin-future-template');
      if (!isModernTemplate && !isFutureTemplate) return;

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
      if (isModernTemplate && firstSegment === adminPrefix && modernCrudTargets.indexOf(secondSegment) !== -1) {
        document.body.classList.add('admin-modern-crud-refresh');
      }

      var futureUniformButtonTargets = ['page', 'pages_blocks', 'usercustom', 'pluginforms'];
      if (isFutureTemplate && firstSegment === adminPrefix && futureUniformButtonTargets.indexOf(secondSegment) !== -1) {
        document.body.classList.add('admin-future-uniform-buttons');
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
        if (!isModernTemplate) return;

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

      if (isFutureTemplate) {
        var ensureSingleOpenDropdown = function (currentDropdown) {
          if (!sidebar) return;
          var openedDropdowns = sidebar.querySelectorAll('.nav-dropdown.open');
          openedDropdowns.forEach(function (item) {
            if (item !== currentDropdown) {
              item.classList.remove('open');
            }
          });
        };

        document.addEventListener('click', function (event) {
          var toggle = event.target.closest('.nav-dropdown-toggle');
          if (!toggle) return;
          if (!sidebar.contains(toggle)) return;

          var currentDropdown = toggle.closest('.nav-dropdown');
          if (!currentDropdown) return;

          // Wait for CoreUI toggle, then enforce accordion behavior.
          setTimeout(function () {
            ensureSingleOpenDropdown(currentDropdown.classList.contains('open') ? currentDropdown : null);
          }, 0);
        });

        setTimeout(function () {
          var initiallyOpened = sidebar.querySelectorAll('.nav-dropdown.open');
          if (initiallyOpened.length > 1) {
            var preferred = sidebar.querySelector('.nav-dropdown.open .nav-link.active');
            var keeper = preferred ? preferred.closest('.nav-dropdown') : initiallyOpened[0];
            ensureSingleOpenDropdown(keeper);
          }
        }, 0);
      }

    })();
  </script>

  @yield('after_scripts')
  @stack('after_scripts')
</body>
</html>
