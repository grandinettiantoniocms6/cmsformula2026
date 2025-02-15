<div class="block-social text-{{ $item->align }} space-{{ $item->mt }}">
    @if($array)
        <nav class="nav nav-social">
            @foreach($array as $value)
                <a href="{{ $value->url }}" class="nav-link px-1" target="_blank" title="{{ $value->title }}">
                    @if($value->icon)
                        <i class="{{ $value->icon }} {{ $value->social_sizeicon }}" aria-hidden="true"></i>
                    @else
                        {{ $value->title }}
                    @endif
                </a>
            @endforeach
        </nav>
    @endif
</div>
