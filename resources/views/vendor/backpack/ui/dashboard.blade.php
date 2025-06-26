@extends(backpack_view('blank'))

<?php
    $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->where("is_active", 1)->where("version", 3)->first();
    $adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
    $adminPluginParking = \App\Models\AdminPlugin::where("name", "pluginParking")->where("is_active", 1)->first();
?>

@section('header')
    <meta charset="UTF-8">
    <h3 class="page-title mb-0">
        <span class="text-capitalize">Bacheca</span>
    </h3>
@endsection

@section('content')
    <div class="row gutter-3">
        <div class="col-xl-8 mb-3">
            <img src="{{ url("img/dashboard.gif") }}" class="img-fluid">
        </div>
        <div class="col-xl-4 mb-3">
            <div class="card card-dashboard">
                <div class="card-body d-flex flex-column">
                    <div class="row mb-3">
                        <div class="col line-height-sm">
                            <div>Bentornato</div>
                            <h3>{{ \backpack_user()->name }}</h3>
                        </div>
                        <div class="col-auto">
                            <?php
                                $day_desc = config("cmsformula.days_short");
                                $months_desc = config("cmsformula.months_ext");
                                $day_d = $day_desc[\Carbon\Carbon::now()->format("D")];
                                $day_m = $months_desc[\Carbon\Carbon::now()->format("m")];
                            ?>
                            <div class="media align-items-center">
                                <div class="border-right pr-2">
                                    <div class="font-3xl line-height-xs">{{ \Carbon\Carbon::now()->format("d") }}</div>
                                    <div class="font-xs text-uppercase text-center line-height-xs"> {{ $day_d }}</div>
                                </div>
                                <div class="media-body line-height-md pl-2">
                                    <div class="font-lg text-uppercase">{{ $day_m }}</div>
                                    <div class="font-sm text-capitalize">{{ \Carbon\Carbon::now()->format("Y") }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $page_count = \App\Models\Page::count();
                    $websetting = \App\Models\WebsiteSetting::first();
                    $page_percentage = ($page_count * 100) / $websetting->number_max_page;
                    ?>

                    <div class="progress-group mb-3 mt-auto">
                        <div class="progress-group-header mb-2">
                            <div class="font-lg">Pagine</div>
                            <div class="ml-auto font-weight-bold">{{ $page_count }} su {{ $websetting->number_max_page }} disponibili</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $page_percentage }}%" aria-valuenow="{{ $page_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $folder_path = public_path("/uploads");
                    $size = formatSize(folderSize($folder_path));
                    ?>

                    <div class="progress-group mb-0">
                        <div class="progress-group-header">
                            <div class="font-lg">Spazio server utilizzato</div>
                            <div class="ml-auto font-weight-bold">{{ $size }}</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row gutter-3">
        <div class="col-6 col-sm-4 col-xl-2 mb-3">
            <a class="card card-link p-2" href="/admin/page/create">
                <i class="hgi hgi-stroke hgi-add-circle"></i>
                <h6>Nuova pagina</h6>
            </a>
        </div><!-- /.col-->

        <div class="col-6 col-sm-4 col-xl-2 mb-3">
            <a class="card card-link p-2" href="/admin/page">
                <i class="hgi hgi-stroke hgi-file-01"></i>
                <h6>Elenco Pagine</h6>
            </a>
        </div><!-- /.col-->

        <div class="col-6 col-sm-4 col-xl-2 mb-3">
            <a class="card card-link p-2" href="/admin/elfinder">
                <i class="nav-icon hgi hgi-stroke hgi-image-add-02"></i>
                <h6>File Manager</h6>
            </a>
        </div><!-- /.col-->

        <div class="col-6 col-sm-4 col-xl-2 mb-3">
            <a class="card card-link p-2" href="/admin/websiteSetting/1/edit">
                <i class="hgi hgi-stroke hgi-settings-05"></i>
                <h6>Impostazioni</h6>
            </a>
        </div><!-- /.col-->

        <div class="col-6 col-sm-4 col-xl-2 mb-3">
            <a class="card card-link p-2" href="/admin/pluginTutorial/view">
                <i class="hgi hgi-stroke hgi-youtube"></i>
                <h6>Tutorial</h6>
            </a>
        </div><!-- /.col-->

        <div class="col-6 col-sm-4 col-xl-2 mb-3">
            <a class="card card-link p-2" href="https://www.webisland.it/contatti" target="_blank">
                <i class="hgi hgi-stroke hgi-file-01"></i>
                <h6>Richiedi Assistenza</h6>
            </a>
        </div><!-- /.col-->

    </div>

    @if($adminPlugin)
        <div class="row gutter-3">
            <div class="col-xl-6 mb-4">
                <div class="card card-dashboard">
                    <div id="carousel-top-1" class="carousel slide carousel-dash" data-ride="carousel" data-interval="6000">
                        <div class="carousel-inner">
                            <div class="carousel-item flex-column active">
                                <div class="card-header">
                                    <div class="row gutter-1 align-items-center flex-grow-1">
                                        <div class="col">
                                            <h5 class="line-height-xs my-0">Top 10 Prodotti</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Prodotti</button>
                                                <div class="dropdown-menu dropdown-menu-right font-sm">
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="0" disabled>Prodotti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="1">Clienti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="2">Andamento Mensile</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="3">Ultimi 7 Giorni</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-2">
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
                                        <table class="table table-borderless line-height-sm mb-0" id="table-top-prodotti">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Prodotto</th>
                                                <th>N.Acq.</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; ?>
                                            @foreach($list as $v)
                                                <?php
                                                $name = json_decode($v->name, true);
                                                ?>
                                                <tr>
                                                    <td width="50">{{ $i }}°</td>
                                                    <td>{{ $name['it'] }}</td>
                                                    <td width="50">{{ $v->tot }}</td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>

                            <div class="carousel-item flex-column">
                                <div class="card-header">
                                    <div class="row gutter-1 align-items-center flex-grow-1">
                                        <div class="col">
                                            <h5 class="line-height-xs my-0">Top 10 Clienti</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Clienti</button>
                                                <div class="dropdown-menu dropdown-menu-right font-sm">
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="0">Prodotti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="1" disabled>Clienti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="2">Andamento Mensile</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="3">Ultimi 7 Giorni</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-2">
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
                                        <table class="table table-borderless line-height-sm mb-0" id="table-top-clienti">
                                            <thead>
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Cliente</th>
                                                <th width="50">N.Acq.</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; ?>
                                            @foreach($list as $v)
                                                <tr>
                                                    <td>{{ $i }}°</td>
                                                    <td>{{ $v->name }}</td>
                                                    <td>{{ $v->tot }}</td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>

                            <div class="carousel-item flex-column">
                                <div class="card-header">
                                    <div class="row gutter-1 align-items-center flex-grow-1">
                                        <div class="col">
                                            <h5 class="line-height-xs my-0">Andamento Mensile {{ \Carbon\Carbon::now()->format("Y") }}</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Andamento Mensile</button>
                                                <div class="dropdown-menu dropdown-menu-right font-sm">
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="0">Prodotti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="1">Clienti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="2" disabled>Andamento Mensile</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="3">Ultimi 7 Giorni</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-2">
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
                                        <table class="table table-borderless line-height-sm mb-0" id="table-top-mensile">
                                            <thead>
                                            <tr>
                                                <th>Mese</th>
                                                <th width="150">Totale</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list as $k=> $v)
                                                <tr>
                                                    <td>{{ $month[$k] }}</td>
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

                            <div class="carousel-item flex-column">
                                <div class="card-header">
                                    <div class="row gutter-1 align-items-center flex-grow-1">
                                        <div class="col">
                                            <h5 class="line-height-xs my-0">Ultimi 7 Giorni</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Ultimi 7 Giorni</button>
                                                <div class="dropdown-menu dropdown-menu-right font-sm">
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="0">Prodotti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="1">Clienti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="2">Andamento Mensile</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-1" data-slide-to="3" disabled>Ultimi 7 Giorni</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-2">
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
                                        <table class="table table-borderless line-height-sm mb-0" id="table-top-giorno">
                                            <thead>
                                            <tr>
                                                <th>Giorno</th>
                                                <th width="150">Totale</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($last_7_days as $k=> $v)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $k)->format("d/m/Y") }}</td>
                                                    <td>{{ number_format($v, 2, ",", ".") }} &euro;</td>
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

            <div class="col-xl-6 mb-4">
                <div class="card card-dashboard">
                    <div class="card-header">
                        <h5 class="line-height-xs my-0">Totale ordini</h5>
                    </div>
                    <div class="card-body flex-grow-0">
                        <?php
                        $order_sum = \App\Models\Order::sum("total_tax");
                        $order_count = \App\Models\Order::count();
                        $product_count = \App\Models\PluginProducts::count();
                        ?>

                        <div class="row align-items-end border-bottom">
                            <div class="col-sm mb-3">
                                <div class="media align-items-center">
                                    <i class="hgi hgi-stroke hgi-coins-euro font-5xl line-height-sm"></i>
                                    <div class="media-body ml-3">
                                        <h4 class="font-3xl mb-0 line-height-sm">€ {{ number_format($order_sum,2,",",".") }}</h4>
                                        <div class="text-uppercase">Ad oggi</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-auto mb-3">
                                <div class="media align-items-center">
                                    <i class="hgi hgi-stroke hgi-sharp hgi-delivery-box-01 font-5xl line-height-sm"></i>
                                    <div class="media-body ml-3">
                                        <h4 class="font-2xl mb-0 line-height-sm">{{ $product_count }}</h4>
                                        <div class="text-uppercase font-sm">Prodotti inseriti</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-auto mb-3">
                                <div class="media align-items-center">
                                    <i class="hgi hgi-stroke hgi-shopping-cart-check-in-02 font-5xl line-height-sm"></i>
                                    <div class="media-body ml-3">
                                        <h4 class="font-2xl mb-0 line-height-sm">{{ $order_count }}</h4>
                                        <div class="text-uppercase font-sm">Ordini ricevuti</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $list = \App\Models\Order::with("user")->orderBy("created_at", "desc")->take(5)->get(); ?>
                    @if(count($list))
                        <div class="card-body pt-0 flex-grow-1">
                            <h6 class="text-uppercase line-height-xs mt-3">Ultimi ordini</h6>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Stato</th>
                                        <th>Totale</th>
                                        <th>Spedizione</th>
                                        <th>Data ordine</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    @foreach($list as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>
                                                @if($order->user)
                                                    {{ $order->user->name }}
                                                @else
                                                    Utente cancellato
                                                @endif
                                            </td>
                                            <td>{!! $order->get_status() !!}</td>
                                            <td>{!! $order->get_total() !!}</td>
                                            <td>{{ number_format($order->total_shipping_tax, 2, ",", ".") }}</td>
                                            <td></td>
                                            <td class="text-right"><a class="font-xs" href="/admin/shopOrders/{{ $order->id }}/show">Visualizza</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if($adminPluginBooking)
        <div class="row gutter-3">
            <div class="col-xl-6 mb-4">
                <div class="card card-dashboard">

                    <div id="carousel-top-2" class="carousel slide carousel-dash" data-ride="carousel" data-interval="6000">
                        <div class="carousel-inner">
                            <div class="carousel-item flex-column active">
                                <div class="card-header">
                                    <div class="row gutter-1 align-items-center flex-grow-1">
                                        <div class="col">
                                            <h5 class="line-height-xs my-0">Top Camere</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Camere</button>
                                                <div class="dropdown-menu dropdown-menu-right font-sm">
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="0" disabled>Camere</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="1">Clienti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="2">Andamento Mensile</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="3">Ultimi 7 Giorni</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body py-2">
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
                                        <table class="table table-borderless line-height-sm mb-0" id="table-top-camere">
                                            <thead>
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Camera</th>
                                                <th width="100">N.Acq.</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; ?>
                                            @foreach($list as $v)
                                                <?php $name = json_decode($v->name, true); ?>
                                                <tr>
                                                    <td>{{ $i }}°</td>
                                                    <td>{{ $name['it'] }}</td>
                                                    <td>{{ $v->tot }}</td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>

                            <div class="carousel-item flex-column">
                                <div class="card-header">
                                    <div class="row gutter-1 align-items-center flex-grow-1">
                                        <div class="col">
                                            <h5 class="line-height-xs my-0">Top Clienti</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Clienti</button>
                                                <div class="dropdown-menu dropdown-menu-right font-sm">
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="0">Camere</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="1" disabled>Clienti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="2">Andamento Mensile</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="3">Ultimi 7 Giorni</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body py-2">
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
                                        <table class="table table-borderless line-height-sm mb-0" id="table-top-clienti">
                                            <thead>
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Cliente</th>
                                                <th width="100">N.Acq.</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; ?>
                                            @foreach($list as $v)
                                                <tr>
                                                    <td>{{ $i }}°</td>
                                                    <td>{{ $v->name }}</td>
                                                    <td>{{ $v->tot }}</td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>

                            <div class="carousel-item flex-column">
                                <div class="card-header">
                                    <div class="row gutter-1 align-items-center flex-grow-1">
                                        <div class="col">
                                            <h5 class="line-height-xs my-0">Andamento Mensile {{ \Carbon\Carbon::now()->format("Y") }}</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Andamento Mensile</button>
                                                <div class="dropdown-menu dropdown-menu-right font-sm">
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="0">Camere</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="1">Clienti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="2" disabled>Andamento Mensile</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="3">Ultimi 7 Giorni</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-2">
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
                                        <table class="table table-borderless line-height-sm mb-0" id="table-top-mensile">
                                            <thead>
                                            <tr>
                                                <th>Mese</th>
                                                <th width="150">Totale</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list as $k=> $v)
                                                <tr>
                                                    <td>{{ $month[$k] }}</td>
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

                            <div class="carousel-item flex-column">
                                <div class="card-header">
                                    <div class="row gutter-1 align-items-center flex-grow-1">
                                        <div class="col">
                                            <h5 class="line-height-xs my-0">Ultimi 7 Giorni</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Ultimi 7 Giorni</button>
                                                <div class="dropdown-menu dropdown-menu-right font-sm">
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="0">Camere</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="1">Clienti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="2">Andamento Mensile</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-2" data-slide-to="3" disabled>Ultimi 7 Giorni</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-2">
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
                                        <table class="table table-borderless line-height-sm mb-0" id="table-top-giorno">
                                            <thead>
                                            <tr>
                                                <th>Giorno</th>
                                                <th width="150">Totale</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($last_7_days as $k=> $v)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $k)->format("d/m/Y") }}</td>
                                                    <td>{{ number_format($v, 2, ",", ".") }} &euro;</td>
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

            <div class="col-xl-6 mb-4">
                <div class="card card-dashboard">
                    <div class="card-header">
                        <h5 class="line-height-xs my-0">Totale prenotazioni</h5>
                    </div>
                    <div class="card-body flex-grow-0">
                        <?php
                            $order_sum = \App\Models\PluginBookingReservation::sum("total");
                            $order_count = \App\Models\PluginBookingReservation::count();
                        ?>

                        <div class="row align-items-end border-bottom">
                            <div class="col mb-3">
                                <div class="media align-items-center">
                                    <i class="hgi hgi-stroke hgi-coins-euro font-5xl line-height-sm"></i>
                                    <div class="media-body ml-3">
                                        <h4 class="font-3xl mb-0 line-height-sm">€ {{ number_format($order_sum,2,",",".") }}</h4>
                                        <div class="text-uppercase">Ad oggi</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto mb-3">
                                <div class="media align-items-center">
                                    <i class="hgi hgi-stroke hgi-task-01 font-5xl line-height-sm"></i>
                                    <div class="media-body ml-3">
                                        <h4 class="font-2xl mb-0 line-height-sm">{{ $order_count }}</h4>
                                        <div class="text-uppercase font-sm">Prenotazioni ricevute</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php $list = \App\Models\PluginBookingReservation::with("user")->orderBy("created_at", "desc")->take(5)->get(); ?>
                        @if(count($list))
                            <h6 class="text-uppercase line-height-xs mt-3">Ultime prenotazioni</h6>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Stato</th>
                                        <th>Totale</th>
                                        <th>Data inizio</th>
                                        <th>Data fine</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    @foreach($list as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>
                                                @if($order->user)
                                                    {{ $order->user->name }}
                                                @else
                                                    Utente cancellato
                                                @endif
                                            </td>
                                            <td>{!! $order->getStatus() !!}</td>
                                            <td>{{ number_format($order->total, 2, ",", ".") }}</td>
                                            <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $order->date_start)->format("d/m/Y") }}</td>
                                            <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $order->date_end)->format("d/m/Y") }}</td>
                                            <td class="text-right"><a class="font-xs"href="/admin/plugin-booking-reservation/{{ $order->id }}/edit">Visualizza</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endif

    @if($adminPluginParking)
        <div class="row gutter-3">
            <div class="col-xl-6 mb-4">
                <div class="card card-dashboard">
                    <div id="carousel-top-3" class="carousel slide carousel-dash" data-ride="carousel" data-interval="6000">
                        <div class="carousel-inner">
                            <div class="carousel-item flex-column active">
                                <div class="card-header">
                                    <div class="row gutter-1 align-items-center flex-grow-1">
                                        <div class="col">
                                            <h5 class="line-height-xs my-0">Top Camere</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Clienti</button>
                                                <div class="dropdown-menu dropdown-menu-right font-sm">
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-3" data-slide-to="0" disabled>Clienti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-3" data-slide-to="1">Andamento Mensile</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-3" data-slide-to="2">Ultimi 7 Giorni</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-2">
                                    <?php
                                    $list = \App\Models\PluginParkingReservation::selectRaw("COUNT(*) as tot, name")
                                        ->groupBy("name")
                                        ->orderBy("tot", "desc")
                                        ->take(10)
                                        ->get();
                                    ?>
                                    @if($list)
                                        <table class="table table-borderless line-height-sm mb-0" id="table-top-clienti">
                                            <thead>
                                            <tr>
                                                <td width="50">#</td>
                                                <td>Cliente</td>
                                                <td width="50">N.Acq.</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; ?>
                                            @foreach($list as $v)
                                                <tr>
                                                    <td>{{ $i }}°</td>
                                                    <td>{{ $v->name }}</td>
                                                    <td>{{ $v->tot }}</td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>

                            <div class="carousel-item flex-column">
                                <div class="card-header">
                                    <div class="row gutter-1 align-items-center flex-grow-1">
                                        <div class="col">
                                            <h5 class="line-height-xs my-0">Top Camere</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Andamento Mensile</button>
                                                <div class="dropdown-menu dropdown-menu-right font-sm">
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-3" data-slide-to="0">Clienti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-3" data-slide-to="1" disabled="">Andamento Mensile</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-3" data-slide-to="2">Ultimi 7 Giorni</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-2">
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
                                        <table class="table table-borderless line-height-sm mb-0" id="table-top-mensile">
                                            <thead>
                                            <tr>
                                                <th>Mese</th>
                                                <th width="150">Totale</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list as $k=> $v)
                                                <tr>
                                                    <td>{{ $month[$k] }}</td>
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

                            <div class="carousel-item flex-column">
                                <div class="card-header">
                                    <div class="row gutter-1 align-items-center flex-grow-1">
                                        <div class="col">
                                            <h5 class="line-height-xs my-0">Top Camere</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Ultimi 7 Giorni</button>
                                                <div class="dropdown-menu dropdown-menu-right font-sm">
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-3" data-slide-to="0">Clienti</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-3" data-slide-to="1">Andamento Mensile</a>
                                                    <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-3" data-slide-to="2" disabled="">Ultimi 7 Giorni</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-2">
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
                                        <table class="table table-borderless line-height-sm mb-0" id="table-top-giorno">
                                            <thead>
                                            <tr>
                                                <th>Giorno</th>
                                                <th width="150">Totale</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($last_7_days as $k=> $v)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $k)->format("d/m/Y") }}</td>
                                                    <td>{{ number_format($v, 2, ",", ".") }} &euro;</td>
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

            <div class="col-xl-6 mb-4">
                <div class="card card-dashboard">
                    <div class="card-header">
                        <h5 class="line-height-xs my-0">Totale prenotazioni</h5>
                    </div>
                    <div class="card-body flex-grow-0">
                        <?php
                            $order_sum = \App\Models\PluginParkingReservation::sum("total");
                            $order_count = \App\Models\PluginParkingReservation::count();
                        ?>

                            <div class="row align-items-end border-bottom">
                                <div class="col mb-3">
                                    <div class="media align-items-center">
                                        <i class="hgi hgi-stroke hgi-coins-euro font-5xl line-height-sm"></i>
                                        <div class="media-body ml-3">
                                            <h4 class="font-3xl mb-0 line-height-sm">€ {{ number_format($order_sum,2,",",".") }}</h4>
                                            <div class="text-uppercase">Ad oggi</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto mb-3">
                                    <div class="media align-items-center">
                                        <i class="hgi hgi-stroke hgi-task-01 font-5xl line-height-sm"></i>
                                        <div class="media-body ml-3">
                                            <h4 class="font-2xl mb-0 line-height-sm">{{ $order_count }}</h4>
                                            <div class="text-uppercase font-sm">Prenotazioni ricevute</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php $list = \App\Models\PluginParkingReservation::orderBy("created_at", "desc")->take(5)->get(); ?>
                        @if(count($list))
                            <h6 class="text-uppercase line-height-xs mt-3">Ultime prenotazioni</h6>
                            <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Tipo</th>
                                    <th>Totale</th>
                                    <th>Data inizio</th>
                                    <th>Data fine</th>
                                    <th></th>
                                </tr>
                                </thead>
                                @foreach($list as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{!! $order->getType() !!}</td>
                                        <td>{!! $order->getTotal() !!}</td>
                                        <td>{!! $order->getStart() !!}</td>
                                        <td>{!! $order->getEnd() !!}</td>
                                        <td class="text-right"><a class="font-xs"href="/admin/plugin-parking-reservation/{{ $order->id }}/edit">Visualizza</a></td>
                                    </tr>
                                @endforeach
                            </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(env('LOCAL') == 0)
        <?php
            $gestDB = \DB::connection('mysql_2');
            $news = $gestDB->table("news")->where("is_active", 1)->orderBy("lft", "asc")->take(5)->get();
        ?>

        @if($news)
            <div class="row gutter-3">
                <div class="col-xl-12 mb-4">
                    <div class="card-header">
                        <h5 class="line-height-xs my-0">News</h5>
                    </div>
                    <div class="card-body flex-grow-0">
                        @foreach($news as $new)
                            <div class="mb-5">
                                <h5>{{ $new->title }}</h5>
                                {!! $new->description !!}
                                <small>{{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $new->created_at)->format("d/m/Y") }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endif

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


