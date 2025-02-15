<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>

<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h3>{{ @$labels['shop-myarea-dati-fatturazione'] }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="bi bi-chevron-left d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['shop-myarea-dati-fatturazione'] }}</li>
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
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-3">
                        <a class="card bg-light h-100" href="{{ route('myarea.company') }}">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <span class="my-2"><i class="fas fa-plus fa-2x"></i></span>
                                <h6>{{ @$labels['shop-myarea-aggiungi-dati-fatt'] }}</h6>
                            </div>
                        </a>
                    </div>

                    @if(count($companies))
                        @foreach($companies as $company)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card line-height-md h-100">
                                    <div class="card-body text-capitalize">
                                        <h5>{{ @$company->name }}</h5>
                                        {{ @$company->address1 }}<br>
                                        {{ @$company->city }} ({{ @$company->county }})<br>
                                        <strong>{{ @$company->country->name }}</strong>
                                    </div>
                                    @if($company->fiscal_code_vat)
                                        <div class="card-footer text-capitalize bg-transparent">
                                            <div class="small text-muted">{{ @$labels['shop-myarea-piva'] }}</div>
                                            <div class="address-card__row-content">{{ $company->fiscal_code_vat }}</div>
                                        </div>
                                    @endif
                                    @if($company->fiscal_code)
                                        <div class="card-footer text-capitalize bg-transparent">
                                            <div class="small text-muted">{{ @$labels['shop-myarea-fiscalcode'] }}</div>
                                            <div class="address-card__row-content">{{ $company->fiscal_code }}</div>
                                        </div>
                                    @endif
                                    @if($company->pec)
                                        <div class="card-footer text-capitalize bg-transparent">
                                            <div class="small text-muted">{{ @$labels['shop-checkout-pec'] }}</div>
                                            <div class="address-card__row-content">{{ $company->pec }}</div>
                                        </div>
                                    @endif
                                    @if($company->sdi)
                                        <div class="card-footer text-capitalize bg-transparent">
                                            <div class="small text-muted">{{ @$labels['shop-checkout-sdi'] }}</div>
                                            <div class="address-card__row-content">{{ $company->sdi }}</div>
                                        </div>
                                    @endif

                                    <div class="card-footer">
                                        <a class="btn btn-primary btn-sm w-100" href="{{ route('myarea.company', $company->id) }}"><i class="ti-pencil"></i> {{ @$labels['shop-myarea-modifica'] }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>

    </div>
</section>
