<div class="faq-section-five dark-bg mt-120 lg-mt-80 pt-130 pb-130 lg-pt-80 lg-pb-80">
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            <div class="col-xxl-5 col-lg-6">
                <div class="text-wrapper">
                    <div class="title-style-one white-vr">
                        <div class="upper-title">{{ $item->name }}</div>
                        <h2 class="title">Hai ancora <span>dubbi?</span> Contattaci.</h2>
                    </div>
                    <a href="/contatti" class="mt-30 theme-btn-four">Clicca qui.</a>
                </div> <!-- /.text-wrapper -->
            </div>
        </div>
            <div class="col-lg-6 ms-auto">
                <div class="accordion accordion-style-three lg-mt-60" id="accordionTwo">

                    @if($array)
                        <?php
                        $i = 0;
                        ?>

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

                            $active = "";
                            if($i == 0){
                                $active = "show";
                            }

                            if(!key_exists(\App::getLocale(), $title)){
                                $title[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $description)){
                                $description[\App::getLocale()] = "";
                            }
                            ?>

                                <div class="accordion-item">
                                    <div class="accordion-header" id="headingOneA">
                                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOneA">
                                            {{ $title[\App::getLocale()] }}
                                        </button>
                                    </div>
                                    <div id="collapseOneA" class="accordion-collapse collapse {{ $active }}" data-bs-parent="accordionTwo">
                                        <div class="accordion-body">
                                            <p>{!! $description[\App::getLocale()] !!}</p>
                                        </div>
                                    </div>
                                </div>


                            <?php $i++;?>
                        @endforeach
                    @endif


                </div>
            </div>

    </div>
</div>


