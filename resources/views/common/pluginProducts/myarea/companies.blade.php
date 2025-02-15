<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>

<main>

    <section class="section-page-header bg-light py-4 border-bottom">
        <div class="container">
            <h2 class="h3">{{ @$labels['shop-myarea-dati-fatturazione'] }}</h2>
            <nav>
                <ol class="breadcrumb bg-transparent p-0 my-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-angle-left mr-2 d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                    <li class="breadcrumb-item d-none d-md-block active" aria-current="page">{{ @$labels['shop-myarea-dati-fatturazione'] }}</li>
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

                    <div class="row">
                        <div class="col-md-4 col-sm-6 mb-3">
                            <a class="card card-body bg-light h-100 align-items-center justify-content-center text-center" href="{{ route('myarea.company') }}">
                                <span class="my-3"><i class="fas fa-plus fa-2x"></i></span>
                                <h6>{{ @$labels['shop-myarea-aggiungi-dati-fatt'] }}</h6>
                            </a>
                        </div>

                        @if(count($companies))
                            @foreach($companies as $company)
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div class="card card-body h-100">
                                        <h5>{{ @$company->name }}</h5>
                                        <div class="d-block text-capitalize">
                                            {{ @$company->address1 }}<br>
                                            {{ @$company->city }} ({{ @$company->county }})<br>
                                            <strong>{{ @$company->country->name }}</strong>
                                        </div>
                                        @if($company->fiscal_code_vat)
                                            <hr class="my-2">
                                            <div class="d-block text-capitalize">
                                                <div class="small text-muted">{{ @$labels['shop-myarea-piva'] }}</div>
                                                <div class="address-card__row-content">{{ $company->fiscal_code_vat }}</div>
                                            </div>
                                        @endif
                                        @if($company->fiscal_code)
                                            <hr class="my-2">
                                            <div class="d-block text-capitalize">
                                                <div class="small text-muted">{{ @$labels['shop-myarea-fiscalcode'] }}</div>
                                                <div class="address-card__row-content">{{ $company->fiscal_code }}</div>
                                            </div>
                                        @endif
                                        @if($company->pec)
                                            <hr class="my-2">
                                            <div class="d-block">
                                                <div class="small text-muted">{{ @$labels['shop-checkout-pec'] }}</div>
                                                <div class="address-card__row-content">{{ $company->pec }}</div>
                                            </div>
                                        @endif
                                        @if($company->sdi)
                                            <hr class="my-2">
                                            <div class="d-block text-capitalize">
                                                <div class="small text-muted">{{ @$labels['shop-checkout-sdi'] }}</div>
                                                <div class="address-card__row-content">{{ $company->sdi }}</div>
                                            </div>
                                        @endif
                                        <a class="btn btn-outline-primary btn-sm btn-block mt-3" href="{{ route('myarea.company', $company->id) }}"><i class="ti-pencil"></i> {{ @$labels['shop-myarea-modifica'] }}</a>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>

                </main> <!-- col.// -->
            </div>

        </div>
    </section>

</main>
