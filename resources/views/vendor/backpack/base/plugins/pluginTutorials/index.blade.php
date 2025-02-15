@extends(backpack_view('blank'))

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header"><h3>Video Tutorial</h3>
                <p>Di seguito trovate una lista di Video Tutorial realizzati per guidarvi, passo passo, nell'utilizzo del sistema web CMS-Formula 5.0.</p>
            </div>

                <div class="card-body">
                    <div class="row mt-12">
                        @if($tutorials)
                           @foreach($tutorials as $tutorial)
                                <?php
                                    $temp = explode("=", $tutorial->url);
                                ?>
                                <div class="col-sm-6">
                                  <h5>{{ $tutorial->title }}</h5>
                                  @if(key_exists(1, $temp))
                                  <iframe style="width: 100%; height: 520px;" src="https://www.youtube.com/embed/{{ $temp[1] }}" allowfullscreen></iframe>
                                  @endif
                                </div>
                           @endforeach
                        @endif
                    </div>
                </div>
        </div>
    </div>
</div>

@endsection
