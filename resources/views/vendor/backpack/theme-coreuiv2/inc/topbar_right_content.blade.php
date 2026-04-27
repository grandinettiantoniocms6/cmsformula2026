{{-- This file is used to store topbar (right) items --}}

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();
    $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
    $adminNewsUnreadCount = 0;
    $adminNewsList = collect();
    $adminNewsMarkSeenUrl = route('dashboard.news.mark_seen');
    $adminSupportSendUrl = route('dashboard.support.send');

    if(backpack_auth()->check()){
        $newsDbReachableCacheKey = 'admin_news_mysql2_reachable';
        $newsDbReachable = \Cache::get($newsDbReachableCacheKey);
        $useFastProbe = app()->environment('local');

        if(!$useFastProbe){
            $newsDbReachable = true;
        } elseif($newsDbReachable === null){
            $newsDbReachable = true;
            try {
                $mysql2Config = config('database.connections.mysql_2', []);
                $mysql2Host = (string) ($mysql2Config['host'] ?? '');
                $mysql2Port = (int) ($mysql2Config['port'] ?? 3306);

                if($mysql2Host !== ''){
                    $probeTimeout = (float) env('ADMIN_NEWS_DB_PROBE_TIMEOUT', 0.35);
                    $errno = 0;
                    $errstr = '';
                    $socket = @fsockopen($mysql2Host, $mysql2Port, $errno, $errstr, $probeTimeout);
                    if(is_resource($socket)){
                        fclose($socket);
                    } else {
                        $newsDbReachable = false;
                    }
                }
            } catch (\Throwable $e) {
                $newsDbReachable = false;
            }

            \Cache::put($newsDbReachableCacheKey, $newsDbReachable, now()->addSeconds($newsDbReachable ? 60 : 180));
        }

        if($newsDbReachable){
            try {
                $newsConnection = 'mysql_2';
                try {
                    \DB::connection($newsConnection)->getPdo();
                } catch (\Throwable $e) {
                    $newsConnection = 'mysql_2_fallback';
                }

                $baseNewsQuery = \DB::connection($newsConnection)
                    ->table("news")
                    ->whereNull("deleted_at")
                    ->where("is_active", 1);

                $adminNewsList = (clone $baseNewsQuery)
                    ->orderBy("created_at", "desc")
                    ->take(10)
                    ->get();

                $lastSeenKey = 'admin_news_last_seen_at_' . backpack_user()->id;
                $lastSeenAt = \Cache::get($lastSeenKey);
                if(!$lastSeenAt){
                    $lastSeenAt = session($lastSeenKey);
                }
                if($lastSeenAt){
                    $adminNewsUnreadCount = (int) (clone $baseNewsQuery)->where("created_at", ">", $lastSeenAt)->count();
                } else {
                    $adminNewsUnreadCount = (int) (clone $baseNewsQuery)->count();
                }

                \Cache::put($newsDbReachableCacheKey, true, now()->addSeconds(60));
            } catch (\Throwable $e) {
                $adminNewsUnreadCount = 0;
                $adminNewsList = collect();
                \Cache::put($newsDbReachableCacheKey, false, now()->addSeconds(180));
            }
        } else {
            $adminNewsUnreadCount = 0;
            $adminNewsList = collect();
        }
    }
@endphp

