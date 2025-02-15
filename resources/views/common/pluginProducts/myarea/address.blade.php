<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
<main>

    <section class="section-page-header bg-light py-4 border-bottom">
        <div class="container">
            <h2 class="h3">@if(!$address) {{ @$labels['shop-myarea-nuovo-indirizzo'] }} @else {{ @$labels['shop-myarea-mod-indirizzo'] }} @endif</h2>
            <nav>
                <ol class="breadcrumb bg-transparent p-0 my-0">
                    <li class="breadcrumb-item d-none d-md-block"><a href="{{ route('index') }}">{{ @$labels['shop-myarea-home'] }}</a></li>
                    <li class="breadcrumb-item d-none d-md-block active" aria-current="page">@if(!$address) {{ @$labels['shop-myarea-nuovo-indirizzo'] }} @else {{ @$labels['shop-myarea-mod-indirizzo'] }} @endif</li>
                    <li class="breadcrumb-item"><a href="{{ route('myarea.addresses') }}"><i class="fa fa-angle-left mr-2 d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-indirizzi-spedizione'] }}</a></li>
                </ol>
            </nav>
        </div> <!-- container //  -->
    </section>

    <section class="py-4">
        <div class="container">

            <div class="row">
                <aside class="col-12 col-lg-3">
                    @include("common.pluginProducts.inc.myarea_menu")
                </aside> <!-- col.// -->
                <main class="col-12 col-lg-9 mt-4 mt-lg-0">
                    <form id="profile-form" class="form-validate" action="{{ route('myarea.address_save') }}" method="post">
                        {{ csrf_field() }}

                        @if(!$address)
                            <input type="hidden" name="address_id" value="0">
                        @else
                            <input type="hidden" name="address_id" value="{{ $address->id }}">
                        @endif

                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="my-0">@if(!$address) {{ @$labels['shop-myarea-nuovo-indirizzo'] }} @else {{ @$labels['shop-myarea-'] }}{{ @$labels['shop-myarea-mod-indirizzo'] }} @endif</h5>
                                <small class="text-muted">{{ @$labels['shop-myarea-campi-obbligatori'] }}</small>
                            </div>
                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger text-center alert-fixed-bottom-xs">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }} <br>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="name">{{ @$labels['shop-myarea-nome-azienda'] }}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ @$address->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-checkout-nazione'] }}</label>
                                    <select class="form-control" name="country_id" id="country_id" required  @if($address) readonly="readonly" @endif onchange="change_country_myarea('country_id');">
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
                                    <?php
                                    $cities = \App\Models\City::orderBy("sigla_provincia", "asc")->groupBy("sigla_provincia")->get();
                                    ?>
                                    <div class="form-group" id="box_province">
                                        <label id="province">{{ @$labels['shop-checkout-provincia'] }}</label>
                                        <div class="form-select-container">
                                            <select name="county" id="provinceSel" class="custom-select required-if-show select2" onchange="change_province('provinceSel')">
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
                                            <?php
                                            $cities = \App\Models\City::orderBy("nome_comune", "asc")->where("sigla_provincia", $address->county)->get();
                                            ?>
                                            <div class="row" >
                                                <div class="col-8">
                                                    <div class="form-group">
                                                        <label for="city_id">{{ @$labels['shop-checkout-citta'] }}</label>
                                                        <select name="city_id" id="city_id" class="custom-select required-if-show select2" onchange="change_city('city_id')">
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
                                                        <input type="text" class="form-control required-if-show" name="zip" id="zip" value="{{ @$address->postal_code }}">
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
                                                    <label for="city_id">Provincia *</label>
                                                    <input type="text" class="form-control" name="county" id="province" required value="{{ @$address->county }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label for="city_id">Città *</label>
                                                    <input type="text" class="form-control" name="city_id" id="city_id" value="{{ @$address->city }}" required></div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group"><label for="zip">CAP *</label>
                                                    <input type="text" class="form-control" name="zip" id="zip" value="{{ @$address->postal_code }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                            <?php
                                            $cities = \App\Models\City::orderBy("sigla_provincia", "asc")->groupBy("sigla_provincia")->get();
                                            ?>
                                            <div class="form-group" id="box_province">
                                                <label id="province">{{ @$labels['shop-checkout-provincia'] }}</label>
                                                <div class="form-select-container">
                                                    <select name="county" id="provinceSel" class="custom-select required-if-show select2" onchange="change_province('provinceSel')">
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
                                                    <?php
                                                    $cities = \App\Models\City::orderBy("nome_comune", "asc")->where("sigla_provincia", $address->county)->get();
                                                    ?>
                                                    <div class="row" >
                                                        <div class="col-8">
                                                            <div class="form-group">
                                                                <label for="city_id">{{ @$labels['shop-checkout-citta'] }}</label>
                                                                <select name="city_id" id="city_id" class="custom-select required-if-show select2" onchange="change_city('city_id')">
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
                                                                <input type="text" class="form-control required-if-show" name="zip" id="zip" value="{{ @$address->postal_code }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                    @endif
                                @endif

                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-checkout-indirizzo'] }}</label>
                                    <input type="text" class="form-control" id="address1" name="address1" value="{{ @$address->address1 }}" required>
                                </div>
                            </div> <!-- card-body .// -->
                        </div> <!-- card.// -->

                        <div class="form-group mt-4">
                            <div class="row">
                                @if($address)
                                    <div class="col">
                                        <button type="button" onclick="delete_address()" class="btn btn-danger">{{ @$labels['shop-myarea-elimina-indirizzo-sped'] }}</button>
                                    </div>
                                @endif
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-primary btn-lg">@if(!$address) {{ @$labels['shop-myarea-salva-nuovo-indirizzo'] }} @else {{ @$labels['shop-myarea-mod-ind-spedizione'] }} @endif</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </main> <!-- col.// -->
            </div>

        </div>
    </section>

</main>
