<section class="pb-0 md-pt-0" style="@if($item->foto) background-image: url({{ $foto }});@endif height: {{ $item->height_header }}; @if($item->bgcolor) background-color:{{ $item->bgcolor }};@endif" data-anime='{"opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="container">
        <div class="row align-items-center justify-content-center small-screen">
            <div class="col-xl-12 col-sm-12 page-title-double-large position-relative text-{{ $item->text_align }}" style="text-align: {{ $item->text_align }};" data-anime='{ "el": "childs", "opacity": [0, 1], "translateY": [30, 0], "duration": 600, "staggervalue": 300, "easing": "easeOutQuad" }'>

                @if($page->title_page)

                    <h1 class="fw-600 mt-25px" style="color: {{ $page->color_title_page }};">
                        {{ $page->title_page }}
                    </h1>

                @endif
                @if($page->subtitle_page)

                    <h2 class="fw-300 ls-1px mb-0" style="color: {{ $page->color_subtitle_page }};">
                        {{ $page->subtitle_page }}
                    </h2>

                @endif

            </div>
        </div>
    </div>
</section>
