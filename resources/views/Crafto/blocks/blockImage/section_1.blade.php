<section class="top-space-margin page-title-big-typography cover-background pt-0 pb-0" style="@if($item->foto) background-image: url({{ $foto }});@endif height: {{ $item->height_header }}; @if($item->bgcolor) background-color:{{ $item->bgcolor }};@endif" data-anime='{"opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }' >
    <div class="layer" style="background-color: rgba(0, 0, 0, 0.{{ $item->alpha }}); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
        <div class="container">
            <div class="row align-items-center justify-content-center small-screen">
                <div class="col-xl-12 col-sm-12 page-title-double-large position-relative text-{{ $item->text_align }}" style="text-align: {{ $item->text_align }};" data-anime='{ "el": "childs", "opacity": [0, 1], "translateY": [30, 0], "duration": 600, "staggervalue": 300, "easing": "easeOutQuad" }'>

                    @if($page->title_page)

                        <h3 class="fw-500 mt-15px" style="color: {{ $page->color_title_page }};">
                            {{ $page->title_page }}
                        </h3>

                    @endif
                    @if($page->subtitle_page)

                        <h2 class="fw-300 ls-1px mb-25px" style="color: {{ $page->color_subtitle_page }};">
                            {{ $page->subtitle_page }}
                        </h2>

                    @endif

                </div>
            </div>
        </div>
</section>
