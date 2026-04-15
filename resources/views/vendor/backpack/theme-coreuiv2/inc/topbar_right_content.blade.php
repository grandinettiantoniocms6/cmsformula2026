{{-- This file is used to store topbar (right) items --}}

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();
    $adminNewsUnreadCount = 0;
    $adminNewsList = collect();
    $adminNewsMarkSeenUrl = route('dashboard.news.mark_seen');

    if(env("APP_URL") != "http://cmsformula2025.test" && backpack_auth()->check()){
        try {
            $baseNewsQuery = \DB::connection('mysql_2')
                ->table("news")
                ->whereNull("deleted_at")
                ->where("is_active", 1);

            $adminNewsList = (clone $baseNewsQuery)
                ->orderBy("created_at", "desc")
                ->take(10)
                ->get();

            $lastSeenAt = session('admin_news_last_seen_at_' . backpack_user()->id);
            if($lastSeenAt){
                $adminNewsUnreadCount = (int) (clone $baseNewsQuery)->where("created_at", ">", $lastSeenAt)->count();
            } else {
                $adminNewsUnreadCount = (int) (clone $baseNewsQuery)->count();
            }
        } catch (\Throwable $e) {
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

<li class="nav-item d-md-down-none">
    <a class="nav-link topbar-news-link" href="#" id="topbar-news-toggle" title="News">
        <i class="las la-bell"></i>
        @if($adminNewsUnreadCount > 0)
            <span class="topbar-news-badge badge badge-pill badge-danger">{{ $adminNewsUnreadCount > 99 ? '99+' : $adminNewsUnreadCount }}</span>
        @endif
    </a>
</li>

@if(env('NASCONDI_FRONTEND') == 0)
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
