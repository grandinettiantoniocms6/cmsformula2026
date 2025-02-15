<?php
$shopSetting = \App\Models\ShopSettings::first();
$labels = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>
<section class="page-recovery">
    <div class="container-fluid container-2xl">
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-recovery">
                    <div class="p-4 p-md-5">
                        <h4 class="text-center mb-1">{{ @$labels['recoveryPassword-recupera-psw'] }}</h4>
                        <p class="text-center font-sm font-lg-md my-4">{{ @$labels['recoveryPassword-recupera-psw-msg-1'] }}</p>

                        @if ($errors->any())
                            <div class="alert alert-danger text-center">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        @if(session()->has('message'))
                            <div class="alert alert-success text-center">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        @if(session()->has('noUser'))
                            <div class="alert alert-danger text-center">
                                {{ session()->get('noUser') }}
                            </div>
                        @endif

                        <form id="recovery-form" class="form-validate" role="form" method="POST" action="{{ route("index.recoveryProcess") }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="email" class="form-label">{{ @$labels['recoveryPassword-recupera-psw-email'] }}</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100 btn-lg" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['recoveryPassword-recupera-psw-recupera-password'] }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block">
                <div class="card card-links">
                    @if($shopSetting->is_registration_open == 1)
                        <div class="card-body p-md-5">
                            <h4 class="text-center mb-1">{{ @$labels['recoveryPassword-recupera-psw-nuovo-cliente'] }}</h4>
                            <a href="{{ url('/registrati') }}" class="btn btn-primary w-100 mt-3">{{ @$labels['recoveryPassword-recupera-psw-registrati'] }}</a>
                        </div>
                    @endif
                    <div class="card-body p-md-5">
                        <h4 class="text-center mb-1">{{ @$labels['recoveryPassword-recupera-psw-gia-registrato'] }}</h4>
                        <a href="{{ url('/login') }}" class="btn btn-primary w-100 mt-3">{{ @$labels['recoveryPassword-recupera-psw-accedi'] }}</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
