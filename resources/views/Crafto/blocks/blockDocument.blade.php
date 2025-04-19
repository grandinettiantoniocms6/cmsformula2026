<?php
$labels = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>
<section class="bg-solitude-white">
    <div class="container mt-50px">
        <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center">
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
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ $value->file }}" target="_blank">
                                        <div class="row">
                                            <div class="col-12 col-lg-2">
                                                <img src="/uploads/icone/pdf.png" title="PDF icon">
                                            </div>
                                            <div class="col-12 col-lg-9">
                                                <span style="font-size: 18px; font-weight: bold;">{{ $title[\App::getLocale()] }}</span><br>
                                                {!! $description[\App::getLocale()] !!}
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>

                    @endif
                @endforeach

        @endif
        </div>
    </div>
</section>
