<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>

<main>

    <section class="section-page-header bg-light py-4 border-bottom">
        <div class="container">
            <h2 class="h3">@if(!$company) {{ @$labels['shop-myarea-nuovi-dati-fatturazione'] }} @else {{ @$labels['shop-myarea-mod-dati-fatt'] }} @endif</h2>
            <nav>
                <ol class="breadcrumb bg-transparent p-0 my-0">
                    <li class="breadcrumb-item d-none d-md-block"><a href="{{ route('index') }}">{{ @$labels['shop-myarea-home'] }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('myarea.companies') }}"><i class="fa fa-angle-left mr-2 d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-dati-fatturazione'] }}</a></li>
                    <li class="breadcrumb-item d-none d-md-blockactive" aria-current="page">@if(!$company) {{ @$labels['shop-checkout-aggiungi-nuovo-indirizzo-fatt'] }} @else {{ @$labels['shop-myarea-mod-dati-fatt'] }} @endif</li>
                </ol>
            </nav>
        </div> <!-- container //  -->
    </section>

    <section class="py-4">
        <div class="container">

            <div class="row">
                <aside class="col-12 col-lg-3">
                    @include("common.pluginProducts.inc.myarea_menu")
                </aside> <!-- col.// -->
                <main class="col-12 col-lg-9 mt-4 mt-lg-0">

                    <form id="address-invoice-form" class="form-validate" action="{{ route('myarea.company_save') }}" method="post">
                        {{ csrf_field() }}

                        @if(!$company)
                            <input type="hidden" name="company_id" value="0">
                        @else
                            <input type="hidden" name="company_id" value="{{ $company->id }}">
                        @endif

                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="my-0">@if(!$company) {{ @$labels['shop-myarea-nuovi-dati-fatturazione'] }} @else {{ @$labels['shop-myarea-mod-dati-fatt'] }} @endif</h5>
                                <small class="text-muted">{{ @$labels['shop-myarea-campi-obbligatori'] }}</small>
                            </div>
                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger text-center alert-fixed-bottom-xs">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }} <br>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="name">{{ @$labels['shop-checkout-nominativo'] }}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ @$company->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">{{ @$labels['shop-checkout-ragione-sociale'] }}</label>
                                    <input type="text" class="form-control" id="business_name" name="business_name" value="{{ @$company->business_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-myarea-piva'] }}</label>
                                    <input type="text" class="form-control" id="fiscal_code_vat" name="fiscal_code_vat" value="{{ @$company->fiscal_code_vat }}">
                                </div>
                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-myarea-fiscalcode'] }}</label>
                                    <input type="text" class="form-control" id="fiscal_code" name="fiscal_code" value="{{ @$company->fiscalcode }}">
                                </div>

                                <hr>

                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-checkout-indirizzo'] }}</label>
                                    <input type="text" class="form-control" id="address1" name="address1" value="{{ @$company->address1 }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">{{ @$labels['shop-checkout-citta'] }}</label>
                                            <input type="text" class="form-control" id="city" name="city" value="{{ @$company->city }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="mobile">{{ @$labels['shop-checkout-provincia'] }}</label>
                                            <input type="text" class="form-control" id="county" name="county" value="{{ @$company->county }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="mobile">{{ @$labels['shop-checkout-cap'] }}</label>
                                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ @$company->postal_code }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-checkout-nazione'] }}</label>
                                    <select class="custom-select select2" name="country_id" required>
                                        @foreach($countries as $country)
                                            @if($country->id == @$company->country_id)
                                                <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                            @else
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <hr>

                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-checkout-pec'] }}</label>
                                    <input type="text" class="form-control" id="pec" name="pec" value="{{ @$company->pec }}">
                                </div>

                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-checkout-sdi'] }}</label>
                                    <input type="text" class="form-control" id="sdi" name="sdi" value="{{ @$company->sdi }}">
                                </div>

                            </div> <!-- card-body .// -->
                        </div> <!-- card.// -->

                        <div class="form-group mt-4">
                            <div class="row">
                                @if($company)
                                    <div class="col">
                                        <button type="button" onclick="delete_address()" class="btn btn-danger">{{ @$labels['shop-myarea-elimina-dati-fatt'] }} </button>
                                    </div>
                                @endif
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-primary btn-lg">@if(!$company) {{ @$labels['shop-myarea-salva-nuovi-dati-fatt'] }} @else {{ @$labels['shop-myarea-mod-dati-fatt'] }} @endif</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </main> <!-- col.// -->
            </div>

        </div>
    </section>

</main>
