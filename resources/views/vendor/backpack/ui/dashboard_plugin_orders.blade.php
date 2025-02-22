@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" crossorigin="anonymous" />
@endsection

@section('content')

    @if(backpack_user()->roles[0]->id <= 3)
    <!-- Add by Antonio -->
       <div class="row mt-4">
          <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="{{ backpack_url('pluginOrders') }}/planning"> <img src="/img/icons/icona-calendario-new.png"><br>
                                Calendario
                        </a>
                    </div>
                </div>
            </div>
         </div><!-- /.col-->

           <div class="col-sm-4 col-xl-2">
               <div class="card text-white">
                   <div class="card-body">
                       <div class="card-wrapper" style="text-align: center; width: 100%;">
                           <a href="{{ backpack_url('pluginOrdersClients') }}/create"> <img src="/img/icons/icona-nuovo-cliente-new.png"><br>
                               Aggiungi Cliente
                           </a>
                       </div>
                   </div>
               </div>
           </div><!-- /.col-->

           <div class="col-sm-4 col-xl-2">
               <div class="card text-white">
                   <div class="card-body">
                       <div class="card-wrapper" style="text-align: center; width: 100%;">
                           <a href="{{ backpack_url('pluginOrdersProducts') }}/create"> <img src="/img/icons/icona-nuovo-prodotto-new.png"><br>
                               Aggiungi Prodotto
                           </a>
                       </div>
                   </div>
               </div>
           </div><!-- /.col-->

           <div class="col-sm-4 col-xl-2">
               <div class="card text-white">
                   <div class="card-body">
                       <div class="card-wrapper" style="text-align: center; width: 100%;">
                           <a href="{{ backpack_url('pluginOrdersCategories') }}/create"> <img src="/img/icons/icona-categorie-new.png"><br>
                               Aggiungi Categoria
                           </a>
                       </div>
                   </div>
               </div>
           </div><!-- /.col-->

           <div class="col-sm-4 col-xl-2">
               <div class="card text-white">
                   <div class="card-body">
                       <div class="card-wrapper" style="text-align: center; width: 100%;">
                           <a href="{{ backpack_url('pluginOrdersProducts') }}"> <img src="/img/icons/icona-prodotti-new.png"><br>
                               Elenco Prodotti
                           </a>
                       </div>
                   </div>
               </div>
           </div><!-- /.col-->

           <div class="col-sm-4 col-xl-2">
               <div class="card text-white">
                   <div class="card-body">
                       <div class="card-wrapper" style="text-align: center; width: 100%;">
                           <a href="{{ backpack_url('pluginOrdersClients') }}"> <img src="/img/icons/icona-elenco-clienti-new.png"><br>
                               Elenco Clienti
                           </a>
                       </div>
                   </div>
               </div>
           </div><!-- /.col-->
    </div>
    <!-- / Antonio -->
    @endif

    <div class="row">
        @if(backpack_user()->roles[0]->id <= 3)
        <!-- /.col-->
        <div class="col-sm-4">
            <h5>Situazione ordini del giorno ({{ \Carbon\Carbon::now()->format("d/m/Y") }})</h5>
            <?php
            $status = \App\Models\PluginOrdersStatuses::get();
            $now = \Carbon\Carbon::now()->toDateString();
            ?>
            @if($status)
                @foreach($status as $s)
                    <?php
                    $count = \App\Models\PluginOrders::where("plugin_order_status_id", $s->id)->where("date_delivery", "=", $now)->count();
                    ?>
                    <div class="card text-white" style="background-color:{{ $s->color }};">
                        <a href="{{ backpack_url('pluginOrders') }}?s={{ $s->id }}&date={{ $now }}" class="text-white">
                            <div class="card-body">
                                <div class="text-value">{{ $count }}</div>
                                <div>{{ $s->name }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">Statistiche</div>
                <div class="card-body">
                    <?php

                    $month = \Carbon\Carbon::now()->format("m-Y");
                    $last_7_days = [];

                    for($i=6; $i>=0; $i--){
                        $dd = \Carbon\Carbon::now()->subDays($i)->toDateString();
                        $vendite_7_days = \App\Models\PluginOrders::whereRaw("(date_delivery >= '$dd' AND date_delivery <= '$dd')")->sum("total");
                        $last_7_days[$dd] = $vendite_7_days;
                    }


                    $year = \Carbon\Carbon::now()->format("Y");
                    $list = \App\Models\PluginOrders::selectRaw("SUBSTRING(date_delivery,6,2) as date_order_month, sum(total) as sum_total")
                        ->whereRaw("(date_delivery >= '".$year."-01-01' AND date_delivery <= '".$year."-12-31')")
                        ->groupBy("date_order_month")
                        ->get()
                        ->pluck("sum_total","date_order_month")
                        ->toArray();

                    $month = ["01" => "Gennaio", "02" => "Febbraio", "03"=>"Marzo", "04" => "Aprile", "05" => "Maggio", "06" => "Giugno",
                        "07" => "Luglio", "08" => "Agosto", "09" => "Settembre", "10" => "Ottobre", "11" => "Novembre", "12" => "Dicembre"];
                    ?>


                    <div class="row">
                        <div class="col-sm-3">
                            <h5>Ultimi 7 giorni</h5>
                            <table width="100%" class="table table-responsive">
                                @foreach($last_7_days as $k=> $v)
                                    <tr>
                                        <td>
                                            {{ \Carbon\Carbon::createFromFormat("Y-m-d", $k)->format("d/m/Y") }}
                                        </td>
                                        <td class="float-right">
                                            {{ number_format($v, 2, ",", ".") }} &euro;
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="col-sm-3">
                            <h5>Andamento mensile</h5>
                            <table width="100%" class="table table-responsive">
                                @foreach($list as $k=> $v)
                                    <tr>
                                        <td>
                                            {{ $month[$k] }}
                                        </td>
                                        <td class="text-right">
                                            @if(key_exists($k, $list))
                                              {{ number_format($list[$k], 2, ",", ".") }} &euro;
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="col-sm-3">
                            <?php
                            $list = \App\Models\PluginOrdersDetail::selectRaw("COUNT(*) as tot, plugin_product_id, plugins_orders_products.name")
                                ->join("plugins_orders", "plugins_orders.id", "=", "plugins_orders_details.plugin_order_id")
                                ->join("plugins_orders_products", "plugins_orders_products.id", "=", "plugins_orders_details.plugin_product_id")
                                ->whereNull("plugins_orders.deleted_at")
                                ->groupBy("plugin_product_id")
                                ->groupBy("plugins_orders_products.name")
                                ->orderBy("tot", "desc")
                                ->take(10)
                                ->get();
                            ?>

                           <h5>Top 10 prodotti</h5>
                            @if($list)
                                <table width="100%" class="table table-responsive">
                                    @foreach($list as $v)
                                        <tr>
                                            <td>
                                                {{ $v->name }}
                                            </td>
                                            <td class="text-right">
                                                {{ $v->tot }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>

                        <div class="col-sm-3">
                            <?php
                            $list = \App\Models\PluginOrdersDetail::selectRaw("COUNT(*) as tot, plugin_category_id, plugins_orders_categories.name")
                                ->join("plugins_orders", "plugins_orders.id", "=", "plugins_orders_details.plugin_order_id")
                                ->join("plugins_orders_categories", "plugins_orders_categories.id", "=", "plugins_orders_details.plugin_category_id")
                                ->whereNull("plugins_orders.deleted_at")
                                ->groupBy("plugin_category_id")
                                ->groupBy("plugins_orders_categories.name")
                                ->orderBy("tot", "desc")
                                ->take(10)
                                ->get();
                            ?>

                            <h5>Classifica reparti</h5>
                            @if($list)
                                <table width="100%" class="table table-responsive">
                                    @foreach($list as $v)
                                        <tr>
                                            <td>
                                                {{ $v->name }}
                                            </td>
                                            <td class="text-right">
                                                {{ $v->tot }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else

            <?php
            $status = \App\Models\PluginOrdersStatuses::get();
            $now = \Carbon\Carbon::now()->toDateString();
            ?>
             @if($status)
                @foreach($status as $s)
                    <?php
                    $count = \App\Models\PluginOrders::where("plugin_order_status_id", $s->id)->where("date_delivery", "=", $now)->count();
                    ?>
                    <div class="col-sm-2">
                        <div class="card text-white" style="background-color:{{ $s->color }};">
                            <a href="{{ backpack_url('pluginOrders') }}?s={{ $s->id }}&date={{ $now }}" class="text-white">
                                <div class="card-body">
                                    <div class="text-value">{{ $count }}</div>
                                    <div>{{ $s->name }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        @endif
    </div>
@endsection

@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
@endsection

