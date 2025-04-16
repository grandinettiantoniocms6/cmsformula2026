@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" crossorigin="anonymous" />
    <link href="{{ asset('packages/summernote/dist/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <?php
    $adminPluginParking = \App\Models\AdminPlugin::where("name", "pluginParking")->where("is_active", 1)->first();
    ?>
    @if($adminPluginParking)
        <?php
        $mm = \Carbon\Carbon::now()->format("m");
        if(\request()->has('month')){
            $mm = \request()->get('month');
        }
        $year = \Carbon\Carbon::now()->format("Y");
        if(\request()->has('year')){
            $year = \request()->get('year');
        }
        $parkingSetting = \App\Models\PluginParkingSetting::first();

        $start = \Carbon\Carbon::createFromFormat("Y-m-d", "$year-$mm-00");

        $months = ["01" => "Gennaio", "02" => "Febbraio", "03" => "Marzo", "04" => "Aprile", "05" => "Maggio", "06" => "Giugno", "07" => "Luglio",
            "08" => "Agosto", "09" => "Settembre", "10" => "Ottobre", "11" => "Novembre", "12" => "Dicembre"];
        ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Panoramica Parcheggio</div>
                    <form method="GET" class="card-header" action="">
                        {{ csrf_field() }}
                        <div class="form-inline">
                            <select class="custom-select" name="month" id="park-month">
                                @foreach($months as $value_month=>$label_month)
                                    <option value="{{ $value_month }}" @if($value_month == $mm) selected @endif>{{ $label_month }}</option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control mx-2" name="year" value="{{ $year }}">
                            <button type="submit" class="btn btn-dark">CARICA</button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('pluginParking.save_holidays') }}">
                    <div class="card-body">
                        <div class="row gap-2 ml-1 text-center">
                            <div class="form-inline">
                                <input type="checkbox" id="select_all"/>

                               <input style="width: 800px;" type="text" class="form-control mx-2" name="motivation" value="" placeholder="SCRIVI UNA MOTIVAZIONE DI CHIUSURA">
                                <button type="submit" name="button" value="close" class="btn btn-dark">IMPOSTA CHIUSURA</button>
                                <button type="submit" name="button" value="open" class="btn ml-1 btn-info">IMPOSTA DISPONIBILE</button>
                            </div>
                        </div>

                        <br>
                        <div class="row gap-2">
                                {{ csrf_field() }}

                                @for($i=0;$i<=31;$i++)
                                    <?php
                                    $date = $start->addDay();

                                    if($date->format("m") != $mm){
                                        continue;
                                    }

                                    $date_en = $date->toDateString();

                                    $total = $parkingSetting->total_park_scoperto + $parkingSetting->total_park_coperto;

                                    $reservations_scoperto  = \App\Models\PluginParkingReservation::whereRaw("(date_start <= '$date_en' AND date_end >= '$date_en')")->where("type_park", 1)->count();
                                    $reservations_coperto  = \App\Models\PluginParkingReservation::whereRaw("(date_start <= '$date_en' AND date_end >= '$date_en')")->where("type_park", 2)->count();

                                    $holiday = \App\Models\PluginParkingHoliday::where("day", $date_en)->first();
                                    ?>
                                    <div class="col-sm-6 col-md-2 d-flex">
                                        <div class="card flex-grow-1 text-black bg-light mb-3 mb-md-3">
                                            <div class="card-body">
                                                <div>
                                                    <div class="text text-bold mb-2"><strong>{{ $date->format("d/m/Y") }}</strong></div>

                                                    <?php
                                                    $diff = $parkingSetting->total_park_scoperto - $reservations_scoperto;
                                                    if($diff < 0){
                                                        $diff = 0;
                                                    }
                                                    ?>
                                                    <a class="d-flex align-items-center @if($diff > 0) text-success @else text-danger @endif" href="/admin/plugin-parking-reservation?day={{ $date_en }}">
                                                        <h2 class="@if($diff > 0) bg-success @else bg-danger @endif txt-white px-2 rounded my-0">{{ $diff }}</h2>
                                                        <div class="text-uppercase font-sm ml-2">Disponibili SCOPERTO</div>
                                                    </a>

                                                    <?php
                                                    $diff = $parkingSetting->total_park_coperto - $reservations_coperto;
                                                    if($diff < 0){
                                                        $diff = 0;
                                                    }
                                                    ?>
                                                    <a class="d-flex align-items-center mt-1 @if($diff > 0) text-success @else text-danger @endif" href="/admin/plugin-parking-reservation?day={{ $date_en }}">
                                                        <h2 class="@if($diff > 0) bg-success @else bg-danger @endif txt-white px-2 rounded my-0">{{ $diff }}</h2>
                                                        <div class="text-uppercase font-sm ml-2">Disponibili COPERTO</div>
                                                    </a>
                                                </div>
                                                <div class="list-group list-group-flush mt-2">
                                                    <div class="list-group-item d-flex align-items-center justify-content-between bg-transparent px-0 py-1 border-top-0">
                                                        <span class="text">Scoperto: </span> <a href='/admin/plugin-parking-reservation?type_park=1&day={{ $date_en }}'>{{ $reservations_scoperto }} / {{ $parkingSetting->total_park_scoperto }}</a>
                                                    </div>
                                                    <div class="list-group-item d-flex align-items-center justify-content-between bg-transparent px-0 py-1">
                                                        <span class="text">Coperto:</span> <a href="/admin/plugin-parking-reservation?type_park=2&day={{ $date_en }}">{{ $reservations_coperto }} / {{ $parkingSetting->total_park_coperto }}</a>
                                                    </div>

                                                    <input style="margin: 10px 0 10px 0!important;" type="checkbox" class="checkbox" name="days[]" value="{{ $date_en }}">

                                                    @if($holiday)
                                                        <span class="badge badge-dark">Chiuso</span>
                                                        <small>{{ $holiday->motivation }}</small>
                                                    @else
                                                        <span class="badge badge-info">Disponibile</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor

                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('before_styles')

@endsection

@section('after_scripts')

    <script type="text/javascript">
        //select all checkboxes
        $("#select_all").change(function(){  //"select all" change
            var status = this.checked; // "select all" checked status
            $('.checkbox').each(function(){ //iterate all listed checkbox items
                this.checked = status; //change ".checkbox" checked status
            });
        });

        $('.checkbox').change(function(){ //".checkbox" change
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(this.checked == false){ //if this item is unchecked
                $("#select_all")[0].checked = false; //change "select all" checked status to false
            }

            //check "select all" if all checkbox items are checked
            if ($('.checkbox:checked').length == $('.checkbox').length ){
                $("#select_all")[0].checked = true; //change "select all" checked status to true
            }
        });
    </script>

@endsection

