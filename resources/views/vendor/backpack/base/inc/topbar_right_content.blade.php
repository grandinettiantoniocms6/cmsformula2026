<!-- This file is used to store topbar (right) items -->
@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();
@endphp
@if($isModernAdminTemplate)
<style>
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

    .topbar-preview-link:hover {
        background: var(--admin-topbar-hover-bg, rgba(255, 255, 255, .14));
        color: var(--admin-topbar-text, #eef4ff) !important;
        border-color: rgba(255, 255, 255, .35);
        transform: translateY(-1px);
        text-decoration: none;
    }

    @if($isModernAdminTemplate02)
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

<!-- Per personalizzare la top bar con icone usare: https://icons8.com/line-awesome -->
<!--<li class="nav-item d-md-down-none"><a class="nav-link" href="https://www.webisland.it/contatti" target="_blank"><i class="las la-headset"></i></a></li>-->
@if(env('NASCONDI_FRONTEND') == 0)
<!--<li class="nav-item d-md-down-none"><a class="nav-link" href="/stat" target="_blank"><i class="las la-chart-bar"></i></a></li>-->
<li class="nav-item d-md-down-none"><a class="nav-link topbar-preview-link" href="/" target="_blank" title="Anteprima Web"><i class="las la-eye"></i> Anteprima Sito</a></li>
@endif

{{-- <li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-bell"></i><span class="badge badge-pill badge-danger">5</span></a></li>
<li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-list"></i></a></li>
<li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-map"></i></a></li> --}}
