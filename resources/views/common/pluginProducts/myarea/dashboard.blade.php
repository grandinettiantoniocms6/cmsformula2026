<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>

<main>

    <section class="section-page-header bg-light py-4 border-bottom">
        <div class="container">
            <h2 class="h3">{{ @$labels['shop-myarea-mio-account'] }}</h2>
            <nav>
                <ol class="breadcrumb bg-transparent p-0 my-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-angle-left mr-2 d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                    <li class="breadcrumb-item d-none d-md-block active" aria-current="page">{{ @$labels['shop-myarea-mio-account'] }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="py-4">
        <div class="container">

            <div class="row">
                <aside class="col-12 col-lg-3">
                   @include("common.pluginProducts.inc.myarea_menu")
                </aside> <!-- col.// -->
                <main class="col-12 col-lg-9 mt-4 mt-lg-0">
                    @if ($errors->any())
                        <div class="alert alert-danger text-center">
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br>
                            @endforeach
                        </div>
                    @endif
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <form id="profile-form" class="form-validate" action="{{ route('myarea.profileProcess') }}" method="post">
                        {{ csrf_field() }}
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="my-0">{{ @$labels['shop-myarea-info-account'] }}</h5>
                                <small class="text-muted">{{ @$labels['shop-myarea-campi-obbligatori'] }}</small>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name">{{ @$labels['shop-myarea-nome-azienda'] }}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ @$labels['shop-myarea-email'] }}</label>
                                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" name="email" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-checkout-telefono'] }}</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $user->mobile }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-myarea-nazionalita'] }}</label>
                                    <select class="form-control" name="country_id">
                                        <option value="">{{ @$labels['shop-myarea-non-specificato'] }}</option>
                                        @foreach($countries as $country)
                                            @if($country->id == @$user->country_id)
                                                <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                            @else
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <p class="small">{{ @$labels['shop-registrati-info-4'] }}</p>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="check_newsletter" name="check_newsletter" value="1" @if(@$user->check_newsletter == 1) checked @endif>
                                        <label class="custom-control-label" for="check_newsletter">{{ @$labels['shop-registrati-newsletter'] }}</label>
                                    </div>
                                </div>

                            </div> <!-- card-body .// -->
                        </div> <!-- card.// -->

                        <!--<div class="card mb-3">
                            <div class="card-header">
                                <h5 class="my-0">Informazioni Azienda</h5>
                                <small class="text-muted">* Campi con asterisco sono obbligatori</small>
                            </div>

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="mobile">Nome azienda</label>
                                    <input type="text" class="form-control" id="business_name" name="business_name" value="{{ $user->business_name }}">
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Partita Iva</label>
                                    <input type="text" class="form-control" id="vat" name="vat" value="{{ $user->vat }}">
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Email PEC</label>
                                    <input type="text" class="form-control" id="pec" name="pec" value="{{ $user->pec }}">
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Codice SDI</label>
                                    <input type="text" class="form-control" id="sdi" name="sdi" value="{{ $user->sdi }}">
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Indirizzo Fatturazione</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->address_invoice }}">
                                </div>

                            </div>
                        </div> -->

                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="my-0">{{ @$labels['shop-myarea-accessi'] }}</h5>
                                <small class="text-muted">{{ @$labels['shop-myarea-campi-obbligatori'] }}</small>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="old_password">{{ @$labels['shop-myarea-vecchia-password'] }}</label>
                                    <input type="password" id="old_password" name="old_password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="password">{{ @$labels['shop-myarea-nuova-password'] }}</label>
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">{{ @$labels['shop-conferma-nuova-password'] }}</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" data-rule-equalto="#password">
                                </div>

                            </div>
                        </div> <!-- card.// -->

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">{{ @$labels['shop-myarea-modifica-dati'] }}</button>
                        </div>
                    </form>

                </main> <!-- col.// -->
            </div>

        </div>
    </section>

</main>
