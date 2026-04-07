<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">

<head>
  @include(backpack_view('inc.head'))

</head>

<body class="{{ config('backpack.base.body_class') }}">

  @include(backpack_view('inc.main_header'))

  <div class="app-body">

    @include(backpack_view('inc.sidebar'))

    <main class="main pt-2">

       @yield('before_breadcrumbs_widgets')

       @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs'))

       @yield('after_breadcrumbs_widgets')

       @yield('header')

        <div class="container-fluid">

          @yield('before_content_widgets')

          @yield('content')

          @yield('after_content_widgets')

        </div>

    </main>

  </div><!-- ./app-body -->

  <footer class="{{ config('backpack.base.footer_class') }}">
    @include(backpack_view('inc.footer'))
  </footer>

  <button id="admin-scroll-top" type="button" aria-label="Torna su" title="Torna su">
    <i class="la la-angle-up" aria-hidden="true"></i>
  </button>

  <style>
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
  </script>

  @yield('after_scripts')
  @stack('after_scripts')
</body>
</html>
