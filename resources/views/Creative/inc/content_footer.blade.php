@include('common.engine_footer_modals_creative')
<?php  $position = "footer"; ?>
<!--
	=====================================================
		Address Section Two
	=====================================================
-->
<div class="address-section-two mt-200 mb-20">
    <div class="container">
        <div class="inner-content">
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="address-block-two d-flex border-right">
                        <img src="https://www.webisland.it/public/templates/Creative/images/icon/email02.png" alt="" style="width:48px; height: 48px;">
                        <div class="text-meta">
                            <h4 class="title">Contattaci via E-Mail</h4>
                            <p>Ti risponderemo entro 24 ore <br><a href="mailto:info@webisland.it" target="_blank" rel="noopener">info@webisland.it</a></p>
                        </div> <!-- /.text-meta -->
                    </div> <!-- /.address-block-two -->
                </div>
                <div class="col-md-6">
                    <div class="address-block-two d-flex">
                        <img src="https://www.webisland.it/public/templates/Creative/images/icon/whatsapp.png" alt="" style="width:48px; height: 48px;">
                        <div class="text-meta">
                            <h4 class="title">Scrivici su WhatsApp</h4>
                            <p>Dal Lun-ven 08:30-19:00 <br>
                                <a href="https://wa.me/393472349421" target="_blank" rel="noopener">347.2349421</a></p>
                        </div> <!-- /.text-meta -->
                    </div> <!-- /.address-block-two -->
                </div>
            </div>
        </div> <!-- /.inner-content -->
    </div>
</div> <!-- /.address-section-two -->


<div class="vcamp-footer-one p0" id="footer">
    <div class="clearfix">
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
                        <div class="top-footer mt-90 md-mt-70">
                            <div class="row">
                                <div class="col-lg-4 col-md-3 col-sm-4">
                                    <?php $blocks = \App\Models\PageBlock::where("position", "footer")
                                        ->where("col", 1)
                                        ->where("is_active", 1)
                                        ->where("page_id", $page->id)->orderBy("order", "asc")->get();
                                    ?>
                                    @include('common.engine_content')
                                </div>
                                <div class="col-lg-4 col-md-3 col-sm-4">
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
        </div>
</div>

    <div class="container" id="footer">
        <div class="row">
            <div class="col-xxl-11 m-auto">
                <div class="bottom-footer">
                    <div class="row">
                        <div class="col-lg-4 order-lg-0 mb-15">
                            <ul class="d-flex justify-content-center justify-content-lg-start footer-nav style-none">
                                <li>{{ $website->dati }}</li>

                            </ul>
                        </div>
                        <div class="col-lg-4 order-lg-2 mb-15">
                            @include('Creative.inc.socials')
                        </div>
                        <div class="col-lg-4 order-lg-1 mb-15">
                            <p class="copyright text-center">  @include('Creative.inc.footer_links')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