<style>
    .topbar-news-link {
        position: relative;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        margin-right: .45rem;
        border-radius: 999px;
    }

    .topbar-news-link i {
        font-size: 1.03rem;
    }

    .topbar-news-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        min-width: 18px;
        height: 18px;
        padding: 0 4px;
        border-radius: 999px;
        background: #e53935;
        color: #fff;
        font-size: .68rem;
        font-weight: 800;
        line-height: 18px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(229, 57, 53, .4);
        pointer-events: none;
    }

    .admin-news-drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(6, 12, 26, .45);
        z-index: 1047;
        opacity: 0;
        pointer-events: none;
        transition: opacity .2s ease;
    }

    .admin-news-drawer {
        position: fixed;
        top: 0;
        right: 0;
        width: min(420px, 92vw);
        height: 100vh;
        z-index: 1048;
        background: #ffffff;
        box-shadow: -10px 0 28px rgba(10, 20, 45, .22);
        transform: translateX(100%);
        transition: transform .24s ease;
        display: flex;
        flex-direction: column;
    }

    .admin-news-drawer.is-open {
        transform: translateX(0);
    }

    .admin-news-drawer-overlay.is-open {
        opacity: 1;
        pointer-events: auto;
    }

    .admin-news-drawer__header {
        min-height: 58px;
        padding: 0 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e2e9f6;
    }

    .admin-news-drawer__title {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-weight: 700;
        color: #1e3762;
    }

    .admin-news-drawer__close {
        border: 0;
        background: transparent;
        color: #50658f;
        width: 34px;
        height: 34px;
        border-radius: 8px;
    }

    .admin-news-drawer__close:hover {
        background: #edf3ff;
        color: #29497c;
    }

    .admin-news-drawer__body {
        overflow-y: auto;
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .admin-news-item {
        border: 1px solid #dbe5f7;
        border-radius: 12px;
        padding: 11px 12px;
        background: #f9fbff;
    }

    .admin-news-item__title {
        font-weight: 700;
        color: #1f3a66;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .admin-news-item__date {
        display: inline-block;
        color: #60779f;
        font-size: .74rem;
        margin-bottom: 6px;
    }

    .admin-news-item__content {
        color: #334a74;
        font-size: .84rem;
        line-height: 1.45;
    }

    .admin-news-item__content p:last-child {
        margin-bottom: 0;
    }

    .admin-news-empty {
        border: 1px dashed #cfdbf0;
        border-radius: 12px;
        padding: 14px;
        text-align: center;
        color: #5a739d;
        background: #f9fbff;
    }

    .admin-support-drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(6, 12, 26, .45);
        z-index: 1047;
        opacity: 0;
        pointer-events: none;
        transition: opacity .2s ease;
    }

    .admin-support-drawer {
        position: fixed;
        top: 0;
        right: 0;
        width: min(440px, 94vw);
        height: 100vh;
        z-index: 1048;
        background: #ffffff;
        box-shadow: -10px 0 28px rgba(10, 20, 45, .22);
        transform: translateX(100%);
        transition: transform .24s ease;
        display: flex;
        flex-direction: column;
    }

    .admin-support-drawer.is-open {
        transform: translateX(0);
    }

    .admin-support-drawer-overlay.is-open {
        opacity: 1;
        pointer-events: auto;
    }

    .admin-support-drawer__header {
        min-height: 58px;
        padding: 0 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e2e9f6;
    }

    .admin-support-drawer__title {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-weight: 700;
        color: #1e3762;
    }

    .admin-support-drawer__close {
        border: 0;
        background: transparent;
        color: #50658f;
        width: 34px;
        height: 34px;
        border-radius: 8px;
    }

    .admin-support-drawer__close:hover {
        background: #edf3ff;
        color: #29497c;
    }

    .admin-support-drawer__body {
        overflow-y: auto;
        padding: 14px;
    }

    .admin-support-form .form-group {
        margin-bottom: .72rem;
    }

    .admin-support-form label {
        display: block;
        margin-bottom: .25rem;
        font-size: .78rem;
        color: #4c6187;
        font-weight: 700;
        letter-spacing: .01em;
    }

    .admin-support-form .form-control {
        border: 1px solid #d6e2f7;
        border-radius: 10px;
        box-shadow: none;
        font-size: .86rem;
    }

    .admin-support-form .form-control:focus {
        border-color: #a8c2ef;
        box-shadow: 0 0 0 2px rgba(76, 120, 198, .1);
    }

    .admin-support-form textarea.form-control {
        min-height: 160px;
        resize: vertical;
    }

    .admin-support-form__submit {
        width: 100%;
        border: 0;
        border-radius: 10px;
        padding: .62rem .8rem;
        background: #132048;
        color: #fff;
        font-weight: 700;
        font-size: .86rem;
    }

    .admin-support-form__submit[disabled] {
        opacity: .7;
        cursor: not-allowed;
    }

    .admin-support-form__feedback {
        display: none;
        margin-bottom: .62rem;
        border-radius: 10px;
        padding: .56rem .7rem;
        font-size: .8rem;
    }

    .admin-support-form__feedback.is-visible {
        display: block;
    }

    .admin-support-form__feedback--success {
        border: 1px solid #cae8d4;
        background: #effcf4;
        color: #2f6a47;
    }

    .admin-support-form__feedback--error {
        border: 1px solid #f0ced0;
        background: #fff4f5;
        color: #8f2a33;
    }
