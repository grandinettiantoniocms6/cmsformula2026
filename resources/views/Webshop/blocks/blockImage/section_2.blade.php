<section id="block-image-{{ $item->id }}" class="block-image image-wrapper bg-overlay bg-overlay-black-{{ $item->alpha }}"
         style="--image-block-height: {{ $item->height_header }}; @if($item->bgcolor)--image-block-bg:{{ $item->bgcolor }}; @endif @if($page->color_title_page)--image-block-title-color: {{ $page->color_title_page }}; @endif @if($page->color_subtitle_page)--image-block-description-color: {{ $page->color_subtitle_page }};@endif"
>
    @if(trim($foto) != "")
        <img class="img-cover" src="{{ $foto }}" alt="{{ $page->color_title_page }}" loading="lazy">
    @endif

    <div class="container page-container wow animate__fadeInUp" data-wow-duration=".3s">
        @if($page->title_page)
            <h1 class="page-title" style="text-align: {{ $item->text_align }};">{{ $page->title_page }}</h1>
        @endif

        @if( trim($page->subtitle_page) != "" || trim($page->subtitle_page) != "" )
            <p class="page-description" style="text-align: {{ $item->text_align }};">{{ $page->subtitle_page }}</p>
        @endif
    </div>
</section>


