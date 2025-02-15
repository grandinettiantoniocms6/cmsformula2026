<?php $socials = json_decode($website->socials, true); ?>
@if($socials)
    <ul class="d-flex justify-content-center justify-content-lg-end social-icon style-none" style="color: {{ $website->color_icon_topbar }}!important; margin-right: 20px;">
        @foreach($socials as $social)
            <li style="margin-right: 10px;">
                <a href="{{ $social['url'] }}" target="_blank">
                    @if($social['icon'])
                        <i class="{{ $social['icon'] }} {{ $website->sizeicon }}"></i>
                    @else
                        {{ $social['name'] }}
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
@endif
