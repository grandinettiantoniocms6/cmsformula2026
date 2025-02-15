<section class="top-space-margin page-title-big-typography cover-background pt-0 pb-0" style="@if($item->foto) background-image: url({{ $foto }});@endif height: {{ $item->height_header }}; @if($item->bgcolor) background-color:{{ $item->bgcolor }};@endif" data-anime='{"opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
        <div class="container">
            <div class="row extra-very-small-screen align-items-center">
                <div class="col-lg-5 col-sm-8 position-relative page-title-extra-small" data-anime='{ "el": "childs", "opacity": [0, 1], "translateX": [-30, 0], "duration": 800, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>

                    @if( trim($page->subtitle_page) != "" || trim($page->subtitle_page) != "" )

                        <h1 class="mb-20px text-shadow-medium" style="color: {{ $page->color_title_page }};"><span class="w-30px h-2px d-inline-block align-middle position-relative top-minus-2px me-10px" style="background-color: {{ $page->color_title_page }};"></span>
                            {{ $page->title_page }}
                        </h1>

                    @endif

                    @if($page->title_page)

                        <h2 class="text-shadow-medium fw-500 ls-minus-2px mb-0" style="color: {{ $page->color_subtitle_page }};">
                            {{ $page->subtitle_page }}
                        </h2>

                    @endif

                </div>
            </div>
        </div>
</section>
