<?php  $position = "content"; ?>
@if($page->template == "full_page")
        <?php $blocks = \App\Models\PageBlock::where("position", "content")->where("is_active", 1)->where("page_id", $page->id)->orderBy("order", "asc")->get(); ?>
        @include('common.engine_content')
@endif

@if($page->template == "sidebar_left")
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
@endif

@if($page->template == "sidebar_right")
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
@endif

@if($page->template == "three_columns")
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
@endif
