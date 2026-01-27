<?php
    $labels = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>
<section class="block-contact-map" id="block-contact-map-{{ $value->block_id }}" data-anime='{"translateX": [50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="container-fluid px-0 overflow-hidden space-{{ $item->margin_top }}">
        <div class="row gx-0 align-items-center">
            <div class="col-lg-12 order-1 order-lg-2 wow animate__fadeInDown" data-wow-duration=".3s">
                <div class="contact-info py-4 px-5">
                    @if($subtitle[\App::getLocale()])
                        <h6 class="pretitle">{{ $subtitle[\App::getLocale()] }}</h6>
                    @endif
                    @if($title[\App::getLocale()])
                        <h2 class="title">{{ $title[\App::getLocale()] }}</h2>
                    @endif

                    @if(trim($description[\App::getLocale()]) != '')
                        <div class="first-description">{!! $description[\App::getLocale()] !!}</div>
                    @endif

                    <ul class="list-unstyled address">
                        @if($address1)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="fas fa-map-marker-alt" style="color: {{ $value->color_txt }};"></i></span>
                                <div>
                                    <div style="color: {{ $value->color_txt }};">{{ $address1 }}</div>
                                    <div style="color: {{ $value->color_txt }};">{{ $address2 }}</div>
                                    <div style="color: {{ $value->color_txt }};">{{ $address3 }}</div>
                                </div>
                            </li>
                        @endif
                        @if($phone1)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="fas fa-phone" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"><a href="tel:{{ $phone1 }}" target="_blank">{{ $phone1 }}</a></div>
                            </li>
                        @endif
                        @if($phone2)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="fas fa-phone" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"><a href="tel:{{ $phone2 }}" target="_blank">{{ $phone2 }}</a></div>
                            </li>
                        @endif
                        @if($phone3)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="fas fa-phone" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"><a href="tel:{{ $phone3 }}" target="_blank">{{ $phone3 }}</a></div>
                            </li>
                        @endif
                        @if($fax)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="fas fa-phone" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};">{{ @$labels['fax-block-contact-gmap'] }} {{ $fax }}</div>
                            </li>
                        @endif
                        @if($whatsapp)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="fab fa-whatsapp" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"><a href="https://api.whatsapp.com/send?phone={{ $whatsapp }}" target="_blank">{{ @$labels['whatsapp-block-contact-gmap'] }} {{ $whatsapp }}</a></div>
                            </li>
                        @endif
                        @if($email1)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="far fa-envelope" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"><a href="mailto:{{ $email1 }}" target="_blank">{{ $email1 }}</a></div>
                            </li>
                        @endif
                        @if($email2)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="far fa-envelope" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"><a href="mailto:{{ $email2 }}" target="_blank">{{ $email2 }}</a></div>
                            </li>
                        @endif
                        @if($email3)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="far fa-envelope" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"><a href="mailto:{{ $email3 }}" target="_blank">{{ $email3 }}</a></div>
                            </li>
                        @endif
                        @if($pec)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="far fa-envelope" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};">{{ $pec }}</div>
                            </li>
                        @endif
                        @if($facebook)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="fab fa-facebook" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"><a href="{{ $facebook }}" target="_blank">{{ @$labels['fb-block-contact-gmap'] }}</a></div>
                            </li>
                        @endif
                        @if($instagram)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="fab fa-instagram" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"><a href="{{ $instagram }}" target="_blank">{{ @$labels['insta-block-contact-gmap'] }}</a></div>
                            </li>
                        @endif
                        @if($linkedin)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="fab fa-linkedin" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"><a href="{{ $linkedin }}" target="_blank">{{ @$labels['linkedin-block-contact-gmap'] }}</a></div>
                            </li>
                        @endif
                        @if($orari)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="fas fa-clock" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"> {{ $orari }}</div>
                            </li>
                        @endif
                        @if($come_raggiungerci)
                            <li class="d-flex mb-1">
                                <span class="me-2"><i class="fas fa-map" style="color: {{ $value->color_txt }};"></i></span>
                                <div style="color: {{ $value->color_txt }};"><a href="{{ $come_raggiungerci }}" target="_blank">{{ @$labels['map-block-contact-gmap'] }}</a></div>
                            </li>
                        @endif

                    </ul>

                    @if($description2[\App::getLocale()])
                        <div class="second-description">{!! $description2[\App::getLocale()] !!} </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
