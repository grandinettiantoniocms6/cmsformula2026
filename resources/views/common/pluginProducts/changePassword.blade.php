<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
<main>

    <section class="py-4">
        <div class="container">

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-body p-md-5">
                            <h4 class="text-center mb-1">{{ @$labels['shop-imposta-nuova-password'] }}</h4>
                            <h6 class="text-center mb-4">{{ @$labels['shop-gia-registrato'] }} <a href="{{ url('/login') }}">{{ @$labels['shop-login'] }}</a></h6>

                            @if ($errors->any())
                                <div class="alert alert-danger text-center alert-fixed-bottom-xs">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span class="fa fa-times"></span>
                                    </button>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }} <br>
                                    @endforeach
                                </div>
                            @endif

                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    <div class="display-4"><i class="fa fa-check"></i></div>
                                    <h5>{{ session()->get('message') }}</h5>
                                </div>
                            @endif

                            <form id="changepwr-form" class="form-validate" method="post" action="{{ route('index.changePasswordProcess') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="code" value="{{ $code }}">

                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-nuova-password'] }}</label>
                                    <input type="password" class=" form-control" id="password1" name="password" minlength="8" data-rule-nowhitespace="true">
                                </div>

                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-conferma-nuova-password'] }}</label>
                                    <input type="password" class=" form-control" id="password2" name="password_confirmation" minlength="8" data-rule-nowhitespace="true">
                                </div>

                                <div class="form-group my-0">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-modifica-password'] }}</button>
                                </div> <!-- form-group// -->
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>
