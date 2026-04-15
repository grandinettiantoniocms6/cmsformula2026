<section class="tj-page-header" style="@if($item->foto) background-image: url({{ $foto }});@endif height: {{ $item->height_header }}; @if($item->bgcolor) background-color:{{ $item->bgcolor }}!important;@endif position: relative; overflow: hidden;">
    <div class="layer" style="background-color: rgba(0, 0, 0, 0.{{ $item->alpha }}); position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;"></div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="row">
            <div class="col-lg-12">
                <div class="tj-page-header-content" style="text-align: {{ $item->text_align }};">
                    @if($page->title_page)
                        <h1 class="tj-page-title" style="color: {{ $page->color_title_page }};">
                            {{ $page->title_page }}
                        </h1>
                    @endif
                    @if($page->subtitle_page)
                        <div class="tj-page-link">
                            <span style="color: {{ $page->color_subtitle_page }};">
                                {{ $page->subtitle_page }}
                            </span>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
