@extends(backpack_view('blank'))

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Import</div>
                <div class="card-body">
                    <?php $url = route('pluginCaccia.import_save'); ?>
                    <form method="post" action="{{ $url }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="form-control" id="chooseFile">
                                <label class="custom-file-label" for="chooseFile">Scegli file</label>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-dark btn-block">Carica</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            bsCustomFileInput.init();
        });
    </script>
@endsection
