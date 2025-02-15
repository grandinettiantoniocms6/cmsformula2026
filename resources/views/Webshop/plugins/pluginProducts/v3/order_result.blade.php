<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_ID') }}&currency=EUR"></script>

<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h1 class="page-title font-2xl my-0">{{ @$labels['shop-order-result-conferma-ordine'] }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ @$labels['shop-order-result-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['shop-order-result-conferma-ordine'] }}</li>
            </ol>
        </nav>
    </div>
</section>

<section class="page-checkout page-myarea py-4 py-lg-5">
    <div class="container-fluid container-2xl">
        <div id="error_payment"></div>
        <div class="row">
            <div class="col-lg-8">
                <?php
                $shopSetting = \App\Models\ShopSettings::first();
                ?>
                @if($shopSetting->checkout == 0)
                    <div class="alert alert-info text-center">
                        <div class="display-4"><i class="bi bi-check"></i></div>
                        <h5 class="mb-1">{{ @$labels['shop-order-inviato'] }} </h5>
                    </div>
                    <p class="text-center"><a class="btn btn-primary" href="{{ url('/myarea/orders') }}">{{ @$labels['shop-order-result-miei-ordini'] }} </a></p>
                @else

                    <?php $has_paypal = \App\Models\Payment::where("is_paypal", 1)->where("is_active", 1)->count(); ?>

                    @if(!$order->paypal_payment_id)
                        <?php $payment = \App\Models\Payment::find($order->payment_id); ?>
                        @if($payment->is_paypal && $shopSetting->checkout == 1)
                            <div class="alert alert-info text-center">
                                <div class="display-4"><i class="bi bi-info-circle"></i></div>
                                <h5 class="mb-1">{{ @$labels['shop-order-result-ordine-confermato'] }} </h5>
                                <h4 class="mt-0">{!! @$labels['shop-order-result-pay-to-paypal'] !!} </h4>
                            </div>

                            @if($has_paypal > 0)
                                <h5 class="text-center">{{ @$labels['shop-order-result-esegui-pagamento'] }} </h5>
                                <div class="pb-5 text-center"> {!! @$labels['shop-order-result-avviso-48ore-1'] !!} </div>
                                <div id="paypal-button-container" class="text-center"></div>
                            @endif
                        @else
                            @if($payment->is_contrassegno)
                                <div class="alert alert-info text-center">
                                    <div class="display-4"><i class="bi bi-info-circle"></i></div>
                                    <h5 class="mb-1">{{ @$labels['shop-order-result-ordine-confermato-2'] }}</h5>
                                    <h4 class="mt-0">{!! @$labels['shop-order-result-pay-to-contrassegno'] !!} </h4>
                                </div>

                                <h5 class="text-center mb-1">{{ @$labels['shop-order-result-grazie-2'] }}</h5>
                                <div class="pb-4 text-center">{!! @$labels['shop-order-result-avviso-48ore-2'] !!} </div>
                                <p class="text-center"><a class="btn btn-primary" href="{{ url('/myarea/orders') }}">{{ @$labels['shop-order-result-miei-ordini'] }}</a></p>

                                <h3 class="text-center mb-1">{{ @$labels['shop-order-result-annulla-ordine'] }}</h3>
                            @else
                                <div class="alert alert-info text-center">
                                    <div class="display-4"><i class="bi bi-info-circle"></i></div>
                                    <h5 class="mb-1">{{ @$labels['shop-order-result-ordine-confermato-3'] }}</h5>
                                    <h4 class="mt-0">{!! @$labels['shop-order-result-pay-to-bonifico'] !!}</h4>
                                </div>

                                <div class="card text-center p-4">{{ $order->payment->info }}</div>

                                @if($has_paypal > 0)
                                    <h6 class="text-center mb-0">{{ @$labels['shop-order-result-cambio-tipo-pagamento'] }}</h6>
                                    <h5 class="text-center">{{ @$labels['shop-order-result-scelgo-paypal'] }}</h5>
                                    <div id="paypal-button-container" class="text-center"></div>
                                @endif
                            @endif

                        @endif
                    @else
                        <div class="alert alert-info text-center">
                            <div class="display-4"><i class="bi bi-check"></i></div>
                            <h5 class="mb-1">{{ @$labels['shop-order-result-ordine-confermato-4'] }}</h5>
                            <h4 class="mt-0">{{ @$labels['shop-order-result-pagamento-ok'] }}</h4>
                        </div>
                        <h5 class="text-center mb-1">{{ @$labels['shop-order-result-grazie-3'] }}</h5>
                        <div class="pb-4 text-center">{!! @$labels['shop-order-result-avviso-48ore-3'] !!} </div>
                        <p class="text-center"><a class="btn btn-primary" href="{{ url('/myarea/orders') }}">{{ @$labels['shop-order-result-miei-ordini'] }}</a></p>
                    @endif

                @endif
            </div>
            <aside class="col-lg-4">
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h5>{{ @$labels['shop-order-result-tuo-ordine'] }}</h5>
                        @include("$thema.plugins.pluginProducts.v3.partials.checkout.checkout_order")
                        <?php
                        $lang = \App::getLocale();
                        $url = route("pluginProducts.$lang");
                        ?>
                        <a href="{{ route('order.detail') }}?order_id={{ $order->id }}" class="btn btn-success w-100"> {{ @$labels['shop-myarea-dettaglio-ordine'] }}</a>
                        <a href="{{ $url }}" class="btn btn-primary w-100"> <i class="bi bi-chevron-left"></i> {{ @$labels['shop-order-result-torna-allo-shopping'] }}</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
