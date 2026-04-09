@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
@endphp

@section('header')
    <div class="admin-templates-header-shell">
        <h3 class="page-title mb-0">
            <span class="text-capitalize">Template</span>
        </h3>
    </div>
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
                    <div class="card admin-template-card">
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

@push('after_styles')
    @if($isModernAdminTemplate)
    <style>
        .admin-templates-header-shell {
            background: linear-gradient(125deg, #ffffff 0%, #f2f6ff 100%);
            border: 1px solid #dae5fb;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 14px;
            box-shadow: 0 8px 22px rgba(23, 43, 81, 0.08);
        }

        .admin-templates-header-shell .page-title {
            color: #182f59;
            font-weight: 700;
        }

        .admin-template-card {
            border: 1px solid #dfe7f6;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 22px rgba(19, 38, 75, 0.08);
            margin-bottom: 18px;
        }

        .admin-template-card .card-header {
            background: #f5f8ff;
            color: #233e6f;
            font-weight: 700;
            border-bottom: 1px solid #e0e8f7;
        }

        .admin-template-card .card-body p {
            color: #42557e;
        }

        .admin-template-card .card-footer {
            background: #fbfcff;
            border-top: 1px solid #e6ecf8;
        }

        .admin-template-card .btn {
            border-radius: 9px;
            font-weight: 700;
        }

        .admin-template-card .form-control,
        .admin-template-card .custom-select {
            border-radius: 8px;
            border-color: #d5def0;
        }
    </style>
    @endif
@endpush

