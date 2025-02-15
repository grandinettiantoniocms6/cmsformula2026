<h5 class="mb-3">Dati di Fatturazione</h5>
@if(count($user->companies))
    <div id="invoice_address">
        <?php $i = 0; ?>
        @foreach ($user->companies as $company)
            @php
                $selected = '';
                if($i == 0 && $id == 0){
                      $selected = 'checked';
                }else{
                    if($id == $company->id){
                        $selected = 'checked';
                    }
                }

                $business_name = "";
                if(trim($company->business_name) != ""){
                    $business_name = "({$company->business_name})";
                }
            @endphp

            <div class="form-check card-check">
                <input type="radio" name="company_id" id="company_address_{{ $company->id }}" value="{{ $company->id }}" class="form-check-input" {{ $selected }} onclick="change_radio_fatturazione();">
                <label class="card card-body flex-row" for="company_address_{{ $company->id }}">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ @$company->name }} {{ $business_name }}</h6>
                        <div class="text-muted font-sm">
                            <div>{{ @$company->address1 }} {{ @$company->number_street }} - {{ @$company->city }} ({{ @$company->county }}) - {{ @$company->country->name }}</div>
                            @if($company->fiscal_code_vat)<div>P.IVA: {{ $company->fiscal_code_vat }}</div>@endif
                            @if($company->pec)<div>PEC: {{ $company->pec }}</div>@endif
                            @if($company->sdi)<div>SDI: {{ $company->sdi }}</div>@endif
                        </div>
                    </div>
                    <button class="btn btn-secondary btn-circle" type="button" onclick="edit_fatturazione({{ $company->id }})"><i class="fas fa-edit"></i></button>
                </label>
            </div>
            <?php $i++; ?>
        @endforeach
    </div>
@endif
