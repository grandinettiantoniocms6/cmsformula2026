<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>

<main>

    <section class="section-page-header bg-light py-4 border-bottom">
        <div class="container">
            <h2 class="h3">{{ @$labels['shop-myarea-indirizzi'] }}</h2>
            <nav>
                <ol class="breadcrumb bg-transparent p-0 my-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-angle-left mr-2 d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                    <li class="breadcrumb-item d-none d-md-block active" aria-current="page">{{ @$labels['shop-myarea-indirizzi'] }}</li>
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
                            <a class="card card-body bg-light h-100 align-items-center justify-content-center text-center" href="{{ route('myarea.address') }}">
                                <span class="my-3"><i class="fas fa-plus fa-2x"></i></span>
                                <h6>{{ @$labels['shop-myarea-aggiungi-ind-sped'] }}</h6>
                            </a>
                        </div>

                        @if(count($addresses))
                            @foreach($addresses as $address)
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div class="card card-body h-100">
                                        <h5>{{ @$address->name }}</h5>
                                        <div class="d-block text-capitalize">
                                            {{ @$address->address1 }}<br>
                                            {{ @$address->postal_code }}, {{ @$address->city }} ({{ @$address->county }})<br>
                                            <strong>{{ @$address->country->name }}</strong>
                                        </div>
                                        <a class="btn btn-outline-primary btn-sm btn-block mt-3" href="{{ route('myarea.address', $address->id) }}"><i class="ti-pencil"></i> {{ @$labels['shop-myarea-modifica'] }}</a>
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
