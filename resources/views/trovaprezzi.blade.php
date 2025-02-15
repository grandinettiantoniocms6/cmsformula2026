<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<Products>
        @foreach($products as $product)
            @if(trim($product->url) != '' && count($product->images))
                <Offer>
                    <Name>{{ $product->name }}</Name>
                    <Brand>
                        @if($product->brand)
                            {{ $product->brand->name }}
                        @else
                            {{ env('PROJECT_NAME') }}
                        @endif
                    </Brand>
                    <Description><![CDATA[{{ strip_tags(utf8_encode($product->description)) }}]]></Description>
                    <OriginalPrice>{{ $product->getFinalPrice($product->categories()->first()->id) }}</OriginalPrice>
                    <Price>{{ $product->getFinalPrice($product->categories()->first()->id) }}</Price>
                    <Code>{{ $product->sku }}</Code>
                    <Link>{{ $product->url }}</Link>
                    <Stock>{{ $product->stock }}</Stock>
                    <Categories>{{ $product->cat_tree }}</Categories>
                    <Image>
                        @foreach ($product->images as $image)
                            {{ url("uploads/products/{$image->name}") }}
                            <?php break; ?>
                        @endforeach
                    </Image>
                    <ShippingCost>0</ShippingCost>
                    @if($product->ean)
                        <EanCode>
                              {{ $product->ean }}
                        </EanCode>
                    @endif
                </Offer>
            @endif
        @endforeach
    </Products>
</urlset>