<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>

<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h3>@if(!$address) {{ @$labels['shop-myarea-nuovo-indirizzo'] }} @else {{ @$labels['shop-myarea-mod-indirizzo'] }} @endif</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item">@if(!$address) {{ @$labels['shop-myarea-nuovo-indirizzo'] }} @else {{ @$labels['shop-myarea-mod-indirizzo'] }} @endif</li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('myarea.addresses') }}"><i class="bi bi-chevron-left d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-indirizzi-spedizione'] }}</a></li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-4">
    <div class="container">

        <div class="row">
            <aside class="col-12 col-xl-3">
                @include("$thema.inc.myarea_menu")
            </aside>
            <div class="col-12 col-xl-9">
                <form id="profile-form" class="form-validate" action="{{ route('myarea.address_save') }}" method="post">
                    {{ csrf_field() }}

                    @if(!$address)
                        <input type="hidden" name="address_id" value="0">
                    @else
                        <input type="hidden" name="address_id" value="{{ $address->id }}">
                    @endif

                    <div class="card card-myarea">
                        <div class="card-header">
                            <h5>@if(!$address) {{ @$labels['shop-myarea-nuovo-indirizzo'] }} @else {{ @$labels['shop-myarea-'] }}{{ @$labels['shop-myarea-mod-indirizzo'] }} @endif</h5>
                            <div>{{ @$labels['shop-myarea-campi-obbligatori'] }}</div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger text-center">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif

                            <div class="form-group">
                                <label class="form-label font-sm">{{ @$labels['shop-myarea-nome-azienda'] }}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ @$address->name }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label font-sm">{{ @$labels['shop-checkout-nazione'] }}</label>
                                <select class="form-select" name="country_id" id="country_id" required  @if($address) readonly="readonly" @endif onchange="change_country_myarea('country_id');">
                                    <option value=""> - </option>
                                    @foreach($countries as $country)
                                        @if($country->id == @$address->country_id)
                                            <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                        @else
                                            <option value="{{ $country->id }}" @if($country->id == 106 && !$address) selected @endif>{{ $country->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>


                            @if(@$address->country_id == 106)
                                <?php $cities = \App\Models\City::orderBy("sigla_provincia", "asc")->groupBy("sigla_provincia")->get(); ?>
                                <div class="form-group" id="box_province">
                                    <label class="form-label font-sm">{{ @$labels['shop-checkout-provincia'] }}</label>
                                    <div class="form-select-container">
                                        <select name="county" id="provinceSel" class="form-select" onchange="change_province('provinceSel')">
                                            <option value="">{{ @$labels['shop-seleziona'] }}</option>
                                            @foreach ($cities as $city)
                                                @php
                                                    $selected = '';
                                                    if(@$address->county == $city->sigla_provincia){
                                                        $selected = 'selected';
                                                    }
                                                @endphp
                                                <option value="{{ $city->sigla_provincia }}" {{ $selected }}>{{ $city->sigla_provincia }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div id="box_city">
                                    @if($address)
                                        <?php $cities = \App\Models\City::orderBy("nome_comune", "asc")->where("sigla_provincia", $address->county)->get(); ?>
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label class="form-label font-sm">{{ @$labels['shop-checkout-citta'] }}</label>
                                                    <select name="city_id" id="city_id" class="form-select" onchange="change_city('city_id')">
                                                        <option value="">{{ @$labels['shop-seleziona'] }}</option>
                                                        @foreach ($cities as $city)
                                                            @php
                                                                $selected = '';
                                                                if($address->city == $city->nome_comune){
                                                                    $selected = 'selected';
                                                                }
                                                            @endphp
                                                            <option value="{{ $city->id }}" {{ $selected }}>{{ $city->nome_comune }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="zip">{{ @$labels['shop-partials-cap'] }}</label>
                                                    <input type="text" class="form-control" name="zip" id="zip" value="{{ @$address->postal_code }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else

                                @if($address)
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label font-sm">Provincia *</label>
                                                <input type="text" class="form-control" name="county" id="province" required value="{{ @$address->county }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label class="form-label font-sm">Città *</label>
                                                <input type="text" class="form-control" name="city_id" id="city_id" value="{{ @$address->city }}" required></div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label font-sm">CAP *</label>
                                                <input type="text" class="form-control" name="zip" id="zip" value="{{ @$address->postal_code }}" required>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <?php $cities = \App\Models\City::orderBy("sigla_provincia", "asc")->groupBy("sigla_provincia")->get(); ?>
                                    <div class="form-group" id="box_province">
                                        <label class="form-label font-sm">{{ @$labels['shop-checkout-provincia'] }}</label>
                                        <div class="form-select-container">
                                            <select name="county" id="provinceSel" class="form-select" onchange="change_province('provinceSel')">
                                                <option value="">{{ @$labels['shop-seleziona'] }}</option>
                                                @foreach ($cities as $city)
                                                    @php
                                                        $selected = '';
                                                        if(@$address->county == $city->sigla_provincia){
                                                            $selected = 'selected';
                                                        }
                                                    @endphp
                                                    <option value="{{ $city->sigla_provincia }}" {{ $selected }}>{{ $city->sigla_provincia }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div id="box_city">
                                        @if($address)
                                            <?php $cities = \App\Models\City::orderBy("nome_comune", "asc")->where("sigla_provincia", $address->county)->get(); ?>
                                            <div class="row" >
                                                <div class="col-8">
                                                    <div class="form-group">
                                                        <label class="form-label font-sm">{{ @$labels['shop-checkout-citta'] }}</label>
                                                        <select name="city_id" id="city_id" class="form-select" onchange="change_city('city_id')">
                                                            <option value="">{{ @$labels['shop-seleziona'] }}</option>
                                                            @foreach ($cities as $city)
                                                                @php
                                                                    $selected = '';
                                                                    if($address->city == $city->nome_comune){
                                                                        $selected = 'selected';
                                                                    }
                                                                @endphp
                                                                <option value="{{ $city->id }}" {{ $selected }}>{{ $city->nome_comune }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="form-label font-sm">{{ @$labels['shop-partials-cap'] }}</label>
                                                        <input type="text" class="form-control" name="zip" id="zip" value="{{ @$address->postal_code }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endif

                            <div class="form-group">
                                <label class="form-label font-sm">{{ @$labels['shop-checkout-indirizzo'] }}</label>
                                <input type="text" class="form-control" id="address1" name="address1" value="{{ @$address->address1 }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-2 justify-content-end">
                        <div class="col"></div>
                        @if($address)
                            <div class="col-sm-auto my-1">
                                <button type="button" onclick="delete_address()" class="btn btn-danger w-100">{{ @$labels['shop-myarea-elimina-indirizzo-sped'] }}</button>
                            </div>
                        @endif
                        <div class="col-sm-auto my-1">
                            <button type="submit" class="btn btn-primary w-100">@if(!$address) {{ @$labels['shop-myarea-salva-nuovo-indirizzo'] }} @else {{ @$labels['shop-myarea-mod-ind-spedizione'] }} @endif</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
