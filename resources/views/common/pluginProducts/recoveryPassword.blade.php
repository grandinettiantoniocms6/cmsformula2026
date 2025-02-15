<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
<main>
    <section class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body p-md-5">
                            <h4 class="text-center mb-1">{{ @$labels['shop-recupera-psw'] }}</h4>
                            <p class="text-center my-4">{{ @$labels['shop-recupera-psw-msg-1'] }}</p>

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
                                    <label for="email">{{ @$labels['shop-recupera-psw-email'] }}</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                </div>

                                <div class="form-group my-0">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-recupera-psw-recupera-password'] }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="card card-body py-5 h-100">
                        @if($shopSetting->is_registration_open == 1)
                        <h4 class="text-center mb-1">{{ @$labels['shop-recupera-psw-nuovo-cliente'] }}</h4>
                        <a href="{{ url('/registrati') }}" class="btn btn-primary btn-block btn-lg mt-3">{{ @$labels['shop-recupera-psw-registrati'] }}</a>

                        <hr class="my-auto">
                        @endif

                        <h4 class="text-center mb-1">{{ @$labels['shop-recupera-psw-gia-registrato'] }}</h4>
                        <a href="{{ url('/login') }}" class="btn btn-primary btn-block btn-lg mt-3">{{ @$labels['shop-recupera-psw-accedi'] }}</a>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>
