<?xml version="1.0" encoding="UTF-8" ?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title><![CDATA[Shop {{ env('PROJECT_NAME') }}]]></title>
        <link><![CDATA[{{ env('APP_URL') }}]]></link>
        <description>WooCommerce Product List RSS feed</description>
        <metadata>
            <ref_application_id>451257172939091</ref_application_id>
        </metadata>

        <item>
            <g:id>742</g:id>
            <g:inventory>5</g:inventory>
            <g:description><![CDATA[ Lo schienale è composto internamente da poliestere ad alto flusso d’aria, mentre all’esterno è rivestito con poliestere a nido d’ape. Questa combinazione di materiali permette la dissipazione del calore corporeo e la fuoriuscita di liquidi senza lasciare la sensazione di bagnato.   I cuscini Palintech sono anti odore, antibatterici, antimicotici.     ]]></g:description>
            <g:condition>new</g:condition>
            <g:mpn>742</g:mpn>
            <g:title>Schienale per sedia a rotelle</g:title>
            <g:short_description><![CDATA[ Lo schienale è composto internamente da poliestere ad alto flusso d’aria, mentre all’esterno è rivestito con poliestere a nido d’ape. Questa combinazione di materiali permette la dissipazione del calore corporeo e la fuoriuscita di liquidi senza lasciare la sensazione di bagnato.   I cuscini Palintech sono anti odore, antibatterici, antimicotici.     ]]></g:short_description>
            <g:availability>in stock</g:availability>
            <g:price>159.00 EUR</g:price>
            <g:link><![CDATA[https://shop.palintech.it/prodotto/schienale-per-sedia-a-rotelle-nero/]]></g:link>
            <g:image_link><![CDATA[https://shop.palintech.it/wp-content/uploads/2021/05/MED030.png]]></g:image_link>
            <g:item_group_id>742</g:item_group_id>
            <g:custom_label_0>recent-product</g:custom_label_0>
            <g:custom_label_1>manutenzione</g:custom_label_1>
            <g:product_type>Plus Ability &gt; Schienali per sedia a rotelle</g:product_type>
            <g:additional_image_link><![CDATA[https://shop.palintech.it/wp-content/uploads/2021/05/Palintech_cuscini_0002.jpg]]></g:additional_image_link>
            <g:additional_image_link><![CDATA[https://shop.palintech.it/wp-content/uploads/2021/05/Palintech_cuscini_0003.jpg]]></g:additional_image_link>
        </item>
        @if($products)
            @foreach($products as $product)
                <?php
                $cat_prod_name = "";
                $cat_prod_slug = "no-categoria";
                $cat_prod = $product->category();
                if($cat_prod){
                    $cat_prod_name = $cat_prod->name;
                    $cat_prod_slug = $cat_prod->slug;
                }
                $url = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]);

                $promo_price = $product->get_promo_price();
                $vat = $product->tax ? $product->tax->value : 22;
                $vat_calculate = ($vat / 100) + 1;
                $p_temp = $product;
                ?>

                <item>
                    <g:id>{{ $product->id }}</g:id>
                    <g:inventory>{{ $product->qty }}</g:inventory>
                    <g:description><![CDATA[{!! strip_tags($product->description) !!}]]></g:description>
                    <g:condition>new</g:condition>
                    <g:mpn>{{ $product->sku }}</g:mpn>
                    <g:title>{{ $product->name }}</g:title>
                    <g:short_description><![CDATA[{{ strip_tags($product->description_short) }}]]></g:short_description>
                    <g:availability>in stock</g:availability>

                    @if($promo_price)
                        @if(env('VIEW_WITH_IVA') == 1)
                            <g:price>{{ number_format($promo_price * $vat_calculate, 2, ".", ",") }} EUR</g:price>
                        @else
                            <g:price>{{ number_format($promo_price, 2, ".", ",") }} EUR</g:price>
                          @endif
                     @endif

                    <g:link><![CDATA[{{ $url }}]]></g:link>
                    @if($product->cover)
                       <g:image_link><![CDATA[{{ $product->cover }}]]></g:image_link>
                    @endif
                    <g:item_group_id>{{ $product->group_id }}</g:item_group_id>
                    @if(trim($product->custom_1) != "")
                        <g:custom_label_0>{{ $product->custom_1 }}</g:custom_label_0>
                    @endif
                    @if(trim($product->custom_2) != "")
                        <g:custom_label_1>{{ $product->custom_2 }}</g:custom_label_1>
                    @endif
                    <g:product_type>{{ $cat_prod_name }}</g:product_type>
                    @if($product->images)
                            @foreach($product->images as $image)
                                <?php
                                if(is_numeric(strpos($image->image, "uploads"))){
                                    $url = url("$image->image");
                                }else{
                                    $url = url("uploads/products/$image->image");
                                }
                                ?>
                                <g:additional_image_link><![CDATA[{{ $url }}]]></g:additional_image_link>
                            @endforeach
                        </div>
                    @endif
                </item>
            @endforeach


        @endif

    </channel>
</rss>
