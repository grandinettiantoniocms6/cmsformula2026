@extends(backpack_view('blank'))

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header"><h3>Video Tutorial</h3></div>
                @if(env('LOCAL') == 0)
                <div class="card-body">
                    <?php
                    $url = "https://gest.webisland.it/tutorials.xml";
                    $xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
                    ?>
                    <div class="row mt-6">
                        @if($xml->channel)
                           @foreach($xml->channel->item as $tutorial)
                                <div class="col-sm-6">
                                  <h5>{{ $tutorial->title }}</h5>
                                  <iframe style="width: 100%; height: 640px;" src="{{ $tutorial->description }}" allowfullscreen></iframe>
                                </div>
                           @endforeach
                        @endif
                    </div>
                </div>
                @endif
        </div>
    </div>
</div>

@endsection
