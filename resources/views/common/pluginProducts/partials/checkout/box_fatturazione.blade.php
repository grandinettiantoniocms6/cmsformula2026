<h5 class="mb-3">Dati di Fatturazione</h5>
@if(count($user->companies))
    <div class="list-methods mb-3">
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
                <label class="method-item card flex-row py-2 px-3 active" for="company_address_{{ $company->id }}">
                    <div class="custom-control custom-radio mr-2">
                        <input type="radio" name="company_id" id="company_address_{{ $company->id }}" value="{{ $company->id }}" class="custom-control-input" {{ $selected }} onclick="change_radio_fatturazione();">
                        <span class="custom-control-label d-inline-block">
                            <h6 class="font-weight-normal mb-1">{{ @$company->name }} {{ $business_name }}</h6>
                            <div class="d-block small">
                                <span class="text-capitalize">
                                    {{ @$company->address1 }}
                                    {{ @$company->number_street }} -
                                    {{ @$company->city }}
                                    ({{ @$company->county }}) - {{ @$company->country->name }}</span><br>
                                @if($company->fiscal_code_vat)P.IVA: {{ $company->fiscal_code_vat }}<br>@endif
                                @if($company->pec)PEC: {{ $company->pec }}<br>@endif
                                @if($company->sdi)SDI: {{ $company->sdi }}@endif
                            </div>
                        </span>
                    </div>
                    <div class="ml-auto my-auto">
                        <button class="btn btn-sm btn-outline-primary" type="button" onclick="edit_fatturazione({{ $company->id }})"><i class="fas fa-edit"></i></button>
                        {{--<button  class="btn btn-sm btn-outline-primary" type="button" onclick="delete_fatturazione({{ $company->id }})"><i class="far fa-trash-alt"></i></button>--}}
                    </div>
                </label>
                <?php $i++; ?>
            @endforeach
        </div>
    </div>
@endif
