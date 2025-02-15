<div class="card mb-0">
    <div class="card-header bg-light">
        <div class="row align-items-center">
            <div class="col">Cronologia
            </div>
            <div class="col-auto">
            </div>
        </div>
    </div>
    <div class="card-body py-0">
        @if($chiefs)
            @foreach($chiefs as $chief)
                <?php
                $item = \App\Models\PluginCacciaChiefs::find($chief->chief_id);
                $user = \App\User::find($chief->user_id);
                ?>
                <div class="row border-bottom align-items-end">
                    <div class="py-2 col-md-1">
                        <label>{{ $item->code }}</label>
                    </div>
                    <div class="py-2 col-md-2">
                        <label>
                            @if($chief->date_associate)
                               {{ \Carbon\Carbon::createFromFormat("Y-m-d", $chief->date_associate)->format("d/m/Y") }}
                            @endif
                        </label>
                    </div>
                    <div class="py-2 col-md-6">
                        @if( $chief->status_id == 0)
                            <span class="badge badge-info">In valutazione</span>
                        @endif

                        @if( $chief->status_id == 1)
                            <span class="badge badge-success">Accettato</span>
                        @endif

                        @if( $chief->status_id == 2)
                            <span class="badge badge-danger">Rifiutato</span>
                        @endif
                    </div>
                    <div class="py-2 col-md-3">
                        <label>{{ $user->name }}</label>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
