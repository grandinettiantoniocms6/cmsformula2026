@extends(backpack_view('blank'))

@section('header')
    <h3 class="page-title mb-0">
        <span class="text-capitalize">Video Tutorial</span>
    </h3>
    <p>Di seguito trovate una lista di Video Tutorial realizzati per guidarvi, passo passo, nell'utilizzo del sistema web CMS-Formula 5.0.</p>
@endsection

@section('content')
    <div class="row">
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
@endsection
