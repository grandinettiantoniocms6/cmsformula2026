<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
<main>

    <section class="section-page-header bg-light py-4 border-bottom">
        <div class="container">
            <h2 class="h3">{{ @$labels['shop-myarea-wishlist-miei-preferiti'] }}</h2>
            <nav>
                <ol class="breadcrumb bg-transparent p-0 my-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-angle-left mr-2 d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                    <li class="breadcrumb-item d-none d-md-block active" aria-current="page">{{ @$labels['shop-wishlist-miei-preferiti'] }}</li>
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

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="my-0">{{ @$labels['shop-myarea-wishlist-miei-preferiti'] }}</h5>
                        </div>
                        <div class="card-table">
                            @if(count($products))
                                <div class="m-1 m-md-0">
                                    <table class="table table-fluid my-0">
                                        <thead>
                                        <tr>
                                            <th>{{ @$labels['shop-carrello-prodotto'] }}</th>
                                            <th>{{ @$labels['shop-partials-prezzo'] }}</th>
                                            <th width="150"></th>
                                            <th width="50"></th>
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
                                                <td class="align-middle" data-column="Prodotto" data-fluid="100">
                                                    <a class="wishlist__product-name mr-3" href="{{ $url_product }}">{{ $product->name }}</a>
                                                    @if($product->stock > 0)
                                                        <div class="d-block"><div class="badge badge-success">{{ @$labels['shop-wishlist-disponibile'] }}</div></div>
                                                    @else
                                                        <div class="d-block"><div class="badge badge-danger">{{ @$labels['shop-wishlist-non-disponibile'] }}</div></div>
                                                    @endif
                                                </td>
                                                <td class="align-middle" data-column="Prezzo" data-fluid="100">€ {{ number_format($finalPrice,2, ',','.') }}</td>
                                                <td class="align-middle" data-column="Rimuovi dai Preferiti" data-fluid="100">
                                                    <a href="{{ route('index') }}/myarea/remove-wishlist-list?id={{ $wishlist->product_id }}" class="btn btn-light btn-sm"><i class="fas fa-times"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="py-4 text-center my-0">
                                    <div class="display-4 text-muted"><i class="fab fa-creative-commons-nc-eu"></i></div>
                                    <h5 class="mb-4">{{ @$labels['shop-wishlist-no-prodotti'] }}</h5>
                                    <a class="btn btn-primary btn-sm" href="{{ route('index') }}">{{ @$labels['shop-continua-acquisti'] }}</a>
                                </div>
                            @endif
                        </div>
                    </div>

                </main>
            </div>

        </div>
    </section>

</main>
