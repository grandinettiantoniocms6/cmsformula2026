<section class="top-space-margin page-title-big-typography cover-background round-cursor" style="@if($item->foto) background-image: url({{ $foto }});@endif height: {{ $item->height_header }}; @if($item->bgcolor) background-color:{{ $item->bgcolor }};@endif">
    <div class="layer" style="background-color: rgba(0, 0, 0, 0.{{ $item->alpha }}); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
    <div class="container">
        <div class="row extra-very-small-screen align-items-center">
            <div class="col-lg-8 col-sm-4 position-relative page-title-extra-small" data-anime='{ "el": "childs", "opacity": [0, 1], "translateX": [-30, 0], "duration": 800, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                @if($page->subtitle_page)
                    <h1 class="mb-20px text-shadow-medium" style="color: {{ $page->color_subtitle_page }};"><span class="w-30px h-2px bg-red d-inline-block align-middle position-relative top-minus-2px me-10px"></span>{{ $page->subtitle_page }}</h1>
                @endif
                @if($page->title_page)
                    <h4 class="text-shadow-medium fw-500 ls-minus-2px mb-0" style="color: {{ $page->color_title_page }};">{{ $page->title_page }}</h4>
                @endif

            </div>
        </div>
    </div>
</section>
