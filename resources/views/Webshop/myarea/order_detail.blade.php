<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$symbol = "&euro;";
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
    $symbol = "&#36;";
}
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
    $symbol = "&euro;";
}
?>

<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h3>{{ @$labels['shop-myarea-dettaglio-ordine'] }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['shop-myarea-dettaglio-ordine'] }}</li>
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

                <div class="alert alert-{{ $order->status->className }}">
                    <div class="row">
                        <div class="col-sm">
                            <h5>{{ @$labels['shop-myarea-ordine-num'] }} #{{ $order->id }}</h5>
                            <div>{{ @$labels['shop-myarea-data'] }} {{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $order->created_at)->format("d/m/Y H:i") }}</div>
                        </div>
                        <div class="col-sm-auto d-flex align-items-center">
                            <h3 class="mt-2 mt-sm-0 mb-0"><span class="ml-auto font-weight-normal">{{ $order->status->name }}</span></h3>
                        </div>
                    </div>
                </div>

                @if(\Session::has('msg'))
                    <div class="alert alert-success">{{ \Session::get('msg') }}</div>
                @endif

                @if($order->payment && in_array($order->status->id, [1,5]))
                    <div class="card mb-3">
                        <h6 class="card-header">{{ @$labels['shop-myarea-metodo-di-pagamento'] }}</h6>
                        <div class="card-body">
                            @php
                                $payments = \App\Models\Payment::get();
                                if( $order->status->id == 4){
                                    $disabled = 'disabled';
                                } else {
                                    $disabled = '';
                                }
                            @endphp

                            <form method="post" action="{{ route('order.edit.payment') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <div class="row">
                                    <div class="col">
                                        <select name="payment_id" class="custom-select" {{ $disabled }}>
                                            @foreach($payments as $payment)
                                                @if($payment->id == $order->payment_id)
                                                    <option value="{{ $payment->id }}" selected>{{ $payment->name }}</option>
                                                @else
                                                    <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <?php
                                    $shopSetting = \App\Models\ShopSettings::first();
                                    ?>
                                    @if($order->status_id == $shopSetting->status_default_nonpagato)
                                        <div class="col-sm-auto mt-2 mt-sm-0">
                                            <button type="submit" class="btn btn-block btn-primary {{ $disabled }}" {{ $disabled }}>{{ @$labels['shop-myarea-modifica'] }}</button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                            <?php
                            $shopSetting = \App\Models\ShopSettings::first();
                            ?>
                            @if($order->status_id == $shopSetting->status_default_nonpagato)
                                <?php
                                $payment = \App\Models\Payment::find($order->payment_id);
                                ?>
                                <div class="alert alert-info text-center mt-2">
                                    <div class="display-4"><i class="bi bi-info-circle"></i></div>
                                    <h5 class="mb-1">{{ @$labels['shop-myarea-ordine-confermato'] }}</h5>
                                    <h4 class="mt-0">{{ @$labels['shop-myarea-hai-scelto-di-pagare-con'] }} {{ $order->payment->name }}.</h4>
                                </div>
                                <div class="card bg-light card-body">{{ $order->payment->info }}</div>

                                @if($payment->is_paypal)
                                    @if(!$order->paypal_payment_id)
                                        <br /><a href="{{ route("order.result") }}?order_id={{ $order->id }}" class="btn btn-success btn-block">{{ @$labels['shop-myarea-paga-adesso'] }}</a>
                                    @else
                                        <div class="card bg-light card-body">{{ $order->paypal_payment_id }}</div>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                @endif

                <div class="card mb-3">
                    <h6 class="card-header">{{ @$labels['shop-myarea-dettaglio-ordine'] }}</h6>
                    <div class="card-table">
                        <div class="m-1 m-md-0">
                            @include("$thema.plugins.pluginProducts.v3.partials.detail_order")
                        </div>
                    </div>
                </div>

                @if($order->total_giftcard > 0)
                    <div class="card card-body">
                        <p><strong>{{ @$labels['shop-myarea-gift-card-numero'] }}</strong></p>
                        <h3>{{ $order->number_giftcard }} </h3>
                        <p>{{ @$labels['shop-myarea-valore-consumato'] }} <strong>{{ number_format($order->total_giftcard,2, ",", ".") }} {!! $symbol !!}</strong></p>
                    </div>
                @endif

                @if($order->note)
                    <div class="card mb-3">
                        <h6 class="card-header">{{ @$labels['shop-myarea-note-ordine'] }}</h6>
                        <div class="card-body">{{ $order->note }}</div>
                    </div>
                @endif

                <div class="card mb-3">
                    <div class="row no-gutters">
                        @if($shipping)
                            <div class="col-sm-6">
                                <h6 class="card-header">{{ @$labels['shop-indirizzo-spedizione'] }}</h6>
                                <div class="card-body">
                                    <h6>{{ @$shipping->name }}</h6>
                                    <div class="d-block text-capitalize">
                                        {{ @$shipping->address1 }}
                                        @if($shipping->number_street), {{ $shipping->number_street }}@endif<br>
                                        @if($shipping->postal_code){{ $shipping->postal_code }}, @endif{{ $shipping->city }} @if($shipping->county)({{ $shipping->county }})@endif<br>
                                        <strong>{{ @$shipping->country->name }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($billing)
                            <div class="col-sm-6">
                                <h6 class="card-header">{{ @$labels['shop-myarea-indirizzo-fatturazione'] }}</h6>
                                <div class="card-body">
                                    @if($billing->business_name)
                                        <h6>{{ $billing->business_name }}</h6>
                                    @else
                                        <h6>{{ @$billing->name }}</h6>
                                    @endif

                                    <div class="d-block text-capitalize">
                                        {{ @$billing->address1 }}
                                        @if($billing->number_street), {{ $billing->number_street }}@endif<br>
                                        {{ @$billing->city }} @if($billing->county)({{ $billing->county }})@endif<br>
                                        <strong>{{ @$billing->country->name }}</strong>

                                        @if($billing->pec)
                                            <br>Pec: {{ $billing->pec }}
                                        @endif
                                        @if($billing->fiscal_code_vat)
                                            <br>P.Iva: {{ $billing->fiscal_code_vat }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

