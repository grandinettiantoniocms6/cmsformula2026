@include('Bexo.engine_footer_modals')
@once
    <style>
        #footer .tj-copyright-area .copyright-content-area .bexo-footer-contact {
            margin-top: 0;
            margin-bottom: 0;
            padding: 0;
            box-shadow: none;
        }
    </style>
@endonce
<?php  $position = "footer"; ?>
<?php $footer_blocks = \App\Models\PageBlock::where("position", "footer")
    ->where("is_active", 1)
    ->where("page_id", $page->id)->orderBy("order", "asc")->get();
?>
<footer class="tj-footer-section footer-1 section-gap-x" id="footer">

    @if($page && $page->template_footer == "row" && count($footer_blocks)>0)
        <div class="footer-main-area">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-xl-12 col-lg-12 col-md-12">

                                    <?php $blocks = \App\Models\PageBlock::where("position", "footer")->where("is_active", 1)->where("page_id", $page->id)->orderBy("order", "asc")->get(); ?>
                                @include('common.engine_content')

                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($page && $page->template_footer == "two_cols" && count($footer_blocks)>0)
            <div class="footer-main-area">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-xl-6 col-lg-6 col-md-12">
                                <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                                ->where("col", 1)
                                ->where("is_active", 1)
                                ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                                ?>
                            @include('common.engine_content')
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12">
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
            <div class="footer-main-area">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-xl-4 col-lg-6 col-md-12">
                                    <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                                    ->where("col", 1)
                                    ->where("is_active", 1)
                                    ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                                    ?>
                                @include('common.engine_content')
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-12">
                                    <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                                    ->where("col", 2)
                                    ->where("is_active", 1)
                                    ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                                    ?>
                                @include('common.engine_content')
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-12">
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
            <div class="footer-main-area">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-xl-3 col-lg-6 col-md-12">
                                    <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                                    ->where("col", 1)
                                    ->where("is_active", 1)
                                    ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                                    ?>
                                @include('common.engine_content')
                            </div>
                        <div class="col-xl-3 col-lg-6 col-md-12">
                                    <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                                    ->where("col", 2)
                                    ->where("is_active", 1)
                                    ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                                    ?>
                                @include('common.engine_content')
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12">
                                    <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                                    ->where("col", 3)
                                    ->where("is_active", 1)
                                    ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                                    ?>
                                @include('common.engine_content')
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12">
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

            <div class="tj-copyright-area">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="copyright-content-area">

                                <div class="footer-contact bexo-footer-contact">
                                    <ul>
                                        <li>
                                            @if($website->title_footer_1)
                                                {{ $website->dati }} | <a href="#" data-bs-toggle="modal" data-bs-target="#footer_1">{{ $website->title_footer_1 }}</a>
                                            @else
                                                {{ $website->dati }}
                                            @endif
                                        </li>

                                    </ul>
                                </div>

                                <div class="social-links">
                                    <?php $socials = json_decode($website->socials, true); ?>
                                    @if($socials)
                                        <ul>
                                            @foreach($socials as $social)
                                                <li><a href="{{ $social['url'] }}" target="_blank">
                                                    @if($social['icon'])
                                                        <i class="{{ $social['icon'] }} {{ $website->sizeicon }}" style="color: {{ $website->color_icon_topbar }}!important; "></i>
                                                    @else
                                                        {{ $social['name'] }}
                                                    @endif
                                                </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>


                                <div class="copyright-text">
                                    @include('Bexo.inc.footer_links')
                                </div>


                        </div>
                    </div>
                </div>
            </div>
</footer>
