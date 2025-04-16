@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" crossorigin="anonymous" />
    <link href="{{ asset('packages/summernote/dist/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Monitor Prenotazioni</div>
                    <form method="GET" class="card-header" action="">
                        {{ csrf_field() }}
                        <div class="row gutters-pages">
                            <?php $indietro = \Carbon\Carbon::createFromFormat("Y-m-d", $date_en)->subDay()->toDateString();?>
                            <div class="col-auto mb-1"><a href="/admin/plugin/pluginParking/monitor?data={{ $indietro }}" class="btn btn-light"><i class="la la-angle-left"></i> <span class="d-none d-sm-inline">Indietro</span></a></div>
                            <div class="col col-sm-auto mb-1"><input type="date" class="form-control" name="data" value="{{ $date_en }}"></div>

                            <?php $avanti = \Carbon\Carbon::createFromFormat("Y-m-d", $date_en)->addDay()->toDateString();?>
                                <div class="col-auto mb-1"><a href="/admin/plugin/pluginParking/monitor?data={{ $avanti }}" class="btn btn-light"><span class="d-none d-sm-inline">Avanti</span> <i class="la la-angle-right"></i></a></div>
                                <div class="col col-sm-auto mb-1"><button type="submit" name="button" value="carica" class="btn btn-dark btn-block">Carica</button></div>
                                <div class="col col-sm-auto mb-1"><button type="submit" name="button" value="export" class="btn btn-info btn-block">Esporta</button></div>
                        </div>
                    </form>
                    <div class="card-body">
                        <div class="row gap-2">
                            <div class="col-xl-6 mb-3">
                                <div class="card-header bg-success">
                                    <h4 class="mb-0"><i class="las la-arrow-circle-down"></i> ENTRATE <i class="las la-car-alt"></i></h4>
                                </div>

                                @if($reservations_in)
                                    <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Nome Cognome</th>
                                                <th>Telefono</th>
                                                <th>Nr.Pass</th>
                                                <th>Targa</th>
                                                <th>Ora</th>
                                                <th>Tipo Park</th>
                                                <th>Prezzo</th>
                                                <th>Stato</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reservations_in as $item)
                                                <tr>
                                                    <td><a href="/admin/plugin-parking-reservation/{{ $item->id }}/edit">{{ $item->name }}</a></td>
                                                    <td>{{ $item->mobile }}</td>
                                                    <td>{{ $item->number_partecipants }}</td>
                                                    <td>{{ $item->targa }}</td>
                                                    <td>{{ \Carbon\Carbon::createFromFormat("H:i:s", $item->time_start)->format("H:i") }}</td>
                                                    <td>
                                                        @if($item->type_park == 1)
                                                            SC
                                                        @endif
                                                        @if($item->type_park == 2)
                                                            CO
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $item->total }}
                                                    </td>
                                                    <td>
                                                        {!! $item->getIsCheckin() !!}
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    </div>
                                @endif
                            </div>
                            <div class="col-xl-6 mb-3">
                                <div class="card-header bg-danger">
                                    <h4 class="mb-0"><i class="las la-arrow-circle-up"></i> USCITE <i class="las la-car-side"></i></h4>
                                </div>

                                @if($reservations_out)
                                    <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th>Nome Cognome</th>
                                            <th>Telefono</th>
                                            <th>Nr.Pass</th>
                                            <th>Targa</th>
                                            <th>Volo rientro</th>
                                            <th>Ora</th>
                                            <th>Tipo Park</th>
                                            <th>Prezzo</th>
                                            <th>Stato</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($reservations_out as $item)
                                            <tr>
                                                <td><a href="/admin/plugin-parking-reservation/{{ $item->id }}/edit">{{ $item->name }}</a></td>
                                                <td>{{ $item->mobile }}</td>
                                                <td>{{ $item->number_partecipants }}</td>
                                                <td>{{ $item->targa }}</td>
                                                <td>{{ $item->number_flight }}</td>
                                                <td>{{ \Carbon\Carbon::createFromFormat("H:i:s", $item->time_end)->format("H:i") }}</td>
                                                <td>
                                                    @if($item->type_park == 1)
                                                        SC
                                                    @endif
                                                    @if($item->type_park == 2)
                                                        CO
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $item->total }}
                                                </td>
                                                <td>
                                                    {!! $item->getIsPayed() !!}
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

