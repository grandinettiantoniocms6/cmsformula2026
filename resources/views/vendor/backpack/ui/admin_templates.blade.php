@extends(backpack_view('blank'))

@section('header')
    <h3 class="page-title mb-0">
        <span class="text-capitalize">Template</span>
    </h3>
@endsection

@section('content')

    <div class="row">
        <?php
        $templates = \App\Models\AdminTemplate::get();
        $tema = env("TEMA");
        ?>
        @if($templates)
            @foreach($templates as $template)
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header font-weight-bold">{{ $template->name }}</div>
                        <img class="img-fluid" src="{{ url($template->image_name) }}">
                        <div class="card-body">
                            <p>{{ $template->description }}</p>
                            <h5 class="font-weight-bold mb-3">{{ number_format($template->price, 2, ",", ".") }} &euro;</h5>
                            <a href="{{ $template->url }}" class="btn btn-block btn-dark" target="_blank">Vedi anteprima</a>
                        </div>
                        <div class="card-footer">
                            <form method="post" action="{{ route('changeTemplate') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{ $template->id }}">
                                <input type="hidden" name="template" value="{{ $template->name }}">

                                @if($template->name == "Crafto")
                                    <div class="row gutters-pages">
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="font-weight-semi-bold">Nav Style</label>
                                                <input type="text" class="form-control" name="nav_style" value="{{ $template->nav_style }}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="font-weight-semi-bold">Inc</label>
                                                <input type="text" class="form-control" name="inc" value="{{ $template->inc }}">
                                            </div>
                                        </div>
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
                                        <select class="custom-select" name="header" required>
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
                    </div>
                </div>
            @endforeach
        @endif
    </div>

@endsection

@section('after_scripts')

@endsection

