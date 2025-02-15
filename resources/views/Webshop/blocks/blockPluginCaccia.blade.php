<?php
$settingCaccia = \App\Models\PluginCacciaSettings::first();

$year =  \Carbon\Carbon::now()->format("Y");
if($settingCaccia->year_front){
    $year = $settingCaccia->year_front;
}

$sql = "";
$code = "";
if(request()->has('code')){
    $code = trim(request()->get('code'));
    $hunter = \App\Models\PluginCacciaHunters::where("code", $code)->first();
    if($hunter){
        $sql = "and hunter_id = $hunter->id";
    }
}

$list = \App\Models\PluginCacciaHuntersPoints::selectRaw("SUM(point) as tot, hunter_id")
    ->whereRaw("(created_at >= '$year-01-01 00:00:00' AND created_at <= '$year-12-31 23:59:59') $sql")
    ->groupBy("hunter_id")
    ->orderBy("tot", "desc")
    ->get();
?>
<section class="block-caccia">
    <div class="container">
        <h2 class="title mb-4">Graduatoria Cacciatori</h2>
        <form method="get">
            {{ csrf_field() }}
            <div class="row gx-2 mb-2">
                <div class="col">
                    <input class="form-control" type="text" name="code" value="{{ $code }}" placeholder="Inserisci il codice">
                </div>
                <div class="col-auto">
                    <button type="submit" name="button" value="filtra" class="btn btn-primary">Filtra</button>
                </div>
            </div>
        </form>

        @if($list)
            @foreach($list as $item)
                <?php
                $hunter = \App\Models\PluginCacciaHunters::find($item->hunter_id);
                if(!$hunter){
                    continue;
                }
                $chiefs = \App\Models\PluginCacciaHuntersPoints::where("hunter_id", $hunter->id)->whereNotNull("hunter_chief_id")->get();
                ?>
                <!-- Modal -->
                    <div class="modal fade" id="exampleModalCaccia_{{ $hunter->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Storico {{ $hunter->code }}</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if($chiefs)
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Punti</th>
                                                <th>Cacciatore</th>
                                                <th>Capo</th>
                                                <th>Data esito</th>
                                            </tr>
                                            </thead>

                                            @foreach($chiefs as $c)
                                                <?php
                                                $chief = \App\Models\PluginCacciaChiefs::find($c->chief_id);
                                                $hunter_chief = \App\Models\PluginCacciaHuntersChiefs::find($c->hunter_chief_id);
                                                ?>
                                                @if($chief)
                                                    <tr>
                                                        <td>{{ $c->point }}</td>
                                                        <td>{{ $hunter->first_name }} {{ $hunter->last_name[0] }}.</td>
                                                        <td>{{ $chief->code }}</td>
                                                        <td>
                                                            @if($hunter_chief)
                                                                @if($hunter_chief->date_esito)
                                                                    {{ \Carbon\Carbon::createFromFormat("Y-m-d", $hunter_chief->date_esito)->format("d/m/Y") }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                </div>
                            </div>
                        </div>
                    </div>
             @endforeach

            <table class="table table-sm table-bordered">
                <thead>
                <tr>
                    <th>Codice</th>
                    <th>Cacciatore</th>
                    <th>Punti</th>
                    <th>Numero Capi</th>
                    <th>Dettaglio</th>
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
                        <td>{{ $hunter->code }}</td>
                        <td>{{ $hunter->first_name }} {{ $hunter->last_name[0] }}.</td>
                        <td>{{ $item->tot }}</td>
                        <td>{{ count($chiefs) }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalCaccia_{{ $hunter->id  }}">
                                Storico
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>


