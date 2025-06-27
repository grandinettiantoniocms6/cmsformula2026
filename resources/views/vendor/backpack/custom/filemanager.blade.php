@extends(backpack_view('blank'))

@section('header')
    <section class="content-header">
        <h1>
            File Manager
            <small>Gestisci i tuoi file</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">Dashboard</a></li>
            <li class="active">File Manager</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="card">
        <div class="card-body" style="height: calc(100vh - 200px);">
            <iframe src="{{ url('laravel-filemanager?type=image') }}"
                    style="border: none; width: 100%; height: 100%;"
                    allowfullscreen></iframe>
        </div>
    </div>
@endsection
