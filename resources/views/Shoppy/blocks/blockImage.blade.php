@if($block->position == "header")
    <?php $page = \App\Models\Page::where("id", $block->page_id)->first(); ?>
    <section class="page-title bg-overlay-black-60 parallax" data-jarallax='{"speed": 0.6}' style="background-image: url({{ url($item->foto) }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-name">
                        @if($page->title_page)
                            @if($page->color_title_page)
                                <h1 style="color: {{ $page->color_title_page }}">{{ $page->title_page }}</h1>
                            @else
                                <h1>{{ $page->title_page }}</h1>
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
                </div>
            </div>
        </div>
    </section>
@else
    <section class="white-bg page-section-ptb">
        <div class="container">
            <div class="row">
                <img src="{{ $item->foto }}" alt="" class="img-fluid">
            </div>
        </div>
    </section>
@endif
