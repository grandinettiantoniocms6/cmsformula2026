{{ csrf_field() }}
<input type="hidden" name="redirect" value="/admin/pages_blocks/{{ $page->id }}">
<input type="hidden" name="page_id" value="{{ $page->id }}">
<div class="form-inline">
    <div class="form-group">

        <select class="custom-select select2" name="type">
            <option value="">Seleziona blocco</option>
            @if($admin_blocks)
                <optgroup label="- Nuovo Blocco -">
                    @foreach($admin_blocks as $k=>$block)
                        <option value="{{ $k }}">{{ $block }}</option>
                    @endforeach
                </optgroup>

                <optgroup label="- Blocchi Esistenti -">
                @foreach($admin_blocks_exists as $k=>$block)
                    <?php
                        $label = "$block->name_table error";
                        $item = \DB::table($block->name_table)->find($block->obj_id);
                        if($item){
                            $vet_name = json_decode($item->name, true);
                            if(!$vet_name){
                                $label = $item->name;
                            }else{
                                $label = $vet_name['it'];
                            }
                        }
                    ?>
                    <option value="{{ $block->id }}">{{ $label }} ({{ $block->label }})</option>
                @endforeach
                </optgroup>
            @endif
        </select>
    </div>
    <div class="form-group mx-2">
        <button type="submit" class="btn btn-info">Aggiungi</button>
    </div>
</div>
