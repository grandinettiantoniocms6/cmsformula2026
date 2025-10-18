<?php
$website = \App\Models\WebsiteSetting::first();
$labels = \App\Models\Label::get()->pluck("value", "key")->toArray();

$titleBlocco = json_decode($item->title, true);
if($titleBlocco){
    if(!key_exists(\App::getLocale(), $titleBlocco)){
        $titleBlocco[\App::getLocale()] = "";
    }
}else{
    $titleBlocco[\App::getLocale()] = "";
}

$descriptionBlocco = json_decode($item->description, true);
if($descriptionBlocco){
    if(!key_exists(\App::getLocale(), $descriptionBlocco)){
        $descriptionBlocco[\App::getLocale()] = "";
    }
}else{
    $descriptionBlocco[\App::getLocale()] = "";
}

?>

@if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")

    <section class="position-relative overflow-hidden pt-5">
        <div class="separator-line-9px bg-base-color position-absolute top-0px right-0px" data-bottom-top="width: 15%" data-center-top="width: 50%;"></div>
        <div class="container">
            <div class="row justify-content-center mb-2">
                <div class="col-xl-12 col-lg-9 col-md-10 text-center" data-anime='{ "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <span class="ps-25px pe-25px mb-15px text-uppercase text-base-color fs-12 lh-40 fw-700 border-radius-100px bg-solitude-blue d-inline-flex">{{ $titleBlocco[\App::getLocale()] }}</span>
                    <p>{!! $descriptionBlocco[\App::getLocale()] !!}</p>
                </div>
            </div>
        </div>
@endif

<section class="big-section bg-very-light-gray block-faq mt-3" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            <div class="accordion accordion-style-01" id="accordion-{{ $item->id }}" data-active-icon="fa-angle-down" data-inactive-icon="fa-angle-right" data-anime='{ "el": "childs", "translateX": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>

                @if($array)
                        <?php $i = 0;?>
                    @foreach($array as $value)
                            <?php
                            $id = $value->id;
                            $title = json_decode($value->title, true);
                            if($title === null){
                                $title = [];
                            }

                            $description = json_decode($value->description, true);
                            if($description === null){
                                $description = [];
                            }

                            $active = '';
                            $collapsed = 'collapsed';
                            if($i == 0){
                                $active = 'show';
                                $collapsed = '';
                            }

                            if(!key_exists(\App::getLocale(), $title)){
                                $title[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $description)){
                                $description[\App::getLocale()] = "";
                            }
                            ?>

                        <div class="accordion-item bg-white {{ $active }}" data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 600, "delay":150, "staggervalue": 150, "easing": "easeOutQuad" }'>
                            <div class="accordion-header">
                                <button class="accordion-button {{ $collapsed }}" style="background-color:#ffffff!important; border-color: #ffffff!important; border: 0px;" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-collapse-{{ $item->id }}-{{ $i }}" aria-expanded="false" aria-controls="collapseTwo">
                                    <b>{{ $title[\App::getLocale()] }}</b>
                                </button>
                            </div>
                            <div id="accordion-collapse-{{ $item->id }}-{{ $i }}" class="accordion-collapse collapse {{$active }}" data-bs-parent="#accordion-{{ $item->id }}" >
                                <div class="accordion-body last-paragraph-no-margin">
                                    {!! $description[\App::getLocale()] !!}
                                </div>
                            </div>
                        </div>
                            <?php $i++;?>


                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
