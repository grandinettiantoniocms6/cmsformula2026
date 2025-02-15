<?php $socials = json_decode($website->socials, true); ?>
@if($socials)
    @if($socials[0]['name'] != "")
    <nav class="nav nav-social">
        @foreach($socials as $social)
            <a class="nav-link" href="{{ $social['url'] }}" target="_blank" title="{{ $social['name'] }}" title="{{ $social['name'] }}">
                @if($social['icon'])
                    <i class="{{ $social['icon'] }} {{ $website->sizeicon }}"></i>
                @else
                    {{ $social['name'] }}
                @endif
            </a>
        @endforeach
    </nav>
    @endif
@endif
