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
      // Set active state on menu element
      var full_url = "{{ Request::fullUrl() }}";
      var $navLinks = $(".sidebar-nav li a, .app-header li a");

      // First look for an exact match including the search string
      var $curentPageLink = $navLinks.filter(
          function() { return $(this).attr('href') === full_url; }
      );

      // If not found, look for the link that starts with the url
      if(!$curentPageLink.length > 0){
          $curentPageLink = $navLinks.filter( function() {
            if ($(this).attr('href')?.startsWith(full_url)) {
              return true;
            }

            if (full_url.startsWith($(this).attr('href'))) {
              return true;
            }

            return false;
          });
      }

      // for the found links that can be considered current, make sure
      // - the parent item is open
      $curentPageLink.parents('li').addClass('open');
      // - the actual element is active
      $curentPageLink.each(function() {
        $(this).addClass('active');
      });
  </script>
@endpush
