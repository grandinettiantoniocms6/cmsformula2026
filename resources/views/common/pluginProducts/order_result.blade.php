<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
<main>
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_ID') }}&currency=EUR"></script>

    <section class="section-page-header bg-light py-4 border-bottom">
        <div class="container">
            <h2 class="h3">{{ @$labels['shop-order-result-conferma-ordine'] }}</h2>
            <nav>
                <ol class="breadcrumb bg-transparent p-0 my-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ @$labels['shop-order-result-home'] }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ @$labels['shop-order-result-conferma-ordine'] }}</li>
                </ol>
            </nav>
        </div> <!-- container //  -->
    </section>

    <section class="py-4">
        <div class="container">

            <div class="row">
                <main class="col-12 col-lg-7">

                    <div class="wizard clearfix">
                        <section class="mb-3">
                            <div id="error_payment"></div>
                                <?php
                                $shopSetting = \App\Models\ShopSettings::first();
                                ?>
                                @if($shopSetting->checkout == 0)
                                <div class="alert alert-info text-center">
                                    <div class="display-4"><i class="fa fa-check"></i></div>
                                    <h5 class="mb-1">{{ @$labels['shop-order-inviato'] }} </h5>
                                </div>
                                <p class="text-center"><a class="btn btn-primary" href="{{ url('/myarea/orders') }}">{{ @$labels['shop-order-result-miei-ordini'] }} </a></p>
                                @else
                                @if(!$order->paypal_payment_id)
                                    <?php
                                    $payment = \App\Models\Payment::find($order->payment_id);
                                    ?>
                                    @if($payment->is_paypal && $shopSetting->checkout == 1)
                                        <div class="alert alert-info text-center">
                                            <div class="display-4"><i class="fas fa-info-circle"></i></div>
                                            <h5 class="mb-1">{{ @$labels['shop-order-result-ordine-confermato'] }} </h5>
                                            <h4 class="mt-0">{!! @$labels['shop-order-result-pay-to-paypal'] !!} </h4>
                                        </div>

                                        <h5 class="text-center">{{ @$labels['shop-order-result-esegui-pagamento'] }} </h5>
                                        <div class="pb-5 text-center"> {!! @$labels['shop-order-result-avviso-48ore-1'] !!} </div>
                                        <div id="paypal-button-container"></div>
                                    @else
                                        @if($payment->is_contrassegno)
                                            <div class="alert alert-info text-center">
                                                <div class="display-4"><i class="fas fa-info-circle"></i></div>
                                                <h5 class="mb-1">{{ @$labels['shop-order-result-ordine-confermato-2'] }}</h5>
                                                <h4 class="mt-0">{!! @$labels['shop-order-result-pay-to-contrassegno'] !!} </h4>
                                            </div>

                                            <h5 class="text-center mb-1">{{ @$labels['shop-order-result-grazie-2'] }}</h5>
                                            <div class="pb-4 text-center">{!! @$labels['shop-order-result-avviso-48ore-2'] !!} </div>
                                            <p class="text-center"><a class="btn btn-primary" href="{{ url('/myarea/orders') }}">{{ @$labels['shop-order-result-miei-ordini'] }}</a></p>

                                            <h3 class="text-center mb-1">{{ @$labels['shop-order-result-annulla-ordine'] }}</h3>
                                        @else
                                            <div class="alert alert-info text-center">
                                                <div class="display-4"><i class="fas fa-info-circle"></i></div>
                                                <h5 class="mb-1">{{ @$labels['shop-order-result-ordine-confermato-3'] }}</h5>
                                                <h4 class="mt-0">{!! @$labels['shop-order-result-pay-to-bonifico'] !!}</h4>
                                            </div>

                                            <div class="jumbotron text-break text-center py-5 h4 font-weight-normal">{{ $order->payment->info }}</div>

                                            <hr/>
                                            <h6 class="text-center mb-0">{{ @$labels['shop-order-result-cambio-tipo-pagamento'] }}</h6>
                                            <h5 class="text-center">{{ @$labels['shop-order-result-scelgo-paypal'] }}</h5>
                                            <div id="paypal-button-container"></div>
                                        @endif

                                    @endif
                                @else
                                    <div class="alert alert-info text-center">
                                        <div class="display-4"><i class="fa fa-check"></i></div>
                                        <h5 class="mb-1">{{ @$labels['shop-order-result-ordine-confermato-4'] }}</h5>
                                        <h4 class="mt-0">{{ @$labels['shop-order-result-pagamento-ok'] }}</h4>
                                    </div>
                                    <h5 class="text-center mb-1">{{ @$labels['shop-order-result-grazie-3'] }}</h5>
                                    <div class="pb-4 text-center">{!! @$labels['shop-order-result-avviso-48ore-3'] !!} </div>
                                    <p class="text-center"><a class="btn btn-primary" href="{{ url('/myarea/orders') }}">{{ @$labels['shop-order-result-miei-ordini'] }}</a></p>
                                @endif

                           @endif

                        </section>
                    </div>

                </main> <!-- col.// -->

                <aside class="col-12 col-lg-5">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="my-0">{{ @$labels['shop-order-result-tuo-ordine'] }}</h5>
                        </div>
                        <div class="card-table">
                            @include('common.pluginProducts.partials.checkout.checkout_order')
                        </div>
                        <div class="card-body border-top bg-light py-0">
                            <a href="{{ route('index') }}" class="btn btn-outline-primary btn-block my-2"> <i class="fa fa-chevron-left mr-2"></i> {{ @$labels['shop-order-result-torna-allo-shopping'] }}</a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

</main>
