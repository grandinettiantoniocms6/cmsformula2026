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
        @if($points)
            @foreach($points as $point)
                <?php
                $user = \App\User::find($point->user_id);
                ?>
                <div class="row border-bottom align-items-end">
                    <div class="py-2 col-md-1">
                        <label>{{ $point->point }}</label>
                    </div>
                    <div class="py-2 col-md-2">
                        <label>{{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $point->created_at)->format("d/m/Y H:i") }}</label>
                    </div>
                    <div class="py-2 col-md-6">
                        <label>{{ $point->note }}</label>
                    </div>
                    <div class="py-2 col-md-3">
                        <label>{{ $user->name }}</label>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
