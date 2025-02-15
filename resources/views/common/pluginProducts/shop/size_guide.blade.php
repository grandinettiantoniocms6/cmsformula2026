@if($shopSetting->photo_size)
    <div class="modal" id="modal_size" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ @$labels['shop-varie-guida-alle-teglie'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="{{ url($shopSetting->photo_size) }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ @$labels['shop-varie-chiudi'] }}</button>
                </div>
            </div>
        </div>
    </div>

    <a href="#" data-toggle="modal" data-target="#modal_size" class="btn btn-block btn-link">
        <i class="fas fa-tshirt"></i> {{ @$labels['shop-varie-guida-alle-teglie'] }}
    </a>
@else
    @if($shopSetting->page_id_size)
        <?php
        $page = \App\Models\Page::find($shopSetting->page_id_size);
        ?>
        <a href="/{{ $page->slug }}" @if($shopSetting->page_size_type_href) target="_blank" @endif class="btn btn-block btn-link">
            <i class="fas fa-tshirt"></i> {{ @$labels['shop-varie-guida-alle-teglie'] }}
        </a>
    @else
        @if(count($itemProduct->images_size))
            @if(count($itemProduct->images_size) == 1)
                @foreach($itemProduct->images_size as $image_size)
                    <?php
                    if(is_numeric(strpos($image_size->image, "uploads"))){
                        $url = url("$image_size->image");
                    }else{
                        $url = url("uploads/products/$image_size->image");
                    }
                    ?>
                    <!-- <a class="popup-single btn btn-block btn-link" href="{{ $url }}"><h4><i class="fas fa-tshirt"></i> {{ @$labels['shop-varie-guida-alle-teglie'] }}</a></h4>-->

                    <div class="modal" id="modal_size" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ @$labels['shop-varie-guida-alle-teglie'] }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @foreach($itemProduct->images_size as $image_size)
                                        <?php
                                        if(is_numeric(strpos($image_size->image, "uploads"))){
                                            $url = url("$image_size->image");
                                        }else{
                                            $url = url("uploads/products/$image_size->image");
                                        }
                                        ?>
                                        <figure class="product-image">
                                            <img src="{{ $url }}"
                                                 data-zoom-image="{{ $url }}"
                                                 alt="{{ $itemProduct->name }}">
                                        </figure>

                                        <br>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ @$labels['shop-varie-chiudi'] }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" data-toggle="modal" data-target="#modal_size" class="btn btn-block btn-link">
                        <i class="fas fa-tshirt"></i> {{ @$labels['shop-varie-guida-alle-teglie'] }}
                    </a>
                @endforeach
            @else
                <div class="modal" id="modal_size" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ @$labels['shop-varie-guida-alle-teglie'] }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @foreach($itemProduct->images_size as $image_size)
                                    <?php
                                    if(is_numeric(strpos($image_size->image, "uploads"))){
                                        $url = url("$image_size->image");
                                    }else{
                                        $url = url("uploads/products/$image_size->image");
                                    }
                                    ?>
                                    <figure class="product-image">
                                        <img src="{{ $url }}"
                                             data-zoom-image="{{ $url }}"
                                             alt="{{ $itemProduct->name }}">
                                    </figure>

                                    <br>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ @$labels['shop-varie-chiudi'] }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#" data-toggle="modal" data-target="#modal_size" class="btn btn-block btn-link">
                    <i class="fas fa-tshirt"></i> {{ @$labels['shop-varie-guida-alle-teglie'] }}
                </a>
            @endif
        @endif
    @endif
@endif
