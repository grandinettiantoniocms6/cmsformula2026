<?php
$adminPluginProducts = \App\Models\AdminPlugin::where("name", "pluginProducts")
    ->where("version", 3)
    ->where("is_active", 1)
    ->first();


$adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();

if($adminPluginProducts){
    $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
}

if($adminPluginBooking){
    $labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
}
?>


<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h3>{{ @$labels['shop-myarea-mio-account'] }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="bi bi-chevron-left d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['shop-myarea-mio-account'] }}</li>
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
                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        @foreach ($errors->all() as $error)
                            {{ $error }} <br>
                        @endforeach
                    </div>
                @endif
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif

                <form id="profile-form" class="form-validate" action="{{ route('myarea.profileProcess') }}" method="post">
                    {{ csrf_field() }}
                    <div class="card card-myarea">
                        <div class="card-header">
                            <h5>{{ @$labels['shop-myarea-info-account'] }}</h5>
                            <div>{{ @$labels['shop-myarea-campi-obbligatori'] }}</div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">{{ @$labels['shop-myarea-nome-azienda'] }}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{ @$labels['shop-myarea-email'] }}</label>
                                <input type="email" class="form-control" id="email" value="{{ $user->email }}" name="email" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{ @$labels['shop-checkout-telefono'] }}</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $user->mobile }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ @$labels['shop-myarea-nazionalita'] }}</label>
                                <select class="form-control" name="country_id">
                                    <option value="">{{ @$labels['shop-myarea-non-specificato'] }}</option>
                                    @foreach($countries as $country)
                                        @if($country->id == @$user->country_id)
                                            <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                        @else
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <label class="form-label">{{ @$labels['shop-registrati-info-4'] }}</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="check_newsletter" name="check_newsletter" value="1" @if(@$user->check_newsletter == 1) checked @endif>
                                <label class="form-check-label" for="check_newsletter">{{ @$labels['shop-registrati-newsletter'] }}</label>
                            </div>

                        </div>
                    </div>

                    <div class="card card-myarea">
                        <div class="card-header">
                            <h5>{{ @$labels['shop-myarea-accessi'] }}</h5>
                            <div>{{ @$labels['shop-myarea-campi-obbligatori'] }}</div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">{{ @$labels['shop-myarea-vecchia-password'] }}</label>
                                <input type="password" id="old_password" name="old_password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ @$labels['shop-myarea-nuova-password'] }}</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ @$labels['shop-conferma-nuova-password'] }}</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" data-rule-equalto="#password">
                            </div>
                        </div>
                    </div>

                    <div class="row gx-2 justify-content-end">
                        <div class="col"></div>
                        <div class="col-sm-auto my-1">
                            <button type="submit" class="btn btn-primary w-100">{{ @$labels['shop-myarea-modifica-dati'] }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</section>
