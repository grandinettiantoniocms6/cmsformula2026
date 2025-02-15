@if($page)
    <title>@if($page && trim($page->meta_title != "")) {{ $website->title }} - {{ $page->meta_title }} @else {{ $website->title }} @endif</title>
    @if($page && trim($page->meta_description) != "")
        <meta name="description" content="{{ $page->meta_description }}">
    @else
        <meta name="description" content="{{ $website->meta_description }}">
    @endif
    @if($page && (trim($page->meta_keywords) != ""))
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @else
        <meta name="keywords" content="{{ $website->meta_keywords }}">
    @endif
@endif
