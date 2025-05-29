@extends(backpack_view('blank'))

@section('header')
    <h3 class="page-title mb-0">
        <span class="text-capitalize">Bacheca

        </span>
    </h3>

@endsection

@section('content')
    <?php
    $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->where("is_active", 1)->where("version", 3)->first();
    $adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
    $adminPluginParking = \App\Models\AdminPlugin::where("name", "pluginParking")->where("is_active", 1)->first();
    ?>
    <style>
        .hgi{
            font-size: 35px;
        }
    </style>
    <div class="container-fluid">
        <div class="row row-short pt-4">
            <div class="col-xl-8 col-xx" id="column-banner">
                <div class="banner-container">
                    <img src="{{ url("img/dashboard.gif") }}" width="100%">
                </div>
            </div>
            <div class="col-xl-4 d-flex flex-column" id="column-account">
                <div class="card card-dashboard d-flex flex-column flex-grow-1">
                    <div class="row no-gutters flex-grow-1">
                        <div class="col col-xl-9 col-xx d-flex flex-column order-2 order-lg-1">
                            <div class="card-body d-flex flex-column">
                                <div class="">
                                    <?php
                                    $day_desc = config("cmsformula.days_desc");
                                    $day_d = $day_desc[\Carbon\Carbon::now()->format("D")];
                                    ?>
                                    <div class="font-sm font-x3-lg">Ciao <strong>{{ \backpack_user()->name }}</strong>, <br>Oggi è <strong>{{ $day_d }} {{ \Carbon\Carbon::now()->format("d/m/Y") }}</div>

                                    <div class="font-lg text-dark"><br></div>

                                    <?php
                                    $folder_path = public_path("/uploads");
                                    $size = formatSize(folderSize($folder_path));
                                    ?>
                                    <div class="line-height-sm">
                                        <strong>Spazio server utilizzato:</strong>
                                        {{ $size }}
                                    </div>

                                    <?php
                                    $page_count = \App\Models\Page::count();
                                    $websetting = \App\Models\WebsiteSetting::first();
                                    $perc = ($page_count * 100) / $websetting->number_max_page;
                                    ?>

                                    <div class="line-height-sm">
                                        <strong> Pagine:</strong>
                                        {{ $page_count }} su {{ $websetting->number_max_page }} disponibili
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/page/create">
                                <i class="hgi hgi-stroke hgi-file-01 nav-icon"></i> <br>
                                Nuova pagina
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->

            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/page">  <i class="hgi hgi-stroke hgi-file-01 nav-icon"></i> <br>
                                Elenco Pagine
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->

            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/elfinder">  <i class="nav-icon hgi hgi-stroke hgi-image-add-02"></i> <br>
                                File Manager
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->

            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/websiteSetting/1/edit">  <i class="hgi hgi-stroke hgi-settings-05 nav-icon"></i> <br>
                                Impostazioni
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->

            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/pluginTutorial/view">  <i class="hgi la la-youtube nav-icon"></i> <br>
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
                            <a href="https://www.webisland.it/contatti" target="_blank">  <i class="hgi hgi-stroke hgi-file-01 nav-icon"></i> <br>
                                Richiedi Assistenza
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->

        </div>

        @if($adminPlugin)
        <div class="row row-short flex-grow-1">
            <div class="col-md-12 col-xx-9">
                <div class="row row-short flex-grow-1">
                    <div class="col-md-6 d-flex flex-column">
                        <div class="card card-dashboard flex-column flex-grow-1">

                            <div id="carousel-top-5" class="carousel slide carousel-dash" data-ride="carousel" data-interval="6000">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="card-body">
                                            <div class="row row-extrashort">
                                                <div class="col">
                                                    <h4 class="line-height-xs">Top 10 Prodotti</h4>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Prodotti</button>
                                                        <div class="dropdown-menu dropdown-menu-right font-sm">
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0" disabled="">Prodotti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Clienti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Andamento Mensile</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3">Ultimi 7 Giorni</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
                                                <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-prod">
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            Prodotto
                                                        </td>
                                                        <td>
                                                            N.Acq.
                                                        </td>
                                                    </tr>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        ?>
                                                    @foreach($list as $v)
                                                            <?php
                                                            $name = json_decode($v->name, true);
                                                            ?>
                                                        <tr>
                                                            <td>{{ $i }}°</td>
                                                            <td>
                                                                {{ $name['it'] }}
                                                            </td>
                                                            <td>
                                                                {{ $v->tot }}
                                                            </td>
                                                        </tr>
                                                            <?php
                                                            $i++;
                                                            ?>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="carousel-item">
                                        <div class="card-body">
                                            <div class="row row-extrashort">
                                                <div class="col">
                                                    <h4 class="line-height-xs">Top 10 Clienti</h4>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Clienti</button>
                                                        <div class="dropdown-menu dropdown-menu-right font-sm">
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Prodotti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1" disabled="">Clienti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Andamento Mensile</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3">Ultimi 7 Giorni</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
                                                <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-clienti">
                                                    <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                           Cliente
                                                        </td>
                                                        <td>
                                                           N.Acq.
                                                        </td>
                                                    </tr>
                                                        <?php
                                                        $i = 1;
                                                        ?>
                                                    @foreach($list as $v)
                                                        <tr>
                                                            <td>{{ $i }}°</td>
                                                            <td>
                                                                {{ $v->name }}
                                                            </td>
                                                            <td>
                                                                {{ $v->tot }}
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                        ?>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="carousel-item">
                                        <div class="card-body">
                                            <div class="row row-extrashort">
                                                <div class="col">
                                                    <h4 class="line-height-xs">Andamento Mensile {{ \Carbon\Carbon::now()->format("Y") }}</h4>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Andamento Mensile</button>
                                                        <div class="dropdown-menu dropdown-menu-right font-sm">
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Prodotti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Clienti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2" disabled="">Andamento Mensile</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3">Ultimi 7 Giorni</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                                <?php
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
                                               @if($list)
                                                <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-mensile">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            Mese
                                                        </td>
                                                        <td>
                                                            Totale
                                                        </td>
                                                    </tr>
                                                    @foreach($list as $k=> $v)
                                                        <tr>
                                                            <td>
                                                                {{ $month[$k] }}
                                                            </td>
                                                            <td>
                                                                @if(key_exists($k, $list))
                                                                    {{ number_format($list[$k], 2, ",", ".") }} &euro;
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="carousel-item">
                                        <div class="card-body">
                                            <div class="row row-extrashort">
                                                <div class="col">
                                                    <h4 class="line-height-xs">Ultimi 7 Giorni</h4>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Ultimi 7 Giorni</button>
                                                        <div class="dropdown-menu dropdown-menu-right font-sm">
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Prodotti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Clienti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Andamento Mensile</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3" disabled="">Ultimi 7 Giorni</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                                <?php
                                                $month = \Carbon\Carbon::now()->format("m-Y");
                                                $last_7_days = [];

                                                for($i=6; $i>=0; $i--){
                                                    $dd = \Carbon\Carbon::now()->subDays($i)->toDateTimeString();
                                                    $vendite_7_days = \App\Models\Order::whereRaw("(created_at >= '$dd' AND created_at <= '$dd')")->sum("total");
                                                    $last_7_days[$dd] = $vendite_7_days;
                                                }
                                                ?>
                                            @if($last_7_days)
                                                <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-giorno">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            Giorno
                                                        </td>
                                                        <td>
                                                            Totale
                                                        </td>
                                                    </tr>
                                                    @foreach($last_7_days as $k=> $v)
                                                        <tr>
                                                            <td>
                                                                {{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $k)->format("d/m/Y") }}
                                                            </td>
                                                            <td>
                                                                {{ number_format($v, 2, ",", ".") }} &euro;
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6 d-flex flex-column">
                        <div class="card card-dashboard flex-column flex-grow-1">
                            <div class="card-body">
                                <h4 class="line-height-xs">Totale ordini</h4>
                                <?php
                                    $order_sum = \App\Models\Order::sum("total_tax");
                                    $order_count = \App\Models\Order::count();
                                    $product_count = \App\Models\PluginProducts::count();
                                 ?>
                                <h4 class="line-height-xs font-4xl">€ {{ number_format($order_sum,2,",",".") }} &euro;</h4>
                                <div class="font-xs">Disponibile ad oggi</div>

                                <div class="hr my-2"></div>

                                <ul class="nav flex-column font-sm gap-1 mt-3">
                                    <li class="nav gap-x-2 flex-nowrap">
                                        <div class="font-sm">Ordini ricevuti</div>
                                        <div class="ml-auto text-right text-nowrap">{{ $order_count }}</div>
                                    </li>
                                    <li class="nav gap-x-2 flex-nowrap">
                                        <div class="font-sm">Prodotti inseriti</div>
                                        <div class="ml-auto text-right text-nowrap">{{ $product_count }}</div>
                                    </li>
                                </ul>

                                <?php
                                $list = \App\Models\Order::with("user")->orderBy("created_at", "desc")->take(5)->get();
                                ?>
                                @if(count($list))
                                    <div class="hr my-2"></div>
                                    <br>
                                    <h4 class="line-height-xs">Ultimi ordini</h4>

                                    <table class="table table-sm mb-0">
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
                                                <td class="text-right">
                                                    <a class="btn btn-dark btn-sm" href="/admin/shopOrders/{{ $order->id }}/show">Visualizza</a>
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

            <div class="col-md-4 col-xx-3 d-flex flex-column">

                <!--<div class="card card-dashboard flex-column flex-grow-1">
                    <div class="card-body d-flex flex-column">
                        <h4 class="line-height-xs">Magazzino</h4>
                        <h4 class="line-height-xs font-4xl">€ 623,25</h4>
                        <div class="font-xs mb-4">Disponibile ad oggi</div>


                        <ul class="nav flex-column font-sm gap-1 mt-auto">
                            <li class="nav gap-x-2 flex-nowrap">
                                <div class="font-sm w-90px text-success font-600">Buone</div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 20%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="text-success font-600 w-40px text-right">2</div>
                            </li>
                            <li class="nav gap-x-2 flex-nowrap">
                                <div class="font-sm w-90px text-dark">Basse</div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="text-dark w-40px text-right">0</div>
                            </li>
                            <li class="nav gap-x-2 flex-nowrap">
                                <div class="font-sm w-90px text-dark font-600">Scarse</div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="text-dark font-600 w-40px text-right">0</div>
                            </li>
                            <li class="nav gap-x-2 flex-nowrap">
                                <div class="font-sm w-90px text-warning font-600">Sottoscorta</div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="text-warning font-600 w-40px text-right">0</div>
                            </li>
                            <li class="nav gap-x-2 flex-nowrap">
                                <div class="font-sm w-90px text-danger font-600">Esaurite</div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="text-danger font-600 w-40px text-right">0</div>
                            </li>
                        </ul>
                    </div>
                </div>-->
            </div>
        </div>
        @endif

        @if($adminPluginBooking)
            <div class="row row-short flex-grow-1">
                <div class="col-md-12 col-xx-9">
                    <div class="row row-short flex-grow-1">
                        <div class="col-md-6 d-flex flex-column">
                            <div class="card card-dashboard flex-column flex-grow-1">

                                <div id="carousel-top-5" class="carousel slide carousel-dash" data-ride="carousel" data-interval="6000">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="card-body">
                                                <div class="row row-extrashort">
                                                    <div class="col">
                                                        <h4 class="line-height-xs">Top Camere</h4>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Camere</button>
                                                            <div class="dropdown-menu dropdown-menu-right font-sm">
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0" disabled="">Camere</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Clienti</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Andamento Mensile</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3">Ultimi 7 Giorni</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <?php
                                                    $list = \App\Models\PluginBookingReservation::selectRaw("COUNT(*) as tot, plugin_booking_room_id, plugins_booking_rooms.name")
                                                        ->join("plugins_booking_rooms", "plugins_booking_rooms.id", "=", "plugin_booking_room_id")
                                                        ->groupBy("plugin_booking_room_id")
                                                        ->groupBy("plugins_booking_rooms.name")
                                                        ->orderBy("tot", "desc")
                                                        ->take(10)
                                                        ->get();
                                                    ?>
                                                @if($list)
                                                    <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-prod">
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                Camera
                                                            </td>
                                                            <td>
                                                                N.Acq.
                                                            </td>
                                                        </tr>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            ?>
                                                        @foreach($list as $v)
                                                                <?php
                                                                $name = json_decode($v->name, true);
                                                                ?>
                                                            <tr>
                                                                <td>{{ $i }}°</td>
                                                                <td>
                                                                    {{ $name['it'] }}
                                                                </td>
                                                                <td>
                                                                    {{ $v->tot }}
                                                                </td>
                                                            </tr>
                                                                <?php
                                                                $i++;
                                                                ?>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="card-body">
                                                <div class="row row-extrashort">
                                                    <div class="col">
                                                        <h4 class="line-height-xs">Top Clienti</h4>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Clienti</button>
                                                            <div class="dropdown-menu dropdown-menu-right font-sm">
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Camere</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1" disabled="">Clienti</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Andamento Mensile</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3">Ultimi 7 Giorni</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                                $list = \App\Models\PluginBookingReservation::selectRaw("COUNT(*) as tot, plugins_booking_reservations.user_id, users.name")
                                                    ->join("users", "users.id", "=", "plugins_booking_reservations.user_id")
                                                    ->groupBy("plugins_booking_reservations.user_id")
                                                    ->groupBy("users.name")
                                                    ->orderBy("tot", "desc")
                                                    ->take(10)
                                                    ->get();
                                                ?>
                                                @if($list)
                                                    <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-clienti">
                                                        <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                Cliente
                                                            </td>
                                                            <td>
                                                                N.Acq.
                                                            </td>
                                                        </tr>
                                                            <?php
                                                            $i = 1;
                                                            ?>
                                                        @foreach($list as $v)
                                                            <tr>
                                                                <td>{{ $i }}°</td>
                                                                <td>
                                                                    {{ $v->name }}
                                                                </td>
                                                                <td>
                                                                    {{ $v->tot }}
                                                                </td>
                                                            </tr>
                                                                <?php
                                                                $i++;
                                                                ?>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="card-body">
                                                <div class="row row-extrashort">
                                                    <div class="col">
                                                        <h4 class="line-height-xs">Andamento Mensile {{ \Carbon\Carbon::now()->format("Y") }}</h4>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Andamento Mensile</button>
                                                            <div class="dropdown-menu dropdown-menu-right font-sm">
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Camere</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Clienti</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2" disabled="">Andamento Mensile</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3">Ultimi 7 Giorni</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <?php
                                                    $year = \Carbon\Carbon::now()->format("Y");
                                                    $list = \App\Models\PluginBookingReservation::selectRaw("SUBSTRING(created_at,6,2) as date_order_month, sum(total) as sum_total")
                                                        ->whereRaw("(created_at >= '".$year."-01-01 00:00:00' AND created_at <= '".$year."-12-31 23:59:59')")
                                                        ->groupBy("date_order_month")
                                                        ->get()
                                                        ->pluck("sum_total","date_order_month")
                                                        ->toArray();

                                                    $month = ["01" => "Gennaio", "02" => "Febbraio", "03"=>"Marzo", "04" => "Aprile", "05" => "Maggio", "06" => "Giugno",
                                                        "07" => "Luglio", "08" => "Agosto", "09" => "Settembre", "10" => "Ottobre", "11" => "Novembre", "12" => "Dicembre"];

                                                    ?>
                                                @if($list)
                                                    <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-mensile">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                Mese
                                                            </td>
                                                            <td>
                                                                Totale
                                                            </td>
                                                        </tr>
                                                        @foreach($list as $k=> $v)
                                                            <tr>
                                                                <td>
                                                                    {{ $month[$k] }}
                                                                </td>
                                                                <td>
                                                                    @if(key_exists($k, $list))
                                                                        {{ number_format($list[$k], 2, ",", ".") }} &euro;
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="card-body">
                                                <div class="row row-extrashort">
                                                    <div class="col">
                                                        <h4 class="line-height-xs">Ultimi 7 Giorni</h4>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Ultimi 7 Giorni</button>
                                                            <div class="dropdown-menu dropdown-menu-right font-sm">
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Camere</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Clienti</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Andamento Mensile</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3" disabled="">Ultimi 7 Giorni</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <?php
                                                    $month = \Carbon\Carbon::now()->format("m-Y");
                                                    $last_7_days = [];

                                                    for($i=6; $i>=0; $i--){
                                                        $dd = \Carbon\Carbon::now()->subDays($i)->format("Y-m-d");
                                                        $vendite_7_days = \App\Models\PluginBookingReservation::whereRaw("(created_at >= '$dd 00:00:00' AND created_at <= '$dd 23:59:59')")->sum("total");
                                                        $last_7_days[$dd] = $vendite_7_days;
                                                    }
                                                    ?>
                                                @if($last_7_days)
                                                    <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-giorno">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                Giorno
                                                            </td>
                                                            <td>
                                                                Totale
                                                            </td>
                                                        </tr>
                                                        @foreach($last_7_days as $k=> $v)
                                                            <tr>
                                                                <td>
                                                                    {{ \Carbon\Carbon::createFromFormat("Y-m-d", $k)->format("d/m/Y") }}
                                                                </td>
                                                                <td>
                                                                    {{ number_format($v, 2, ",", ".") }} &euro;
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6 d-flex flex-column">
                            <div class="card card-dashboard flex-column flex-grow-1">
                                <div class="card-body">
                                    <h4 class="line-height-xs">Totale prenotazioni</h4>
                                        <?php
                                        $order_sum = \App\Models\PluginBookingReservation::sum("total");
                                        $order_count = \App\Models\PluginBookingReservation::count();
                                        ?>
                                    <h4 class="line-height-xs font-4xl">€ {{ number_format($order_sum,2,",",".") }} &euro;</h4>
                                    <div class="font-xs">Disponibile ad oggi</div>

                                    <div class="hr my-2"></div>

                                    <ul class="nav flex-column font-sm gap-1 mt-3">
                                        <li class="nav gap-x-2 flex-nowrap">
                                            <div class="font-sm">Prenotazioni ricevute</div>
                                            <div class="ml-auto text-right text-nowrap">{{ $order_count }}</div>
                                        </li>
                                    </ul>

                                    <?php
                                    $list = \App\Models\PluginBookingReservation::with("user")->orderBy("created_at", "desc")->take(5)->get();
                                    ?>
                                    @if(count($list))
                                        <div class="hr my-2"></div>
                                        <br>
                                        <h4 class="line-height-xs">Ultime prenotazioni</h4>

                                        <table class="table table-sm mb-0">
                                            <thead>
                                            <tr><th>ID</th><th>Cliente</th><th>Stato</th><th>Totale</th><th>Data inizio</th><th>Data FINE</th><th></th></tr>
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
                                                        {!! $order->getStatus() !!}
                                                    </td>
                                                    <td>
                                                        {{ number_format($order->total, 2, ",", ".") }}
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::createFromFormat("Y-m-d", $order->date_start)->format("d/m/Y") }}
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::createFromFormat("Y-m-d", $order->date_end)->format("d/m/Y") }}
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-dark btn-sm" href="/admin/plugin-booking-reservation/{{ $order->id }}/edit">Visualizza</a>
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

                <div class="col-md-4 col-xx-3 d-flex flex-column">

                    <!--<div class="card card-dashboard flex-column flex-grow-1">
                        <div class="card-body d-flex flex-column">
                            <h4 class="line-height-xs">Magazzino</h4>
                            <h4 class="line-height-xs font-4xl">€ 623,25</h4>
                            <div class="font-xs mb-4">Disponibile ad oggi</div>


                            <ul class="nav flex-column font-sm gap-1 mt-auto">
                                <li class="nav gap-x-2 flex-nowrap">
                                    <div class="font-sm w-90px text-success font-600">Buone</div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 20%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="text-success font-600 w-40px text-right">2</div>
                                </li>
                                <li class="nav gap-x-2 flex-nowrap">
                                    <div class="font-sm w-90px text-dark">Basse</div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="text-dark w-40px text-right">0</div>
                                </li>
                                <li class="nav gap-x-2 flex-nowrap">
                                    <div class="font-sm w-90px text-dark font-600">Scarse</div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="text-dark font-600 w-40px text-right">0</div>
                                </li>
                                <li class="nav gap-x-2 flex-nowrap">
                                    <div class="font-sm w-90px text-warning font-600">Sottoscorta</div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="text-warning font-600 w-40px text-right">0</div>
                                </li>
                                <li class="nav gap-x-2 flex-nowrap">
                                    <div class="font-sm w-90px text-danger font-600">Esaurite</div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="text-danger font-600 w-40px text-right">0</div>
                                </li>
                            </ul>
                        </div>
                    </div>-->
                </div>
            </div>
        @endif

        @if($adminPluginParking)
            <div class="row row-short flex-grow-1">
                <div class="col-md-12 col-xx-9">
                    <div class="row row-short flex-grow-1">
                        <div class="col-md-6 d-flex flex-column">
                            <div class="card card-dashboard flex-column flex-grow-1">

                                <div id="carousel-top-5" class="carousel slide carousel-dash" data-ride="carousel" data-interval="6000">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="card-body">
                                                <div class="row row-extrashort">
                                                    <div class="col">
                                                        <h4 class="line-height-xs">Top Clienti</h4>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Clienti</button>
                                                            <div class="dropdown-menu dropdown-menu-right font-sm">
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0" disabled="">Clienti</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Andamento Mensile</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Ultimi 7 Giorni</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <?php
                                                    $list = \App\Models\PluginParkingReservation::selectRaw("COUNT(*) as tot, name")
                                                        ->groupBy("name")
                                                        ->orderBy("tot", "desc")
                                                        ->take(10)
                                                        ->get();
                                                    ?>
                                                @if($list)
                                                    <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-clienti">
                                                        <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                Cliente
                                                            </td>
                                                            <td>
                                                                N.Acq.
                                                            </td>
                                                        </tr>
                                                            <?php
                                                            $i = 1;
                                                            ?>
                                                        @foreach($list as $v)
                                                            <tr>
                                                                <td>{{ $i }}°</td>
                                                                <td>
                                                                    {{ $v->name }}
                                                                </td>
                                                                <td>
                                                                    {{ $v->tot }}
                                                                </td>
                                                            </tr>
                                                                <?php
                                                                $i++;
                                                                ?>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="card-body">
                                                <div class="row row-extrashort">
                                                    <div class="col">
                                                        <h4 class="line-height-xs">Andamento Mensile {{ \Carbon\Carbon::now()->format("Y") }}</h4>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Andamento Mensile</button>
                                                            <div class="dropdown-menu dropdown-menu-right font-sm">
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Clienti</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1" disabled="">Andamento Mensile</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Ultimi 7 Giorni</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <?php
                                                    $year = \Carbon\Carbon::now()->format("Y");
                                                    $list = \App\Models\PluginParkingReservation::selectRaw("SUBSTRING(created_at,6,2) as date_order_month, sum(total) as sum_total")
                                                        ->whereRaw("(created_at >= '".$year."-01-01 00:00:00' AND created_at <= '".$year."-12-31 23:59:59')")
                                                        ->groupBy("date_order_month")
                                                        ->get()
                                                        ->pluck("sum_total","date_order_month")
                                                        ->toArray();

                                                    $month = ["01" => "Gennaio", "02" => "Febbraio", "03"=>"Marzo", "04" => "Aprile", "05" => "Maggio", "06" => "Giugno",
                                                        "07" => "Luglio", "08" => "Agosto", "09" => "Settembre", "10" => "Ottobre", "11" => "Novembre", "12" => "Dicembre"];

                                                    ?>
                                                @if($list)
                                                    <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-mensile">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                Mese
                                                            </td>
                                                            <td>
                                                                Totale
                                                            </td>
                                                        </tr>
                                                        @foreach($list as $k=> $v)
                                                            <tr>
                                                                <td>
                                                                    {{ $month[$k] }}
                                                                </td>
                                                                <td>
                                                                    @if(key_exists($k, $list))
                                                                        {{ number_format($list[$k], 2, ",", ".") }} &euro;
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="card-body">
                                                <div class="row row-extrashort">
                                                    <div class="col">
                                                        <h4 class="line-height-xs">Ultimi 7 Giorni</h4>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Ultimi 7 Giorni</button>
                                                            <div class="dropdown-menu dropdown-menu-right font-sm">
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Clienti</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Andamento Mensile</a>
                                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2" disabled="">Ultimi 7 Giorni</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <?php
                                                    $month = \Carbon\Carbon::now()->format("m-Y");
                                                    $last_7_days = [];

                                                    for($i=6; $i>=0; $i--){
                                                        $dd = \Carbon\Carbon::now()->subDays($i)->format("Y-m-d");
                                                        $vendite_7_days = \App\Models\PluginParkingReservation::whereRaw("(created_at >= '$dd 00:00:00' AND created_at <= '$dd 23:59:59')")->sum("total");
                                                        $last_7_days[$dd] = $vendite_7_days;
                                                    }
                                                    ?>
                                                @if($last_7_days)
                                                    <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-giorno">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                Giorno
                                                            </td>
                                                            <td>
                                                                Totale
                                                            </td>
                                                        </tr>
                                                        @foreach($last_7_days as $k=> $v)
                                                            <tr>
                                                                <td>
                                                                    {{ \Carbon\Carbon::createFromFormat("Y-m-d", $k)->format("d/m/Y") }}
                                                                </td>
                                                                <td>
                                                                    {{ number_format($v, 2, ",", ".") }} &euro;
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6 d-flex flex-column">
                            <div class="card card-dashboard flex-column flex-grow-1">
                                <div class="card-body">
                                    <h4 class="line-height-xs">Totale prenotazioni</h4>
                                        <?php
                                        $order_sum = \App\Models\PluginParkingReservation::sum("total");
                                        $order_count = \App\Models\PluginParkingReservation::count();
                                        ?>
                                    <h4 class="line-height-xs font-4xl">€ {{ number_format($order_sum,2,",",".") }} &euro;</h4>
                                    <div class="font-xs">Disponibile ad oggi</div>

                                    <div class="hr my-2"></div>

                                    <ul class="nav flex-column font-sm gap-1 mt-3">
                                        <li class="nav gap-x-2 flex-nowrap">
                                            <div class="font-sm">Prenotazioni ricevute</div>
                                            <div class="ml-auto text-right text-nowrap">{{ $order_count }}</div>
                                        </li>
                                    </ul>

                                    <?php
                                    $list = \App\Models\PluginParkingReservation::orderBy("created_at", "desc")->take(5)->get();
                                    ?>
                                    @if(count($list))
                                        <div class="hr my-2"></div>
                                        <br>
                                        <h4 class="line-height-xs">Ultime prenotazioni</h4>

                                        <table class="table table-sm mb-0">
                                            <thead>
                                            <tr><th>ID</th><th>Cliente</th><th>Tipo</th><th>Totale</th><th>Data inizio</th><th>Data FINE</th><th></th></tr>
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
                                                        {!! $order->getType() !!}
                                                    </td>
                                                    <td>
                                                        {!! $order->getTotal() !!}
                                                    </td>
                                                    <td>
                                                        {!! $order->getStart() !!}
                                                    </td>
                                                    <td>
                                                        {!! $order->getEnd() !!}
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-dark btn-sm" href="/admin/plugin-parking-reservation/{{ $order->id }}/edit">Visualizza</a>
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

                <div class="col-md-4 col-xx-3 d-flex flex-column">

                    <!--<div class="card card-dashboard flex-column flex-grow-1">
                        <div class="card-body d-flex flex-column">
                            <h4 class="line-height-xs">Magazzino</h4>
                            <h4 class="line-height-xs font-4xl">€ 623,25</h4>
                            <div class="font-xs mb-4">Disponibile ad oggi</div>


                            <ul class="nav flex-column font-sm gap-1 mt-auto">
                                <li class="nav gap-x-2 flex-nowrap">
                                    <div class="font-sm w-90px text-success font-600">Buone</div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 20%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="text-success font-600 w-40px text-right">2</div>
                                </li>
                                <li class="nav gap-x-2 flex-nowrap">
                                    <div class="font-sm w-90px text-dark">Basse</div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="text-dark w-40px text-right">0</div>
                                </li>
                                <li class="nav gap-x-2 flex-nowrap">
                                    <div class="font-sm w-90px text-dark font-600">Scarse</div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="text-dark font-600 w-40px text-right">0</div>
                                </li>
                                <li class="nav gap-x-2 flex-nowrap">
                                    <div class="font-sm w-90px text-warning font-600">Sottoscorta</div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="text-warning font-600 w-40px text-right">0</div>
                                </li>
                                <li class="nav gap-x-2 flex-nowrap">
                                    <div class="font-sm w-90px text-danger font-600">Esaurite</div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="text-danger font-600 w-40px text-right">0</div>
                                </li>
                            </ul>
                        </div>
                    </div>-->
                </div>
            </div>
        @endif

    </div>

 </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('packages/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}">
    <link href="{{ url('/css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('packages/select2/dist/js/i18n/it.js') }}"></script>

    <script src="{{ asset('packages/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
@endsection

@section('footer')
@endsection


