{{-- =================================================== --}}
{{-- ========== Top menu items (ordered left) ========== --}}
{{-- =================================================== --}}
@php
    $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
@endphp

@if($isFutureAdminTemplate)
<style>
    body.admin-future-template .app-header {
        position: relative;
    }

    .future-topbar-search {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 380px;
        margin: 0;
    }

    .future-topbar-search .future-topbar-search__wrap {
        position: relative;
        width: 100%;
    }

    .future-topbar-search .future-topbar-search__icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(52, 80, 130, .7);
        font-size: .9rem;
        pointer-events: none;
    }

    .future-topbar-search .future-topbar-search__input {
        width: 100%;
        height: 40px;
        border: 1px solid #cfdcf2;
        border-radius: 10px;
        background: #ffffff;
        color: #2b4779;
        font-weight: 600;
        font-size: .87rem;
        padding: 0 .82rem 0 2.15rem;
    }

    .future-topbar-search .future-topbar-search__input::placeholder {
        color: #7a90b8;
    }

    .future-topbar-search .future-topbar-search__input:focus {
        outline: none;
        border-color: #9fb8e4;
        box-shadow: 0 0 0 3px rgba(66, 114, 199, .12);
    }

    .future-topbar-search .future-topbar-search__results {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #d4e0f4;
        border-radius: 10px;
        box-shadow: 0 10px 24px rgba(20, 45, 90, .14);
        max-height: 340px;
        overflow-y: auto;
        display: none;
        z-index: 1090;
    }

    .future-topbar-search .future-topbar-search__results.is-open {
        display: block;
    }

    .future-topbar-search .future-topbar-search__result-item {
        display: block;
        padding: .56rem .7rem;
        border-bottom: 1px solid #edf2fc;
        color: #24467c;
        text-decoration: none;
    }

    .future-topbar-search .future-topbar-search__result-item:last-child {
        border-bottom: 0;
    }

    .future-topbar-search .future-topbar-search__result-item:hover {
        background: #f3f7ff;
        text-decoration: none;
    }

    .future-topbar-search .future-topbar-search__result-label {
        display: block;
        font-size: .83rem;
        font-weight: 700;
        color: #233f70;
        line-height: 1.28;
    }

    .future-topbar-search .future-topbar-search__result-desc {
        display: block;
        font-size: .72rem;
        color: #6a83af;
        margin-top: 1px;
    }

    .future-topbar-search .future-topbar-search__result-empty {
        padding: .66rem .7rem;
        color: #6f86ae;
        font-size: .78rem;
    }

    @media (max-width: 1399.98px) {
        .future-topbar-search {
            max-width: 320px;
        }
    }

    body.admin-future-template .app-header > ul.navbar-nav.ml-auto {
        margin-left: 0 !important;
    }

    body.admin-future-template .future-topbar-left {
        display: inline-flex;
        align-items: center;
        flex: 0 0 auto;
        white-space: nowrap;
        margin-left: 0;
    }

    body.admin-future-template .future-topbar-left .nav-item {
        display: inline-flex;
        align-items: center;
        min-height: var(--future-header-height);
    }
</style>
@endif

<ul class="nav navbar-nav d-md-down-none px-3 future-topbar-left">

    @if (backpack_auth()->check())
        {{-- Topbar. Contains the left part --}}
        @include(backpack_view('inc.topbar_left_content'))
    @endif

</ul>
{{-- ========== End of top menu left items ========== --}}

@if($isFutureAdminTemplate && backpack_auth()->check())
<form class="future-topbar-search d-none d-lg-flex" action="{{ route('dashboard.quick_search') }}" method="GET" role="search" data-suggest-url="{{ route('dashboard.quick_search_suggest') }}">
    <div class="future-topbar-search__wrap">
        <i class="la la-search future-topbar-search__icon" aria-hidden="true"></i>
        <input
            type="text"
            name="search"
            class="future-topbar-search__input"
            placeholder="Cerca pagine o impostazioni..."
            aria-label="Ricerca rapida admin"
        >
        <div class="future-topbar-search__results" id="future-topbar-search-results"></div>
    </div>
</form>
@endif


{{-- ========================================================= --}}
{{-- ========= Top menu right items (ordered right) ========== --}}
{{-- ========================================================= --}}
<ul class="nav navbar-nav ml-auto @if(backpack_theme_config('html_direction') == 'rtl') mr-0 @endif">
    @if (backpack_auth()->guest())
        <li class="nav-item"><a class="nav-link" href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a>
        </li>
        @if (config('backpack.base.registration_open'))
            <li class="nav-item"><a class="nav-link" href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a></li>
        @endif
    @else
        {{-- Topbar. Contains the right part --}}
        @include(backpack_view('inc.topbar_right_content'))
        @include(backpack_view('inc.menu_user_dropdown'))
    @endif
</ul>
{{-- ========== End of top menu right items ========== --}}

@if($isFutureAdminTemplate && backpack_auth()->check())
<script>
  (function () {
    var form = document.querySelector('.future-topbar-search');
    if (!form) return;

    var input = form.querySelector('input[name="search"]');
    var resultsBox = form.querySelector('#future-topbar-search-results');
    var suggestUrl = form.getAttribute('data-suggest-url');
    if (!input || !resultsBox || !suggestUrl) return;

    var debounceTimer = null;
    var activeController = null;
    var minChars = 2;

    var escapeHtml = function (value) {
      return String(value || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    };

    var closeResults = function () {
      resultsBox.classList.remove('is-open');
      resultsBox.innerHTML = '';
    };

    var renderResults = function (items) {
      if (!Array.isArray(items) || items.length === 0) {
        resultsBox.innerHTML = '<div class="future-topbar-search__result-empty">Nessun risultato</div>';
        resultsBox.classList.add('is-open');
        return;
      }

      var html = items.map(function (item) {
        var label = escapeHtml(item.label || '');
        var description = escapeHtml(item.description || '');
        var url = escapeHtml(item.url || '#');
        return '<a class="future-topbar-search__result-item" href="' + url + '">' +
          '<span class="future-topbar-search__result-label">' + label + '</span>' +
          '<span class="future-topbar-search__result-desc">' + description + '</span>' +
          '</a>';
      }).join('');

      resultsBox.innerHTML = html;
      resultsBox.classList.add('is-open');
    };

    var fetchSuggestions = function (query) {
      if (activeController) {
        activeController.abort();
      }

      activeController = new AbortController();
      var requestUrl = suggestUrl + '?q=' + encodeURIComponent(query);

      fetch(requestUrl, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        signal: activeController.signal
      })
        .then(function (response) {
          if (!response.ok) return { items: [] };
          return response.json();
        })
        .then(function (payload) {
          var currentQuery = String(input.value || '').trim();
          if (currentQuery !== query) return;
          renderResults(payload.items || []);
        })
        .catch(function (error) {
          if (error && error.name === 'AbortError') return;
          closeResults();
        });
    };

    input.addEventListener('input', function () {
      var query = String(input.value || '').trim();
      if (debounceTimer) {
        clearTimeout(debounceTimer);
      }

      if (query.length < minChars) {
        closeResults();
        return;
      }

      debounceTimer = setTimeout(function () {
        fetchSuggestions(query);
      }, 220);
    });

    input.addEventListener('focus', function () {
      var query = String(input.value || '').trim();
      if (query.length >= minChars && !resultsBox.classList.contains('is-open')) {
        fetchSuggestions(query);
      }
    });

    input.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        closeResults();
      }
    });

    document.addEventListener('click', function (event) {
      if (!form.contains(event.target)) {
        closeResults();
      }
    });
  })();
</script>
@endif
