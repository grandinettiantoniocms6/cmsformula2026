@include('Crafto.engine_footer_modals')
<?php  $position = "footer"; ?>
<?php $footer_blocks = \App\Models\PageBlock::where("position", "footer")
    ->where("is_active", 1)
    ->where("page_id", $page->id)->orderBy("order", "asc")->get();
?>
<footer id="footer">
    @if($page && $page->template_footer == "row" && count($footer_blocks)>0)
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg footer-column-1">
                            <?php $blocks = \App\Models\PageBlock::where("position", "footer")->where("is_active", 1)->where("page_id", $page->id)->orderBy("order", "asc")->get(); ?>
                        @include('common.engine_content')
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($page && $page->template_footer == "two_cols" && count($footer_blocks)>0)
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg footer-column-1">
                            <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 1)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                            ?>
                        @include('common.engine_content')
                    </div>
                    <div class="col-lg footer-column-2">
                            <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 2)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                            ?>
                        @include('common.engine_content')
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($page && $page->template_footer == "three_cols" && count($footer_blocks)>0)
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg footer-column-1">
                            <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 1)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                            ?>
                        @include('common.engine_content')
                    </div>
                    <div class="col-lg footer-column-2">
                            <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 2)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                            ?>
                        @include('common.engine_content')
                    </div>
                    <div class="col-lg footer-column-3">
                            <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 3)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                            ?>
                        @include('common.engine_content')
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($page && $page->template_footer == "four_cols" && count($footer_blocks)>0)
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg footer-column-1">
                            <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 1)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                            ?>
                        @include('common.engine_content')
                    </div>
                    <div class="col-lg footer-column-2">
                            <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 2)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                            ?>
                        @include('common.engine_content')
                    </div>
                    <div class="col-lg footer-column-3">
                            <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 3)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                            ?>
                        @include('common.engine_content')
                    </div>
                    <div class="col-lg footer-column-4">
                            <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 4)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                            ?>
                        @include('common.engine_content')
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg">

                    @if($website->title_footer_1)
                        <span class="copyright">{{ $website->dati }} | <a href="#" data-bs-toggle="modal" data-bs-target="#footer_1">{{ $website->title_footer_1 }}</a></span>
                    @else
                        <span class="copyright">{{ $website->dati }}</span>
                    @endif

                </div>
                <div class="col-lg-auto">
                    <?php $socials = json_decode($website->socials, true); ?>
                    @if($socials)
                        <div class="col-md-5 text-end d-none d-lg-flex fs-15">
                            @foreach($socials as $social)
                                <a href="{{ $social['url'] }}" target="_blank" class="me-25px lg-me-15px">
                                    @if($social['icon'])
                                        <i class="{{ $social['icon'] }} {{ $website->sizeicon }}" style="color: {{ $website->color_icon_topbar }}!important; "></i>
                                    @else
                                        {{ $social['name'] }}
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-lg-auto">
                    @include('Crafto.inc.footer_links')
                </div>
            </div>
        </div>
    </div>
</footer>
