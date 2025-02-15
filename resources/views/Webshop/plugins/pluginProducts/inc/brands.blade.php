@if($plugin->show_brands == 1)
    <?php $brands = \App\Models\PluginProductsBrands::where("is_active", 1)->get(); ?>
    @if($brands)
        <div class="col-12">
          <div class="owl-carousel" data-nav-dots="false" data-nav-arrow="true" data-items="3" data-sm-items="2" data-lg-items="3" data-md-items="3" data-xs-items="2" data-autoplay="false">
               @foreach($brands as $brand)
                        <div class="item">
                            <div class="product">
                                <div class="product-image">
                                    @if($brand->image)
                                        <img class="img-fluid mx-auto" src="{{ url($brand->image) }}" alt="{{ $brand->name }}">
                                    @endif
                                </div>
                                <div class="product-description">
                                    <div class="product-title">
                                        {{ $brand->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    @endif
@endif
