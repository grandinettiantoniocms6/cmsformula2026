﻿﻿@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
    if ($isFutureAdminTemplate) {
        $breadcrumbs = [];
    }
@endphp

@php
    $blocks_in_page = \App\Models\PageBlock::where("page_id", $page->id)->get();
    $blocks_active_count = (int) $blocks_in_page->where('is_active', 1)->count();
    $blocks_inactive_count = max(0, (int) $blocks_in_page->count() - $blocks_active_count);
@endphp

@section('header')
    @if(!$isFutureAdminTemplate)
        <div class="pages-blocks-header-shell">
            <div class="pages-blocks-header-main">
                <h3 class="page-title mb-0">
                    <span class="text-capitalize">{{ $page->name }}</span>
                    <small>({{ count($blocks_in_page) }} blocchi creati)</small>
                </h3>
            </div>
        </div>
    @else
        <div class="future-page-blocks-commandbar future-page-blocks-commandbar--board">
            <div class="future-page-blocks-commandbar__row future-page-blocks-commandbar__row--primary">
                <div class="future-page-blocks-commandbar__left">
                    <div class="future-page-blocks-commandbar__title-wrap">
                        <strong class="future-page-blocks-commandbar__title">{{ $page->name }}</strong>
                        <span class="future-page-blocks-commandbar__meta">{{ count($blocks_in_page) }} blocchi</span>
                    </div>
                    <div class="future-page-blocks-kpis">
                        <span class="future-page-blocks-kpi"><i class="la la-layer-group"></i> Totali: {{ count($blocks_in_page) }}</span>
                        <span class="future-page-blocks-kpi is-good"><i class="la la-eye"></i> Attivi: {{ $blocks_active_count }}</span>
                        <span class="future-page-blocks-kpi is-muted"><i class="la la-eye-slash"></i> Disattivi: {{ $blocks_inactive_count }}</span>
                    </div>
                </div>
            </div>
            <div class="future-page-blocks-commandbar__primary-actions">
                @if($page->slug == "/")
                    <a href="/" target="_blank" class="btn btn-sm btn-secondary pages-toolbar-btn">
                        <span><i class="la la-eye"></i></span>
                        <span>Anteprima</span>
                    </a>
                @else
                    <a href="/{{ $page->slug }}" target="_blank" class="btn btn-sm btn-secondary pages-toolbar-btn">
                        <span><i class="la la-eye"></i></span>
                        <span>Anteprima</span>
                    </a>
                @endif

                <a href="/admin/page/{{ $page->id }}/edit" class="btn btn-sm btn-outline-dark pages-toolbar-btn">
                    <span><i class="la la-pencil"></i></span>
                    <span>Layout pagina</span>
                </a>
            </div>
            <div class="future-page-blocks-commandbar__row future-page-blocks-commandbar__row--tools">
                <label class="future-page-blocks-search mb-0">
                    <i class="la la-search" aria-hidden="true"></i>
                    <input type="text" data-block-search="1" placeholder="Cerca blocchi..." aria-label="Cerca blocchi">
                </label>
                <button type="button" class="future-page-blocks-chip is-active" data-filter-section="all">Tutti</button>
                <button type="button" class="future-page-blocks-chip" data-filter-section="header">Header</button>
                <button type="button" class="future-page-blocks-chip" data-filter-section="content">Contenuto</button>
                <button type="button" class="future-page-blocks-chip" data-filter-section="footer">Footer</button>
                <button type="button" class="future-page-blocks-chip future-page-blocks-chip-neutral" data-collapse-all="1">Comprimi</button>

                <div class="future-page-blocks-view-switch" role="group" aria-label="Vista blocchi">
                    <button type="button" class="future-page-blocks-view-btn is-active" data-view-mode="visual">Visuale</button>
                    <button type="button" class="future-page-blocks-view-btn" data-view-mode="compact">Compatta</button>
                </div>
                <button type="button" class="future-page-blocks-chip" data-toggle-block-library="1" data-toggle-block-library-label="1">Nascondi libreria</button>
            </div>
        </div>
    @endif
@endsection

@section('before_breadcrumbs_widgets')
    @if(!$isFutureAdminTemplate)
        <div class="col-auto pages-blocks-top-actions">
            @if($page->slug == "/")
                <a href="/" target="_blank" class="btn btn-sm btn-secondary pages-toolbar-btn">
                    <span><i class="la la-eye"></i></span>
                    <span class="d-none d-md-inline">Anteprima</span>
                </a>
            @else
                <a href="/{{ $page->slug }}" target="_blank" class="btn btn-sm btn-secondary pages-toolbar-btn">
                    <span><i class="la la-eye"></i></span>
                    <span class="d-none d-md-inline">Anteprima</span>
                </a>
            @endif

            <a href="/admin/page/{{ $page->id }}/edit" class="btn btn-sm btn-outline-dark pages-toolbar-btn">
                <span><i class="la la-pencil"></i></span>
                <span class="d-none d-md-inline">Layout pagina</span>
            </a>
        </div>
    @endif
@endsection

@section('after_breadcrumbs_widgets')
    @if(!$isFutureAdminTemplate)
        <div class="col">
            <ol class="breadcrumb bg-transparent p-0 justify-content-end">
                <li class="breadcrumb-item text-capitalize"><a href="/admin/dashboard">Bacheca</a></li>
                <li class="breadcrumb-item text-capitalize"><a href="/admin/page">pagine</a></li>
                <li class="breadcrumb-item text-capitalize active" aria-current="page">{{ $page->name }}</li>
            </ol>
        </div>
    @endif
@endsection


