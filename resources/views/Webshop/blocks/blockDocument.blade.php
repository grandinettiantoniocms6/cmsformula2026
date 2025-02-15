<?php
$labels = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>
<section class="block-document wow animate__fadeInUp" data-wow-duration=".3s">
    <div class="container">
        <div class="row justify-content-left">
        <!--h2 class="title">{ @$labels['title-document'] }}</h2>-->
        @if($array)
             @foreach($array as $value)

                    <?php

                        $description = json_decode($value->description, true);
                        if($description === null){
                        $description = [];
                        }

                        if(!key_exists(\App::getLocale(), $description)){
                            $description[\App::getLocale()] = "";
                        }

                    ?>

                    @if(trim($value->file) != "" || $value->file)
                        <?php $title = json_decode($value->title, true); ?>

                        <div class="col-lg-{{ $item->col }} col-md-6 col-sm-6 mb-3">
                            <div class="card wow animate__fadeInUp" data-wow-duration=".3s">
                                <div class="card-body">
                                    <a href="{{ $value->file }}" target="_blank">
                                        <div class="icon">
                                            <i class="far fa-file-pdf"></i>
                                        </div>
                                        <div class="card-text">{{ $title[\App::getLocale()] }}</div>
                                    </a>
                                    <p>{!! $description[\App::getLocale()] !!}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

        @endif
        </div>
    </div>
</section>
