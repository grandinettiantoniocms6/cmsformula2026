<section class="top-space-margin page-title-big-typography cover-background pt-0 pb-0" style="@if($item->foto) background-image: url({{ $foto }});@endif height: {{ $item->height_header }}; @if($item->bgcolor) background-color:{{ $item->bgcolor }};@endif" data-anime='{"opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }' >

        <div class="container">
            <div class="row align-items-center justify-content-center small-screen">
                <div class="col-xl-6 col-lg-7 col-sm-8 position-relative text-center page-title-extra-small" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 400, "delay": 0, "staggervalue": 100, "easing": "easeOutQuad" }'>

                    @if($page->title_page)

                        <h2 class="m-auto alt-font text-shadow-double-large fw-700 w-90 xl-w-100" style="color: {{ $page->color_title_page }};"
                            data-fancy-text='{ "translateY": [50, 0], "string": ["{{ $page->title_page }}"],
                        "duration": 400, "delay": 0, "speed": 50, "easing": "easeOutQuad" }'>
                        </h2>
                    @endif

                    @if( trim($page->subtitle_page) != "" || trim($page->subtitle_page) != "" )

                    <div><h1 class="text-uppercase mb-15px alt-font opacity-6 fw-500 ls-2px" style="color: {{ $page->color_subtitle_page }};"
                             data-fancy-text='{ "translateY": [50, 0], "string": ["{{ $page->subtitle_page }}"],
                             "duration": 400, "delay": 0, "speed": 50, "easing": "easeOutQuad" }'></h1>
                    </div>
                    @endif

                </div>
            </div>
        </div>
</section>


