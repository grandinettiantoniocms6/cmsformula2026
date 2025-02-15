<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>

<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h3>@if(!$company) {{ @$labels['shop-myarea-nuovi-dati-fatturazione'] }} @else {{ @$labels['shop-myarea-mod-dati-fatt'] }} @endif</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('myarea.companies') }}"><i class="bi bi-chevron-left d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-dati-fatturazione'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">@if(!$company) {{ @$labels['shop-checkout-aggiungi-nuovo-indirizzo-fatt'] }} @else {{ @$labels['shop-myarea-mod-dati-fatt'] }} @endif</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-4">
    <div class="container">

        <div class="row">
            <aside class="col-12 col-xl-3">
                @include("$thema.inc.myarea_menu")
            </aside>
            <div class="col-12 col-xl-9">

                <form id="address-invoice-form" class="form-validate" action="{{ route('myarea.company_save') }}" method="post">
                    {{ csrf_field() }}

                    @if(!$company)
                        <input type="hidden" name="company_id" value="0">
                    @else
                        <input type="hidden" name="company_id" value="{{ $company->id }}">
                    @endif

                    <div class="card card-myarea">
                        <div class="card-header">
                            <h5>@if(!$company) {{ @$labels['shop-myarea-nuovi-dati-fatturazione'] }} @else {{ @$labels['shop-myarea-mod-dati-fatt'] }} @endif</h5>
                            <div>{{ @$labels['shop-myarea-campi-obbligatori'] }}</div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger text-center">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="form-label font-sm">{{ @$labels['shop-checkout-nominativo'] }}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ @$company->name }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label font-sm">{{ @$labels['shop-checkout-ragione-sociale'] }}</label>
                                <input type="text" class="form-control" id="business_name" name="business_name" value="{{ @$company->business_name }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label font-sm">{{ @$labels['shop-myarea-piva'] }}</label>
                                <input type="text" class="form-control" id="fiscal_code_vat" name="fiscal_code_vat" value="{{ @$company->fiscal_code_vat }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label font-sm">{{ @$labels['shop-myarea-fiscalcode'] }}</label>
                                <input type="text" class="form-control" id="fiscal_code" name="fiscal_code" value="{{ @$company->fiscal_code }}">
                            </div>
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="form-group">
                                <label class="form-label font-sm">{{ @$labels['shop-checkout-indirizzo'] }}</label>
                                <input type="text" class="form-control" id="address1" name="address1" value="{{ @$company->address1 }}" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label font-sm">{{ @$labels['shop-checkout-citta'] }}</label>
                                        <input type="text" class="form-control" id="city" name="city" value="{{ @$company->city }}" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label font-sm">{{ @$labels['shop-checkout-provincia'] }}</label>
                                        <input type="text" class="form-control" id="county" name="county" value="{{ @$company->county }}" required>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label font-sm">{{ @$labels['shop-checkout-cap'] }}</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ @$company->postal_code }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mobile">{{ @$labels['shop-checkout-nazione'] }}</label>
                                <select class="form-select" name="country_id" required>
                                    @foreach($countries as $country)
                                        @if($country->id == @$company->country_id)
                                            <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                        @else
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="form-group">
                                <label class="form-label font-sm">{{ @$labels['shop-checkout-pec'] }}</label>
                                <input type="text" class="form-control" id="pec" name="pec" value="{{ @$company->pec }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label font-sm">{{ @$labels['shop-checkout-sdi'] }}</label>
                                <input type="text" class="form-control" id="sdi" name="sdi" value="{{ @$company->sdi }}">
                            </div>
                        </div>
                    </div>
                    <div class="row gx-2 justify-content-end">
                        <div class="col"></div>
                        @if($company)
                            <div class="col-sm-auto my-1">
                                <button type="button" onclick="delete_address()" class="btn btn-danger w-100">{{ @$labels['shop-myarea-elimina-dati-fatt'] }} </button>
                            </div>
                        @endif
                        <div class="col-sm-auto my-1">
                            <button type="submit" class="btn btn-primary w-100">@if(!$company) {{ @$labels['shop-myarea-salva-nuovi-dati-fatt'] }} @else {{ @$labels['shop-myarea-mod-dati-fatt'] }} @endif</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
