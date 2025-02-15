@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" crossorigin="anonymous" />
    <link href="{{ asset('packages/summernote/dist/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Panoramica interventi</div>
                    <form method="GET" class="card-header" action="">
                        {{ csrf_field() }}
                        <div class="row gutters-pages">
                            <?php $indietro = \Carbon\Carbon::createFromFormat("Y-m-d", $date_en)->subDay()->toDateString();?>
                            <div class="col-auto mb-1"><a href="/admin/plugin/pluginInterventions/monitor?data={{ $indietro }}" class="btn btn-light"><i class="la la-angle-left"></i> <span class="d-none d-sm-inline">Indietro</span></a></div>
                            <div class="col col-sm-auto mb-1"><input type="date" class="form-control" name="data" value="{{ $date_en }}"></div>

                            <?php $avanti = \Carbon\Carbon::createFromFormat("Y-m-d", $date_en)->addDay()->toDateString();?>

                                <div class="col-auto mb-1"><a href="/admin/plugin/pluginInterventions/monitor?data={{ $avanti }}" class="btn btn-light"><span class="d-none d-sm-inline">Avanti</span> <i class="la la-angle-right"></i></a></div>

                                <?php
                                $mezzi = \App\Models\PluginInterventionsVehicles::orderBy("name", "asc")->get();
                                ?>
                                @if($mezzi)
                                    <div class="col col-sm-auto mb-1">
                                        <select class="form-control" name="vehicle_id">
                                            <option value="0">Tutti i mezzi</option>
                                            @foreach($mezzi as $mezzo)
                                                <option value="{{ $mezzo->id }}" @if($vehicle_select == $mezzo->id) selected @endif>{{ $mezzo->name }} ({{ $mezzo->code }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="col col-sm-auto mb-1">
                                    <input type="time" class="form-control" name="start" value="{{ $start }}">
                                </div>

                                <div class="col col-sm-auto mb-1">
                                    <input type="time" class="form-control" name="end" value="{{ $end }}">
                                </div>

                                <div class="col col-sm-auto mb-1"><button type="submit" name="button" value="carica" class="btn btn-primary btn-block">Carica</button></div>

                                <div class="col col-sm-auto mb-1"><a class="btn btn-success btn-block" href="/admin/plugin-interventions/create?data={{ $date_en }}">Aggiungi intervento</a></div>

                                <?php
                                $count = \App\Models\PluginInterventionsNote::where("day", $date_en)->where("is_closed", 0)->count();
                                ?>
                                @if($count > 0)
                                    <div class="col col-sm-auto mb-1"><a class="btn btn-warning btn-block" href="/admin/plugin-interventions-note?day={{ $date_en }}">{{ $count }} Note aperte</a></div>
                                @endif


                                <div class="col col-sm-auto mb-1"><button type="submit" name="button" value="export" class="btn btn-info btn-block">Esporta</button></div>
                        </div>
                    </form>
                    <div class="card-body">
                        <div class="row gap-2">
                            <div class="col-xl-12 mb-3">
                                @if($reservations)
                                    <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Orario</th>
                                                <th>Cliente</th>
                                                <th>Indirizzo</th>
                                                <th>Cellulare</th>
                                                <th>Mezzo</th>
                                                <th>Autista</th>
                                                <th>Manovale</th>
                                                <th>Stato</th>
                                                <th>Priorità</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reservations as $item)
                                                <tr> <!--  @if($item->status) style="background-color: {{ $item->status->color }}; color:black" @endif -->
                                                    <td>
                                                        @if($item->date_intervention)
                                                            <?php
                                                            $date_it = \Carbon\Carbon::createFromFormat("Y-m-d", $item->date_intervention)->format("d/m/Y");
                                                            ?>
                                                            {{ $date_it }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if($item->is_all_day){
                                                            echo "Tutto il giorno";
                                                        }else{
                                                            $start = "";
                                                            $end = "";
                                                            if($item->start){
                                                                $start = \Carbon\Carbon::createFromFormat("H:i:s", $item->start)->format("H:i");
                                                            }
                                                            if($item->end){
                                                                $end = \Carbon\Carbon::createFromFormat("H:i:s", $item->end)->format("H:i");
                                                            }
                                                            echo "Dalle $start alle $end";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        {{ $item->first_name }} {{ $item->last_name }}
                                                    </td>
                                                    <td>
                                                        {{ $item->address }}  {{ $item->civico }}  {{ $item->interno }}
                                                        <br>
                                                        {{ $item->frazione }}  {{ $item->comune }}  {{ $item->provincia }}
                                                        <br>
                                                        {{ $item->cap }}
                                                    </td>
                                                    <td>{{ $item->mobile }}</td>
                                                    <td>
                                                        <span style="padding:3px; background-color: {{ $item->vehicle->color }}">{{ $item->vehicle->name }}</span>
                                                    </td>
                                                    <td>
                                                        @if($item->driver)
                                                            {{ $item->driver->first_name }} {{ $item->driver->last_name }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item->laborer)
                                                            {{ $item->laborer->first_name }} {{ $item->laborer->last_name }}
                                                        @endif
                                                    </td>

                                                    <td style="color: black">
                                                        @if($item->status)
                                                            {!! strip_tags($item->getStatus()) !!}
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if($item->is_priority)
                                                            SI
                                                        @else
                                                            NO
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a style="color:black;" href="/admin/plugin-interventions/{{ $item->id }}/edit" class="btn btn-light">Vedi</a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('before_styles')

@endsection

@section('after_scripts')
@endsection

