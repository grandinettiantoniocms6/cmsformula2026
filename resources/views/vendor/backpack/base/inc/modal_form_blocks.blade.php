@php
    $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();

    $futureManualCategoryMap = [
        'blockbanner' => 'hero',
        'blockcarousel' => 'hero',
        'blockslideshow' => 'hero',
        'blockhero' => 'hero',
        'blockparallax' => 'hero',
        'blockvideobg' => 'hero',
        'blockscrollingtext' => 'hero',
        'blockonephoto' => 'media',
        'blockimage' => 'media',
        'blockimagelink' => 'media',
        'blockgallery' => 'media',
        'blockportfolio' => 'media',
        'blockportfolio2' => 'media',
        'blockmetro' => 'media',
        'blockmetrox' => 'media',
        'blockcollage' => 'media',
        'blockdocument' => 'media',
        'blockvideotut' => 'media',
        'blockcontact' => 'contatti',
        'blockcontactgmap' => 'contatti',
        'blockpluginform' => 'contatti',
        'blocksocial' => 'contatti',
        'blockfaq' => 'testi',
        'blocknews' => 'testi',
        'blockhtml' => 'testi',
        'blockhtmlbook' => 'testi',
        'blockhtmlimage' => 'testi',
        'blockhtmltwocol' => 'testi',
        'blocklistoflink' => 'testi',
        'blocktab' => 'testi',
        'blocktimeline' => 'testi',
        'blockseparator' => 'testi',
        'blockhightlight' => 'testi',
        'blockprogressbar' => 'testi',
        'blockcountdown' => 'utility',
        'blockicon' => 'utility',
        'blockflusso' => 'utility',
        'blockgrid' => 'utility',
        'blockprice' => 'shop',
        'blockstore' => 'shop',
        'blockpluginproduct' => 'shop',
        'blockpluginproductlast' => 'shop',
        'blockpluginproductsearch' => 'shop',
        'blockplugincounter' => 'shop',
        'blockpluginbooking' => 'shop',
        'blockpluginbookingsearchtype' => 'shop',
        'blockpluginparking' => 'shop',
        'blockplugintimetable' => 'shop',
        'blockplugincaccia' => 'shop',
        'blockreference' => 'utility',
        'blocklastwork' => 'utility',
        'blockbrand' => 'utility',
        'blockpage' => 'utility',
        'blockscrollbar' => 'utility',
        'blockstaff' => 'utility',
    ];

    $resolveFutureCategory = function ($key, $label) use ($futureManualCategoryMap) {
        $normalizedKey = strtolower(preg_replace('/[^a-z0-9]/', '', (string) ($key ?? '')));
        if (isset($futureManualCategoryMap[$normalizedKey])) {
            return $futureManualCategoryMap[$normalizedKey];
        }

        $haystack = strtolower(($key ?? '') . ' ' . ($label ?? ''));
        if (strpos($haystack, 'header') !== false || strpos($haystack, 'menu') !== false || strpos($haystack, 'topbar') !== false) {
            return 'header';
        }
        if (strpos($haystack, 'hero') !== false || strpos($haystack, 'slider') !== false || strpos($haystack, 'banner') !== false) {
            return 'hero';
        }
        if (strpos($haystack, 'contact') !== false || strpos($haystack, 'map') !== false || strpos($haystack, 'form') !== false) {
            return 'contatti';
        }
        if (strpos($haystack, 'news') !== false || strpos($haystack, 'blog') !== false || strpos($haystack, 'faq') !== false || strpos($haystack, 'test') !== false || strpos($haystack, 'text') !== false || strpos($haystack, 'title') !== false) {
            return 'testi';
        }
        if (strpos($haystack, 'gallery') !== false || strpos($haystack, 'video') !== false || strpos($haystack, 'image') !== false || strpos($haystack, 'foto') !== false) {
            return 'media';
        }
        if (strpos($haystack, 'product') !== false || strpos($haystack, 'shop') !== false || strpos($haystack, 'catalog') !== false) {
            return 'shop';
        }

        return 'utility';
    };

    $futureCategoryLabels = [
        'header' => 'Header',
        'hero' => 'Hero',
        'testi' => 'Testi',
        'media' => 'Media',
        'contatti' => 'Contatti',
        'shop' => 'Shop',
        'utility' => 'Utility',
    ];

    $futureCategoriesInModal = [];
    if ($isFutureAdminTemplate && !empty($admin_blocks)) {
        foreach ($admin_blocks as $blockKey => $blockLabel) {
            $cat = $resolveFutureCategory($blockKey, $blockLabel);
            $futureCategoriesInModal[$cat] = $futureCategoryLabels[$cat] ?? ucfirst($cat);
        }
    }
