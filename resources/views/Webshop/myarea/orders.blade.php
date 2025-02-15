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
        <h3>{{ @$labels['shop-myarea-ordini'] }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="bi bi-chevron-left d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['shop-myarea-ordini'] }}</li>
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
                <div class="card card-myarea">
                    <div class="card-header">
                        <h5>{{ @$labels['shop-myarea-storico-ordini'] }}</h5>
                    </div>
                    <div class="card-body">
                        @if(count($orders))
                            <table class="table table-fluid">
                                    <thead>
                                    <tr>
                                        <th width="50" class="text-end">{{ @$labels['shop-myarea-ordine'] }}</th>
                                        <th width="200">{{ @$labels['shop-myarea-data-ora'] }}</th>
                                        <th width="130">{{ @$labels['shop-myarea-stato-ordine'] }}</th>
                                        <th class="text-end">{{ @$labels['shop-myarea-totale-ordine'] }}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td data-column="Ordine" class="text-end"><a href="{{ route('order.detail') }}?order_id={{ $order->id }}" title="Ordine #{{ $order->id }}">#{{ $order->id }}</a></td>
                                            <td data-column="Data e ora">{{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $order->created_at)->format("d/m/Y H:i") }}</td>
                                            <td data-column="Status">
                                                @if($order->status)
                                                    <strong>{{ $order->status->name }}</strong>
                                                @endif
                                            </td>
                                            <td class="text-end" data-column="Totale">{!! $symbol !!} {{ number_format(($order->total_tax - $order->total_coupon - $order->total_giftcard) + $order->total_shipping_tax + $order->total_extra,2, ',','.') }}</td>
                                            <td class="text-end" data-column="Azioni">
                                                <a class="btn btn-primary btn-sm mx-1 mx-md-0" href="{{ route('order.detail') }}?order_id={{ $order->id }}"><span data-bs-toggle="tooltip" title="{{ @$labels['shop-myarea-dettaglio-ordine'] }}"><i class="fas fa-file-invoice"></i></span></a>
                                                <a class="btn btn-primary btn-sm" href="{{ route('myarea.support') }}"><span data-bs-toggle="tooltip" title="{{ @$labels['shop-myarea-richiedi-assistenza-ordine'] }}"><i class="fas fa-life-ring"></i></span></a>

                                                <?php
                                                $shopSetting = \App\Models\ShopSettings::first();
                                                $payment = \App\Models\Payment::where("is_paypal", 1)->first();
                                                ?>
                                                @if($payment)
                                                    @if($order->status_id == $shopSetting->status_default_nonpagato && ($order->payment_id == $payment->id))
                                                        <a class="btn btn-success btn-sm ms-1 ms-md-0" href="{{ route("order.result") }}?order_id={{ $order->id }}"><span data-bs-toggle="tooltip" title="{{ @$labels['shop-myarea-paga-adesso'] }}"><i class="fas fa-money-check-alt"></i> {{ @$labels['shop-myarea-'] }}{{ @$labels['shop-myarea-paga-adesso'] }}</span></a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                        @else
                            <div class="py-4 text-center">
                                <div class="display-4 text-muted"><i class="fab fa-creative-commons-nc-eu"></i></div>
                                <h5 class="mb-4">{{ @$labels['shop-myarea-nessun-ordine-trovato'] }}.</h5>
                                <a class="btn btn-primary" href="{{ route('index') }}">{{ @$labels['shop-continua-acquisti'] }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
