{{-- =================================================== --}}
{{-- ========== Top menu items (ordered left) ========== --}}
{{-- =================================================== --}}
@php
    $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
@endphp

@if($isFutureAdminTemplate)
<style>
    .future-topbar-search {
        flex: 1 1 auto;
        max-width: 520px;
        margin: 0 .75rem;
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
        height: 38px;
        border: 1px solid #cfdcf2;
        border-radius: 10px;
        background: #ffffff;
        color: #2b4779;
        font-weight: 600;
        font-size: .84rem;
        padding: 0 .7rem 0 2rem;
    }

    .future-topbar-search .future-topbar-search__input::placeholder {
        color: #7a90b8;
    }

    .future-topbar-search .future-topbar-search__input:focus {
        outline: none;
        border-color: #9fb8e4;
        box-shadow: 0 0 0 3px rgba(66, 114, 199, .12);
    }

    @media (max-width: 1399.98px) {
        .future-topbar-search {
            max-width: 420px;
            margin: 0 .55rem;
        }
    }
</style>
@endif

<ul class="nav navbar-nav d-md-down-none px-3">

    @if (backpack_auth()->check())
        {{-- Topbar. Contains the left part --}}
        @include(backpack_view('inc.topbar_left_content'))
    @endif

</ul>
{{-- ========== End of top menu left items ========== --}}

@if($isFutureAdminTemplate && backpack_auth()->check())
<form class="future-topbar-search d-none d-lg-flex" action="{{ backpack_url('page') }}" method="GET" role="search">
    <div class="future-topbar-search__wrap">
        <i class="la la-search future-topbar-search__icon" aria-hidden="true"></i>
        <input
            type="text"
            name="search"
            class="future-topbar-search__input"
            placeholder="Cerca pagine, prodotti, file..."
            aria-label="Ricerca rapida admin"
        >
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
