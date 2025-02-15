<div class="modal" role="dialog" id="modalProductView">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModalView({{ $itemProduct->id }})"></button>
            </div>
            <div class="modal-body">
                <div class="single-product row py-0">
                    @include("$thema.plugins.pluginProducts.v3.shop.type_detail_photo_modal_view")
                    <div class="col-md-7">
                        <div class="product-details">
                            <div class="product-meta">
                                <div class="row">
                                    @foreach($vet_ids as $product_id)
                                        <?php
                                        $tempProduct = \App\Models\PluginProducts::where("id", $product_id)->first();
                                        if(!$tempProduct){
                                            continue;
                                        }

                                        if(env("PROJECT_NAME") == "Maison-Flaneur"){
                                            $cover = $tempProduct->getLastPhoto();
                                        }else{
                                            $cover = $tempProduct->getCover();
                                        }

                                        $cat_prod_name = "";
                                        $cat_prod_slug = "no-categoria";

                                        $cat_prod = $tempProduct->category();
                                        if($cat_prod){
                                            $cat_prod_name = $cat_prod->name;
                                            $cat_prod_slug = $cat_prod->slug;
                                        }

                                        $url = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug, $tempProduct->slug])
                                        ?>

                                        <div class="col-3 text-center">
                                            <a class="color color-img" href="{{ $url }}" data-bs-toggle="tooltip" title="{{ $tempProduct->code_article }} {{ $tempProduct->name_variant }}">
                                                @if(env('local') == 1)
                                                    <img loading="lazy" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $tempProduct->name_variant }}" width="35" height="35">
                                                @else
                                                     <img loading="lazy" src="{{ $cover }}" alt="{{ $tempProduct->name_variant }}" width="35" height="35">
                                                @endif

                                                <?php
                                                $symbol = "&euro;";
                                                $start_price = $tempProduct->price;
                                                if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                                                    if($tempProduct->price_dollar){
                                                        $symbol = "&#36;";
                                                        $start_price = $tempProduct->price_dollar;
                                                    }
                                                }

                                                if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                                                    if($tempProduct->price_2){
                                                        $symbol = "&euro;";
                                                        $start_price = $tempProduct->price_2;
                                                    }
                                                }
                                                $promo_price = $tempProduct->get_promo_price();

                                                $vat = $tempProduct->tax ? $tempProduct->tax->value : 22;
                                                $vat_calculate = ($vat / 100) + 1;

                                                $p_temp = $tempProduct;
                                                ?>
                                                @include("$thema.plugins.pluginProducts.v3.shop.calculate_price")
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
