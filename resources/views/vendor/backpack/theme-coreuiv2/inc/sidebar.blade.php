@if (backpack_auth()->check())
    @php
      $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
      $websiteSetting = \App\Models\WebsiteSetting::first();

      $normalizePublicAssetPath = static function (?string $path): string {
          $value = trim((string) $path);
          if ($value === '') {
              return '';
          }

          $value = str_replace('\\', '/', $value);
          $value = preg_replace('#^/?public/#', '', $value) ?? $value;
          return ltrim($value, '/');
      };

      $adminLogoPath = $normalizePublicAssetPath($websiteSetting->logo_admin ?? '');
      $defaultAdminLogoPath = $normalizePublicAssetPath('public/img/commons/admin/logo-login.png');
    @endphp

    {{-- Left side column. contains the sidebar --}}
    <aside class="{{ backpack_theme_config('classes.sidebar') }}" aria-label="Sidebar amministrazione">
      @if($isFutureAdminTemplate)
        <div class="future-sidebar-brand">
          <a href="{{ url(backpack_theme_config('home_link')) }}" title="{{ backpack_theme_config('project_name') }}">
            @if($adminLogoPath !== '')
              <img src="{{ asset($adminLogoPath) }}" alt="Logo admin">
            @else
              <img src="{{ asset($defaultAdminLogoPath) }}" alt="Logo admin">
            @endif
          </a>
        </div>
      @endif

      {{-- sidebar: style can be found in sidebar.less --}}
      <nav class="sidebar-nav overflow-hidden">
        {{-- sidebar menu: : style can be found in sidebar.less --}}
        <ul class="nav">
          {{-- <li class="nav-title">{{ trans('backpack::base.administration') }}</li> --}}
          {{-- ================================================ --}}
          {{-- ==== Recommended place for admin menu items ==== --}}
          {{-- ================================================ --}}

          @include(backpack_view('inc.sidebar_content'))

          {{-- ======================================= --}}
          {{-- <li class="divider"></li> --}}
          {{-- <li class="nav-title">Entries</li> --}}
        </ul>
      </nav>
      {{-- /.sidebar --}}
    </aside>
@endif

@push('before_scripts')
  <script type="text/javascript">
    // Save default sidebar class
    let sidebarClass = (document.body.className.match(/sidebar-(sm|md|lg|xl)-show/) || ['sidebar-lg-show'])[0];
    let sidebarTransition = function(value) {
        document.querySelector('.app-body > .sidebar').style.transition = value || '';
    };

    let isFutureTemplate = document.body.classList.contains('admin-future-template');
    let isMobileOrTablet = window.matchMedia('(max-width: 1199.98px)').matches;
    if (isFutureTemplate && isMobileOrTablet) {
      document.body.classList.remove('sidebar-show', 'sidebar-lg-show');
      sessionStorage.removeItem('sidebar-collapsed');
      sidebarTransition('');
      return;
    }

    // Recover sidebar state
    let sessionState = sessionStorage.getItem('sidebar-collapsed');
    if (sessionState) {
      // disable the transition animation temporarily, so that if you're browsing across
      // pages with the sidebar closed, the sidebar does not flicker into the view
      sidebarTransition("none");
      document.body.classList.toggle(sidebarClass, sessionState === '1');

      // re-enable the transition, so that if the user clicks the hamburger menu, it does have a nice transition
      setTimeout(sidebarTransition, 100);
    }
  </script>
@endpush

