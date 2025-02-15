<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>

<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h3>{{ @$labels['shop-myarea-indirizzi'] }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="bi bi-chevron-left d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['shop-myarea-indirizzi'] }}</li>
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
                        <a class="card bg-light h-100" href="{{ route('myarea.address') }}">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <span class="my-2"><i class="fas fa-plus fa-2x"></i></span>
                                <h6>{{ @$labels['shop-myarea-aggiungi-ind-sped'] }}</h6>
                            </div>
                        </a>
                    </div>

                    @if(count($addresses))
                        @foreach($addresses as $address)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body text-capitalize line-height-md">
                                        <h5>{{ @$address->name }}</h5>
                                        {{ @$address->address1 }}<br>
                                        {{ @$address->postal_code }}, {{ @$address->city }} ({{ @$address->county }})<br>
                                        <strong>{{ @$address->country->name }}</strong>
                                    </div>
                                    <div class="card-footer">
                                        <a class="btn btn-primary btn-sm w-100" href="{{ route('myarea.address', $address->id) }}"><i class="ti-pencil"></i> {{ @$labels['shop-myarea-modifica'] }}</a>
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
