<?php  $position = "header"; ?>
@if($page && $page->template_header == "row")
         <?php $blocks = \App\Models\PageBlock::where("position", "header")->where("page_id", $page->id)->where("is_active", 1)->orderBy("order", "asc")->get(); ?>
         @include('common.engine_content')
@endif
@if($page && $page->template_header == "two_cols")
    <div class="col-12 col-md-6">
        <?php $blocks = \App\Models\PageBlock::where("position", "header")
            ->where("col", 1)
            ->where("is_active", 1)
            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
        ?>
        @include('common.engine_content')
    </div>
    <div class="col-12 col-md-6">
        <?php $blocks = \App\Models\PageBlock::where("position", "header")
            ->where("col", 2)
            ->where("is_active", 1)
            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
        ?>
        @include('common.engine_content')
    </div>
@endif
@if($page && $page->template_header == "three_cols")
    <div class="col-12 col-md-4">
        <?php $blocks = \App\Models\PageBlock::where("position", "header")
            ->where("col", 1)
            ->where("is_active", 1)
            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
        ?>
        @include('common.engine_content')
    </div>
    <div class="col-12 col-md-4">
        <?php $blocks = \App\Models\PageBlock::where("position", "header")
            ->where("col", 2)
            ->where("is_active", 1)
            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
        ?>
        @include('common.engine_content')
    </div>
    <div class="col-12 col-md-4">
        <?php $blocks = \App\Models\PageBlock::where("position", "header")
            ->where("col", 3)
            ->where("is_active", 1)
            ->where("page_id", $page->id)->orderBy("order", "asc")->get();
        ?>
        @include('common.engine_content')
    </div>
@endif