</style>

@if($isModernAdminTemplate)
<style>
    .topbar-news-link {
        background: rgba(255, 255, 255, .14);
        border: 1px solid rgba(255, 255, 255, .22);
        color: var(--admin-topbar-text, #eef4ff) !important;
        transition: all .2s ease;
    }

    .topbar-news-link:hover {
        background: var(--admin-topbar-hover-bg, rgba(255, 255, 255, .14));
        border-color: rgba(255, 255, 255, .35);
        transform: translateY(-1px);
        color: var(--admin-topbar-text, #eef4ff) !important;
        text-decoration: none;
    }

    .topbar-preview-link {
        display: inline-flex !important;
        align-items: center;
        gap: .42rem;
        padding: .38rem .82rem !important;
        margin-right: .35rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, .14);
        border: 1px solid rgba(255, 255, 255, .22);
        color: var(--admin-topbar-text, #eef4ff) !important;
        font-weight: 700;
        letter-spacing: .01em;
        transition: all .2s ease;
    }

    .topbar-preview-link i {
        font-size: .95rem;
        opacity: .95;
    }

    .topbar-preview-link:hover {
        background: var(--admin-topbar-hover-bg, rgba(255, 255, 255, .14));
        color: var(--admin-topbar-text, #eef4ff) !important;
        border-color: rgba(255, 255, 255, .35);
        transform: translateY(-1px);
        box-shadow: 0 8px 16px rgba(7, 16, 40, .2);
        text-decoration: none;
    }

    @if($isModernAdminTemplate02)
    .topbar-news-link {
        background: #edf4ff;
        border-color: #d2e3ff;
        color: #2a4674 !important;
        box-shadow: 0 8px 18px rgba(31, 77, 158, .08);
    }

    .topbar-news-link:hover {
        background: #dfeeff;
        border-color: #bdd8ff;
        color: #1f3e6d !important;
        box-shadow: 0 10px 20px rgba(31, 77, 158, .14);
    }

    .topbar-preview-link {
        background: #edf4ff;
        border-color: #d2e3ff;
        color: #2a4674 !important;
        box-shadow: 0 8px 18px rgba(31, 77, 158, .08);
    }

    .topbar-preview-link:hover {
        background: #dfeeff;
        border-color: #bdd8ff;
        color: #1f3e6d !important;
        box-shadow: 0 10px 20px rgba(31, 77, 158, .14);
    }
    @endif
</style>
@endif

@if($isFutureAdminTemplate)
<style>
    .topbar-news-link,
    .topbar-preview-link,
    .topbar-help-link {
        width: 46px;
        height: 46px;
    }

    .topbar-news-link i,
    .topbar-preview-link i,
    .topbar-help-link i {
        font-size: 1.2rem;
    }

    .topbar-news-link {
        background: #ffffff;
        border: 1px solid #d5e2f8;
        color: #36558d !important;
        transition: all .2s ease;
    }

    .topbar-news-link:hover {
        background: #f3f7ff;
        border-color: #c2d6fb;
        color: #2a4b83 !important;
    }

    .topbar-preview-link {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        gap: .42rem;
        width: auto;
        padding: .38rem .82rem !important;
        height: 38px;
        margin-right: .45rem;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #d5e2f8;
        color: #36558d !important;
        transition: all .2s ease;
    }

    .topbar-preview-link:hover {
        background: #f3f7ff;
        border-color: #c2d6fb;
        color: #2a4b83 !important;
    }

    .topbar-preview-link span {
        display: inline;
        font-weight: 700;
        font-size: .84rem;
        letter-spacing: .01em;
    }

    .topbar-help-link {
        position: relative;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        margin-right: .45rem;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #d5e2f8;
        color: #36558d !important;
        transition: all .2s ease;
    }

    .topbar-help-link:hover {
        background: #f3f7ff;
        border-color: #c2d6fb;
        color: #2a4b83 !important;
    }

    .future-topbar-separator {
        display: inline-flex;
        align-items: center;
        color: #ccd7ea;
        font-weight: 700;
        font-size: .95rem;
        padding: 0 .28rem 0 .05rem;
    }

    @media (max-width: 1499.98px) {
        .topbar-preview-link {
            width: 38px;
            min-width: 38px;
            padding: 0 !important;
            margin-right: .32rem;
            gap: 0;
        }

        .topbar-preview-link span {
            display: none !important;
        }
    }

    @media (max-width: 991.98px) {
        body.admin-future-template .app-header .navbar-nav.ml-auto > li.nav-item.d-md-down-none:not(.future-user-meta-item) {
            display: inline-flex !important;
            min-height: 40px;
        }

        body.admin-future-template .app-header .navbar-nav.ml-auto .future-topbar-separator {
            display: none !important;
        }

        .topbar-news-link,
        .topbar-preview-link,
        .topbar-help-link {
            width: 36px;
            height: 36px;
            min-width: 36px;
            margin-right: .2rem;
        }

        .topbar-news-link i,
        .topbar-preview-link i,
        .topbar-help-link i {
            font-size: 1rem;
        }
    }

    @media (max-width: 767.98px) {
        .topbar-news-link,
        .topbar-preview-link,
        .topbar-help-link {
            width: 34px;
            height: 34px;
            min-width: 34px;
            margin-right: .12rem;
        }
    }

    @media (max-width: 459.98px) {
        .topbar-preview-link,
        .topbar-news-link,
        .topbar-help-link {
            display: none !important;
        }
    }
</style>
@endif

@if(env('NASCONDI_FRONTEND') == 0 && $isFutureAdminTemplate)
    <li class="nav-item d-md-down-none">
        <a class="nav-link topbar-preview-link" href="/" target="_blank" title="Anteprima Web">
            <i class="las la-eye"></i>
            <span>Anteprima Sito</span>
        </a>
    </li>
@endif

<li class="nav-item d-md-down-none">
    <a class="nav-link topbar-news-link" href="#" id="topbar-news-toggle" title="News">
        <i class="las la-bell"></i>
        @if($adminNewsUnreadCount > 0)
            <span class="topbar-news-badge badge badge-pill badge-danger">{{ $adminNewsUnreadCount > 99 ? '99+' : $adminNewsUnreadCount }}</span>
        @endif
    </a>
</li>

@if($isFutureAdminTemplate)
    <li class="nav-item d-md-down-none">
        <a class="nav-link topbar-help-link" href="#" id="topbar-help-toggle" data-admin-support-toggle="1" title="Assistenza">
            <i class="la la-headset"></i>
        </a>
    </li>
    <li class="nav-item d-md-down-none">
        <span class="future-topbar-separator">|</span>
    </li>
@endif

@if(env('NASCONDI_FRONTEND') == 0 && !$isFutureAdminTemplate)
    <li class="nav-item d-md-down-none">
        <a class="nav-link topbar-preview-link" href="/" target="_blank" title="Anteprima Web">
            <i class="las la-eye"></i>
            <span>Anteprima Sito</span>
        </a>
    </li>
@endif

<div id="admin-news-drawer-overlay" class="admin-news-drawer-overlay"></div>
<aside id="admin-news-drawer" class="admin-news-drawer" aria-hidden="true">
    <div class="admin-news-drawer__header">
        <span class="admin-news-drawer__title"><i class="las la-rss"></i> News</span>
        <button type="button" class="admin-news-drawer__close" id="admin-news-drawer-close" aria-label="Chiudi pannello news">
            <i class="las la-times"></i>
        </button>
    </div>
    <div class="admin-news-drawer__body">
        @if($adminNewsList->count() > 0)
            @foreach($adminNewsList as $new)
                <article class="admin-news-item">
                    <div class="admin-news-item__title">{{ $new->title }}</div>
                    @php
                        $newsPublishedAt = $new->published_at ?? $new->publication_date ?? $new->data_pubblicazione ?? $new->created_at ?? null;
                    @endphp
                    @if($newsPublishedAt)
                        <small class="admin-news-item__date">Pubblicata il {{ \Carbon\Carbon::parse($newsPublishedAt)->format("d/m/Y H:i") }}</small>
                    @endif
                    <div class="admin-news-item__content">{!! $new->description !!}</div>
                </article>
            @endforeach
        @else
            <div class="admin-news-empty">Nessuna news disponibile al momento.</div>
        @endif
    </div>
</aside>

@if($isFutureAdminTemplate)
<div id="admin-support-drawer-overlay" class="admin-support-drawer-overlay"></div>
<aside id="admin-support-drawer" class="admin-support-drawer" aria-hidden="true">
    <div class="admin-support-drawer__header">
        <span class="admin-support-drawer__title"><i class="las la-life-ring"></i> Richiedi assistenza</span>
        <button type="button" class="admin-support-drawer__close" id="admin-support-drawer-close" aria-label="Chiudi pannello assistenza">
            <i class="las la-times"></i>
        </button>
    </div>
    <div class="admin-support-drawer__body">
        <div id="admin-support-feedback" class="admin-support-form__feedback"></div>
        <form id="admin-support-form" class="admin-support-form">
            <div class="form-group">
                <label for="admin-support-name">Nome</label>
                <input id="admin-support-name" class="form-control" name="name" type="text" maxlength="120" value="{{ backpack_auth()->check() ? backpack_user()->name : '' }}" required>
            </div>
            <div class="form-group">
                <label for="admin-support-email">Email</label>
                <input id="admin-support-email" class="form-control" name="email" type="email" maxlength="180" value="{{ backpack_auth()->check() ? backpack_user()->email : '' }}" required>
            </div>
            <div class="form-group">
                <label for="admin-support-subject">Oggetto</label>
                <input id="admin-support-subject" class="form-control" name="subject" type="text" maxlength="200" placeholder="Oggetto richiesta" required>
            </div>
            <div class="form-group">
                <label for="admin-support-message">Messaggio</label>
                <textarea id="admin-support-message" class="form-control" name="message" maxlength="6000" placeholder="Descrivi qui il problema..." required></textarea>
            </div>
            <button type="submit" id="admin-support-submit" class="admin-support-form__submit">Invia richiesta</button>
        </form>
    </div>
</aside>
@endif

<script>
  (function () {
    var toggle = document.getElementById('topbar-news-toggle');
    var drawer = document.getElementById('admin-news-drawer');
    var overlay = document.getElementById('admin-news-drawer-overlay');
    var closeBtn = document.getElementById('admin-news-drawer-close');
    if (!toggle || !drawer || !overlay || !closeBtn) return;

    var markSeenUrl = @json($adminNewsMarkSeenUrl);
    var unreadBadge = toggle.querySelector('.topbar-news-badge');
    var hasUnread = !!unreadBadge;
    var markedSeen = false;

    var openDrawer = function () {
      drawer.classList.add('is-open');
      overlay.classList.add('is-open');
      drawer.setAttribute('aria-hidden', 'false');
      document.body.classList.add('admin-news-drawer-open');
    };

    var closeDrawer = function () {
      drawer.classList.remove('is-open');
      overlay.classList.remove('is-open');
      drawer.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('admin-news-drawer-open');
    };

    var markSeen = function () {
      if (!hasUnread || markedSeen || !markSeenUrl) return;
      markedSeen = true;

      var csrf = document.querySelector('meta[name="csrf-token"]');
      fetch(markSeenUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': csrf ? csrf.getAttribute('content') : ''
        },
        body: JSON.stringify({})
      }).then(function () {
        if (unreadBadge && unreadBadge.parentNode) {
          unreadBadge.parentNode.removeChild(unreadBadge);
        }
        hasUnread = false;
      }).catch(function () {
        markedSeen = false;
      });
    };

    toggle.addEventListener('click', function (event) {
      event.preventDefault();
      openDrawer();
      markSeen();
    });

    closeBtn.addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);
    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') closeDrawer();
    });
  })();