@section('after_styles')
    <!-- include select2 css-->
    <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    @if(!$isModernAdminTemplate)
    <style>
        .pages-blocks-shell .blocks-section-title {
            border: 1px solid #d6dce8;
            border-radius: 4px;
            font-weight: 700;
            padding: 8px 12px;
            margin-bottom: 8px;
            color: #fff;
        }

        .pages-blocks-shell .blocks-section-title.section-header {
            background-color: #141b36;
            border-color: #141b36;
        }

        .pages-blocks-shell .blocks-section-title.section-content {
            background-color: #47c29a;
            border-color: #47c29a;
        }

        .pages-blocks-shell .blocks-section-title.section-footer {
            background-color: #f4be00;
            border-color: #f4be00;
            color: #1f2a44;
        }
    </style>
    @endif
    @if($isModernAdminTemplate)
    <style>
        input.search::placeholder {
            color: #333;
        }

        .pages-blocks-header-shell {
            background: linear-gradient(120deg, #ffffff 0%, #f3f7ff 100%);
            border: 1px solid #dbe5fb;
            border-radius: 14px;
            padding: 14px 16px;
            box-shadow: 0 8px 22px rgba(24, 43, 81, 0.08);
        }

        .pages-blocks-header-main {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pages-blocks-header-inline-tools {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
            flex-wrap: wrap;
        }

        .pages-blocks-header-inline-tools .breadcrumb {
            margin-bottom: 0;
        }

        .pages-blocks-header-shell .page-title {
            color: #182b51;
            font-weight: 700;
            display: flex;
            align-items: baseline;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pages-blocks-header-shell .page-title small {
            color: #5f6f95;
            font-size: .9rem;
            font-weight: 600;
        }

        .pages-blocks-top-actions .pages-toolbar-btn {
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 6px 14px rgba(20, 39, 75, 0.12);
            transition: transform .12s ease, box-shadow .12s ease;
        }

        .pages-blocks-top-actions .pages-toolbar-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(20, 39, 75, 0.16);
        }

        .pages-blocks-shell .blocks-section-title {
            border: 0;
            border-radius: 12px;
            font-weight: 700;
            padding: 10px 14px;
            margin-bottom: 8px;
            box-shadow: 0 6px 16px rgba(21, 37, 70, 0.12);
            color: #fff;
            letter-spacing: .01em;
        }

        .pages-blocks-shell .blocks-section-title i {
            opacity: .9;
            margin-right: 5px;
        }

        .pages-blocks-shell .blocks-section-title.section-header {
            background: linear-gradient(90deg, #3f72c2 0%, #5586d6 100%);
        }

        .pages-blocks-shell .blocks-section-title.section-content {
            background: linear-gradient(90deg, #31aa8a 0%, #4cc1a2 100%);
        }

        .pages-blocks-shell .blocks-section-title.section-footer {
            background: linear-gradient(90deg, #f4b000 0%, #ffc93b 100%);
            color: #2c2c2c;
        }

        .pages-blocks-shell .card.my-0 {
            border: 1px solid #dfe7f5;
            border-radius: 12px;
            box-shadow: 0 10px 22px rgba(18, 34, 68, 0.07);
            overflow: hidden;
        }

        .pages-blocks-shell .card.my-0 .card-header {
            background: #f7f9ff;
            border-bottom: 1px solid #e2e9f7;
            color: #22375f;
            font-weight: 700;
        }

        .pages-blocks-shell .card.my-0 .card-header .btn {
            border-radius: 9px;
            font-weight: 700;
            box-shadow: none;
        }

        .pages-blocks-shell .card.my-0 .list-group-item {
            border: 1px solid #e5ebf7 !important;
            border-radius: 10px;
            background: #ffffff;
            margin-bottom: 8px;
            padding: 12px;
            transition: border-color .12s ease, box-shadow .12s ease, transform .12s ease;
        }

        .pages-blocks-shell .card.my-0 .list-group-item:hover {
            border-color: #cddbf7 !important;
            box-shadow: 0 8px 16px rgba(28, 50, 93, 0.1);
            transform: translateY(-1px);
        }

        .pages-blocks-shell .card.my-0 .list-group-item em {
            color: #4d6fb2 !important;
            font-style: italic;
        }

        .pages-blocks-shell .card.my-0 .list-group-item .btn {
            border-radius: 8px;
            min-width: 36px;
            font-weight: 600;
        }

        .pages-blocks-shell .text-danger.d-flex.align-items-center.py-1.px-2 {
            border: 1px solid #f7d1d6;
            background: #fff3f4;
            border-radius: 10px;
            padding: 10px 12px !important;
            margin-top: 4px;
        }
    </style>
    @endif
    @if($isFutureAdminTemplate)
    <style>
        .future-blocks-modal-dialog {
            max-width: 1180px;
        }

        .future-blocks-modal-content {
            border-radius: 14px;
            border: 1px solid #dbe6fb;
            box-shadow: 0 20px 42px rgba(13, 34, 74, .16);
            overflow: hidden;
        }

        .future-blocks-modal-header {
            padding: 14px 16px 12px;
            border-bottom: 1px solid #e3ebfa;
            background: linear-gradient(180deg, #ffffff 0%, #f6f9ff 100%);
        }

        .future-blocks-modal-header .modal-title {
            font-weight: 800;
            color: #132048;
            letter-spacing: -.01em;
        }

        .future-modal-close {
            color: #1f3366;
            opacity: .9;
        }

        .future-blocks-modal-body {
            padding: 12px 14px 6px;
            background: #f8fbff;
        }

        .future-blocks-tabs {
            border-bottom: 1px solid #dae4f7;
            margin-bottom: 10px;
        }

        .future-blocks-tabs .nav-link {
            border: 0;
            border-radius: 8px 8px 0 0;
            color: #476296;
            font-weight: 700;
            padding: .52rem .72rem;
        }

        .future-blocks-tabs .nav-link.active {
            color: #132048;
            background: #ffffff;
            border: 1px solid #dbe6fb;
            border-bottom-color: #ffffff;
        }

        .future-blocks-tab-content {
            background: #ffffff;
            border: 1px solid #dbe6fb;
            border-radius: 0 10px 10px 10px;
            padding: 8px 10px 10px;
        }

        .future-name-group label {
            color: #2a4375;
            font-weight: 700;
            font-size: .84rem;
        }

        .future-blocks-search-input {
            border: 1px solid #cfdbf2;
            border-radius: 10px;
            min-height: 40px;
            background: #f9fbff !important;
        }

        .future-blocks-search-input:focus {
            border-color: #8ca9df;
            box-shadow: 0 0 0 3px rgba(64, 106, 198, .12);
            background: #fff !important;
        }

        .future-category-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 10px;
        }

        .future-category-pills .btn {
            border-radius: 999px;
            border: 1px solid #d3def3;
            color: #274074;
            background: #f7faff;
            font-weight: 700;
            font-size: .73rem;
            padding: .24rem .58rem;
            line-height: 1.2;
            box-shadow: none;
        }

        .future-category-pills .btn.is-active {
            background: #132048;
            border-color: #132048;
            color: #fff;
        }

        .future-blocks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(215px, 1fr));
            gap: 10px;
        }

        .future-block-card {
            margin: 0;
            border: 1px solid #dbe6fb;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease, transform .15s ease;
        }

        .future-block-card:hover {
            border-color: #b6caee;
            box-shadow: 0 10px 22px rgba(19, 42, 86, .12);
            transform: translateY(-1px);
        }

        .future-block-card .card__body-cover {
            height: 118px;
            background: #edf3ff;
        }

        .future-block-card .card__body-cover-image {
            object-fit: cover;
            height: 100%;
        }

        .future-block-card .card__body-header {
            padding: 10px 10px 12px;
            min-height: 74px;
        }

        .future-block-card .card__body-header-title {
            color: #132048;
            font-size: .86rem;
            line-height: 1.3;
            font-weight: 800;
            display: block;
            margin-bottom: 3px;
        }

        .future-block-card .card__body-header-subtitle {
            color: #5e759f;
            font-size: .74rem;
            margin-bottom: 0;
        }

        .future-block-badge {
            display: inline-flex;
            margin-top: 4px;
            padding: .18rem .5rem;
            border-radius: 999px;
            font-size: .68rem;
            font-weight: 700;
            color: #264172;
            border: 1px solid #d1def5;
            background: #f5f9ff;
        }

        .future-blocks-empty {
            margin-top: 8px;
            border: 1px dashed #cfdcf3;
            border-radius: 9px;
            padding: 12px 10px;
            text-align: center;
            font-size: .82rem;
            color: #5f749b;
            background: #f8fbff;
        }

        .future-blocks-modal-footer {
            border-top: 1px solid #e3ebfa;
            background: #fff;
            padding: 10px 12px;
        }

        .future-blocks-modal-footer .btn-dark {
            background: #132048;
            border-color: #132048;
        }

        .pages-blocks-shell .card.my-0 {
            border: 1px solid #dbe6fb;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(14, 35, 76, 0.06);
            overflow: hidden;
            background: #ffffff;
        }

        .pages-blocks-shell .blocks-section-title {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 8px;
            border: 1px solid transparent;
            padding: 7px 11px;
            margin-bottom: 7px;
            font-size: .77rem;
            font-weight: 800;
            letter-spacing: .02em;
            text-transform: uppercase;
            box-shadow: none;
        }

        .pages-blocks-shell .blocks-section-title i {
            font-size: 1rem;
            opacity: .95;
        }

        .pages-blocks-shell .blocks-section-title.section-header {
            background: linear-gradient(140deg, #1f3f88 0%, #2c60cc 100%);
            border-color: #224d9f;
            color: #fff;
        }

        .pages-blocks-shell .blocks-section-title.section-content {
            background: linear-gradient(140deg, #1f7a62 0%, #27a87e 100%);
            border-color: #1f8667;
            color: #fff;
        }

        .pages-blocks-shell .blocks-section-title.section-footer {
            background: linear-gradient(140deg, #8b6712 0%, #c79c2a 100%);
            border-color: #9f7920;
            color: #fff;
        }

        .pages-blocks-shell .card.my-0 .card-header {
            background: linear-gradient(180deg, #fcfdff 0%, #f2f6ff 100%);
            border-bottom: 1px solid #dee8fb;
            padding-top: .44rem !important;
            padding-bottom: .44rem !important;
        }

        .pages-blocks-shell .card.my-0 .card-header > span {
            color: #1f3d73;
            font-weight: 700;
            font-size: .82rem;
            letter-spacing: .01em;
        }

        .pages-blocks-shell .card.my-0 .card-header .btn {
            min-height: 30px;
            border-radius: 6px;
            font-weight: 700;
            padding: 0 8px;
            line-height: 1;
            box-shadow: none !important;
            transition: all .14s ease;
        }

        .pages-blocks-shell .card.my-0 .card-header .btn.btn-info,
        .pages-blocks-shell .card.my-0 .card-header .btn.btn-success,
        .pages-blocks-shell .card.my-0 .card-header .btn.btn-dark {
            border: 1px solid #c8d8f4;
            background: #ffffff;
            color: #204073;
        }

        .pages-blocks-shell .card.my-0 .card-header .btn.btn-info:hover,
        .pages-blocks-shell .card.my-0 .card-header .btn.btn-success:hover,
        .pages-blocks-shell .card.my-0 .card-header .btn.btn-dark:hover {
            background: #edf4ff;
            border-color: #b9cef2;
            color: #132048;
        }

        .pages-blocks-shell .card.my-0 .card-header .btn.btn-warning {
            border: 1px solid #eed39a;
            background: #fff7e5;
            color: #86610a;
        }

        .pages-blocks-shell .card.my-0 .card-header .btn.btn-warning:hover {
            border-color: #e3c178;
            background: #ffefcc;
            color: #735105;
        }

        .pages-blocks-top-actions .pages-toolbar-btn {
            border-radius: 10px;
            border: 1px solid #cfdbf2;
            background: #ffffff;
            color: #23406f;
            font-weight: 700;
            min-height: 34px;
            box-shadow: 0 6px 14px rgba(18, 39, 74, .08);
            transition: all .14s ease;
        }

        .pages-blocks-top-actions .pages-toolbar-btn:hover {
            background: #edf4ff;
            border-color: #bed1f2;
            color: #15315f;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .pages-blocks-shell .page-block-sort-item + .page-block-sort-item {
            margin-top: 6px;
        }

        .pages-blocks-shell [id^="header_col_"],
        .pages-blocks-shell [id^="content_col_"],
        .pages-blocks-shell [id^="footer_col_"] {
            min-height: 72px;
            border: 1px dashed transparent;
            border-radius: 12px;
            transition: border-color .16s ease, background-color .16s ease;
        }

        .pages-blocks-shell [id^="header_col_"]:empty,
        .pages-blocks-shell [id^="content_col_"]:empty,
        .pages-blocks-shell [id^="footer_col_"]:empty {
            border-color: #d8e4fa;
            background: repeating-linear-gradient(
                -45deg,
                #fbfdff,
                #fbfdff 8px,
                #f4f8ff 8px,
                #f4f8ff 16px
            );
            position: relative;
        }

        .pages-blocks-shell [id^="header_col_"]:empty::after,
        .pages-blocks-shell [id^="content_col_"]:empty::after,
        .pages-blocks-shell [id^="footer_col_"]:empty::after {
            content: 'Nessun blocco presente';
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6f83ab;
            font-size: .77rem;
            font-weight: 700;
            letter-spacing: .01em;
        }

        .pages-blocks-shell .page-block-row {
            border: 1px solid #dfe9fb !important;
            border-radius: 8px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            padding: 8px 8px !important;
            min-height: 52px;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(19, 41, 84, 0.05);
            transition: border-color .14s ease, box-shadow .14s ease, transform .14s ease;
            cursor: move;
        }

        .pages-blocks-shell .page-block-row:hover {
            border-color: #c8d9f6 !important;
            box-shadow: 0 6px 12px rgba(19, 41, 84, 0.08);
            transform: none;
        }

        .pages-blocks-shell .page-block-drag {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #4d6fa8;
            background: #edf3ff;
            border: 1px solid #d9e6fc;
            cursor: move;
            flex: 0 0 30px;
            pointer-events: none;
        }

        .pages-blocks-shell .page-block-drag i {
            font-size: .9rem;
        }

        .pages-blocks-shell .page-block-meta {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .pages-blocks-shell .page-block-name {
            color: #1a3568;
            font-size: .78rem;
            font-weight: 700;
            line-height: 1.25;
            max-width: 460px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0 !important;
        }

        .pages-blocks-shell .page-block-type {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-style: normal;
            color: #4f6a98 !important;
            font-size: .71rem;
            font-weight: 700;
            background: #eef4ff;
            border: 1px solid #d6e3f8;
            border-radius: 7px;
            padding: 1px 6px;
            max-width: 100%;
        }

        .pages-blocks-shell .page-block-status {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            min-height: 20px;
            padding: 1px 7px;
            margin-left: 0;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .01em;
            border: 1px solid transparent;
            width: max-content;
        }

        .pages-blocks-shell .page-block-status.is-on {
            background: #ecfbf3;
            border-color: #b9e8ce;
            color: #1d8450;
        }

        .pages-blocks-shell .page-block-status.is-off {
            background: #fff3f5;
            border-color: #f2cdd4;
            color: #c43a53;
        }

        .pages-blocks-shell .page-block-actions {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding-left: 8px;
            flex-wrap: wrap;
        }

        .pages-blocks-shell .page-block-action-btn {
            min-width: 28px;
            min-height: 28px;
            width: 28px;
            height: 28px;
            padding: 0 !important;
            border-radius: 6px !important;
            border: 1px solid #d5e1f7;
            background: #ffffff;
            color: #2a4475;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: none !important;
            transition: background .12s ease, border-color .12s ease, color .12s ease;
        }

        .pages-blocks-shell .page-block-action-btn:hover {
            background: #edf3ff;
            border-color: #bcd1f4;
            color: #132048;
            text-decoration: none;
        }

        .pages-blocks-shell .page-block-action-btn.page-block-action-btn-danger {
            border-color: #f0c4ca;
            background: #fff5f6;
            color: #c63e52;
        }

        .pages-blocks-shell .page-block-action-btn.page-block-action-btn-danger:hover {
            border-color: #e6a8b1;
            background: #ffecef;
            color: #b72b3f;
        }

        .pages-blocks-shell .page-block-action-btn i {
            font-size: .88rem;
        }

        .pages-blocks-shell .page-block-actions .btn-warning.page-block-action-btn {
            width: auto;
            min-width: 86px;
            padding: 0 10px !important;
            background: #fff6de;
            border-color: #efd496;
            color: #8a6308;
            font-weight: 700;
        }

        .pages-blocks-shell .page-block-actions .page-block-inherit-btn {
            width: auto;
            min-width: 106px;
            padding: 0 12px !important;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .01em;
        }

        .pages-blocks-shell .page-block-actions .btn-light.page-block-action-btn:not([class*='text-']) {
            color: #284576;
        }

        .pages-blocks-shell .page-block-toggle-btn.is-on {
            background: #ebfbf2;
            border-color: #b7e8cc;
            color: #1f8a56 !important;
        }

        .pages-blocks-shell .page-block-toggle-btn.is-off {
            background: #fff3f5;
            border-color: #f2ccd4;
            color: #c93b54 !important;
        }

        .pages-blocks-shell .text-danger.d-flex.align-items-center.py-1.px-2 {
            border: 1px solid #f2ced5;
            background: linear-gradient(180deg, #fff6f7 0%, #fff1f3 100%);
            border-radius: 12px;
            padding: 10px 12px !important;
            margin-top: 6px;
            color: #b8364d !important;
            font-weight: 700;
        }

        .pages-blocks-shell .text-danger.d-flex.align-items-center.py-1.px-2 .btn-outline-danger {
            border-radius: 8px;
            font-weight: 700;
            border-color: #d5586e;
            color: #b5334b;
            background: #fff;
        }

        .pages-blocks-shell .text-danger.d-flex.align-items-center.py-1.px-2 .btn-outline-danger:hover {
            background: #ffecef;
        }

        .future-page-blocks-commandbar {
            position: relative;
            z-index: 20;
            margin: 0;
            padding: 8px 10px;
            border: 1px solid #d1def6;
            border-radius: 6px;
            background: linear-gradient(180deg, rgba(255, 255, 255, .98) 0%, rgba(245, 250, 255, .98) 100%);
            box-shadow: 0 3px 12px rgba(17, 36, 72, .05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
        }

        .future-page-blocks-commandbar__left {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            min-width: 0;
            flex-wrap: wrap;
        }

        .future-page-blocks-commandbar__title-wrap {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            min-width: 0;
        }

        .future-page-blocks-commandbar__title {
            color: #152d57;
            font-size: .88rem;
            font-weight: 800;
            white-space: nowrap;
            letter-spacing: .01em;
        }

        .future-page-blocks-commandbar__meta {
            display: inline-flex;
            align-items: center;
            border: 1px solid #d3e0f7;
            border-radius: 5px;
            min-height: 21px;
            padding: .08rem .42rem;
            background: #f6f9ff;
            color: #3f5f96;
            font-size: .71rem;
            font-weight: 800;
            white-space: nowrap;
            letter-spacing: .02em;
            text-transform: uppercase;
        }

        .future-page-blocks-kpis {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            min-width: 0;
            flex-wrap: wrap;
        }

        .future-page-blocks-kpi {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            min-height: 22px;
            padding: 0 .45rem;
            border: 1px solid #d6e2f9;
            border-radius: 5px;
            background: #f7faff;
            color: #3b5a91;
            font-size: .69rem;
            font-weight: 700;
            letter-spacing: .01em;
            white-space: nowrap;
        }

        .future-page-blocks-kpi.is-good {
            border-color: #c6ebda;
            background: #edf9f3;
            color: #1d7f51;
        }

        .future-page-blocks-kpi.is-muted {
            border-color: #e2d8c2;
            background: #faf6ec;
            color: #6f5a2a;
        }

        .future-page-blocks-commandbar__actions {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .future-page-blocks-search {
            position: relative;
            min-width: 230px;
        }

        .future-page-blocks-search .la-search {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6a82ad;
            font-size: .82rem;
            pointer-events: none;
        }

        .future-page-blocks-search input {
            width: 100%;
            min-height: 31px;
            border-radius: 7px;
            border: 1px solid #d3def3;
            background: #ffffff;
            color: #1f3a6e;
            font-size: .76rem;
            font-weight: 600;
            padding: .2rem .62rem .2rem 1.72rem;
            outline: 0;
        }

        .future-page-blocks-search input:focus {
            border-color: #9fb8e4;
            box-shadow: 0 0 0 3px rgba(66, 114, 199, .12);
        }

        body.admin-future-template .future-page-blocks-commandbar .pages-toolbar-btn {
            border-radius: 6px;
            min-height: 30px;
            padding: 0 .6rem;
            display: inline-flex;
            align-items: center;
            gap: .34rem;
        }

        .future-page-blocks-chip {
            border: 1px solid #d2def3;
            border-radius: 5px;
            min-height: 30px;
            padding: 0 .52rem;
            background: #f7faff;
            color: #23406f;
            font-size: .73rem;
            font-weight: 700;
            letter-spacing: .01em;
            transition: all .12s ease;
            line-height: 1;
        }

        .future-page-blocks-chip:hover {
            background: #edf4ff;
            border-color: #c0d2f0;
            color: #1a3566;
        }

        .future-page-blocks-chip.is-active {
            border-color: #1f4ea5;
            background: #1f4ea5;
            color: #fff;
        }

        .future-page-blocks-chip.future-page-blocks-chip-neutral {
            background: #ffffff;
            border-color: #d6e3f8;
            color: #2d4a7f;
        }

        .future-page-blocks-chip.future-page-blocks-chip-neutral.is-collapsed-all {
            background: #1c3d7c;
            border-color: #1c3d7c;
            color: #fff;
        }

        .future-page-blocks-view-switch {
            display: inline-flex;
            align-items: center;
            border: 1px solid #d3def3;
            border-radius: 5px;
            overflow: hidden;
            margin-left: 1px;
            background: #fff;
        }

        .future-page-blocks-view-btn {
            border: 0;
            background: transparent;
            color: #36558d;
            min-height: 30px;
            padding: 0 .5rem;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .01em;
            line-height: 1;
        }

        .future-page-blocks-view-btn + .future-page-blocks-view-btn {
            border-left: 1px solid #d9e4f6;
        }

        .future-page-blocks-view-btn.is-active {
            background: #edf3ff;
            color: #1c3b71;
        }

        .future-page-blocks-section {
            transition: opacity .12s ease;
        }

        .future-page-blocks-section-body {
            margin-bottom: .38rem !important;
        }

        .pages-blocks-shell .row.gutters-pages {
            margin-left: -4px;
            margin-right: -4px;
        }

        .pages-blocks-shell .row.gutters-pages > [class*='col'] {
            padding-left: 4px;
            padding-right: 4px;
        }

        .pages-blocks-shell .card.my-0 .p-2 {
            padding: .38rem !important;
        }

        .future-page-blocks-section-title {
            width: 100%;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
        }

        .future-page-blocks-section-label,
        .future-page-blocks-section-meta {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .future-page-blocks-section-count {
            border: 1px solid rgba(255, 255, 255, .34);
            border-radius: 7px;
            min-height: 20px;
            padding: .06rem .4rem;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .01em;
            line-height: 1.2;
            background: rgba(255, 255, 255, .14);
        }

        .future-page-blocks-section-chevron {
            font-size: 1rem;
            transition: transform .14s ease;
        }

        .future-page-blocks-section.is-collapsed .future-page-blocks-section-body {
            display: none;
        }

        .future-page-blocks-section.is-collapsed .future-page-blocks-section-chevron {
            transform: rotate(180deg);
        }

        .pages-blocks-shell .future-sortable-placeholder {
            border: 2px dashed #9eb8e7;
            border-radius: 11px;
            background: rgba(226, 236, 255, .55);
            min-height: 58px;
            margin-bottom: 8px;
            box-shadow: inset 0 0 0 1px rgba(147, 174, 226, .35);
        }

        .pages-blocks-shell .future-drop-active {
            border-color: #9db7e6 !important;
            background: #f3f7ff !important;
            box-shadow: inset 0 0 0 2px rgba(84, 130, 214, .14) !important;
        }

        .pages-blocks-shell .future-dragging {
            opacity: .9;
            transform: rotate(-.3deg);
            box-shadow: 0 10px 22px rgba(17, 38, 76, .18);
        }

        .pages-blocks-shell.is-compact .card.my-0 .card-header {
            padding-top: .34rem !important;
            padding-bottom: .34rem !important;
        }

        .pages-blocks-shell.is-compact .card.my-0 .card-header > span {
            font-size: .76rem;
        }

        .pages-blocks-shell.is-compact .card.my-0 .card-header .btn {
            min-height: 28px;
            padding: 0 7px;
            font-size: .71rem;
        }

        .pages-blocks-shell.is-compact .page-block-row {
            min-height: 46px;
            padding: 6px 7px !important;
            border-radius: 6px;
            gap: 5px;
        }

        .pages-blocks-shell.is-compact .page-block-name {
            font-size: .79rem;
            margin-bottom: 0 !important;
        }

        .pages-blocks-shell.is-compact .page-block-meta {
            gap: 2px;
        }

        .pages-blocks-shell.is-compact .page-block-type {
            font-size: .67rem;
            padding: 0 5px;
        }

        .pages-blocks-shell.is-compact .page-block-actions {
            gap: 4px;
        }

        .pages-blocks-shell.is-compact .page-block-action-btn {
            width: 26px;
            height: 26px;
            min-width: 26px;
            min-height: 26px;
        }

        /* Future complete restyling */
        body.admin-future-template {
            --future-accent: #2556d8;
            --future-accent-2: #0f2a66;
            --future-surface: #ffffff;
            --future-border: #d5e1f5;
            --future-muted: #5f739a;
            --future-text: #152c56;
        }

        body.admin-future-template .container-fluid.animated.fadeIn {
            background:
                radial-gradient(1400px 580px at 100% -10%, rgba(37, 86, 216, .08) 0%, rgba(37, 86, 216, 0) 62%),
                radial-gradient(900px 420px at -10% 0%, rgba(19, 163, 139, .07) 0%, rgba(19, 163, 139, 0) 58%);
            border: 1px solid #d8e3f6;
            border-radius: 10px;
            padding: 10px !important;
        }

        body.admin-future-template .future-page-blocks-commandbar {
            border-radius: 8px;
            border: 1px solid #183a8c;
            background: linear-gradient(125deg, #102b68 0%, #1b448f 58%, #2b63c4 100%);
            box-shadow: 0 16px 30px rgba(17, 40, 87, .24);
            padding: 9px 10px;
        }

        body.admin-future-template .future-page-blocks-commandbar.future-page-blocks-commandbar--board {
            display: grid;
            gap: 8px;
        }

        body.admin-future-template .future-page-blocks-commandbar__row {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
            min-width: 0;
        }

        body.admin-future-template .future-page-blocks-commandbar__row--primary {
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, .22);
            padding-bottom: 8px;
            width: 100%;
        }

        body.admin-future-template .future-page-blocks-commandbar__row--tools {
            justify-content: flex-start;
            padding-top: 1px;
        }

        body.admin-future-template .future-page-blocks-commandbar__primary-actions {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            flex-wrap: wrap;
            margin-left: auto;
        }

        body.admin-future-template .future-page-blocks-commandbar__title {
            color: #fff;
            font-size: 1.7rem;
        }

        body.admin-future-template .future-page-blocks-commandbar__meta {
            border-color: rgba(255, 255, 255, .34);
            background: rgba(255, 255, 255, .16);
            color: #fff;
        }

        body.admin-future-template .future-page-blocks-kpi {
            border-color: rgba(255, 255, 255, .34);
            background: rgba(255, 255, 255, .14);
            color: #fff;
            font-weight: 800;
        }

        body.admin-future-template .future-page-blocks-kpi.is-good {
            border-color: #9ce3c6;
            background: rgba(30, 157, 107, .22);
            color: #e7fff4;
        }

        body.admin-future-template .future-page-blocks-kpi.is-muted {
            border-color: #c8d8ff;
            background: rgba(223, 232, 255, .2);
            color: #f0f5ff;
        }

        body.admin-future-template .future-page-blocks-search input {
            border-color: rgba(255, 255, 255, .52);
            background: rgba(255, 255, 255, .16);
            color: #fff;
            font-weight: 700;
        }

        body.admin-future-template .future-page-blocks-search input::placeholder {
            color: rgba(255, 255, 255, .78);
        }

        body.admin-future-template .future-page-blocks-search .la-search {
            color: rgba(255, 255, 255, .9);
        }

        body.admin-future-template .future-page-blocks-commandbar .pages-toolbar-btn {
            border: 1px solid rgba(255, 255, 255, .4);
            background: rgba(255, 255, 255, .12);
            color: #fff;
            font-weight: 800;
            min-height: 30px;
        }

        body.admin-future-template .future-page-blocks-commandbar .pages-toolbar-btn:hover {
            background: rgba(255, 255, 255, .22);
            border-color: rgba(255, 255, 255, .58);
        }

        body.admin-future-template .future-page-blocks-chip {
            border-color: rgba(255, 255, 255, .45);
            background: rgba(255, 255, 255, .12);
            color: #fff;
            font-weight: 800;
        }

        body.admin-future-template .future-page-blocks-chip:hover {
            background: rgba(255, 255, 255, .22);
            border-color: rgba(255, 255, 255, .62);
            color: #fff;
        }

        body.admin-future-template .future-page-blocks-chip.is-active {
            background: #fff;
            border-color: #fff;
            color: #184193;
        }

        body.admin-future-template .future-page-blocks-chip.future-page-blocks-chip-neutral.is-collapsed-all {
            background: #fff;
            border-color: #fff;
            color: #153a87;
        }

        body.admin-future-template .future-page-blocks-view-switch {
            border-color: rgba(255, 255, 255, .45);
            background: rgba(255, 255, 255, .12);
        }

        body.admin-future-template .future-page-blocks-view-btn {
            color: #fff;
            font-weight: 800;
        }

        body.admin-future-template .future-page-blocks-view-btn + .future-page-blocks-view-btn {
            border-left-color: rgba(255, 255, 255, .32);
        }

        body.admin-future-template .future-page-blocks-view-btn.is-active {
            background: #fff;
            color: #153a87;
        }

        body.admin-future-template .pages-blocks-shell {
            display: grid;
            gap: 10px;
            margin-top: 8px;
        }

        body.admin-future-template .future-page-blocks-section[data-section="header"] {
            grid-area: future-header;
        }

        body.admin-future-template .future-page-blocks-section[data-section="content"] {
            grid-area: future-content;
        }

        body.admin-future-template .future-page-blocks-section[data-section="footer"] {
            grid-area: future-footer;
        }

        body.admin-future-template .future-page-blocks-section {
            --section-accent: #285ada;
            border: 1px solid #d2def5;
            border-radius: 10px;
            background: #f9fbff;
            box-shadow: 0 10px 20px rgba(18, 42, 90, .08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        body.admin-future-template .future-page-blocks-section[data-section="header"] {
            --section-accent: #285ada;
        }

        body.admin-future-template .future-page-blocks-section[data-section="content"] {
            --section-accent: #1f9a76;
        }

        body.admin-future-template .future-page-blocks-section[data-section="footer"] {
            --section-accent: #bf8518;
        }

        body.admin-future-template .pages-blocks-shell .blocks-section-title.future-page-blocks-section-title {
            background: #fff;
            color: var(--future-text);
            border: 0;
            border-radius: 0;
            margin: 0;
            padding: 10px 12px;
            border-bottom: 1px solid #e0e9fb;
            box-shadow: inset 3px 0 0 var(--section-accent);
            text-transform: none;
            font-size: .8rem;
            letter-spacing: .005em;
        }

        body.admin-future-template .future-page-blocks-section-label i {
            color: var(--section-accent);
            font-size: 1rem;
        }

        body.admin-future-template .future-page-blocks-section-count {
            border-color: #bfd0ef;
            background: #edf3ff;
            color: #274a83;
            font-size: .69rem;
            font-weight: 800;
        }

        body.admin-future-template .future-page-blocks-section-body {
            margin: 0 !important;
            padding: 8px 8px 6px;
            background: linear-gradient(180deg, #f9fbff 0%, #f5f9ff 100%);
        }

        body.admin-future-template .pages-blocks-shell .card.my-0 {
            border: 1px solid #d4e1f6;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 8px 18px rgba(18, 42, 90, .08);
        }

        body.admin-future-template .pages-blocks-shell .card.my-0 .card-header {
            background: #fff;
            border-bottom: 1px solid #e3ebfb;
            padding-top: .42rem !important;
            padding-bottom: .42rem !important;
        }

        body.admin-future-template .pages-blocks-shell .card.my-0 .card-header > span {
            font-size: .76rem;
            font-weight: 800;
            color: #1a3970;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        body.admin-future-template .pages-blocks-shell .card.my-0 .card-header .btn {
            border-radius: 6px;
            min-height: 28px;
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .02em;
            text-transform: uppercase;
            border: 1px solid #ccdaf5;
            background: #f4f8ff;
            color: #23477f;
        }

        body.admin-future-template .pages-blocks-shell .card.my-0 .card-header .btn:hover {
            border-color: #b3c8ee;
            background: #eaf2ff;
            color: #183a70;
        }

        body.admin-future-template .pages-blocks-shell [id^="header_col_"],
        body.admin-future-template .pages-blocks-shell [id^="content_col_"],
        body.admin-future-template .pages-blocks-shell [id^="footer_col_"] {
            border-radius: 8px;
            border-color: #d7e3f9;
            min-height: 74px;
        }

        body.admin-future-template .pages-blocks-shell .page-block-row {
            border: 1px solid #d9e4f8 !important;
            border-radius: 7px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(18, 42, 90, .06);
            min-height: 72px;
            padding-top: 9px !important;
            padding-bottom: 9px !important;
        }

        body.admin-future-template .pages-blocks-shell .page-block-row:hover {
            border-color: #b8cef1 !important;
            box-shadow: 0 8px 16px rgba(18, 42, 90, .11);
            transform: translateY(-1px);
        }

        body.admin-future-template .pages-blocks-shell .page-block-drag {
            border-radius: 5px;
            background: #eef3ff;
            border-color: #d8e4fb;
            color: #3860a5;
        }

        body.admin-future-template .pages-blocks-shell .page-block-name {
            color: #173564;
            font-size: .77rem;
            font-weight: 800;
        }

        body.admin-future-template .pages-blocks-shell .page-block-type {
            font-size: .76rem;
            padding: 1px 6px;
            border-radius: 6px;
            color: #416191 !important;
            background: #eef4ff;
            border-color: #d6e4fb;
            width: max-content;
            font-weight: 800;
        }

        body.admin-future-template .pages-blocks-shell .page-block-status {
            font-size: .64rem;
            min-height: 18px;
            padding: 0 6px;
            margin-left: 0;
        }

        body.admin-future-template .pages-blocks-shell .page-block-actions {
            gap: 4px;
        }

        body.admin-future-template .pages-blocks-shell .page-block-action-btn {
            width: 26px;
            height: 26px;
            min-width: 26px;
            min-height: 26px;
            border-radius: 5px !important;
            border-color: #d6e3f8;
            background: #fff;
            color: #2a4a82;
        }

        body.admin-future-template .pages-blocks-shell .page-block-actions .page-block-inherit-btn {
            width: auto;
            min-width: 82px;
            padding: 0 9px !important;
            gap: 3px;
            white-space: nowrap;
        }

        body.admin-future-template .pages-blocks-shell .page-block-action-btn:hover {
            border-color: #c2d4f3;
            background: #eef4ff;
            color: #14335f;
        }

        body.admin-future-template .pages-blocks-shell .page-block-action-btn.page-block-action-btn-danger {
            border-color: #efc5cf;
            background: #fff5f7;
            color: #c13d55;
        }

        body.admin-future-template .pages-blocks-shell .future-sortable-placeholder {
            border-radius: 7px;
            border-color: #8db0ea;
            background: rgba(210, 224, 250, .5);
            min-height: 52px;
        }

        @media (min-width: 1200px) {
            body.admin-future-template .pages-blocks-shell {
                grid-template-columns: minmax(300px, 1fr) minmax(480px, 1.45fr) minmax(300px, 1fr);
                grid-template-areas: "future-header future-content future-footer";
                align-items: start;
            }

            body.admin-future-template .future-page-blocks-section {
                min-height: calc(100vh - 230px);
                max-height: calc(100vh - 170px);
            }

            body.admin-future-template .future-page-blocks-section-body {
                overflow: auto;
                flex: 1 1 auto;
            }
        }

        @media (max-width: 1199.98px) {
            body.admin-future-template .pages-blocks-shell {
                grid-template-columns: 1fr;
                grid-template-areas:
                    "future-header"
                    "future-content"
                    "future-footer";
            }
        }

        @media (max-width: 991.98px) {
            .pages-blocks-shell .card.my-0 .card-header {
                gap: 8px;
            }

            .pages-blocks-shell .card.my-0 .card-header .btn {
                min-height: 32px;
                padding: 0 8px;
                font-size: .73rem;
            }

            .pages-blocks-shell .page-block-row {
                padding: 8px !important;
                min-height: 58px;
            }

            .pages-blocks-shell .page-block-name {
                font-size: .82rem;
                max-width: 320px;
            }
        }

        @media (min-width: 992px) {
            .future-page-blocks-commandbar {
                flex-wrap: nowrap;
            }

            .future-page-blocks-commandbar__left,
            .future-page-blocks-commandbar__actions {
                flex-wrap: nowrap;
            }
        }

        @media (max-width: 767.98px) {
            .future-page-blocks-commandbar {
                padding: 9px 10px;
                gap: 8px;
            }

            .future-page-blocks-commandbar__left {
                width: 100%;
                justify-content: space-between;
            }

            .future-page-blocks-commandbar__actions {
                width: 100%;
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
            }

            body.admin-future-template .future-page-blocks-commandbar__row--primary {
                border-bottom: 0;
                padding-bottom: 0;
            }

            body.admin-future-template .future-page-blocks-commandbar__primary-actions {
                width: 100%;
            }

            .future-page-blocks-kpis {
                width: 100%;
            }

            .pages-blocks-shell .page-block-actions {
                padding-left: 0;
            }

            .pages-blocks-header-inline-tools {
                width: 100%;
                justify-content: space-between;
                margin-left: 0;
            }

            .pages-blocks-header-inline-tools .breadcrumb {
                width: 100%;
                justify-content: flex-start;
            }
        }

        /* Future minimal layout override */
        body.admin-future-template .container-fluid.animated.fadeIn {
            background: transparent !important;
            border: 0 !important;
            border-radius: 0 !important;
            padding: 0 !important;
        }

        body.admin-future-template .future-page-blocks-commandbar.future-page-blocks-commandbar--board {
            background: #ffffff !important;
            border: 1px solid #d7e1f0 !important;
            box-shadow: 0 2px 10px rgba(17, 38, 76, .06) !important;
            border-radius: 8px !important;
            gap: 6px !important;
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) auto !important;
            grid-template-areas:
                "title actions"
                "tools tools" !important;
            align-items: center !important;
            width: 100% !important;
        }

        body.admin-future-template .future-page-blocks-commandbar__row--primary {
            border-bottom: 1px solid #e7edf7 !important;
            padding-bottom: 7px !important;
            width: 100% !important;
            display: flex !important;
            grid-area: title !important;
            align-items: center !important;
            column-gap: 12px !important;
        }

        body.admin-future-template .future-page-blocks-commandbar__row--tools {
            grid-area: tools !important;
        }

        body.admin-future-template .future-page-blocks-commandbar__row--primary .future-page-blocks-commandbar__left {
            min-width: 0 !important;
        }

        body.admin-future-template .future-page-blocks-commandbar__primary-actions {
            grid-area: actions !important;
            justify-self: end !important;
            margin-left: 0 !important;
            white-space: nowrap !important;
        }

        body.admin-future-template .future-page-blocks-commandbar__title,
        body.admin-future-template .future-page-blocks-commandbar__meta,
        body.admin-future-template .future-page-blocks-kpi,
        body.admin-future-template .future-page-blocks-chip,
        body.admin-future-template .future-page-blocks-view-btn,
        body.admin-future-template .future-page-blocks-search .la-search {
            color: #1f3a67 !important;
        }

        body.admin-future-template .future-page-blocks-commandbar__meta,
        body.admin-future-template .future-page-blocks-kpi,
        body.admin-future-template .future-page-blocks-chip,
        body.admin-future-template .future-page-blocks-view-switch {
            background: #f7f9fc !important;
            border-color: #d7e1f0 !important;
        }

        body.admin-future-template .future-page-blocks-kpi.is-good {
            background: #eef8f2 !important;
            border-color: #c6e7d1 !important;
            color: #1f7b4f !important;
        }

        body.admin-future-template .future-page-blocks-kpi.is-muted {
            background: #f7f4ec !important;
            border-color: #e4dbc6 !important;
            color: #6c5a2b !important;
        }

        body.admin-future-template .future-page-blocks-search input {
            background: #ffffff !important;
            border-color: #d6e0ef !important;
            color: #1f3a67 !important;
            font-weight: 600 !important;
        }

        body.admin-future-template .future-page-blocks-search input::placeholder {
            color: #6f84ab !important;
        }

        body.admin-future-template .future-page-blocks-commandbar .pages-toolbar-btn {
            background: #ffffff !important;
            border: 1px solid #d3deef !important;
            color: #1f3a67 !important;
            box-shadow: none !important;
        }

        body.admin-future-template .future-page-blocks-commandbar .pages-toolbar-btn:hover {
            background: #f4f8ff !important;
            border-color: #bfd0ea !important;
        }

        body.admin-future-template .future-page-blocks-chip.is-active {
            background: #1f4ea5 !important;
            border-color: #1f4ea5 !important;
            color: #fff !important;
        }

        body.admin-future-template .future-page-blocks-section.is-filter-hidden {
            display: none !important;
        }

        body.admin-future-template .future-page-blocks-view-btn.is-active {
            background: #eaf1ff !important;
            color: #153a87 !important;
        }

        body.admin-future-template .pages-blocks-shell {
            display: block !important;
            margin-top: 8px !important;
        }

        body.admin-future-template .future-page-blocks-section {
            display: block !important;
            min-height: auto !important;
            max-height: none !important;
            margin-bottom: 10px !important;
            border: 1px solid #d8e2f1 !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 10px rgba(17, 38, 76, .05) !important;
            background: #ffffff !important;
        }

        body.admin-future-template .future-page-blocks-section:last-child {
            margin-bottom: 0 !important;
        }

        body.admin-future-template .pages-blocks-shell .blocks-section-title.future-page-blocks-section-title {
            box-shadow: none !important;
            border-bottom: 1px solid #e6edf8 !important;
            background: #fbfcff !important;
            padding: 9px 12px !important;
            font-size: .8rem !important;
        }

        body.admin-future-template .future-page-blocks-section-body {
            overflow: visible !important;
            background: #ffffff !important;
            padding: 7px 8px 6px !important;
        }

        body.admin-future-template .pages-blocks-shell .card.my-0 {
            border: 1px solid #dde6f4 !important;
            border-radius: 8px !important;
            box-shadow: none !important;
            background: #fff !important;
        }

        body.admin-future-template .pages-blocks-shell .card.my-0 .card-header {
            background: #fff !important;
            border-bottom: 1px solid #e9eef8 !important;
        }

        body.admin-future-template .pages-blocks-shell .card.my-0 .card-header > span {
            text-transform: none !important;
            letter-spacing: 0 !important;
            font-size: .79rem !important;
            color: #1b3764 !important;
        }

        body.admin-future-template .pages-blocks-shell .page-block-row {
            background: #fff !important;
            border: 1px solid #dce5f3 !important;
            box-shadow: none !important;
            border-radius: 7px !important;
            min-height: 72px !important;
        }

        body.admin-future-template .pages-blocks-shell .page-block-row:hover {
            transform: none !important;
            border-color: #c9d8ee !important;
            box-shadow: 0 1px 6px rgba(17, 38, 76, .07) !important;
        }

        @media (max-width: 767.98px) {
            body.admin-future-template .future-page-blocks-commandbar__row--primary {
                border-bottom: 0 !important;
                padding-bottom: 0 !important;
            }

            body.admin-future-template .future-page-blocks-commandbar.future-page-blocks-commandbar--board {
                grid-template-columns: 1fr !important;
                grid-template-areas:
                    "title"
                    "actions"
                    "tools" !important;
            }

            body.admin-future-template .future-page-blocks-commandbar__primary-actions {
                width: 100%;
                justify-self: stretch !important;
                justify-content: flex-end !important;
            }
        }

        body.admin-future-template .future-page-blocks-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 440px;
            gap: 10px;
            align-items: start;
        }

        @media (min-width: 1200px) {
            body.admin-future-template .future-page-blocks-layout.is-library-collapsed {
                grid-template-columns: minmax(0, 1fr) !important;
            }
        }

        body.admin-future-template .future-page-blocks-main {
            min-width: 0;
        }

        body.admin-future-template .future-block-library {
            position: sticky;
            top: var(--future-library-sticky-top, 92px);
            border: 1px solid #d8e2f1;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(17, 38, 76, .05);
            overflow: hidden;
            max-height: calc(100vh - var(--future-library-sticky-top, 92px) - 12px);
            display: flex;
            flex-direction: column;
            transition: all .18s ease;
            align-self: start;
        }

        body.admin-future-template .future-block-library.is-collapsed {
            width: 0;
            min-width: 0;
            border: 0;
            box-shadow: none;
            opacity: 0;
            pointer-events: none;
            overflow: hidden;
        }

        body.admin-future-template .future-block-library-header {
            padding: 9px 10px;
            border-bottom: 1px solid #e7edf7;
            background: #fbfcff;
        }

        body.admin-future-template .future-block-library-headline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 7px;
        }

        body.admin-future-template .future-block-library-title {
            font-size: .82rem;
            color: #1a3764;
            font-weight: 800;
            display: block;
        }

        body.admin-future-template .future-block-library-toggle {
            border: 1px solid #d3deef;
            background: #fff;
            color: #244679;
            border-radius: 6px;
            min-height: 28px;
            padding: 0 .55rem;
            font-size: .72rem;
            font-weight: 700;
            line-height: 1;
        }

        body.admin-future-template .future-block-library-toggle:hover {
            background: #f4f8ff;
            border-color: #bfd0ea;
            color: #1c3d71;
        }

        body.admin-future-template .future-block-library-search {
            width: 100%;
            border: 1px solid #d8e2f1;
            border-radius: 6px;
            min-height: 32px;
            padding: .3rem .55rem;
            font-size: .76rem;
            color: #1f3a67;
            background: #fff;
        }

        body.admin-future-template .future-block-library-body {
            overflow: auto;
            padding: 8px;
            display: grid;
            gap: 6px;
        }

        body.admin-future-template .future-library-item {
            display: grid;
            grid-template-columns: 160px minmax(0, 1fr) 18px;
            gap: 8px;
            align-items: center;
            border: 1px solid #dbe5f4;
            border-radius: 7px;
            background: #fff;
            padding: 5px;
            cursor: grab;
            user-select: none;
        }

        body.admin-future-template .future-library-item:hover {
            border-color: #c8d8ef;
            background: #f9fbff;
        }

        body.admin-future-template .future-library-item-thumb {
            width: 160px;
            height: 96px;
            border-radius: 5px;
            object-fit: cover;
            border: 1px solid #dce6f5;
            background: #f4f7fd;
        }

        body.admin-future-template .future-library-item-name {
            font-size: .74rem;
            color: #173564;
            font-weight: 700;
            line-height: 1.25;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        body.admin-future-template .future-library-item-drag {
            color: #6b83ab;
            font-size: .86rem;
            text-align: center;
        }

        body.admin-future-template .future-page-blocks-section.is-drop-target {
            border-color: #8fb0e7 !important;
            box-shadow: 0 0 0 2px rgba(47, 97, 185, .16) !important;
        }

        body.admin-future-template .future-drop-zone-target {
            border-color: #8fb0e7 !important;
            background: #f2f7ff !important;
            box-shadow: inset 0 0 0 2px rgba(47, 97, 185, .14) !important;
        }

        body.admin-future-template .future-drop-zone-card {
            border-color: #9bb9e9 !important;
            box-shadow: 0 0 0 2px rgba(47, 97, 185, .1) !important;
        }

        body.admin-future-template .future-block-library-empty {
            padding: 12px 8px;
            text-align: center;
            color: #6f84ab;
            font-size: .75rem;
            border: 1px dashed #d8e2f1;
            border-radius: 7px;
        }

        body.admin-future-template .future-quick-name-modal .modal-content {
            border: 1px solid #d7e2f1;
            border-radius: 10px;
            box-shadow: 0 14px 34px rgba(15, 36, 75, .2);
        }

        body.admin-future-template .future-quick-name-modal .modal-header {
            border-bottom: 1px solid #e6edf8;
            background: #fbfcff;
        }

        body.admin-future-template .future-quick-name-modal .modal-title {
            font-size: .9rem;
            color: #183765;
            font-weight: 800;
        }

        body.admin-future-template .future-quick-name-modal .modal-body label {
            color: #294a7d;
            font-size: .78rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        body.admin-future-template .future-quick-name-modal .form-control {
            border: 1px solid #d5e0ef;
            border-radius: 7px;
            min-height: 36px;
            color: #1f3a67;
        }

        body.admin-future-template .future-quick-name-modal .modal-footer {
            border-top: 1px solid #e6edf8;
            background: #fff;
        }

        @media (max-width: 1199.98px) {
            body.admin-future-template .future-page-blocks-layout {
                grid-template-columns: 1fr;
            }

            body.admin-future-template .future-block-library {
                position: relative;
                top: 0;
                max-height: 420px;
            }
        }

        @media (min-width: 1200px) {
            body.admin-future-template .future-block-library {
                position: sticky !important;
            }
        }

        @media (min-width: 1600px) {
            body.admin-future-template .future-page-blocks-layout {
                grid-template-columns: minmax(0, 1fr) 500px;
            }
        }

    </style>
    @endif
@endsection

@section('content')
    <?php
    $thema = env('TEMA');

    $admin_blocks = \App\Models\AdminBlock::where("is_active", 1)->orderBy("label", "asc")
        ->whereRaw("(templates LIKE '%$thema%' OR templates is null)")
        ->get()->pluck("label", "name")->toArray();

    /*$admin_blocks_exists = \App\Models\PageBlock::selectRaw("blocks_pages.*, admin_blocks.label, admin_blocks.name, admin_blocks.name_table")
        ->join("admin_blocks", "admin_blocks.name", "=", "blocks_pages.type")
        ->whereNotNull("obj_id")
        ->whereNull("is_ereditable_from_id")
        ->whereNull("blocks_pages.deleted_at")
        ->orderBy("admin_blocks.label", "asc")
        ->get();*/

    $admin_blocks_exists = [];

    ?>
    @if($isFutureAdminTemplate)
    <div class="future-page-blocks-layout">
        <div class="future-page-blocks-main">
    @endif
    <div class="pages-blocks-shell">
    <div class="future-page-blocks-section" data-section="header">
    <div class="blocks-section-title section-header future-page-blocks-section-title" data-section-toggle="header" role="button" tabindex="0" aria-expanded="true">
        <span class="future-page-blocks-section-label"><i class="las la-arrow-circle-up"></i> Header pagina / Parte Alta</span>
        <span class="future-page-blocks-section-meta">
            <span class="future-page-blocks-section-count" data-section-count="header">0 blocchi</span>
            <i class="la la-angle-up future-page-blocks-section-chevron" aria-hidden="true"></i>
        </span>
    </div>
    <div class="row gutters-pages mb-3 future-page-blocks-section-body">
        <?php
        $position = "header";
        switch($page->template_header){
            case "row": ?>
                <?php $col = 1;?>
                <div class="col-12 mb-1">
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna unica</span>
                                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>
                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;

            case "two_cols": ?>
                <div class="col-lg-6 mb-1">
                    <?php $col = 1;?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna sinistra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>
                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-1">
                    <?php $col = 2;?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna destra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>
                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;

            case "three_cols":
            ?>
                <div class="col-lg-4 mb-1">
                    <?php $col = 1;?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna sinistra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>
                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-1">
                    <?php $col = 2;?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna centrale</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>
                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-1">
                    <?php $col = 3;?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna destra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
        } ?>
    </div>

    </div>

    <div class="future-page-blocks-section" data-section="content">
    <div class="blocks-section-title section-content future-page-blocks-section-title" data-section-toggle="content" role="button" tabindex="0" aria-expanded="true">
        <span class="future-page-blocks-section-label"><i class="las la-arrows-alt-v"></i> Contenuto pagina / Parte Centrale</span>
        <span class="future-page-blocks-section-meta">
            <span class="future-page-blocks-section-count" data-section-count="content">0 blocchi</span>
            <i class="la la-angle-up future-page-blocks-section-chevron" aria-hidden="true"></i>
        </span>
    </div>
    <div class="row gutters-pages mb-3 future-page-blocks-section-body">
        <?php
        $position = "content";
        switch($page->template){
            case "full_page": ?>
                <div class="col-12 mb-1">
                    <?php $col = 1; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna unica</span>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
            case "sidebar_left": ?>
                <div class="col-lg-5 col-xl-4 mb-1">
                    <?php $col = 1; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Sidebar Sinistra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-xl-8 mb-1">
                    <?php $col = 2; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Contenuto Destro</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                                @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
            case "sidebar_right": ?>
                <div class="col-lg-7 col-xl-8 mb-1">
                    <?php $col = 1; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Contenuto Sinistro</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-4 mb-1">
                    <?php $col = 2; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Sidebar Destra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
            case "three_columns": ?>
                <div class="col-lg-4 mb-1">
                    <?php $col = 1; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna Sinistra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-1">
                    <?php $col = 2; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna Centrale</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-1">
                    <?php $col = 3; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna Destra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
        } ?>
    </div>

    </div>

    <div class="future-page-blocks-section" data-section="footer">
    <div class="blocks-section-title section-footer future-page-blocks-section-title" data-section-toggle="footer" role="button" tabindex="0" aria-expanded="true">
        <span class="future-page-blocks-section-label"><i class="las la-arrow-circle-down"></i> Footer pagina / Parte Bassa</span>
        <span class="future-page-blocks-section-meta">
            <span class="future-page-blocks-section-count" data-section-count="footer">0 blocchi</span>
            <i class="la la-angle-up future-page-blocks-section-chevron" aria-hidden="true"></i>
        </span>
    </div>
    <div class="row gutters-pages mb-4 future-page-blocks-section-body">
        <?php
        $position = "footer";
        switch($page->template_footer){
            case "row": ?>
                <div class="col-12 mb-1">
                    <?php $col = 1; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna unica</span>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="footer_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
            case "two_cols": ?>
            <div class="col-lg-6 mb-1">
                <?php $col = 1; ?>
                <div class="card my-0 h-100">
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna sinistra</span>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
                </div>
            </div>
            <div class="col-lg-6 mb-1">
                <?php $col = 2; ?>
                <div class="card my-0 h-100">
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna destra</span>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
                </div>
            </div>
            <div class="col-12">
                @include('vendor.backpack.base.inc.blocks_loop_limbo')
            </div>
        <?php
        break;
            case "three_cols":
        ?>
            <div class="col-lg-4 mb-1">
            <?php $col = 1; ?>
            <div class="card my-0 h-100">
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna sinistra</span>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
            </div>
        </div>
            <div class="col-lg-4 mb-1">
            <?php $col = 2; ?>
            <div class="card my-0 h-100">
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna centrale</span>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
            </div>
        </div>
            <div class="col-lg-4 mb-1">
            <?php $col = 3; ?>
            <div class="card my-0 h-100">
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna destra</span>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
            </div>
        </div>
            <div class="col-12">
                @include('vendor.backpack.base.inc.blocks_loop_limbo')
            </div>
        <?php
        break;
            case "four_cols":
        ?>
            <div class="col-lg-3 mb-1">
                <?php $col = 1; ?>
                <div class="card my-0 h-100">
                <?php
                $position = "footer";
                $col = 1;
                ?>
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna 1</span>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
            </div>
        </div>
            <div class="col-lg-3 mb-1">
                <?php $col = 2; ?>
                <div class="card my-0 h-100">
                    <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                            <span>Colonna 2</span>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                        </div>

                        <input type="hidden" name="position" value="<?php echo $position;?>">
                        <input type="hidden" name="col" value="<?php echo $col;?>">

                        @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                    </form>
                    <div id="footer_col_<?php echo $col;?>" class="p-2">
                        @include('vendor.backpack.base.inc.blocks_loop')
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-1">
                <?php $col = 3; ?>
                <div class="card my-0 h-100">
                    <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                            <span>Colonna 3</span>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                        </div>

                        <input type="hidden" name="position" value="<?php echo $position;?>">
                        <input type="hidden" name="col" value="<?php echo $col;?>">

                        @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                    </form>
                    <div id="footer_col_<?php echo $col;?>" class="p-2">
                        @include('vendor.backpack.base.inc.blocks_loop')
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-1">
                <?php $col = 4; ?>
                <div class="card my-0 h-100">
                    <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                            <span>Colonna 4</span>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                        </div>

                        <input type="hidden" name="position" value="<?php echo $position;?>">
                        <input type="hidden" name="col" value="<?php echo $col;?>">

                        @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                    </form>
                    <div id="footer_col_<?php echo $col;?>" class="p-2">
                        @include('vendor.backpack.base.inc.blocks_loop')
                    </div>
                </div>
            </div>
            <div class="col-12">
                @include('vendor.backpack.base.inc.blocks_loop_limbo')
            </div>
        <?php
        break;
        } ?>
    </div>
    </div>
    </div>
    @if($isFutureAdminTemplate)
        </div>
        <aside class="future-block-library" data-future-block-library>
            <div class="future-block-library-header">
                <div class="future-block-library-headline">
                    <strong class="future-block-library-title">Blocchi disponibili</strong>
                    <button type="button" class="future-block-library-toggle" data-toggle-block-library="1">Nascondi</button>
                </div>
                <input type="text" class="future-block-library-search" data-future-block-library-search placeholder="Cerca blocco...">
            </div>
            <div class="future-block-library-body" data-future-block-library-list>
                @foreach($admin_blocks as $blockType => $blockLabel)
                    <div class="future-library-item" data-block-type="{{ $blockType }}" data-block-label="{{ $blockLabel }}">
                        <img
                            class="future-library-item-thumb"
                            src="{{ url('imagesAdminBlocks/Future') }}/{{ $blockType }}.jpg"
                            alt="{{ $blockLabel }}"
                            onerror="this.onerror=null;this.src='{{ url('imagesAdminBlocks') }}/{{ $blockType }}.jpg';"
                        >
                        <span class="future-library-item-name">{{ $blockLabel }}</span>
                        <span class="future-library-item-drag"><i class="la la-grip-vertical"></i></span>
                    </div>
                @endforeach
                <div class="future-block-library-empty d-none" data-future-block-library-empty>Nessun blocco trovato.</div>
            </div>
        </aside>
        <form id="futureQuickAddBlockForm" method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}" class="d-none">
            @csrf
            <input type="hidden" name="redirect" value="/admin/pages_blocks/{{ $page->id }}">
            <input type="hidden" name="page_id" value="{{ $page->id }}">
            <input type="hidden" name="quick_add" value="1">
            <input type="hidden" name="position" value="">
            <input type="hidden" name="col" value="">
            <input type="hidden" name="type" value="">
            <input type="hidden" name="name" value="">
        </form>
        <div class="modal fade future-quick-name-modal" id="futureQuickBlockNameModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <form id="futureQuickBlockNameForm" autocomplete="off">
                        <div class="modal-header">
                            <h5 class="modal-title">Nuovo blocco</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                                <i class="la la-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="futureQuickBlockNameInput">Nome blocco</label>
                            <input type="text" id="futureQuickBlockNameInput" class="form-control" maxlength="190" required>
                            <small class="text-muted d-block mt-2" id="futureQuickBlockNameMeta"></small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Annulla</button>
                            <button type="submit" class="btn btn-primary btn-sm">Salva blocco</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection

@section('after_scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- include select2 js-->
    <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
    @if (app()->getLocale() !== 'en')
        <script src="{{ asset('packages/select2/dist/js/i18n/' . app()->getLocale() . '.js') }}"></script>
    @endif

    <script type="text/javascript">
        $(document).ready(function () {

            $('.select2').select2({
                    theme: "bootstrap"
            });

            var updateContainerPositions = function ($container) {
                $container.children().each(function (index) {
                    if ($(this).attr('data-position') != (index + 1)) {
                        $(this).attr('data-position', (index + 1)).addClass('updated');
                    }
                });
            };

            var initSortableContainer = function (selector) {
                var $container = $(selector);
                if (!$container.length) {
                    return;
                }

                $container.sortable({
                    handle: '.page-block-row',
                    cancel: '.page-block-actions, .page-block-actions *, a, button, input, select, textarea',
                    placeholder: 'future-sortable-placeholder',
                    forcePlaceholderSize: true,
                    tolerance: 'pointer',
                    start: function (event, ui) {
                        ui.item.addClass('future-dragging');
                        $container.addClass('future-drop-active');
                    },
                    stop: function (event, ui) {
                        ui.item.removeClass('future-dragging');
                        $container.removeClass('future-drop-active');
                    },
                    update: function () {
                        updateContainerPositions($container);
                        saveNewPositions();
                    }
                });
            };

            [
                '#header_col_1', '#header_col_2', '#header_col_3',
                '#content_col_1', '#content_col_2', '#content_col_3',
                '#footer_col_1', '#footer_col_2', '#footer_col_3', '#footer_col_4'
            ].forEach(initSortableContainer);
        });
    </script>

    <script type="text/javascript">
        function saveNewPositions() {
            var positions = [];
            $('.updated').each(function () {
                positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                $(this).removeClass('updated');
            });

            $.ajax({
                url: '{{ route('pages.blocks.saveOrder', $page->id) }}',
                method: 'PUT',
                dataType: 'text',
                data: {
                    updated: 1,
                    positions: positions,
                    _token: '{{ csrf_token() }}'
                }, success: function (response) {
                    console.log(response);
                },error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        }
    </script>

    <script>
        function deleteBlock(url) {
            swal({
                title: "Sicuro di voler cancellare il blocco?",
                text: "Una volta eseguita, l'operazione non è più reversibile",
                icon: "warning",
                buttons: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $(location).attr('href', url)
                    }
                })
        }
    </script>

    @if($isFutureAdminTemplate)
    <script>
        (function () {
            function applyFutureModalFilters($panel) {
                if (!$panel || !$panel.length) {
                    return;
                }

                var query = (($panel.find('.js-future-tab-search').val() || '') + '').toLowerCase().trim();
                var $activeCategory = $panel.find('.js-future-category-btn.is-active');
                var activeCategory = $activeCategory.length ? ($activeCategory.data('category') + '') : 'all';
                var visibleCount = 0;

                $panel.find('.js-future-block-card').each(function () {
                    var $card = $(this);
                    var searchIndex = (($card.data('search') || '') + '').toLowerCase();
                    var cardCategory = (($card.data('category') || '') + '').toLowerCase();

                    var queryMatch = query === '' || searchIndex.indexOf(query) !== -1;
                    var categoryMatch = activeCategory === 'all' || cardCategory === activeCategory;
                    var shouldShow = queryMatch && categoryMatch;

                    $card.toggle(shouldShow);
                    if (shouldShow) {
                        visibleCount++;
                    }
                });

                $panel.find('.js-future-empty').toggleClass('d-none', visibleCount > 0);
            }

            function initFutureBlockModal($modal) {
                if (!$modal || !$modal.length || $modal.data('futureInitDone')) {
                    return;
                }

                $modal.data('futureInitDone', true);

                $modal.on('click', '.js-future-category-btn', function () {
                    var $btn = $(this);
                    var $panel = $btn.closest('.js-future-filter-panel');
                    $btn.siblings('.js-future-category-btn').removeClass('is-active');
                    $btn.addClass('is-active');
                    applyFutureModalFilters($panel);
                });

                $modal.on('input', '.js-future-tab-search', function () {
                    applyFutureModalFilters($(this).closest('.js-future-filter-panel'));
                });

                $modal.on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                    var target = $(e.target).attr('href');
                    if (!target) {
                        return;
                    }
                    $(target).find('.js-future-filter-panel').each(function () {
                        applyFutureModalFilters($(this));
                    });
                });
            }

            $(document).on('shown.bs.modal', '.modal[id^="modal_"][id$="_block"]', function () {
                var $modal = $(this);
                initFutureBlockModal($modal);
                $modal.find('.js-future-filter-panel').each(function () {
                    applyFutureModalFilters($(this));
                });
            });

            var $sections = $('.future-page-blocks-section');
            if ($sections.length) {
                var searchQuery = '';
                var $shell = $('.pages-blocks-shell');

                var updateSectionCounts = function () {
                    $sections.each(function () {
                        var $section = $(this);
                        var sectionName = ($section.data('section') || '') + '';
                        var count = $section.find('.page-block-sort-item').length;
                        $section.find('[data-section-count="' + sectionName + '"]').text(count + ' blocchi');
                    });
                };

                var setSectionCollapsed = function ($section, collapsed, instant) {
                    var $body = $section.find('.future-page-blocks-section-body');
                    $section.toggleClass('is-collapsed', !!collapsed);
                    $section.find('.future-page-blocks-section-title').attr('aria-expanded', collapsed ? 'false' : 'true');

                    if (!$body.length) {
                        return;
                    }

                    if (instant) {
                        $body.stop(true, true);
                        if (collapsed) {
                            $body.hide();
                        } else {
                            $body.show();
                        }
                        return;
                    }

                    if (collapsed) {
                        $body.stop(true, true).slideUp(140);
                    } else {
                        $body.stop(true, true).slideDown(140);
                    }
                };

                var applyBlocksSearch = function () {
                    var normalizedQuery = (searchQuery || '').toLowerCase().trim();
                    var hasQuery = normalizedQuery.length > 0;

                    $sections.each(function () {
                        var $section = $(this);
                        var sectionName = ($section.data('section') || '') + '';
                        var visibleCount = 0;

                        $section.find('.page-block-sort-item').each(function () {
                            var $item = $(this);
                            var name = (($item.find('.page-block-name').text() || '') + '').toLowerCase();
                            var type = (($item.find('.page-block-type').text() || '') + '').toLowerCase();
                            var match = !hasQuery || name.indexOf(normalizedQuery) !== -1 || type.indexOf(normalizedQuery) !== -1;
                            $item.toggle(match);
                            if (match) {
                                visibleCount++;
                            }
                        });

                        if (!hasQuery) {
                            $section.find('[data-section-count="' + sectionName + '"]').text(visibleCount + ' blocchi');
                            return;
                        }

                        $section.find('[data-section-count="' + sectionName + '"]').text(visibleCount + ' risultati');
                    });
                };

                var setViewMode = function (mode) {
                    var normalized = (mode || 'visual') + '';
                    $('[data-view-mode]').removeClass('is-active');
                    $('[data-view-mode="' + normalized + '"]').addClass('is-active');
                    $shell.toggleClass('is-compact', normalized === 'compact');
                };

                var $library = $('[data-future-block-library]');
                var $libraryList = $('[data-future-block-library-list]');
                var $librarySearch = $('[data-future-block-library-search]');
                var $libraryEmpty = $('[data-future-block-library-empty]');
                var $quickAddForm = $('#futureQuickAddBlockForm');
                var $quickNameModal = $('#futureQuickBlockNameModal');
                var $quickNameForm = $('#futureQuickBlockNameForm');
                var $quickNameInput = $('#futureQuickBlockNameInput');
                var $quickNameMeta = $('#futureQuickBlockNameMeta');
                var $libraryToggleLabel = $('[data-toggle-block-library-label]');
                var $layout = $('.future-page-blocks-layout');
                var pendingQuickBlock = null;

                var openQuickNameModal = function (payload) {
                    pendingQuickBlock = payload || null;
                    if (!pendingQuickBlock || !$quickNameModal.length) {
                        return;
                    }
                    var defaultName = (pendingQuickBlock.blockLabel || pendingQuickBlock.blockType || 'Nuovo blocco') + '';
                    $quickNameInput.val(defaultName);
                    $quickNameMeta.text('Sezione: ' + pendingQuickBlock.sectionName + ' - Colonna: ' + pendingQuickBlock.colValue);
                    $quickNameModal.modal('show');
                    setTimeout(function () {
                        $quickNameInput.trigger('focus').select();
                    }, 180);
                };

                var submitQuickBlock = function (payload, customName) {
                    if (!$quickAddForm.length || !payload) {
                        return;
                    }

                    $quickAddForm.find('input[name="position"]').val(payload.sectionName);
                    $quickAddForm.find('input[name="col"]').val(payload.colValue);
                    $quickAddForm.find('input[name="type"]').val(payload.blockType);
                    $quickAddForm.find('input[name="name"]').val((customName || '').trim());
                    $quickAddForm.trigger('submit');
                };

                var applyLibrarySearch = function () {
                    if (!$libraryList.length) {
                        return;
                    }
                    var query = (($librarySearch.val() || '') + '').toLowerCase().trim();
                    var visibleCount = 0;
                    $libraryList.find('.future-library-item').each(function () {
                        var $item = $(this);
                        var label = (($item.data('block-label') || '') + '').toLowerCase();
                        var type = (($item.data('block-type') || '') + '').toLowerCase();
                        var match = query === '' || label.indexOf(query) !== -1 || type.indexOf(query) !== -1;
                        $item.toggle(match);
                        if (match) {
                            visibleCount++;
                        }
                    });
                    if ($libraryEmpty.length) {
                        $libraryEmpty.toggleClass('d-none', visibleCount > 0);
                    }
                };

                if ($library.length) {
                    var syncLibraryStickyOffset = function () {
                        var viewportWidth = window.innerWidth || document.documentElement.clientWidth || 0;
                        if (viewportWidth < 1200) {
                            document.documentElement.style.removeProperty('--future-library-sticky-top');
                            return;
                        }

                        var topOffset = 92;
                        var header = document.querySelector('.app-header');
                        if (header) {
                            var headerHeight = Math.round(header.getBoundingClientRect().height || 0);
                            if (headerHeight > 0) {
                                topOffset = headerHeight + 14;
                            }
                        }
                        document.documentElement.style.setProperty('--future-library-sticky-top', topOffset + 'px');
                    };

                    var syncLibraryToggleLabel = function () {
                        if (!$libraryToggleLabel.length) {
                            // continue below for layout class sync
                        }
                        var isCollapsed = $library.hasClass('is-collapsed');
                        if ($libraryToggleLabel.length) {
                            $libraryToggleLabel.text(isCollapsed ? 'Mostra libreria' : 'Nascondi libreria');
                        }
                        if ($layout.length) {
                            $layout.toggleClass('is-library-collapsed', isCollapsed);
                        }
                    };

                    $(document).on('click', '[data-toggle-block-library]', function () {
                        $library.toggleClass('is-collapsed');
                        syncLibraryToggleLabel();
                    });

                    $librarySearch.on('input', function () {
                        applyLibrarySearch();
                    });

                    $libraryList.find('.future-library-item').draggable({
                        helper: 'clone',
                        appendTo: 'body',
                        zIndex: 10000,
                        revert: 'invalid',
                        containment: 'document',
                        start: function () {
                            $('body').addClass('future-library-dragging');
                        },
                        stop: function () {
                            $('body').removeClass('future-library-dragging');
                        }
                    });

                    var $dropZones = $('[id^="header_col_"], [id^="content_col_"], [id^="footer_col_"]');
                    $dropZones.droppable({
                        accept: '.future-library-item',
                        tolerance: 'pointer',
                        over: function () {
                            $(this).addClass('future-drop-zone-target').closest('.card.my-0').addClass('future-drop-zone-card');
                        },
                        out: function () {
                            $(this).removeClass('future-drop-zone-target').closest('.card.my-0').removeClass('future-drop-zone-card');
                        },
                        drop: function (event, ui) {
                            var $zone = $(this);
                            $zone.removeClass('future-drop-zone-target').closest('.card.my-0').removeClass('future-drop-zone-card');
                            var $source = $(ui.draggable);
                            var blockType = ($source.data('block-type') || '') + '';
                            var blockLabel = ($source.data('block-label') || '') + '';
                            var zoneId = ($zone.attr('id') || '') + '';
                            var zoneParts = zoneId.split('_');
                            if (zoneParts.length < 3) {
                                return;
                            }
                            var sectionName = zoneParts[0];
                            var colValue = parseInt(zoneParts[2], 10);
                            if (!blockType || !sectionName || isNaN(colValue)) {
                                return;
                            }
                            openQuickNameModal({
                                blockType: blockType,
                                blockLabel: blockLabel,
                                sectionName: sectionName,
                                colValue: colValue
                            });
                        }
                    });

                    if ($quickNameForm.length) {
                        $quickNameForm.on('submit', function (event) {
                            event.preventDefault();
                            if (!pendingQuickBlock) {
                                return;
                            }
                            var customName = ($quickNameInput.val() || '').trim();
                            if (!customName) {
                                $quickNameInput.trigger('focus');
                                return;
                            }
                            $quickNameModal.modal('hide');
                            submitQuickBlock(pendingQuickBlock, customName);
                        });

                        $quickNameModal.on('hidden.bs.modal', function () {
                            pendingQuickBlock = null;
                            $quickNameInput.val('');
                            $quickNameMeta.text('');
                        });
                    }

                    applyLibrarySearch();
                    syncLibraryToggleLabel();
                    syncLibraryStickyOffset();

                    var stickyResizeTimer = null;
                    $(window).on('resize', function () {
                        if (stickyResizeTimer) {
                            clearTimeout(stickyResizeTimer);
                        }
                        stickyResizeTimer = setTimeout(function () {
                            syncLibraryStickyOffset();
                        }, 80);
                    });
                }

                $(document).on('click', '.future-page-blocks-section-title', function () {
                    var $section = $(this).closest('.future-page-blocks-section');
                    setSectionCollapsed($section, !$section.hasClass('is-collapsed'));
                });

                $(document).on('keydown', '.future-page-blocks-section-title', function (event) {
                    if (event.key !== 'Enter' && event.key !== ' ') {
                        return;
                    }
                    event.preventDefault();
                    $(this).trigger('click');
                });

                var setFilter = function (filterValue) {
                    var normalized = (filterValue || 'all') + '';
                    $('[data-filter-section]').removeClass('is-active');
                    $('[data-filter-section="' + normalized + '"]').addClass('is-active');

                    $sections.each(function () {
                        var $section = $(this);
                        var sectionName = ($section.data('section') || '') + '';
                        var shouldShow = normalized === 'all' || sectionName === normalized;
                        $section.toggleClass('is-filter-hidden', !shouldShow);
                    });
                };

                $(document).on('click', '[data-filter-section]', function () {
                    setFilter($(this).data('filter-section'));
                });

                $(document).on('input', '[data-block-search]', function () {
                    searchQuery = $(this).val() || '';
                    applyBlocksSearch();
                });

                $(document).on('click', '[data-collapse-all]', function () {
                    var $btn = $(this);
                    var shouldCollapse = !$btn.hasClass('is-collapsed-all');

                    $sections.filter(':visible').each(function () {
                        setSectionCollapsed($(this), shouldCollapse, false);
                    });

                    $btn.toggleClass('is-collapsed-all', shouldCollapse)
                        .text(shouldCollapse ? 'Espandi tutto' : 'Comprimi tutto');
                });

                $(document).on('click', '[data-view-mode]', function () {
                    setViewMode($(this).data('view-mode'));
                });
                updateSectionCounts();
                $sections.each(function () {
                    setSectionCollapsed($(this), false, true);
                });
                setFilter('all');
                setViewMode('visual');
                applyBlocksSearch();
            }
        })();
    </script>
    @endif

    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <script>
        var options = {
            valueNames: [ 'nomeblocco' ],
            listClass: 'grid'
        };
        var b_exist_header_col_1 = new List('b_exist_header_col_1', options);
        var b_new_header_col_1 = new List('b_new_header_col_1', options);
        var b_exist_header_col_2 = new List('b_exist_header_col_2', options);
        var b_new_header_col_2 = new List('b_new_header_col_2', options);
        var b_exist_header_col_3 = new List('b_exist_header_col_3', options);
        var b_new_header_col_3 = new List('b_new_header_col_3', options);

        var b_exist_content_col_1 = new List('b_exist_content_col_1', options);
        var b_new_content_col_1 = new List('b_new_content_col_1', options);
        var b_exist_content_col_2 = new List('b_exist_content_col_2', options);
        var b_new_content_col_2 = new List('b_new_content_col_2', options);
        var b_exist_content_col_3 = new List('b_exist_content_col_3', options);
        var b_new_content_col_3 = new List('b_new_content_col_3', options);

        var b_exist_footer_col_1 = new List('b_exist_footer_col_1', options);
        var b_new_footer_col_1 = new List('b_new_footer_col_1', options);
        var b_exist_footer_col_2 = new List('b_exist_footer_col_2', options);
        var b_new_footer_col_2 = new List('b_new_footer_col_2', options);
        var b_exist_footer_col_3 = new List('b_exist_footer_col_3', options);
        var b_new_footer_col_3 = new List('b_new_footer_col_3', options);
    </script>
@endsection
