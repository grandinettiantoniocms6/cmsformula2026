@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => backpack_url('dashboard'),
        'SuperAdmin' => false,
    ];
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span>Gestione avvisi errori</span>
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-xl-6">
            @if($errors->any())
                <div class="alert alert-danger pb-0">
                    <ul class="list-unstyled">
                        @foreach($errors->all() as $error)
                            <li><i class="la la-info-circle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ backpack_url('superadmin/error-alerts') }}" class="card">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label for="error_alert_enabled_toggle">Abilita invio avvisi errore via email</label>
                        <div class="d-flex align-items-center" style="height:38px">
                            <label class="switch switch-lg switch-label switch-pill switch-success mb-0" for="error_alert_enabled_toggle">
                                <input
                                    type="hidden"
                                    name="error_alert_enabled"
                                    id="error_alert_enabled"
                                    value="{{ (int) old('error_alert_enabled', $errorAlertEnabled) === 1 ? 1 : 0 }}"
                                >
                                <input
                                    type="checkbox"
                                    id="error_alert_enabled_toggle"
                                    class="switch-input"
                                    onchange="document.getElementById('error_alert_enabled').value = this.checked ? 1 : 0"
                                    @if((int) old('error_alert_enabled', $errorAlertEnabled) === 1) checked @endif
                                >
                                <span class="switch-slider" data-checked="ON" data-unchecked="OFF"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="error_alert_email">Email</label>
                        <input
                            type="email"
                            name="error_alert_email"
                            id="error_alert_email"
                            class="form-control"
                            value="{{ old('error_alert_email', $errorAlertEmail) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="error_alert_cc">E-mail in copia</label>
                        <input
                            type="text"
                            name="error_alert_cc"
                            id="error_alert_cc"
                            class="form-control"
                            value="{{ old('error_alert_cc', $errorAlertCc) }}"
                            placeholder="email1@dominio.it, email2@dominio.it"
                        >
                    </div>

                    <div class="form-group mb-0">
                        <label for="error_alert_repeat_hours">Reinvio stesso errore dopo</label>
                        <div class="input-group">
                            <input
                                type="number"
                                name="error_alert_repeat_hours"
                                id="error_alert_repeat_hours"
                                class="form-control"
                                value="{{ old('error_alert_repeat_hours', $errorAlertRepeatHours) }}"
                                min="1"
                                step="1"
                                required
                            >
                            <div class="input-group-append">
                                <span class="input-group-text">ore</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" aria-hidden="true"></span> Salva
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