@push('after_scripts')
  <script>
      (function () {
        var isFutureTemplate = document.body.classList.contains('admin-future-template');
        if (!isFutureTemplate) return;

        var mobileTabletMedia = window.matchMedia('(max-width: 1199.98px)');
        var responsiveSidebarWidth = 240;
        var main = document.querySelector('.app-body > .main');
        var header = document.querySelector('.app-header');
        var syncFutureMainResponsiveLayout = function () {
          if (!main) return;
          if (!mobileTabletMedia.matches) {
            main.style.marginLeft = '';
            main.style.width = '';
            if (header) {
              header.style.left = '';
              header.style.width = '';
            }
            return;
          }

          var isSidebarOpen = document.body.classList.contains('sidebar-show')
            || document.body.classList.contains('sidebar-lg-show');
          if (isSidebarOpen) {
            main.style.marginLeft = responsiveSidebarWidth + 'px';
            main.style.width = 'calc(100% - ' + responsiveSidebarWidth + 'px)';
            if (header) {
              header.style.left = responsiveSidebarWidth + 'px';
              header.style.width = 'calc(100% - ' + responsiveSidebarWidth + 'px)';
            }
            return;
          }

          main.style.marginLeft = '0';
          main.style.width = '100%';
          if (header) {
            header.style.left = '0';
            header.style.width = '100%';
          }
        };

        var syncFutureResponsiveSidebarState = function () {
          if (!mobileTabletMedia.matches) return;
          // Sotto 1200px usiamo solo la classe offcanvas "sidebar-show".
          if (document.body.classList.contains('sidebar-lg-show')) {
            document.body.classList.remove('sidebar-lg-show');
          }
        };

        syncFutureResponsiveSidebarState();
        syncFutureMainResponsiveLayout();
        window.addEventListener('resize', syncFutureResponsiveSidebarState);
        window.addEventListener('resize', syncFutureMainResponsiveLayout);

        document.addEventListener('click', function (event) {
          var toggler = event.target.closest('.sidebar-toggler');
          if (!toggler) return;
          if (!mobileTabletMedia.matches) return;
          if (toggler.getAttribute('data-toggle') !== 'sidebar-lg-show') return;

          event.preventDefault();
          event.stopPropagation();
          document.body.classList.remove('sidebar-lg-show');
          document.body.classList.toggle('sidebar-show');
          syncFutureMainResponsiveLayout();
        }, true);

        var bodyClassObserver = new MutationObserver(syncFutureMainResponsiveLayout);
        bodyClassObserver.observe(document.body, { attributes: true, attributeFilter: ['class'] });
      })();

      // Store sidebar state
      document.querySelectorAll('.sidebar-toggler').forEach(function(toggler) {
        toggler.addEventListener('click', function() {
          sessionStorage.setItem('sidebar-collapsed', Number(!document.body.classList.contains(sidebarClass)))
          // wait for the sidebar animation to end (250ms) and then update the table headers because datatables uses a cached version
          // and dont update this values if there are dom changes after the table is draw. The sidebar toggling makes
          // the table change width, so the headers need to be adjusted accordingly.
          setTimeout(function() {
            if(typeof crud !== "undefined" && crud.table) {
              crud.table.fixedHeader.adjust();
            }
          }, 300);
        })
      });
      // Set active state on sidebar menu element
      var fullUrl = window.location.href;
      var $sidebarLinks = $(".sidebar-nav li a[href]");

      var toAbsolute = function(url) {
        if (!url) return '';
        try {
          return new URL(url, window.location.origin);
        } catch (e) {
          return null;
        }
      };

      var normalizePath = function(path) {
        var clean = decodeURIComponent((path || '').replace(/\/+$/, ''));
        return clean.toLowerCase();
      };

      var currentUrl = toAbsolute(fullUrl);
      var currentPath = normalizePath(currentUrl ? currentUrl.pathname : '');
      var currentSearch = currentUrl ? (currentUrl.search || '') : '';

      var $currentPageLink = $();
      var bestScore = -1;

      $sidebarLinks.each(function() {
        var $link = $(this);
        var href = $link.attr('href');
        if (!href || href === '#' || href.indexOf('javascript:') === 0) {
          return;
        }

        var linkUrl = toAbsolute(href);
        if (!linkUrl) return;

        var linkPath = normalizePath(linkUrl.pathname);
        if (!linkPath) return;

        var exactPathMatch = currentPath === linkPath;
        var childPathMatch = currentPath.indexOf(linkPath + '/') === 0;
        var pathMatch = exactPathMatch || childPathMatch;
        if (!pathMatch) return;

        var linkSearch = linkUrl.search || '';
        var searchMatches = !linkSearch || currentSearch === linkSearch;
        var score = linkPath.length + (searchMatches ? 1000 : 0);

        if (score > bestScore) {
          bestScore = score;
          $currentPageLink = $link;
        }
      });

      if ($currentPageLink.length) {
        // - the parent dropdown is open
        $currentPageLink.parents('li.nav-dropdown').addClass('open');
        // - the current submenu item is active
        $currentPageLink.addClass('active');
        $currentPageLink.closest('li.nav-item').addClass('active');
        // - parent dropdown toggle stays active too
        $currentPageLink.parents('li.nav-dropdown').children('a.nav-link.nav-dropdown-toggle').addClass('active');
      }
  </script>
@endpush
