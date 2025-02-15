<section class="page-section-pt">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 mb-60 clearfix">
                <div class="social-icons color-hover clearfix">
                    @if($array)
                        <ul>
                            @foreach($array as $value)
                                <li>
                                    <a href="{{ $value->url }}" target="_blank">
                                        @if($value->icon)
                                            <i class="fa fa-{{ $value->icon }}"></i>
                                        @else
                                            {{ $value->title }}
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

