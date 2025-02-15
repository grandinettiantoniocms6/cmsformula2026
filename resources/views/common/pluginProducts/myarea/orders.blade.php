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
<main>
    <section class="section-page-header bg-light py-4 border-bottom">
        <div class="container">
            <h2 class="h3">{{ @$labels['shop-myarea-ordini'] }}</h2>
            <nav>
                <ol class="breadcrumb bg-transparent p-0 my-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-angle-left mr-2 d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                    <li class="breadcrumb-item d-none d-md-block active" aria-current="page">{{ @$labels['shop-myarea-ordini'] }}</li>
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

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="my-0">{{ @$labels['shop-myarea-storico-ordini'] }}</h5>
                        </div>
                        <div class="card-table">
                            @if(count($orders))
                                <div class="m-1 m-md-0">
                                    <table class="table table-fluid my-0">
                                        <thead>
                                        <tr>
                                            <th>{{ @$labels['shop-myarea-ordine'] }}</th>
                                            <th>{{ @$labels['shop-myarea-data-ora'] }}</th>
                                            <th width="130">{{ @$labels['shop-myarea-stato-ordine'] }}</th>
                                            <th width="130">{{ @$labels['shop-myarea-totale-ordine'] }}</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td class="align-middle" data-column="Ordine" data-fluid="100"><a href="{{ route('order.detail', $order->id) }}" title="Ordine #{{ $order->id }}">#{{ $order->id }}</a></td>
                                                <td class="align-middle" data-column="Data e ora" data-fluid="100">{{ $order->created_at }}</td>
                                                <td class="align-middle" data-column="Status" data-fluid="100">
                                                    @if($order->status)
                                                    <span class="font-weight-normal badge badge-{{ $order->status->className }}">{{ $order->status->name }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle" data-column="Totale" data-fluid="100">{!! $symbol !!} {{ number_format(($order->total_tax - $order->total_coupon - $order->total_giftcard) + $order->total_shipping_tax + $order->total_extra,2, ',','.') }}</td>
                                                <td class="align-middle text-right" data-column="Azioni" data-fluid="100">
                                                    <a class="btn btn-primary btn-sm mx-1 mx-md-0" href="{{ route('order.detail') }}?order_id={{ $order->id }}"><span data-toggle="tooltip" title="{{ @$labels['shop-myarea-dettaglio-ordine'] }}"><i class="fas fa-file-invoice"></i></span></a>
                                                    <a class="btn btn-primary btn-sm" href="{{ route('myarea.support') }}"><span data-toggle="tooltip" title="{{ @$labels['shop-myarea-richiedi-assistenza-ordine'] }}"><i class="fas fa-life-ring"></i></span></a>

                                                    <?php
                                                    $shopSetting = \App\Models\ShopSettings::first();
                                                    $payment = \App\Models\Payment::where("is_paypal", 1)->first();
                                                    ?>
                                                    @if($payment)
                                                        @if($order->status_id == $shopSetting->status_default_nonpagato && ($order->payment_id == $payment->id))
                                                            <a class="btn btn-success btn-sm ml-1 ml-md-0" href="{{ route("order.result") }}?order_id={{ $order->id }}"><span data-toggle="tooltip" title="{{ @$labels['shop-myarea-paga-adesso'] }}"><i class="fas fa-money-check-alt"></i> {{ @$labels['shop-myarea-'] }}{{ @$labels['shop-myarea-paga-adesso'] }}</span></a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="py-4 text-center my-0">
                                    <div class="display-4 text-muted"><i class="fab fa-creative-commons-nc-eu"></i></div>
                                    <h5 class="mb-4">{{ @$labels['shop-myarea-nessun-ordine-trovato'] }}.</h5>
                                    <a class="btn btn-primary btn-sm" href="{{ route('index') }}">{{ @$labels['shop-continua-acquisti'] }}</a>
                                </div>
                            @endif
                        </div>
                    </div>

                </main>
            </div>
        </div>
    </section>

</main>