@endphp

<div class="modal fade" id="modal_{{ $position }}_col{{ $col }}_block" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable {{ $isFutureAdminTemplate ? 'future-blocks-modal-dialog' : '' }}">
        <div class="modal-content {{ $isFutureAdminTemplate ? 'future-blocks-modal-content' : '' }}">
            <div class="modal-header {{ $isFutureAdminTemplate ? 'future-blocks-modal-header' : '' }}">
                @if($isFutureAdminTemplate)
                    <div>
                        <h5 class="modal-title mb-0">Aggiungi blocco</h5>
                        <small class="text-muted d-block mt-1">Seleziona categoria e blocco da inserire nel layout.</small>
                    </div>
                @else
                    <h5 class="modal-title">Seleziona il Blocco che preferisci</h5>
                @endif
                <button type="button" class="close {{ $isFutureAdminTemplate ? 'future-modal-close' : '' }}" data-dismiss="modal" aria-label="Close">
                    <i class="la la-close la-lg"></i>
                </button>
            </div>
            <div class="modal-body {{ $isFutureAdminTemplate ? 'future-blocks-modal-body' : '' }}">
                {{ csrf_field() }}
                <input type="hidden" name="redirect" value="/admin/pages_blocks/{{ $page->id }}">
                <input type="hidden" name="page_id" value="{{ $page->id }}">

                @if($admin_blocks)
                <ul class="nav nav-tabs {{ $isFutureAdminTemplate ? 'future-blocks-tabs' : '' }}" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-toggle="tab" href="#tab2-{{ $position }}_col{{ $col }}" role="tab" aria-controls="blocco-nuovo" aria-selected="false">Nuovo Blocco</a>
                    </li>
                    @if(count($admin_blocks_exists))
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#tab1-{{ $position }}_col{{ $col }}" role="tab" aria-controls="blocchi-esistenti" aria-selected="true">Blocchi Esistenti</a>
                    </li>
                    @endif
                </ul>
                <div class="tab-content {{ $isFutureAdminTemplate ? 'future-blocks-tab-content' : '' }}">

                    @if(count($admin_blocks_exists))
                        <div class="tab-pane fade {{ $isFutureAdminTemplate ? 'pt-2' : '' }}" id="tab1-{{ $position }}_col{{ $col }}" role="tabpanel" aria-labelledby="blocchi-esistenti">
                        <div id="b_exist_{{ $position }}_col_{{ $col }}" class="{{ $isFutureAdminTemplate ? 'js-future-filter-panel' : '' }}">
                            <div class="form-group {{ $isFutureAdminTemplate ? 'mb-2' : '' }}">
                                <input class="search form-control bg-light {{ $isFutureAdminTemplate ? 'js-future-tab-search future-blocks-search-input' : '' }}" placeholder="Cerca tra i blocchi esistenti" />
                            </div>
                            <div class="grid {{ $isFutureAdminTemplate ? 'future-blocks-grid' : '' }}">
                                @foreach($admin_blocks_exists as $k=>$block)
                                    <?php
                                    $label = "$block->name_table error";
                                    $item = \DB::table($block->name_table)->find($block->obj_id);
                                    if(!$item){
                                        continue;
                                    }

                                    if($item){
                                        $vet_name = json_decode($item->name, true);
                                        if(!$vet_name){
                                            $label = $item->name;
                                        }else{
                                            if(is_array($vet_name) && key_exists("it", $vet_name)){
                                                $label = $vet_name['it'];
                                            }
                                        }
                                    }

                                    $page = \App\Models\Page::where("id", $block->page_id)->first();
                                    $existSearchIndex = strtolower(trim(($label ?? '') . ' ' . ($block->label ?? '') . ' ' . ($page->name ?? '')));
                                    ?>
                                    <label class="card {{ $isFutureAdminTemplate ? 'future-block-card js-future-block-card' : '' }}" @if($isFutureAdminTemplate) data-search="{{ $existSearchIndex }}" @endif>
                                        <div class="nomeblocco d-none">{{ $label }}</div>
                                        <input class="card__input" type="radio" name="type" value="{{ $block->id }}"/>
                                        <div class="card__body shadow-none">
                                            <div class="card__body-cover">
                                                <img class="card__body-cover-image" src="{{ url('imagesAdminBlocks') }}/{{ $block->name }}.jpg">
                                                <span class="card__body-cover-checkbox">
                                                    <svg class="card__body-cover-checkbox--svg" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                </span>
                                            </div>
                                            <header class="card__body-header">
                                                <strong class="card__body-header-title">{{ $label }}</strong>
                                                <p class="card__body-header-subtitle">{{ $block->label }}</p>
                                                @if($page)
                                                    <p class="card__body-header-subtitle"><span class="badge badge-primary">Pagina</span> {{ $page->name }}</p>
                                                @endif
                                            </header>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @if($isFutureAdminTemplate)
                                <div class="future-blocks-empty js-future-empty d-none">Nessun blocco trovato.</div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="tab-pane fade show active {{ $isFutureAdminTemplate ? 'pt-2' : '' }}" id="tab2-{{ $position }}_col{{ $col }}" role="tabpanel" aria-labelledby="blocco-nuovo">
                        <div class="form-group {{ $isFutureAdminTemplate ? 'future-name-group' : '' }}">
                            <label>{{ $isFutureAdminTemplate ? 'Nome interno del nuovo blocco' : 'Inserisci un nome al blocco' }}</label>
                            <input type="text" class="form-control" name="name" placeholder="{{ $isFutureAdminTemplate ? 'Es. Hero Home 01' : '' }}">
                        </div>

                        <div id="b_new_{{ $position }}_col_{{ $col }}" class="{{ $isFutureAdminTemplate ? 'js-future-filter-panel' : '' }}">
                            <div class="form-group {{ $isFutureAdminTemplate ? 'mb-2' : '' }}">
                                <input class="search form-control bg-light {{ $isFutureAdminTemplate ? 'js-future-tab-search future-blocks-search-input' : '' }}" placeholder="Cerca blocco per nome o funzione..." />
                            </div>

                            @if($isFutureAdminTemplate)
                                <div class="future-category-pills js-future-category-pills">
                                    <button type="button" class="btn btn-sm btn-light js-future-category-btn is-active" data-category="all">Tutti</button>
                                    @foreach($futureCategoriesInModal as $futureCategoryKey => $futureCategoryLabel)
                                        <button type="button" class="btn btn-sm btn-light js-future-category-btn" data-category="{{ $futureCategoryKey }}">{{ $futureCategoryLabel }}</button>
                                    @endforeach
                                </div>
                            @endif

                            <div class="grid {{ $isFutureAdminTemplate ? 'future-blocks-grid' : '' }}">
                                @foreach($admin_blocks as $k=>$block)
                                    @php
                                        $futureCategory = $resolveFutureCategory($k, $block);
                                        $newSearchIndex = strtolower(trim(($block ?? '') . ' ' . ($k ?? '') . ' ' . ($futureCategoryLabels[$futureCategory] ?? $futureCategory)));
                                    @endphp
                                    <label class="card {{ $isFutureAdminTemplate ? 'future-block-card js-future-block-card' : '' }}"
                                           @if($isFutureAdminTemplate) data-category="{{ $futureCategory }}" data-search="{{ $newSearchIndex }}" @endif>
                                        <div class="nomeblocco d-none">{{ $block }}</div>
                                        <input class="card__input" type="radio" name="type" value="{{ $k }}"/>
                                        <div class="card__body shadow-none">
                                            <div class="card__body-cover">
                                                <img class="card__body-cover-image" src="{{ url('imagesAdminBlocks') }}/{{ $k }}.jpg">
                                                <span class="card__body-cover-checkbox">
                                                  <svg class="card__body-cover-checkbox--svg" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                  </svg>
                                                </span>
                                            </div>
                                          <header class="card__body-header font-weight-bold">
                                              <strong class="card__body-header-title">{{ $block }}</strong>
                                              @if($isFutureAdminTemplate)
                                                  <span class="future-block-badge">{{ $futureCategoryLabels[$futureCategory] ?? ucfirst($futureCategory) }}</span>
                                              @endif
                                          </header>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @if($isFutureAdminTemplate)
                                <div class="future-blocks-empty js-future-empty d-none">Nessun blocco trovato.</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer {{ $isFutureAdminTemplate ? 'future-blocks-modal-footer' : '' }}">
                @if($isFutureAdminTemplate)
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annulla</button>
                @endif
                <button type="submit" class="btn btn-dark">{{ $isFutureAdminTemplate ? 'Aggiungi' : 'Aggiungi Blocco' }}</button>
            </div>
        </div>
    </div>
</div>
