<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>

<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h3>{{ @$labels['shop-myarea-wishlist-miei-preferiti'] }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="bi bi-chevron-left d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['shop-wishlist-miei-preferiti'] }}</li>
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
                <div class="card card-myarea">
                    <div class="card-header">
                        <h5>{{ @$labels['shop-myarea-wishlist-miei-preferiti'] }}</h5>
                    </div>
                    <div class="card-body">
                        @if(count($products))
                            <table class="table table-fluid">
                                    <thead>
                                    <tr>
                                        <th>{{ @$labels['shop-carrello-prodotto'] }}</th>
                                        <th>{{ @$labels['shop-partials-prezzo'] }}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $wishlist)
                                        @php
                                            $product = \App\Models\PluginProducts::find($wishlist->product_id);
                                            if(!$product){
                                                continue;
                                            }
                                            $finalPrice = $product->getFinalPrice();

                                            $cat_prod_name = "";
                                            $cat_prod_slug = "no-categoria";
                                            $cat_prod = $product->category();
                                            if($cat_prod){
                                                $cat_prod_name = $cat_prod->name;
                                                $cat_prod_slug = $cat_prod->slug;
                                            }

                                            $url_product = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]);
                                            $cover = $product->getCover();
                                        @endphp

                                        <tr>
                                            <td data-column="Prodotto">
                                                <a class="wishlist__product-name mr-3" href="{{ $url_product }}">{{ $product->name }}</a>
                                                @if($product->stock > 0)
                                                    <div class="d-block"><div class="badge badge-success">{{ @$labels['shop-wishlist-disponibile'] }}</div></div>
                                                @else
                                                    <div class="d-block"><div class="badge badge-danger">{{ @$labels['shop-wishlist-non-disponibile'] }}</div></div>
                                                @endif
                                            </td>
                                            <td data-column="Prezzo">€ {{ number_format($finalPrice,2, ',','.') }}</td>
                                            <td data-column="Rimuovi dai Preferiti">
                                                <a href="{{ route('index') }}/myarea/remove-wishlist-list?id={{ $wishlist->product_id }}" class="btn btn-light"><i class="fas fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                        @else
                            <div class="py-4 text-center">
                                <div class="display-4 text-muted"><i class="fas fa-heart"></i></div>
                                <h5 class="mb-4">{{ @$labels['shop-wishlist-no-prodotti'] }}</h5>
                                <a class="btn btn-primary" href="{{ route('index') }}">{{ @$labels['shop-continua-acquisti'] }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
