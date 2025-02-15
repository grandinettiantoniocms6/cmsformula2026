
<div class="product-form product-color row justify-content-center px-3">
    <div class="owl-carousel1" data-loop="false" data-nav-arrow="true" data-items="3" data-md-items="3" data-sm-items="3" data-xs-items="2" data-xx-items="1" data-space="0" data-autoplay="false">
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

            <div class="product--variations d-flex flex-column align-items-center">
                <a class="color color-img" href="{{ $url }}" data-toggle="tooltip" title="{{ $tempProduct->code_article }} {{ $tempProduct->name_variant }}">
                    <img loading="lazy" src="{{ $cover }}" width="70" height="70">
                </a>
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
                        $symbol = "&#36;";
                        $start_price = $tempProduct->price_2;
                    }
                }

                $promo_price = $tempProduct->get_promo_price();

                $vat = $tempProduct->tax ? $tempProduct->tax->value : 22;
                $vat_calculate = ($vat / 100) + 1;

                $p_temp = $tempProduct;
                ?>
                @include('common.pluginProducts.shop.calculate_price')
            </div>
        @endforeach
    </div>
</div>