</script>

@if($isFutureAdminTemplate)
<script>
  (function () {
    var supportDrawer = document.getElementById('admin-support-drawer');
    var supportOverlay = document.getElementById('admin-support-drawer-overlay');
    var supportClose = document.getElementById('admin-support-drawer-close');
    var supportForm = document.getElementById('admin-support-form');
    var supportSubmit = document.getElementById('admin-support-submit');
    var feedback = document.getElementById('admin-support-feedback');
    if (!supportDrawer || !supportOverlay || !supportClose || !supportForm || !supportSubmit || !feedback) return;

    var supportSendUrl = @json($adminSupportSendUrl);

    var showFeedback = function (message, isSuccess) {
      feedback.className = 'admin-support-form__feedback is-visible ' + (isSuccess ? 'admin-support-form__feedback--success' : 'admin-support-form__feedback--error');
      feedback.textContent = message || '';
    };

    var clearFeedback = function () {
      feedback.className = 'admin-support-form__feedback';
      feedback.textContent = '';
    };

    var closeNewsIfOpen = function () {
      var newsDrawer = document.getElementById('admin-news-drawer');
      var newsOverlay = document.getElementById('admin-news-drawer-overlay');
      if (newsDrawer) {
        newsDrawer.classList.remove('is-open');
        newsDrawer.setAttribute('aria-hidden', 'true');
      }
      if (newsOverlay) {
        newsOverlay.classList.remove('is-open');
      }
      document.body.classList.remove('admin-news-drawer-open');
    };

    var openSupport = function () {
      closeNewsIfOpen();
      supportDrawer.classList.add('is-open');
      supportOverlay.classList.add('is-open');
      supportDrawer.setAttribute('aria-hidden', 'false');
      document.body.classList.add('admin-support-drawer-open');
    };

    var closeSupport = function () {
      supportDrawer.classList.remove('is-open');
      supportOverlay.classList.remove('is-open');
      supportDrawer.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('admin-support-drawer-open');
    };

    document.addEventListener('click', function (event) {
      var helpToggle = event.target ? event.target.closest('[data-admin-support-toggle]') : null;
      if (!helpToggle) return;
      event.preventDefault();
      clearFeedback();
      openSupport();
    });

    supportClose.addEventListener('click', closeSupport);
    supportOverlay.addEventListener('click', closeSupport);

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        closeSupport();
      }
    });

    supportForm.addEventListener('submit', function (event) {
      event.preventDefault();
      clearFeedback();

      var csrf = document.querySelector('meta[name="csrf-token"]');
      var formData = new FormData(supportForm);
      var payload = new URLSearchParams();
      formData.forEach(function (value, key) {
        payload.append(key, value);
      });

      supportSubmit.setAttribute('disabled', 'disabled');
      fetch(supportSendUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrf ? csrf.getAttribute('content') : ''
        },
        body: payload.toString()
      }).then(function (response) {
        return response.json().then(function (data) {
          return { status: response.status, data: data || {} };
        }).catch(function () {
          return { status: response.status, data: {} };
        });
      }).then(function (result) {
        if (result.status >= 200 && result.status < 300 && result.data.ok) {
          showFeedback(result.data.message || 'Richiesta inviata con successo.', true);
          supportForm.reset();
          return;
        }

        var message = (result.data && result.data.message) ? result.data.message : 'Invio non riuscito. Verifica i campi e riprova.';
        if (result.status === 422 && result.data && result.data.errors) {
          var firstErrorKey = Object.keys(result.data.errors)[0];
          var firstErrorList = firstErrorKey ? result.data.errors[firstErrorKey] : null;
          if (firstErrorList && firstErrorList.length) {
            message = firstErrorList[0];
          }
        }
        showFeedback(message, false);
      }).catch(function () {
        showFeedback('Invio non riuscito. Riprova tra qualche secondo.', false);
      }).finally(function () {
        supportSubmit.removeAttribute('disabled');
      });
    });
  })();
</script>
@endif
