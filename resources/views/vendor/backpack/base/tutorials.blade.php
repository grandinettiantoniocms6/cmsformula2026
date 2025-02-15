@extends(backpack_view('blank'))

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header"><h3>Video Tutorial</h3></div>
                @if(env('LOCAL') == 0)
                <div class="card-body">

                  <!-- imposto come si chiama la tabella del mio gest dedicata ai video tut 5.0 -->
                    <?php
                      $tutorials = \DB::connection('mysql_2')->table('tutorials5')->orderBy("tutorial5_order", "asc")->get();
                    ?>
                    <div class="row mt-6">
                        @if($tutorials)
                           @foreach($tutorials as $tutorial)

                                    <div class="col-sm-6">
                                      <h5>{{ $tutorial->tutorial5_title }}</h5>
                                      <iframe style="width: 100%; height: 640px;" src="{{ $tutorial->tutorial5_url }}" allowfullscreen></iframe>
                                    </div>

                           @endforeach
                        @endif
                    </div>
                @endif

                </div>
        </div>
    </div>
</div>

@endsection
