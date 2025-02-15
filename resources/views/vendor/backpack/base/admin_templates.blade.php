@extends(backpack_view('blank'))

@section('after_styles')
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Template</div>
                <div class="card-body">
                    <div class="row">
                    <?php
                    $templates = \App\Models\AdminTemplate::get();
                    $tema = env("TEMA");
                    ?>
                    @if($templates)
                        @foreach($templates as $template)
                            <div class="col-sm-4">
                                <h3>{{ $template->name }}</h3>
                                <img class="img-fluid" src="{{ url($template->image_name) }}">
                                <br><br>
                                <p>{{ $template->description }}</p>
                                <br>
                                <h5>{{ number_format($template->price, 2, ",", ".") }} &euro;</h5>
                                <a href="{{ $template->url }}" class="btn btn-block btn-primary" target="_blank">Vedi anteprima</a>
                                <form method="post" action="{{ route('changeTemplate') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $template->id }}">
                                    <input type="hidden" name="template" value="{{ $template->name }}">

                                    @if($template->name == "Crafto")
                                        <div class="form-group">
                                            <label>Nav Style</label>
                                            <input type="text" class="form-control" name="nav_style" value="{{ $template->nav_style }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Inc</label>
                                            <input type="text" class="form-control" name="inc" value="{{ $template->inc }}">
                                        </div>
                                    @endif

                                    @if($template->name == "Webshop")
                                        <div class="form-group">
                                            <?php
                                            $headers = [
                                                "header-standard logo-left" => "Header Standard Logo a sinistra",
                                                "header-standard logo-center" => "Header Standard Logo al centro",
                                                "header-standard logo-right" => "Header Standard Logo a destra",

                                                "header-hamburger logo-left" => "Header Hamburger Logo a sinistra",
                                                "header-hamburger logo-center" => "Header Hamburger Logo al centro",
                                                "header-hamburger logo-right" => "Header Hamburger Logo a destra",
                                            ]
                                            ?>
                                            <select class="form-control" name="header" required>
                                                @foreach($headers as $k=>$v)
                                                    <option value="{{ $k }}" @if($template->header == $k) selected @endif>{{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    @if(backpack_user()->roles[0]->id == 1)
                                        @if($template->name != $tema)
                                            <button class="btn btn-block btn-warning">Imposta</button>
                                        @else
                                            <button class="btn btn-block btn-secondary">In uso</button>
                                        @endif
                                    @endif
                                </form>
                            </div>

                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('after_scripts')

@endsection

