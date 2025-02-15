<?php
$socials = json_decode($website->socials, true);
?>
@if($socials)
    <ul>
        @foreach($socials as $social)
            <li>
                <a href="{{ $social['url'] }}" target="_blank">
                    @if($social['icon'])
                        <span class="ti-{{ $social['icon'] }}"></span>
                    @else
                        {{ $social['name'] }}
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
@endif
