<?php
$langs = \App\Models\AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
?>

<div class="card mb-0">
    <div class="card-header bg-light">
        <div class="row align-items-center">
            <div class="col">Lingue visibilità
            </div>
        </div>
    </div>
    <div class="card-body py-0" id="box_services">
        @if($langs)
            @foreach($langs as $lang)
                <?php
                $item = null;
                if(key_exists($lang, $products_langs)){
                    $item = \App\Models\PluginProductsLangs::find($products_langs[$lang]);
                }

                ?>

                <div class="row border-bottom align-items-end" id="box_lang_{{ $lang }}">
                    <div class="py-2 col-md-2">
                        {{ $lang }}
                    </div>
                    <div class="py-2 col-md-2 col-xl-1">
                        <label>Visibilità</label>

                        @if(key_exists($lang, $products_langs))
                            <select class="form-control" name="lang_active[{{ $lang }}]">
                                @if(@$item->is_active == 1)
                                    <option value="1" selected>Si</option>
                                    <option value="0">No</option>
                                @else
                                    <option value="1">Si</option>
                                    <option value="0" selected>No</option>
                                @endif
                            </select>
                        @else
                            <select class="form-control" name="lang_active[{{ $lang }}]">
                                <option value="1" selected>Si</option>
                                <option value="0">No</option>
                            </select>
                        @endif
                    </div>

                    <div class="py-2 col-md">
                        <label>Immagine presente</label>
                        <br><br>
                        @if(@$item->image)
                            <input type="hidden" name="lang_exist_image[{{ $lang }}]" value="{{ $item->image }}">
                            <a href="{{ url($item->image) }}" target="_blank" class="btn btn-sm btn-success">Vedi</a>
                            <a href="{{ route('delete_image_special', $item->id) }}" class="btn btn-sm btn-danger">Cancella</a>
                        @else
                            -
                        @endif
                    </div>

                    <div class="py-2 col-md">
                        <label>Carica</label>
                        <input type="file" class="form-control" name="lang_image[{{ $lang }}]">
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
