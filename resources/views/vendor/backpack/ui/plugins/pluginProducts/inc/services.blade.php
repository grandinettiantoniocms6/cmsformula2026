<?php
$langs = \App\Models\AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
?>
<div class="card">
    <div class="card-header list-group-item-accent-secondary bg-light font-600 border-bottom-0 py-2">
        <div class="row align-items-center">
            <div class="col line-height-sm">Servizi aggiuntivi</div>
            <div class="col-auto">
                <button type="button" class="btn btn-dark btn-sm py-1" id="add-service"><i class="icon-plus fa-15"></i> <span class="d-none d-md-inline">Aggiungi</span></button>
            </div>
        </div>
    </div>
    <div class="card-table" id="box_services_add">
        <div class="col-md-12 well repeatable-element row m-1 p-2">
            <?php
              $checked = "";
              if($product){
                  if($product->is_services_adding_required){
                      $checked = "checked";
                  }
              }
            ?>
            <input type="checkbox" name="is_services_adding_required" value="1" {{ $checked }}>
            Rendi obbligatoria la scelta del servizio aggiuntivo
        </div>

        @if($products_services)
            @foreach($products_services as $item)
                <div class="col-md-12 well repeatable-element row m-1 p-2" id="box_service_{{ $item->id }}">
                    <div class="form-group col-md-4">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="name_services[]" id="name_services_{{ $item->id }}" value="{{ @$item->name }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Prezzo &euro; iva escl. (da aggiungere)</label>
                        <input type="text" class="form-control" name="price_services[]" id="price_services_{{ $item->id }}" value="{{ @$item->price }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <a class="btn-danger btn mt-4" onclick="deleteRow({{ $item->id }}, 'service')" href="#"><i class="la la-trash la-lg"></i></a>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>
