<div class="modal fade" id="modal_{{ $position }}_col{{ $col }}_block" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleziona il Blocco che preferisci</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="la la-close la-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                {{--<div class="modal-footer">--}}
                    {{--<button type="submit" class="btn btn-info text-right">Aggiungi Blocco</button>--}}
                {{--</div>--}}

                {{ csrf_field() }}
                <input type="hidden" name="redirect" value="/admin/pages_blocks/{{ $page->id }}">
                <input type="hidden" name="page_id" value="{{ $page->id }}">

                @if($admin_blocks)
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-toggle="tab" href="#tab2-{{ $position }}_col{{ $col }}" role="tab" aria-controls="blocco-nuovo" aria-selected="false">Nuovo Blocco</a>
                    </li>
                    @if(count($admin_blocks_exists))
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="tab" href="#tab1-{{ $position }}_col{{ $col }}" role="tab" aria-controls="blocchi-esistenti" aria-selected="true">Blocchi Esistenti</a>
                    </li>
                    @endif

                </ul>
                <div class="tab-content">

                    @if(count($admin_blocks_exists))
                        <div class="tab-pane fade" id="tab1-{{ $position }}_col{{ $col }}" role="tabpanel" aria-labelledby="blocchi-esistenti">
                        <div id="b_exist_{{ $position }}_col_{{ $col }}">
                            <div class="form-group"><input class="search form-control bg-light" placeholder="Cerca tra i blocchi" /></div>
                            <div class="grid">
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
                                            if(is_array($vet_name)){
                                                if(key_exists("it", $vet_name)){
                                                    $label = $vet_name['it'];
                                                }
                                            }
                                        }
                                    }


                                    $page = \App\Models\Page::where("id", $block->page_id)->first();
                                    ?>
                                    <label class="card">
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
                        </div>
                    </div>
                    @endif

                    <div class="tab-pane fade show active" id="tab2-{{ $position }}_col{{ $col }}" role="tabpanel" aria-labelledby="blocco-nuovo">
                        <div class="form-group">
                            <label>Inserisci un nome al blocco</label>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div id="b_new_{{ $position }}_col_{{ $col }}">
                            <div class="form-group"><input class="search form-control bg-light" placeholder="Cerca tra i blocchi" /></div>
                            <div class="grid">
                                @foreach($admin_blocks as $k=>$block)
                                    <label class="card">
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
                                          </header>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Aggiungi Blocco</button>
            </div>
        </div>
    </div>
</div>

