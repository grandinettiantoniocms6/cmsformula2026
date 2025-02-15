<?php $lang = \App::getLocale(); ?>
<?php $labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray(); ?>

<style>
    #block-booking-searchbar-{{ $item->id }} {
        padding: {{ $item->padding }};
        background-color: {{ $item->bgcolor }};
    }
</style>

<section class="block-booking-searchbar image-wrapper bg-overlay bg-overlay-black-{{ $item->alpha }}" id="block-booking-searchbar-{{ $item->id }}">
    <div class="searchbar">
        <div class="container">
            <div class="text-center">
                <?php
                $description = json_decode($item->description, true);
                if($description === null){
                    $description = [];
                }

                if(!key_exists(\App::getLocale(), $description)){
                    $description[\App::getLocale()] = "";
                }
                ?>


                {!! $description[\App::getLocale()] !!}
            </div>
            <form class="validation" id="form_date_searchbar" method="post" action="{{ route("pluginBookingHidden.$lang") }}" style="background-color: {{ $item->form_booking_bgcolor }};bottom:{{ $item->form_booking_top }}; border-radius: {{ $item->form_booking_border_radius }}; border-color: {{ $item->form_booking_border_color }}; border-style: solid; border-width: {{ $item->form_booking_border_width }};>
                {{ csrf_field() }}
                <div class="row gx-2">
                    <?php
                    $type = \App\Models\PluginBookingType::find($item->plugin_booking_type_id);
                    $start = \Carbon\Carbon::now()->toDateString();
                    $end =  \Carbon\Carbon::now()->toDateString();
                    $letti = 1;

                    echo "<input type='hidden' name='type' value='$type->id'>";

                    //[0 => "per data singola", 1 => "per data e orario singolo", 2=> "per range di date", 3 => "per range date e orari"]
                    switch($type->type_booking){
                    case 0:
                    ?>

                    <div class="col-lg-4">
                        <div class="form-group mb-lg-0">
                            <input type="text" name="start" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-quando'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mb-lg-0">
                            <input type="number" placeholder="{{ @$labels['booking-date-quanti'] }}" name="letti" class="form-control form-control-lg" min="1" value="" id="letti" required>
                        </div>
                    </div>
                    <?php
                    break;
                    case 1:
                    ?>
                    <div class="col-lg-3">
                        <div class="form-group mb-lg-0">
                            <input type="text" name="start" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-quando'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start" required>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-lg-0">
                            <input type="text" name="start_time" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-ora'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start_time" required>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group mb-lg-0">
                            <input type="number" placeholder="{{ @$labels['booking-date-quanti'] }}" name="letti" class="form-control form-control-lg" min="1" value="" id="letti" required>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group mb-lg-0">
                            <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti-bimbi'] }}" name="letti_bimbi" class="form-control form-control-lg" min="0" value="" id="letti_bimbi">
                        </div>
                    </div>
                    <?php
                    break;

                    case 2:
                    ?>

                    <div class="col-lg-3">
                        <div class="form-group mb-lg-0">
                            <input type="text" name="start" class="form-control form-control-lg" placeholder="{{ @$labels['booking-check-in'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start-range" required>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-lg-0">
                            <input type="text" name="end" class="form-control form-control-lg" placeholder="{{ @$labels['booking-check-out'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="end-range" required>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group mb-lg-0">
                            <input type="number" placeholder="{{ @$labels['booking-ospiti'] }}" name="letti" class="form-control form-control-lg" min="1" value="" id="letti" required>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group mb-lg-0">
                            <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti-bimbi'] }}" name="letti_bimbi" class="form-control form-control-lg" min="0" value="" id="letti_bimbi">
                        </div>
                    </div>


                    <?php
                    break;
                    case 3:
                    ?>

                    <div class="col-lg-2">
                        <div class="form-group mb-lg-0">
                            <input type="text" name="start" class="form-control form-control-lg" placeholder="{{ @$labels['booking-check-in'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start-range" required>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group mb-lg-0">
                            <input type="text" name="end" class="form-control form-control-lg" placeholder="{{ @$labels['booking-check-out'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="end-range" required>
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group mb-lg-0">
                            <input type="text" name="start_time" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-start'] }}" value="" min="{{ \Carbon\Carbon::now()->toTimeString() }}" id="start_time" required>
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group mb-lg-0">
                            <input type="text" name="end_time" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-end'] }}" value="" min="{{ \Carbon\Carbon::now()->toTimeString() }}" id="end_time"  required>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group mb-lg-0">
                            <input type="number" placeholder="{{ @$labels['booking-date-quanti'] }}" name="letti" class="form-control form-control-lg" min="1" value="" id="letti" required>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group mb-lg-0">
                            <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti-bimbi'] }}" name="letti_bimbi" class="form-control form-control-lg" min="0" value="" id="letti_bimbi">
                        </div>
                    </div>
                    <?php
                    break;
                    }
                    ?>
                    <div class="col-lg-3 mb-lg-0">
                        <button class="btn btn-primary btn-lg width-100" type="submit">{{ @$labels['booking-cerca-disponibilita'] }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if(trim($item->foto) != "")
        <img class="img-cover" src="{{ $item->foto }}" loading="lazy">
    @endif
</section>
