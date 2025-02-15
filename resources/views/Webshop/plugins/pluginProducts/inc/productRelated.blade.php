@if($plugin->show_related_products == 1)
    @if(count($itemProduct->related))

        <div class="col-lg-12 col-md-12">
            <div class="title mt-30 mb-30">
                <h6>{{ $labels['accessori'] }}</h6>
            </div>
            @if(count($itemProduct->related) > 3)
                <div class="owl-carousel" data-nav-dots="false" data-nav-arrow="true" data-items="3" data-sm-items="2" data-lg-items="3" data-md-items="3" data-xs-items="2" data-autoplay="false">
                @foreach($itemProduct->related as $related)
                    @if($related->product)
                        <div class="item">
                            <div class="product">
                                <div class="product-image">
                                    <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [ $related->product->category->slug, $related->product->slug]) }}">
                                        @if($related->product->cover)
                                            <img class="img-fluid mx-auto" src="{{ $related->product->cover }}" alt="{{ $related->product->name }}">
                                        @else
                                            <img class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $related->product->name }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="product-des">
                                    <div class="product-title">
                                        <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [ $related->product->category->slug, $related->product->slug]) }}">{{ $related->product->name }}</a>
                                    </div>
                                    @if($plugin->show_prices && $related->product->price !== null && trim($related->product->price) != "")
                                        <div class="product-price">
                                            @if($related->product->in_promo == 1)
                                                @if($related->product->promo_price < $related->product->price)
                                                    <ins>&euro; {{ number_format($related->product->promo_price, 2, ",", ".") }}</ins>
                                                    <del>&euro; {{ number_format($related->product->price, 2, ",", ".") }}</del>
                                                @else
                                                    <ins>&euro; {{ number_format($related->product->price, 2, ",", ".") }}</ins>
                                                @endif
                                            @else
                                                <ins>&euro; {{ number_format($related->product->price, 2, ",", ".") }}</ins>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
             </div>
            @else
                <div class="row">
                    @foreach($itemProduct->related as $related)
                        @if($related->product)
                            <div class="item col-4">
                                <div class="product">
                                    <div class="product-image">
                                        <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [ $related->product->category->slug, $related->product->slug]) }}">
                                            @if($related->product->cover)
                                                <img class="img-fluid mx-auto" src="{{ $related->product->cover }}" alt="{{ $related->product->name }}">
                                            @else
                                                <img class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $related->product->name }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="product-des">
                                        <div class="product-title">
                                            <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [ $related->product->category->slug, $related->product->slug]) }}">{{ $related->product->name }}</a>
                                        </div>
                                        @if($plugin->show_prices && $related->product->price !== null && trim($related->product->price) != "")
                                            <div class="product-price">
                                                @if($related->product->in_promo == 1)
                                                    @if($related->product->promo_price < $related->product->price)
                                                        <ins>&euro; {{ number_format($related->product->promo_price, 2, ",", ".") }}</ins>
                                                        <del>&euro; {{ number_format($related->product->price, 2, ",", ".") }}</del>
                                                    @else
                                                        <ins>&euro; {{ number_format($related->product->price, 2, ",", ".") }}</ins>
                                                    @endif
                                                @else
                                                    <ins>&euro; {{ number_format($related->product->price, 2, ",", ".") }}</ins>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    @endif
@endif
