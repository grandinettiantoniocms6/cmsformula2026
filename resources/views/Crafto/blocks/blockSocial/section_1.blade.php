
<!-- start section -->
<section class="bg-white" style="margin-top: {{ $item->mt }}px;">
    <div class="container">
        <div class="row justify-content-center">
            @if($array)
                <div class="col-lg-12 col-md-12 col-sm-12 text-center elements-social social-icon-style-08">
                    <ul class="extra-large-icon">
                        @foreach($array as $value)
                            <li><a class="{{ $value->title }}" href="{{ $value->url }}" target="_blank"><i class="{{ $value->icon }}"></i></a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</section>

