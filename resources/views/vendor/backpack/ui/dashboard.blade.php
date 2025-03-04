@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="{{ url("css/admin.css") }}">
@endsection

@section('content')

    <?php
    $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->where("is_active", 1)->first();
    $adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
    $adminPluginParking = \App\Models\AdminPlugin::where("name", "pluginParking")->where("is_active", 1)->first();
    ?>

    <?php
    $block_count = \App\Models\PageBlock::join("pages", "pages.id", "=", "blocks_pages.page_id")
        ->whereNull("pages.deleted_at")
        ->whereNull("is_ereditable_from_id")->count();
    ?>

    <!-- Add by Antonio -->
    @if(env('NASCONDI_FRONTEND') == 0)
    <div class="row gutter-2 mt-4">
        @if(backpack_user()->roles[0]->id != 4)
            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/page/create"> <img src="/img/icons/crea-pagina-03.png"><br>
                                Nuova pagina
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->
        @endif

        <div class="col-sm-4 col-xl-2">
            <div class="card text-white">
                <div class="card-body">
                    <div class="card-wrapper" style="text-align: center; width: 100%;">
                        <a href="/admin/page"> <img src="/img/icons/elenco-pagine-03.png"><br>
                            Elenco Pagine
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- /.col-->

        @if(backpack_user()->roles[0]->id != 4)
            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/elfinder"> <img src="/img/icons/media-03.png"><br>
                                File Manager
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->
        @endif

        @if(backpack_user()->roles[0]->id != 4 && backpack_user()->roles[0]->id != 3)
        <div class="col-sm-4 col-xl-2">
            <div class="card text-white">
                <div class="card-body">
                    <div class="card-wrapper" style="text-align: center; width: 100%;">
                        <a href="/admin/websiteSetting/1/edit"> <img src="/img/icons/setting-03.png"><br>
                            Impostazioni
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- /.col-->
        @endif

        <div class="col-sm-4 col-xl-2">
            <div class="card text-white">
                <div class="card-body">
                    <div class="card-wrapper" style="text-align: center; width: 100%;">
                        <a href="/admin/pluginTutorial/view"> <img src="/img/icons/videotut-03.png"><br>
                            Tutorial
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- /.col-->

        <div class="col-sm-4 col-xl-2">
            <div class="card text-white">
                <div class="card-body">
                    <div class="card-wrapper" style="text-align: center; width: 100%;">
                        <a href="https://www.webisland.it/contatti" target="_blank"> <img src="/img/icons/supporto-03.png"><br>
                            Richiedi Assistenza
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- /.col-->

    </div>
    <!-- / Antonio -->

    <div class="row gutter-2">

        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">Grafico risorse CMS</div>
                <div class="card-body">
                    <canvas id="pieChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="row gutter-2">

                <div class="col-sm-6">

                    <div class="card text-white bg-dark mb-2">
                        <div class="card-body">
                            <?php
                            function formatSize($bytes){
                                $kb = 1024;
                                $mb = $kb * 1024;
                                $gb = $mb * 1024;
                                $tb = $gb * 1024;
                                if (($bytes >= 0) && ($bytes < $kb)) {
                                    return $bytes . ' B';
                                } elseif (($bytes >= $kb) && ($bytes < $mb)) {
                                    return ceil($bytes / $kb) . ' KB';
                                } elseif (($bytes >= $mb) && ($bytes < $gb)) {
                                    return ceil($bytes / $mb) . ' MB';
                                } elseif (($bytes >= $gb) && ($bytes < $tb)) {
                                    return ceil($bytes / $gb) . ' GB';
                                } elseif ($bytes >= $tb) {
                                    return ceil($bytes / $tb) . ' TB';
                                } else {
                                    return $bytes . ' B';
                                }
                            }

                            function folderSize($dir){
                                $total_size = 0;
                                $count = 0;
                                $dir_array = scandir($dir);
                                foreach($dir_array as $key=>$filename){
                                    if($filename!=".." && $filename!="."){
                                        if(is_dir($dir."/".$filename)){
                                            $new_foldersize = foldersize($dir."/".$filename);
                                            $total_size = $total_size+ $new_foldersize;
                                        }else if(is_file($dir."/".$filename)){
                                            $total_size = $total_size + filesize($dir."/".$filename);
                                            $count++;
                                        }
                                    }
                                }
                                return $total_size;
                            }
                            $folder_path = public_path("/uploads");
                            $size = formatSize(folderSize($folder_path));
                            ?>
                            <div class="text-value">{{ $size }}</div>
                            <div>Spazio Server occupato</div>
                            <div class="progress progress-white progress-xs my-2">
                            </div>
                            <small>Ti server più spazio? <a href="https://www.webisland.it/contatti" target="_blank" class="text text-white">Contattaci</a></small>
                        </div>
                    </div>

                    <?php
                    $user_count = \App\User::join("model_has_roles", "model_has_roles.model_id", "=", "users.id")
                        ->whereIn("model_has_roles.role_id", [1])
                        ->count();
                    ?>
                    @if($adminPlugin)
                        <div class="card text-white bg-info mb-2">
                            @if($adminPlugin->version == 3)
                                <div class="card-body">
                                    <?php
                                    $user_count = \App\User::join("model_has_roles", "model_has_roles.model_id", "=", "users.id")
                                        ->whereIn("model_has_roles.role_id", [2,3,4])
                                        ->count();
                                    ?>
                                    <div class="text-value"><?php echo $user_count;?></div>
                                    <div>Amministratori</div>
                                    <div class="progress progress-white progress-xs my-2">
                                    </div>
                                    <small class="text-muted">Totale degli utenti registrati (Tutti i ruoli)</small>
                                </div>
                            @else
                                <div class="card-body">
                                    <?php
                                    $user_count = \App\User::join("model_has_roles", "model_has_roles.model_id", "=", "users.id")
                                        ->whereIn("model_has_roles.role_id", [2,3,4])
                                        ->count();
                                    ?>
                                    <div class="text-value"><?php echo $user_count; ?></div>
                                    <div>Amministratori</div>
                                    <div class="progress progress-white progress-xs my-2">
                                    </div>
                                    <small class="text-muted">Totale degli utenti registrati (Tutti i ruoli)</small>
                                </div>
                            @endif
                        </div>

                        @if($adminPlugin->version == 3)
                            <div class="card text-white bg-success mb-2">
                                <div class="card-body">
                                    <?php
                                    $order_count = \App\Models\Order::count();
                                    ?>
                                    <div class="text-value">{{ $order_count }}</div>
                                    <div>Ordini Ricevuti</div>
                                    <div class="progress progress-white progress-xs my-2">
                                    </div><small class="text-muted">Numero Ordini ricevuti fino ad oggi</small>
                                </div>
                            </div>

                            <div class="card text-white bg-success mb-2">
                                <div class="card-body">
                                    <?php
                                    $order_sum = \App\Models\Order::sum("total_tax");
                                    ?>
                                    <div class="text-value">{{ number_format($order_sum,2,",",".") }} &euro;</div>
                                    <div>Ordini Ricevuti</div>
                                    <div class="progress progress-white progress-xs my-2">
                                    </div><small class="text-muted">Totale Ordini ricevuti fino ad oggi</small>
                                </div>
                            </div>
                        @endif
                    @endif


                    @if($adminPluginBooking)
                        <div class="card text-white bg-success mb-2">
                            <div class="card-body">
                                <?php
                                $year = \Carbon\Carbon::now()->format("Y");

                                $status = \App\Models\PluginBookingStatus::where("is_completato", 1)->first();
                                if($status){
                                    $prenotazioni_count = \App\Models\PluginBookingReservation::whereRaw("created_at >= '$year-01-01 00:00:00' and created_at <= '$year-12-31 23:59:59'")
                                        ->where("plugin_booking_status_id", $status->id)
                                        ->count();
                                }else{
                                    $prenotazioni_count = \App\Models\PluginBookingReservation::whereRaw("created_at >= '$year-01-01 00:00:00' and created_at <= '$year-12-31 23:59:59'")
                                        ->count();
                                }
                                ?>
                                <div class="text-value"><?php echo $prenotazioni_count;?></div>
                                <div><a href="/admin/plugin-booking-reservation" class="text text-white">Prenotazioni</a></div>
                                <div class="progress progress-white progress-xs my-2">
                                </div>
                                <small class="text-muted">Tutte le prenotazioni anno {{ $year }}</small>
                            </div>
                        </div>

                        <div class="card text-white bg-success mb-2">
                            <div class="card-body">
                                    <?php
                                    $year = \Carbon\Carbon::now()->format("Y");

                                    $status = \App\Models\PluginBookingStatus::where("is_completato", 1)->first();
                                    if($status){
                                        $prenotazioni_total = \App\Models\PluginBookingReservation::whereRaw("created_at >= '$year-01-01 00:00:00' and created_at <= '$year-12-31 23:59:59'")
                                            ->where("plugin_booking_status_id", $status->id)
                                            ->sum("total");
                                    }else{
                                        $prenotazioni_total = \App\Models\PluginBookingReservation::whereRaw("created_at >= '$year-01-01 00:00:00' and created_at <= '$year-12-31 23:59:59'")
                                            ->sum("total");
                                    }
                                    ?>
                                <div class="text-value"><?php echo number_format($prenotazioni_total,2,",", "."); ?> &euro;</div>
                                <div><a href="/admin/plugin-booking-reservation" class="text text-white">Totale</a></div>
                                <div class="progress progress-white progress-xs my-2">
                                </div>
                                <small class="text-muted">Tutte le prenotazioni anno {{ $year }}</small>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- /.col-->
                <div class="col-sm-6">
                    <div class="card text-white bg-dark mb-2">
                        <div class="card-body">
                            <?php
                            $page_count = \App\Models\Page::count();
                            $websetting = \App\Models\WebsiteSetting::first();
                            $perc = ($page_count * 100) / $websetting->number_max_page;
                            ?>
                            <div class="text-value">{{ $page_count }} su {{ $websetting->number_max_page }} disponibili</div>
                            <div>Pagine create</div>
                            <div class="progress progress-white progress-xs my-2">
                                <div class="progress-bar" role="progressbar" style="width: {{ round($perc,1) }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div><small class="text-muted">Ti servono pagine illimitate? <a href="https://www.webisland.it/contatti" target="_blank" class="text text-white">Contattaci</a></small>
                        </div>
                    </div>

                    @if($adminPlugin)
                        <div class="card text-white bg-info mb-2">
                            <div class="card-body">
                                @if($adminPlugin->version == 3)
                                    <?php
                                    $user_count = \App\User::join("model_has_roles", "model_has_roles.model_id", "=", "users.id")
                                        ->where("model_has_roles.role_id", 5)
                                        ->count();
                                    ?>
                                    <div class="text-value"><?php echo $user_count;?></div>
                                    <div>Clienti</div>

                                    <div class="progress progress-white progress-xs my-2">
                                    </div>
                                    <small class="text-muted">Totale Clienti Registrati</small>
                                @else

                                    <div class="text-value">{{ $block_count }}</div>
                                    <div>Blocchi Creati</div>
                                    <div class="progress progress-white progress-xs my-2">
                                    </div><small class="text-muted">Blocchi creati nelle pagine</small>
                                @endif

                            </div>
                        </div>


                        @if($adminPlugin->version == 3)
                            <div class="card text-white bg-success mb-2">
                                <div class="card-body">
                                    <?php
                                    $product_count = \App\Models\PluginProducts::count();
                                    ?>
                                    <div class="text-value">{{ $product_count }}</div>
                                    <div>Prodotti Inseriti</div>
                                    <div class="progress progress-white progress-xs my-2">
                                    </div><small class="text-muted">Totale dei prodotti inseriti</small>
                                </div>
                            </div>
                        @endif
                    @endif

                    @if($adminPluginBooking)
                        <div class="card text-white bg-success mb-2">
                            <div class="card-body">
                                <?php
                                $client_count = \App\User::join("model_has_roles", "model_has_roles.model_id", "=", "users.id")
                                    ->whereIn("model_has_roles.role_id", [5])
                                    ->count();
                                ?>
                                <div class="text-value"><?php echo $client_count;?></div>
                                <div><a href="/admin/pluginBookingClients" class="text text-white">Clienti</a></div>
                                <div class="progress progress-white progress-xs my-2">
                                </div>
                                <small class="text-muted">Tutte i clienti registrati</small>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>

        @if($adminPlugin && $adminPlugin->version == 3)
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Ultimi 5 ordini <span class="text float-right"><a href="/admin/shopOrders">Visualizza tutti</a></span></div>
                    <div class="card-body p-2">
                        <?php
                        $list = \App\Models\Order::with("user")->orderBy("created_at", "desc")->take(5)->get();
                        ?>
                        @if($list)
                            <table class="table table-md mb-0">
                                <thead>
                                    <tr><th>ID</th><th>Cliente</th><th>Stato</th><th>Totale</th><th>Spedizione</th><th>Data ordine</th><th></th></tr>
                                </thead>
                                @foreach($list as $order)
                                    <tr>
                                        <td>
                                            {{ $order->id }}
                                        </td>
                                        <td>
                                            @if($order->user)
                                                {{ $order->user->name }}
                                            @else
                                                Utente cancellato
                                            @endif
                                        </td>
                                        <td>
                                            {!! $order->get_status() !!}
                                        </td>
                                        <td>
                                            {!! $order->get_total() !!}
                                        </td>
                                        <td>
                                            {{ number_format($order->total_shipping_tax, 2, ",", ".") }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $order->created_at)->format("d/m/Y H:i") }}
                                        </td>
                                        <td>
                                            <a class="btn btn-default btn-sm" href="/admin/shopOrders/{{ $order->id }}/show">Visualizza</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Statistiche</div>
                    <div class="card-body p-2">
                        <?php

                        $month = \Carbon\Carbon::now()->format("m-Y");
                        $last_7_days = [];

                        for($i=6; $i>=0; $i--){
                            $dd = \Carbon\Carbon::now()->subDays($i)->toDateTimeString();
                            $vendite_7_days = \App\Models\Order::whereRaw("(created_at >= '$dd' AND created_at <= '$dd')")->sum("total");
                            $last_7_days[$dd] = $vendite_7_days;
                        }


                        $year = \Carbon\Carbon::now()->format("Y");
                        $list = \App\Models\Order::selectRaw("SUBSTRING(created_at,6,2) as date_order_month, sum(total) as sum_total")
                            ->whereRaw("(created_at >= '".$year."-01-01 00:00:00' AND created_at <= '".$year."-12-31 23:59:59')")
                            ->groupBy("date_order_month")
                            ->get()
                            ->pluck("sum_total","date_order_month")
                            ->toArray();

                        $month = ["01" => "Gennaio", "02" => "Febbraio", "03"=>"Marzo", "04" => "Aprile", "05" => "Maggio", "06" => "Giugno",
                            "07" => "Luglio", "08" => "Agosto", "09" => "Settembre", "10" => "Ottobre", "11" => "Novembre", "12" => "Dicembre"];

                        ?>


                        <div class="row gutter-2">
                            <div class="col-sm-3">
                                <div class="table-responsive">
                                    <table class="table table-md mb-0">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Ultimi 7 giorni</th>
                                            </tr>
                                        </thead>
                                        @foreach($last_7_days as $k=> $v)
                                            <tr>
                                                <td>
                                                    {{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $k)->format("d/m/Y") }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($v, 2, ",", ".") }} &euro;
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="table-responsive">
                                <table class="table table-md mb-0">
                                    <thead>
                                    <tr>
                                        <th colspan="2">Andamento mensile</th>
                                    </tr>
                                    </thead>
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
                            </div>
                            <div class="col-sm-3">
                                <?php
                                $list = \App\Models\OrderProduct::selectRaw("COUNT(*) as tot, product_id, plugins_products.name")
                                    ->join("shop_orders", "shop_orders.id", "=", "shop_order_product.order_id")
                                    ->join("plugins_products", "plugins_products.id", "=", "shop_order_product.product_id")
                                    ->whereNull("shop_orders.deleted_at")
                                    ->groupBy("product_id")
                                    ->groupBy("plugins_products.name")
                                    ->orderBy("tot", "desc")
                                    ->take(10)
                                    ->get();
                                ?>
                                @if($list)
                                    <div class="table-responsive">
                                        <table class="table table-md mb-0">
                                            <thead>
                                            <tr>
                                                <th colspan="2">Top 10 prodotti</th>
                                            </tr>
                                            </thead>
                                            @foreach($list as $v)
                                                <?php
                                                $name = json_decode($v->name, true);
                                                ?>
                                                <tr>
                                                    <td>
                                                        {{ $name['it'] }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ $v->tot }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <div class="col-sm-3">
                                <?php
                                $list = \App\Models\Order::selectRaw("COUNT(*) as tot, shop_orders.user_id, users.name")
                                    ->join("users", "users.id", "=", "shop_orders.user_id")
                                    ->whereNull("shop_orders.deleted_at")
                                    ->groupBy("shop_orders.user_id")
                                    ->groupBy("users.name")
                                    ->orderBy("tot", "desc")
                                    ->take(10)
                                    ->get();
                                ?>
                                @if($list)
                                    <div class="table-responsive">
                                        <table class="table table-md mb-0">
                                            <thead>
                                            <tr>
                                                <th colspan="2">Top 10 clienti</th>
                                            </tr>
                                            </thead>
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
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        @if($adminPluginParking)
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Ultime 5 prenotazioni <span class="text float-right"><a href="/admin/plugin-parking-reservation">Visualizza tutti</a></span></div>
                    <div class="card-body">
                        <?php $list = \App\Models\PluginParkingReservation::orderBy("created_at", "desc")->take(5)->get(); ?>
                        @if($list)
                            <div class="table-responsive">
                                <table class="table table-md mb-0">
                                    <thead>
                                        <tr><th>ID</th><th>Cliente</th><th>Ingresso</th><th>Uscita</th><th>Tipo</th><th>N.GG</th><th>Totale</th><th></th></tr>
                                    </thead>
                                    @foreach($list as $order)
                                        <tr>
                                            <td>
                                                {{ $order->id }}
                                            </td>
                                            <td>
                                                {{ $order->name }}
                                            </td>
                                            <td>
                                                {!! $order->getStart() !!}
                                            </td>
                                            <td>
                                                {!! $order->getEnd() !!}
                                            </td>
                                            <td>
                                                {!! $order->getType()  !!}
                                            </td>
                                            <td>
                                                {{ $order->number_days }}
                                            </td>

                                            <td>
                                                {!! $order->getTotal() !!}
                                            </td>
                                            <td>
                                                <a class="btn btn-default btn-sm" href="/admin/plugin-parking-reservation/{{ $order->id }}/edit">Visualizza</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div>


    @if(env('LOCAL') == 0)
        <?php
            $url = "https://gest.webisland.it/news.xml";
            $xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
        ?>

    <!-- Messaggi da Webisland Gest -->
        <div class="row gutter-2">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">News da Webisland.it</div>
                    @if($xml->channel)
                        <div class="card-body p-0">
                            <div class="table-responsive table-responsive-sm">
                                <table class="table table-md table-striped mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th width="100" class="py-1">Data</th>
                                        <th class="py-1">News</th>
                                    </tr>
                                    </thead>
                                    <tbody id="accordion">
                                    @foreach($xml->channel->item as $message)
                                        <tr data-toggle="collapse" data-target="#collapse-news-{{ $loop->index }}" @if($loop->first) aria-expanded="true" @else aria-expanded="false" @endif>
                                            <td>{{ \Carbon\Carbon::parse($message->pubDate)->format("d/m/Y H:i") }}</td>
                                            <td><strong>{{ $message->title }}</strong></td>
                                            <td><i class="la la-angle-down la-lg"></i></td>
                                        </tr>
                                        <tr id="collapse-news-{{ $loop->index }}" class="collapse @if($loop->first) show @endif" data-parent="#accordion">
                                            <td colspan="3">
                                                {!! $message->description !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    <!-- / Messaggi da Webisland Gest -->
@endif



@endsection

@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>

    <!-- grafico 1-3 -->
    <script>
        var pieData = {
            labels: [
                "Pagine create",
                "Blocchi creati",
                "Utenti creati"
            ],
            datasets: [
                {
                    data: [<?php echo $page_count;?>, <?php echo $block_count;?>, <?php echo $user_count;?>],
                    backgroundColor: [
                        "#FF6384",
                        "#35a24c",
                        "#e7904d"
                    ]
                }]
        };

        var ctx = document.getElementById('pieChart');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: pieData
        });
    </script>

    <!-- grafico 2 -->
    <script>
        var pieData = {
            labels: [
                "MB utilizzati"
            ],
            datasets: [
                {
                    data: [34],
                    backgroundColor: [
                        "#3b7ee2"
                    ]
                }]
        };

        var ctx = document.getElementById('pieChart2');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: pieData
        });
    </script>
    @endif
@endsection

