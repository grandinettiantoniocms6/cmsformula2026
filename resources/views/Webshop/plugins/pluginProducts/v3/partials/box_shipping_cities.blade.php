<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
<div class="row">
    <?php
    $name_city = "city_id";
    $name_zip = "zip";
    if($element == "provinceSel2"){
        $name_city = "city_id_2";
        $name_zip = "zip_2";
    }
    ?>
    <div class="col-sm-8">
        <div class="form-group">
            <label class="form-label">{{ @$labels['shop-partials-citta'] }}</label>

            @if($express == 1)
                 <select name="{{ $name_city }}" id="{{ $name_city }}" class="form-select required-if-show" onchange="change_city_express('{{ $name_city }}')">
            @else
                 <select name="{{ $name_city }}" id="{{ $name_city }}" class="form-select required-if-show" onchange="change_city('{{ $name_city }}')" required>
            @endif
                <option value="">{{ @$labels['shop-seleziona'] }}</option>
                @foreach ($cities as $city)
                    @php
                        $selected = '';
                        if(old($name_city) == $city->id){
                            $selected = 'selected';
                        }
                    @endphp
                    <option value="{{ $city->id }}" {{ $selected }}>{{ $city->nome_comune }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        @if($express != 1)
        <div class="form-group">
            <label class="form-label">{{ @$labels['shop-partials-cap'] }}</label>
            <input type="text" class="form-control required-if-show" name="{{ $name_zip }}" id="zip" required>
        </div>
        @endif
    </div>
</div>
