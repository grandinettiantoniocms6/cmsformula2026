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
        <h3>{{ @$labels['shop-myarea-abbonamenti'] }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="bi bi-chevron-left d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['shop-myarea-abbonamenti'] }}</li>
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
                        <h5>{{ @$labels['shop-myarea-abbonamenti'] }}</h5>
                    </div>
                    <div class="card-body">
                        @if(count($orders))
                            <table class="table table-fluid">
                                    <thead>
                                    <tr>
                                        <th width="50">ID</th>
                                        <th width="300">{{ @$labels['shop-myarea-abbonamento-nome'] }}</th>
                                        <th width="200">{{ @$labels['shop-myarea-abbonamento-nominativo'] }}</th>
                                        <th width="130">{{ @$labels['shop-myarea-abbonamento-inizio'] }}</th>
                                        <th width="130">{{ @$labels['shop-myarea-abbonamento-fine'] }}</th>
                                        <th>{{ @$labels['shop-myarea-abbonamento-stato'] }}</th>
                                        <th>{{ @$labels['shop-myarea-abbonamento-ordine'] }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $now = \Carbon\Carbon::now();
                                    ?>
                                    @foreach($orders as $order)
                                        <?php
                                        if($order->end){
                                            $end = \Carbon\Carbon::createFromFormat("Y-m-d", $order->end);
                                        }
                                        ?>
                                        <tr>
                                            <td data-column="ID">#{{ $order->id }}</td>
                                            <td data-column="Abbonamento">
                                                <?php
                                                $product = \App\Models\PluginProducts::find($order->product_id);
                                                ?>
                                                @if($product)
                                                    {{ $product->name }}
                                                @endif
                                            </td>
                                            <td data-column="Nominativo">
                                                {{ $order->name }}
                                            </td>
                                            <td data-column="Inizio">{{ \Carbon\Carbon::createFromFormat("Y-m-d", $order->start)->format("d/m/Y") }}</td>
                                            <td data-column="Fine">
                                                @if($order->end)
                                                     {{ \Carbon\Carbon::createFromFormat("Y-m-d", $order->end)->format("d/m/Y") }}
                                                @endif
                                            </td>
                                            <td data-column="Status">
                                                @if(!$order->end)
                                                    <span class="text text-info">Non Attivo</span>
                                                @else
                                                    @if($now->gt($end))
                                                        <span class="text text-danger">Scaduto</span>
                                                    @else
                                                        <span class="text text-success">Attivo</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td data-column="Ordine">
                                                @if($order->order_id)
                                                    <a class="btn btn-primary btn-sm mx-1 mx-md-0" href="{{ route('order.detail') }}?order_id={{ $order->order_id }}"><span data-bs-toggle="tooltip" title="{{ @$labels['shop-myarea-dettaglio-ordine'] }}"><i class="fas fa-file-invoice"></i></span></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                        @else
                            <div class="py-4 text-center">
                                <div class="display-4 text-muted"><i class="fab fa-creative-commons-nc-eu"></i></div>
                                <h5 class="mb-4">{{ @$labels['shop-myarea-nessun-abbonamento-trovato'] }}.</h5>
                                <a class="btn btn-primary" href="{{ route('index') }}">{{ @$labels['shop-continua-acquisti'] }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
