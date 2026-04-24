{{-- This file is used to store topbar (left) items --}}

<?php $website = \App\Models\WebsiteSetting::first(); ?>
@php
    $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
@endphp

@if($isFutureAdminTemplate)
    <style>
        .future-topbar-status {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: .25rem .58rem;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .03em;
            border: 1px solid #c8d8f3;
            background: #e9f7ea;
            color: #2f8b54;
        }
    </style>
@endif
@if(env('NASCONDI_FRONTEND') == 0)
    @if($website->is_online == 1)
        <li class="nav-item d-md-down-none">
            <span class="{{ $isFutureAdminTemplate ? 'future-topbar-status' : 'badge badge-success' }}">SITO ONLINE</span>
        </li>
    @else
        <li class="nav-item d-md-down-none">
            <span class="{{ $isFutureAdminTemplate ? 'future-topbar-status' : 'badge badge-danger' }}">SITO OFFLINE</span>
        </li>
    @endif
@endif
