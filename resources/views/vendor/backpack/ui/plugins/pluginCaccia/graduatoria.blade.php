@extends(backpack_view('blank'))

@section('after_styles')
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Graduatoria Cacciatori</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <form method="post" action="">
                                {{ csrf_field() }}

                                <input type="hidden" name="sql" value="{{ $sql }}">

                                <div class="row">
                                    <div class="col">
                                        <label>Anno</label>
                                        <input class="form-control" type="number" name="year" value="{{ $year }}">
                                    </div>

                                    <div class="col">
                                        <label>Azioni</label>
                                        <button type="submit" name="button" value="filtra" class="form-control btn btn-dark">Filtra</button>
                                        <button type="submit" name="button" value="export" class="form-control btn btn-dark">Esporta</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            @if($list)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <strong>Codice</strong>
                                        </th>
                                        <th>
                                            <strong>Nome</strong>
                                        </th>
                                        <th>
                                            <strong>Punti</strong>
                                        </th>
                                        <th>
                                            <strong>Numero Capi</strong>
                                        </th>
                                        <th>
                                            <strong>Tipo Capi</strong>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $item)
                                        <?php
                                        $hunter = \App\Models\PluginCacciaHunters::find($item->hunter_id);
                                        if(!$hunter){
                                            continue;
                                        }

                                        $chiefs = \App\Models\PluginCacciaHuntersPoints::where("hunter_id", $hunter->id)->whereNotNull("hunter_chief_id")->get();
                                        ?>
                                        <tr>
                                            <td>
                                                {{ $hunter->code }}
                                            </td>
                                            <td>
                                                {{ $hunter->first_name }}  {{ $hunter->last_name }}
                                            </td>
                                            <td>
                                                {{ $item->tot }}
                                            </td>
                                            <td>
                                                {{ count($chiefs) }}
                                            </td>

                                            <td>
                                                @if($chiefs)
                                                    @foreach($chiefs as $c)
                                                        <?php
                                                        $chief = \App\Models\PluginCacciaChiefs::find($c->chief_id);
                                                        ?>
                                                        {{ $c->point }} punti {{ $chief->code }}<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('after_scripts')
@endsection

