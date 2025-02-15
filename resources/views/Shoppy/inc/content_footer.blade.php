@include('common.engine_footer_modals')
<?php  $position = "footer"; ?>
<footer class="footer page-section-pt black-bg" id="footer">
    <div class="container">
        <div class="row">
            @if($page && $page->template_footer == "row")
                <div class="col-lg-5 col-md-5 sm-mt-30">
                    <div class="about-content">
                        <?php $blocks = \App\Models\PageBlock::where("position", "footer")->where("is_active", 1)->where("page_id", $page->id)->orderBy("order", "asc")->get(); ?>
                        @include('common.engine_content')
                    </div>
                </div>
            @endif
            @if($page && $page->template_footer == "two_cols")
                <div class="col-6 col-sm-6 col-lg-6">
                    <div class="about-content">
                        <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 1)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                        ?>
                        @include('common.engine_content')
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-6">
                    <div class="about-content">
                        <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 2)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                        ?>
                        @include('common.engine_content')
                    </div>
                </div>
            @endif
            @if($page && $page->template_footer == "three_cols")
                <div class="col-lg-4 col-md-4">
                    <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                        ->where("col", 1)
                        ->where("is_active", 1)
                        ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                    ?>
                    @include('common.engine_content')
                </div>
                <div class="col-lg-4 col-md-4">
                    <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                        ->where("col", 2)
                        ->where("is_active", 1)
                        ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                    ?>
                    @include('common.engine_content')
                </div>
                <div class="col-lg-4 col-md-4">
                    <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                        ->where("col", 3)
                        ->where("is_active", 1)
                        ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                    ?>
                    @include('common.engine_content')
                </div>
            @endif
            @if($page && $page->template_footer == "four_cols")
                <div class="col-3 col-sm-3 col-lg-3">
                    <div class="about-content">
                        <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 1)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                        ?>
                        @include('common.engine_content')
                    </div>
                </div>
                <div class="col-3 col-sm-3 col-lg-3">
                    <div class="about-content">
                        <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 2)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                        ?>
                        @include('common.engine_content')
                    </div>
                </div>
                <div class="col-3 col-sm-3 col-lg-3">
                    <div class="about-content">
                        <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                            ->where("col", 3)
                            ->where("is_active", 1)
                            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                        ?>
                        @include('common.engine_content')
                    </div>
                </div>
            @endif
        </div>

        <div class="footer-widget mt-20">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mt-15">{{ $website->dati }}  @include('Basic.inc.footer_links')</p>
                </div>
            </div>
        </div>
    </div>
</footer>

