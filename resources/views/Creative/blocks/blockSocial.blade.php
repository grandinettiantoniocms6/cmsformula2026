<div class="social-icons color-hover clearfix">
    @if($array)
        <ul>
            @foreach($array as $value)
                <li class="social">
                    <a href="{{ $value->url }}" target="_blank">
                        @if($value->icon)
                            <i class="{{ $value->icon }} {{ $value->social_sizeicon }}"></i>
                        @else
                            {{ $value->title }}
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

