{{-- This file is used to store topbar (right) items --}}

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
</style>

@if(env('NASCONDI_FRONTEND') == 0)
    <li class="nav-item d-md-down-none">
        <a class="nav-link topbar-preview-link" href="/" target="_blank" title="Anteprima Web">
            <i class="las la-eye"></i>
            <span>Anteprima Sito</span>
        </a>
    </li>
@endif
