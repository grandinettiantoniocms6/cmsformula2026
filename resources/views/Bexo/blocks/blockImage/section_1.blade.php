<div class="site-breadcrumb" style="@if($item->foto) background-image: url({{ $foto }});@endif height: {{ $item->height_header }}; @if($item->bgcolor) background-color:{{ $item->bgcolor }}!important;@endif">
        <div class="container">

            @if($page->title_page)

                <h1 class="breadcrumb-title" style="color: {{ $page->color_title_page }};text-align: {{ $item->text_align }};">
                    {{ $page->title_page }}
                </h1>

            @endif
            @if($page->subtitle_page)

                <h4 style="color: {{ $page->color_subtitle_page }};text-align: {{ $item->text_align }};">
                    {{ $page->subtitle_page }}
                </h4>

            @endif
       </div>
</div>
<!-- test 6a -->
