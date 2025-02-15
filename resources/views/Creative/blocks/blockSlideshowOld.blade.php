<style>
    #rev_slider_267_1 .tp-bgimg.defaultimg {
       opacity: 0.65 !important;
       }
</style>

<section class="parallax">
    @if($array)
            <div id="rev_slider_267_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="webster-slider-5" data-source="gallery" style="margin:0px auto;background:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">

                <!-- START REVOLUTION SLIDER 5.4.6.3 auto mode -->
                <div id="rev_slider_267_1" class="rev_slider fullwidthabanner" style="display:none; background: rgba(0,0,0, 0.8);" data-version="5.4.6.3">

                    <ul>  <!-- SLIDE  -->
                        @foreach($array as $value)
                            <?php
                            $title = json_decode($value->title, true);
                            $title_background = $value->title_background;
                            $abstract = json_decode($value->abstract, true);
                            $url_interno = json_decode($value->url_interno, true);
                            $url_esterno = json_decode($value->url, true);
                            $button = json_decode($value->button, true);
                            $type_href = $value->type_href;

                            $url = "#";
                            if(key_exists(\App::getLocale(), $url_interno)){
                                if(trim($url_interno[\App::getLocale()]) != ""){
                                    $url = "/{$url_interno[\App::getLocale()]}";
                                }
                            }
                            if(key_exists(\App::getLocale(), $url_esterno)){
                                if(trim($url_esterno[\App::getLocale()]) != ""){
                                    $url = $url_esterno[\App::getLocale()];
                                }
                            }

                            if(!key_exists(\App::getLocale(), $abstract)){
                                $abstract[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $title)){
                                $title[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $button)){
                                $button[\App::getLocale()] = "";
                            }
                            ?>
                        <li
                            data-index="rs-{{ $value->id }}"
                            data-transition="fade"
                            data-slotamount="default"
                            data-hideafterloop="0"
                            data-hideslideonmobile="off"
                            data-easein="default"
                            data-easeout="default"
                            data-masterspeed="300"
                            data-rotate="0"
                            data-saveperformance="off"
                            data-title="Slide"

                          >
                            <!-- MAIN IMAGE -->
                            <img src="{{ $value->foto }}"
                                width="100%"
                                 alt=""
                                 data-bgposition="center center"
                                 data-bgfit="cover"
                                 data-bgrepeat="no-repeat"
                                 class="rev-slidebg"
                                 data-no-retina>
                            <!-- LAYERS -->

                            <!-- LAYER TITOLO tp-resizeme -->
                            <div class="tp-caption"
                                 id="slide-layer-2-{{ $value->id }}"
                                 data-x="80"
                                 data-y="255"
                                 data-width="['auto']"
                                 data-height="['auto']"
                                 data-type="text"
                                 data-responsive_offset="on"
                                 data-frames='[{"delay":340,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                                 data-textAlign="['inherit','inherit','inherit','inherit']"
                                 data-paddingtop="[0,0,0,0]"
                                 data-paddingright="[0,0,0,0]"
                                 data-paddingbottom="[0,0,0,0]"
                                 data-paddingleft="[0,0,0,0]"
                                 style="z-index: 7; white-space: nowrap; font-weight: 700; color: {{ $value->title_background }}; letter-spacing: 1px;"><h1>{{ $title[\App::getLocale()] }}</h1></div>

                            <!-- LAYER SOTTOTITOLO tp-resizeme -->
                            <div class="tp-caption"
                                 id="slide-layer-1-{{ $value->id }}"
                                 data-x="80"
                                 data-y="335"
                                 data-width="['auto']"
                                 data-height="['auto']"
                                 data-type="text"
                                 data-responsive_offset="on"
                                 data-frames='[{"delay":1200,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                                 data-textAlign="['inherit','inherit','inherit','inherit']"
                                 data-paddingtop="[0,0,0,0]"
                                 data-paddingright="[0,0,0,0]"
                                 data-paddingbottom="[0,0,0,0]"
                                 data-paddingleft="[0,0,0,0]"
                                 style="z-index: 5; white-space: nowrap; font-weight: 400;"><h3>{!! $abstract[\App::getLocale()] !!}</h3> </div>


                            @if(trim($button[\App::getLocale()])!="")
                                <!-- LAYER NR. 3 PULSANTE -->
                                    <a target="{{ $type_href }}" class="button tp-caption small"
                                       href="{{ $url }}" target="_self" id="slide-layer-3-{{ $value->id }}"
                                       data-x="80"
                                       data-y="bottom"
                                       data-voffset="200"
                                       data-width="['auto']"
                                       data-height="['auto']"
                                       data-type="button"
                                       data-responsive_offset="on"
                                       data-frames='[{"delay":1980,"speed":2000,"frame":"0","from":"y:bottom;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"},{"frame":"hover","speed":"300","ease":"Power0.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;"}]'
                                       data-textAlign="['inherit','inherit','inherit','inherit']"
                                       data-paddingtop="[12,12,12,12]"
                                       data-paddingright="[35,35,35,35]"
                                       data-paddingbottom="[12,12,12,12]"
                                       data-paddingleft="[35,35,35,35]"
                                       data-fontsize="[14,14,14,14]"
                                       style="z-index: 8; white-space: nowrap;  text-transform:uppercase;border-radius:3px 3px 3px 3px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;">
                                        {{ $button[\App::getLocale()] }}
                                    </a>
                            @endif
                        </li>

                        @endforeach
                    </ul>
                    <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
                </div>
            </div>
        @endif
</section>



