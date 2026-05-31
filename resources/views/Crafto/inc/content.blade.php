<?php  $position = "content"; ?>
@if($page->template == "full_page")
        <?php
            $blocks = \App\Models\PageBlock::where("position", "content")->where("is_active", 1)->where("page_id", $page->id)->orderBy("order", "asc")->get();
        ?>
        <section>
            @include('common.engine_content')
        </section>
@endif

@if($page->template == "sidebar_left")
    <section class="pt-0 pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4">
                    <?php $blocks = \App\Models\PageBlock::where("position", "content")
                        ->where("is_active", 1)
                        ->where("col", 1)
                        ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                    ?>
                    @include('common.engine_content')
                </div>

                <div class="col-12 col-md-8">
                    <?php $blocks = \App\Models\PageBlock::where("position", "content")
                        ->where("is_active", 1)
                        ->where("col", 2)
                        ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                    ?>
                    @include('common.engine_content')
                </div>
            </div>
    </div>
    </section>
@endif

@if($page->template == "sidebar_right")
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <?php $blocks = \App\Models\PageBlock::where("position", "content")
                        ->where("is_active", 1)
                        ->where("col", 1)
                        ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                    ?>
                    @include('common.engine_content')
                </div>
                <div class="col-12 col-md-4">
                    <?php $blocks = \App\Models\PageBlock::where("position", "content")
                        ->where("is_active", 1)
                        ->where("col", 2)
                        ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                    ?>
                    @include('common.engine_content')
                </div>
            </div>
    </div>
    </section>
@endif

@if($page->template == "three_columns")
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3">
                    <?php $blocks = \App\Models\PageBlock::where("position", "content")
                        ->where("is_active", 1)
                        ->where("col", 1)
                        ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                    ?>
                    @include('common.engine_content')
                </div>
                <div class="col-12 col-md-6">
                    <?php $blocks = \App\Models\PageBlock::where("position", "content")
                        ->where("col", 2)
                        ->where("is_active", 1)
                        ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                    ?>
                    @include('common.engine_content')
                </div>
                <div class="col-12 col-md-3">
                    <?php $blocks = \App\Models\PageBlock::where("position", "content")
                        ->where("col", 3)
                        ->where("is_active", 1)
                        ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                    ?>
                    @include('common.engine_content')
                </div>
            </div>
        </div>
    </section>
@endif

