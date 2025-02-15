@if(count($products))
    <div class="row" id="filters-bar">
        <div class="col-auto d-lg-none">
            <button class="btn btn-light btn-sm px-2 py-1" id="btn-filter" data-toggle="show" data-target="#sidebar-shop">
                <i class="fa fa-filter"></i><span class="pl-1">Filtri</span>
            </button>
        </div>
        <div class="col">
            <ul class="nav nav-pills justify-content-lg-start justify-content-end">
                <li class="nav-item">
                    <span class="nav-link cursor-pointer px-2 py-1 active" href="#" onclick="view(this, 'list')">
                        <i class="fa fa-bars"></i>
                        <span class="pl-1 d-none d-lg-inline">{{ @$labels['lista-pulsante'] }}</span>
                    </span>
                </li>
                <li class="nav-item">
                    <span class="nav-link cursor-pointer px-2 py-1" href="#" onclick="view(this, 'grid')">
                        <i class="fa fa-th-large"></i>
                        <span class="pl-1 d-none d-lg-inline">{{ @$labels['lista-griglia'] }}</span>
                    </span>
                </li>
            </ul>
        </div>
        <div class="col-12 my-2 d-lg-none"></div>
        <div class="col col-lg-auto d-flex align-items-center">
            <span class="px-2 small text-nowrap">Ordina per</span>
            <select class="custom-select custom-select-sm my-0">
                <option>Prezzo</option>
                <option>Titolo</option>
            </select>
        </div>
        <div class="col-auto d-flex align-items-center">
            <span class="px-2 small text-nowrap">Mostra</span>
            <select class="custom-select custom-select-sm my-0">
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select>
        </div>
    </div>
    <div class="list my-4">
        <div class="row">
            @foreach($products as $product)

                <div class="product listing list-view col-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 product-image-col">
                            <div class="product-image">
                                <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$product->category->slug,$product->slug]) }}">
                                    @if($product->cover)
                                        <img class="img-fluid mx-auto" src="{{ $product->cover }}" alt="">
                                    @else
                                        <img class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="">
                                    @endif
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 product-des-col">
                            <div class="product-des text-left">
                                <div class="product-title">
                                    @if($product->is_evidenza == 1) IN EVIDENZA @endif
                                    <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$product->category->slug,$product->slug]) }}">{{ $product->name }}</a>
                                </div>
                                @if($plugin->show_prices && $product->price !== null && trim($product->price) != "")
                                    <div class="product-price">
                                        @if($product->in_promo == 1)
                                            @if($product->promo_price < $product->price)
                                                <ins>&euro; {{ number_format($product->promo_price, 2, ",", ".") }}</ins>
                                                <del class="badge badge-primary badge-size-normal badge-weight-normal">&euro; {{ number_format($product->price, 2, ",", ".") }}</del>
                                            @else
                                                <ins>&euro; {{ number_format($product->price, 2, ",", ".") }}</ins>
                                            @endif
                                        @else
                                            <ins>&euro; {{ number_format($product->price, 2, ",", ".") }}</ins>
                                        @endif
                                    </div>
                                @endif
                                <div class="product-info">
                                    <p class="mt-20">{{ $product->description_short }}</p>
                                    <a class="button small mt-20" href="{{ route("pluginProducts.detail.".\App::getLocale(), [$product->category->slug,$product->slug]) }}">{{ @$labels['dettaglio-prodotto'] }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider mt-30 mb-3 col-12"></div>
            @endforeach
        </div>
        {{ $products->links() }}
    </div>
@else
    {!! $plugin->no_results !!}
@endif
