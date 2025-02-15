<section class="rev-slider">
    <div id="rev_slider_274_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="webster-slider-8" data-source="gallery" style="margin:0px auto;background:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
        <!-- START REVOLUTION SLIDER 5.4.6.3 auto mode -->
        <div id="rev_slider_274_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.4.6.3">
            <ul>  <!-- SLIDE  -->
                <li data-index="rs-768" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="300"  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                    <div class="col-lg-12">
                        <div class="js-video [youtube, widescreen]">
                            @if($item)
                                <?php
                                 $temp = explode("=", $item->video);
                                ?>
                                <iframe src="https://www.youtube.com/embed/{{ $temp[1] }}" allowfullscreen></iframe>
                            @endif
                        </div>
                    </div>

                </li>
            </ul>
            <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div> </div>
    </div>
</section>


