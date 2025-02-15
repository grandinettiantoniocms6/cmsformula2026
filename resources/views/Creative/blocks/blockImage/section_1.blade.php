<div class="inside-hero-two" style="@if($item->foto) background-image:url({{ url($item->foto) }});@endif @if($item->bgcolor) background-color:{{ $item->bgcolor }}!important;@endif height:{{ $item->height_header }}!important;">
    <div class="container">
        @if($page->title_page)
            @if($page->color_title_page)
                <h2 class="page-title" style="color: {{ $page->color_title_page }}">{{ $page->title_page }}</h2>
            @else
                <h2 class="page-title">{{ $page->title_page }}</h2>
            @endif
        @endif
        @if($page->subtitle_page)
            @if($page->color_subtitle_page)
                <p style="color: {{ $page->color_subtitle_page }}">{{ $page->subtitle_page }}</p>
            @else
                <p>{{ $page->subtitle_page }}</p>
            @endif
        @endif
    </div>
</div> <!-- /.inside-hero-two -->


