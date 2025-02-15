<div class="sidebar-widgets-wrap">
    <div class="sidebar-header">
        <div class="sidebar-title">Filtri</div>
        <button class="sidebar-close" data-toggle="hide" data-target="#sidebar-shop">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="sidebar-widgets-body">
        <div class="sidebar-widget">
            <h5 class="sidebar-widget-title mb-20" data-toggle="collapse" data-target="#widget-search" aria-expanded="true">{{ @$labels['cerca'] }}</h5>
            <div class="widget-search collapse show" id="widget-search">
                @include('common.pluginProducts.inc.search')
            </div>
        </div>
        <div class="sidebar-widget">
            <h5 class="sidebar-widget-title mb-20" data-toggle="collapse" data-target="#widget-categorie" aria-expanded="true">{{ @$labels['categorie'] }}</h5>
            <div class="widget-link collapse show" id="widget-categorie">
                @if($categories)
                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                            <?php $tot = 0; ?>
                            @if(count($category->figli) > 0)
                                @foreach($category->figli as $figlio)
                                    <?php $tot = $tot + $figlio->count;?>
                                @endforeach
                            @else
                                <?php $tot = $tot + $category->count; ?>
                            @endif

                            @if($tot > 0)
                                <li>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route("pluginProducts.".\App::getLocale(), [$category->slug]) }}">{{ $category->name }} ({{ $tot }})</a>
                                        @if(count($category->figli) > 0)
                                            <i class="fas" data-toggle="collapse" data-target="#cat_{{ $category->id }}" aria-expanded="false"></i>
                                        @endif
                                    </div>
                                    @if(count($category->figli) > 0)
                                        <div id="cat_{{ $category->id }}" class="panel-collapse collapse in" data-toggle="false">
                                            <ul class="list-unstyled px-2">
                                                @foreach($category->figli as $figlio)
                                                    @if($figlio->count > 0)
                                                    <li><a href="{{ route("pluginProducts.".\App::getLocale(), [$figlio->slug]) }}"> {{ $figlio->name }} ({{ $figlio->count }}) </a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        @if(count($tags) && $plugin->show_tags == 1)
            <div class="sidebar-widget">
                <h5 class="sidebar-widget-title mb-20" data-toggle="collapse" data-target="#widget-tags" aria-expanded="true">{{ @$labels['tags'] }}</h5>
                <div class="widget-tags collapse show" id="widget-tags">
                    @if($tags)
                        <ul>
                            @foreach($tags as $tag)
                                @if(trim($tag) != "")
                                    <li><a href="{{ route("pluginProductsTags.".\App::getLocale(), $tag) }}">{{ $tag }} </a></li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
<div class="sidebar-backdrop" data-toggle="hide" data-target="#sidebar-shop"></div>
