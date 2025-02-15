<section class="faq white-bg page-section-ptb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="section-title text-center">
                    <h6>{{ $item->name }}</h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="accordion shadow">

                    @if($array)
                        <?php
                        $i = 0;
                        ?>

                        @foreach($array as $value)
                            <?php
                            $id = $value->id;
                            $title = json_decode($value->title, true);
                            $description = json_decode($value->description, true);

                            $active = "";
                            if($i == 0){
                                $active = "acd-active";
                            }

                            if(!key_exists(\App::getLocale(), $title)){
                                $title[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $description)){
                                $description[\App::getLocale()] = "";
                            }
                            ?>

                            <div class="acd-group {{ $active }}">
                                <a href="#" class="acd-heading">{{ $title[\App::getLocale()] }}</a>
                                <div class="acd-des">
                                    {!! $description[\App::getLocale()] !!}
                                </div>
                            </div>
                            <?php $i++;?>
                        @endforeach
                    @endif


                </div>
            </div>
        </div>
    </div>
</section>


