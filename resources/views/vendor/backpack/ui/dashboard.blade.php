@extends(backpack_view('blank'))

<?php
    $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->where("is_active", 1)->where("version", 3)->first();
    $adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
    $adminPluginParking = \App\Models\AdminPlugin::where("name", "pluginParking")->where("is_active", 1)->first();
    $shopSetting = \App\Models\ShopSettings::first();
    $websiteSetting = \App\Models\WebsiteSetting::first();
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $dashboardTodos = \App\Models\DashboardTodo::where('user_id', backpack_user()->id)
        ->orderBy('sort_order', 'asc')
        ->orderBy('id', 'asc')
        ->get();
    $dashboardGif = url("img/dashboard.gif");
    if($websiteSetting && $websiteSetting->dashboard_gif){
        if(\Illuminate\Support\Str::startsWith($websiteSetting->dashboard_gif, ["http://", "https://"])){
            $dashboardGif = $websiteSetting->dashboard_gif;
        }else{
            $dashboardGif = url(ltrim($websiteSetting->dashboard_gif, "/"));
        }
    }
?>

@section('header')
    <meta charset="UTF-8">
    <h3 class="page-title mb-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <span class="text-capitalize">Bacheca</span>
        <small class="dashboard-subtitle">Panoramica operativa</small>
    </h3>
@endsection

@section('content')
    <div class="row gutter-3">
        <div class="col-xl-8 mb-3">
            <div class="dashboard-hero-card">
                <img src="{{ $dashboardGif }}" class="img-fluid dashboard-hero-image" alt="Dashboard preview">
            </div>
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

                    <div class="dashboard-digital-clock mb-3">
                        <div class="dashboard-digital-clock-label">Ora locale</div>
                        <div class="dashboard-digital-clock-time" id="dashboardDigitalClock">--:--:--</div>
                    </div>

                    @if(env('NASCONDI_FRONTEND') == 0)
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
                    @endif

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
        <div class="col-xl-6 mb-3">
            <div class="row gutter-3">
                @if(env('NASCONDI_FRONTEND') == 0)
                    <div class="col-6 col-md-4 mb-3">
                        <a class="card card-link card-link-modern p-2" href="/admin/page/create">
                            <i class="hgi hgi-stroke hgi-add-circle"></i>
                            <h6>Nuova pagina</h6>
                        </a>
                    </div>

                    <div class="col-6 col-md-4 mb-3">
                        <a class="card card-link card-link-modern p-2" href="/admin/page">
                            <i class="hgi hgi-stroke hgi-file-01"></i>
                            <h6>Elenco Pagine</h6>
                        </a>
                    </div>

                    <div class="col-6 col-md-4 mb-3">
                        <a class="card card-link card-link-modern p-2" href="/admin/elfinder">
                            <i class="nav-icon hgi hgi-stroke hgi-image-add-02"></i>
                            <h6>File Manager</h6>
                        </a>
                    </div>
                @endif

                <div class="col-6 col-md-4 mb-3">
                    <a class="card card-link card-link-modern p-2" href="/admin/websiteSetting/1/edit">
                        <i class="hgi hgi-stroke hgi-settings-05"></i>
                        <h6>Impostazioni</h6>
                    </a>
                </div>

                <div class="col-6 col-md-4 mb-3">
                    <a class="card card-link card-link-modern p-2" href="/admin/pluginTutorial/view">
                        <i class="hgi hgi-stroke hgi-youtube"></i>
                        <h6>Tutorial</h6>
                    </a>
                </div>

                <div class="col-6 col-md-4 mb-3">
                    <a class="card card-link card-link-modern p-2" href="https://www.webisland.it/contatti" target="_blank">
                        <i class="hgi hgi-stroke hgi-file-01"></i>
                        <h6>Richiedi Assistenza</h6>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mb-3">
            <div class="card card-dashboard h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="line-height-xs my-0">Note</h5>
                    <small class="text-muted">Appunti amministratore</small>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="dashboardTodoInput" maxlength="255" placeholder="Scrivi una nota e premi Invio">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="dashboardTodoAdd">Salva</button>
                        </div>
                    </div>

                    <ul class="dashboard-todo-list mb-0" id="dashboardTodoList">
                        @foreach($dashboardTodos as $todo)
                            <li class="dashboard-todo-item {{ $todo->is_done ? 'is-done' : '' }}" data-id="{{ $todo->id }}" data-full-title="{{ e($todo->title) }}" draggable="true">
                                <div class="dashboard-todo-date">{{ optional($todo->created_at)->format('d/m/Y') }}</div>
                                <div class="dashboard-todo-title">{{ \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $todo->title))), 100, '...') }}</div>
                                <div class="dashboard-todo-actions">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-action="toggle">{{ $todo->is_done ? 'Riapri' : 'Fatto' }}</button>
                                    <button type="button" class="btn btn-sm btn-light" data-action="edit">Modifica</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-action="delete">Elimina</button>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="dashboard-todo-empty {{ count($dashboardTodos) ? 'd-none' : '' }}" id="dashboardTodoEmpty">
                        Nessuna nota presente.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dashboardTodoEditorModal" tabindex="-1" role="dialog" aria-labelledby="dashboardTodoEditorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dashboardTodoEditorModalLabel">Modifica nota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="dashboardTodoEditor"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Annulla</button>
                    <button type="button" class="btn btn-primary" id="dashboardTodoEditorSave">Salva modifiche</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dashboardTodoDeleteModal" tabindex="-1" role="dialog" aria-labelledby="dashboardTodoDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dashboardTodoDeleteModalLabel">Conferma eliminazione</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Vuoi eliminare questa nota?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Annulla</button>
                    <button type="button" class="btn btn-danger" id="dashboardTodoDeleteConfirm">Elimina nota</button>
                </div>
            </div>
        </div>
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
                                                if(!$name){
                                                    continue;
                                                }
                                                if(!key_exists("it", $name)){
                                                    continue;
                                                }
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
                        $order_sum = \App\Models\Order::where("status_id", $shopSetting->status_default_order_dashboard)->sum("total_tax");
                        $order_count = \App\Models\Order::where("status_id", $shopSetting->status_default_order_dashboard)->count();
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
                                            <h5 class="line-height-xs my-0">Top</h5>
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
                                            <h5 class="line-height-xs my-0">Top</h5>
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
                                            <h5 class="line-height-xs my-0">Top</h5>
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
                                            <h5 class="line-height-xs my-0">Top</h5>
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

@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('packages/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/summernote/dist/summernote-bs4.css') }}">
    <link href="{{ url('/css/dashboard.css') }}" rel="stylesheet">
    <style>
        .dashboard-digital-clock {
            border: 1px solid #dbe7f6;
            border-radius: 12px;
            background: #f8fbff;
            padding: .65rem .8rem;
        }

        .dashboard-digital-clock-label {
            color: #4a5f84;
            font-size: .72rem;
            letter-spacing: .04em;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: .2rem;
        }

        .dashboard-digital-clock-time {
            color: #0f2f61;
            font-size: 1.55rem;
            font-weight: 700;
            line-height: 1.1;
            font-variant-numeric: tabular-nums;
            font-family: "Consolas", "Menlo", "Monaco", monospace;
        }

        .dashboard-todo-list {
            list-style: none;
            padding: 0;
            max-height: 350px;
            overflow-y: auto;
        }

        .dashboard-todo-item {
            border: 1px solid #dbe7f6;
            border-radius: 10px;
            padding: .6rem .7rem;
            background: #f8fbff;
            margin-bottom: .55rem;
            cursor: move;
        }

        .dashboard-todo-item.is-done .dashboard-todo-title {
            text-decoration: line-through;
            opacity: .7;
        }

        .dashboard-todo-item.is-dragging {
            opacity: .55;
            background: #edf4ff;
        }

        .dashboard-todo-title {
            font-weight: 600;
            color: #0f2f61;
            word-break: break-word;
            margin-bottom: .45rem;
            white-space: normal;
        }

        .dashboard-todo-date {
            color: #64748b;
            font-size: .76rem;
            font-weight: 600;
            margin-bottom: .25rem;
        }

        .dashboard-todo-actions {
            display: flex;
            gap: .35rem;
            flex-wrap: wrap;
        }

        .dashboard-todo-empty {
            color: #64748b;
            font-size: .9rem;
        }
    </style>
    @if($isModernAdminTemplate)
    <style>
        .dashboard-subtitle {
            color: #64748b;
            font-size: .95rem;
            font-weight: 500;
        }

        .dashboard-hero-card {
            border-radius: 18px;
            overflow: hidden;
            background: radial-gradient(circle at top right, #dbeafe 0%, #eef2ff 35%, #ffffff 100%);
            box-shadow: 0 14px 40px rgba(15, 23, 42, .08);
            border: 1px solid #e2e8f0;
            padding: .5rem;
        }

        .dashboard-hero-image {
            width: 100%;
            border-radius: 14px;
        }

        .card-dashboard {
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 28px rgba(15, 23, 42, .06);
        }

        .card-dashboard .card-header {
            background: linear-gradient(90deg, #f8fafc 0%, #ffffff 100%);
            border-bottom: 1px solid #e2e8f0;
        }

        #carousel-top-1 .card-header,
        #carousel-top-2 .card-header,
        #carousel-top-3 .card-header {
            background: linear-gradient(135deg, #f3f7ff 0%, #eef6ff 48%, #f8fcff 100%);
            border-bottom: 1px solid #dce8f8;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }

        #carousel-top-1 .card-header h5,
        #carousel-top-2 .card-header h5,
        #carousel-top-3 .card-header h5 {
            color: #16345f;
            font-weight: 700;
            letter-spacing: .015em;
        }

        #carousel-top-1 .card-header .btn.dropdown-toggle,
        #carousel-top-2 .card-header .btn.dropdown-toggle,
        #carousel-top-3 .card-header .btn.dropdown-toggle {
            background: #ffffff;
            border: 1px solid #d5e4f7;
            border-radius: 999px;
            color: #1d3d6e;
            font-weight: 600;
            padding-left: .75rem;
            padding-right: .75rem;
        }

        .card-link-modern {
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .05);
            transition: all .2s ease;
            text-decoration: none !important;
            background: #fff;
            min-height: 104px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: .35rem;
        }

        .card-link-modern i {
            font-size: 1.25rem;
            color: #0f766e;
        }

        .card-link-modern h6 {
            font-weight: 600;
            margin: 0;
            color: #0f172a;
        }

        .card-link-modern:hover {
            transform: translateY(-3px);
            border-color: #bae6fd;
            box-shadow: 0 14px 24px rgba(2, 132, 199, .14);
        }

        .card-dashboard .table {
            font-size: .92rem;
        }

        .card-dashboard .table thead th {
            color: #475569;
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .02em;
            border-top: 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .card-dashboard .table tbody tr:hover {
            background: #f8fafc;
        }

        #table-top-prodotti,
        #table-top-clienti,
        #table-top-mensile,
        #table-top-giorno {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        #table-top-prodotti thead th,
        #table-top-clienti thead th,
        #table-top-mensile thead th,
        #table-top-giorno thead th {
            border-bottom: 0;
            color: #617697;
            font-size: .73rem;
            font-weight: 700;
            letter-spacing: .04em;
        }

        #table-top-prodotti tbody tr,
        #table-top-clienti tbody tr,
        #table-top-mensile tbody tr,
        #table-top-giorno tbody tr {
            background: #f7faff;
            box-shadow: 0 5px 14px rgba(15, 23, 42, .05);
        }

        #table-top-prodotti tbody td,
        #table-top-clienti tbody td,
        #table-top-mensile tbody td,
        #table-top-giorno tbody td {
            border-top: 0;
            border-bottom: 0;
            padding: .5rem .65rem;
            color: #1d3558;
        }

        #table-top-prodotti tbody tr td:first-child,
        #table-top-clienti tbody tr td:first-child {
            width: 52px;
            font-weight: 700;
            color: #0f3f7f;
            background: #e6f0ff;
            border-top-left-radius: 9px;
            border-bottom-left-radius: 9px;
            text-align: center;
        }

        #table-top-prodotti tbody tr td:last-child,
        #table-top-clienti tbody tr td:last-child,
        #table-top-mensile tbody tr td:last-child,
        #table-top-giorno tbody tr td:last-child {
            border-top-right-radius: 9px;
            border-bottom-right-radius: 9px;
            font-weight: 700;
            color: #144277;
        }

        .card-dashboard .card-body.flex-grow-0 > .row.align-items-end.border-bottom {
            border-bottom: 0 !important;
            border-radius: 14px;
            background: linear-gradient(135deg, #eef4ff 0%, #f8fbff 100%);
            padding: .8rem .65rem .15rem;
            margin-bottom: .75rem;
        }

        .card-dashboard .card-body.flex-grow-0 > .row.align-items-end.border-bottom .media {
            align-items: center;
            background: #ffffff;
            border: 1px solid #dbe7f6;
            border-radius: 12px;
            padding: .65rem .8rem;
            min-height: 88px;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .06);
        }

        .card-dashboard .card-body.flex-grow-0 > .row.align-items-end.border-bottom .media i {
            color: #1f3a6d;
            font-size: 2.05rem !important;
            background: #eaf1ff;
            border-radius: 10px;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-dashboard .card-body.flex-grow-0 > .row.align-items-end.border-bottom .media .media-body h4 {
            color: #0f2f61;
            font-weight: 700;
            margin-bottom: .1rem !important;
        }

        .card-dashboard .card-body.flex-grow-0 > .row.align-items-end.border-bottom .media .media-body .text-uppercase {
            color: #4a5f84;
            font-size: .7rem;
            letter-spacing: .04em;
            font-weight: 700;
        }

        .card-dashboard .card-body h6.text-uppercase.line-height-xs.mt-3 {
            color: #334c76;
            font-weight: 700;
            letter-spacing: .03em;
        }

        .progress {
            border-radius: 999px;
            background: #e2e8f0;
        }

        .progress-bar {
            border-radius: 999px;
        }

        .dropdown-menu {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 16px 30px rgba(15, 23, 42, .1);
        }

        @media (max-width: 992px) {
            .dashboard-subtitle {
                width: 100%;
                margin-top: .25rem;
            }
        }
    </style>
    @endif
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('packages/select2/dist/js/i18n/it.js') }}"></script>
    <script src="{{ asset('packages/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('packages/summernote/dist/lang/summernote-it-IT.min.js') }}"></script>

    <script src="{{ asset('packages/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dashboardDigitalClock = document.getElementById('dashboardDigitalClock');
            if (dashboardDigitalClock) {
                const updateDigitalClock = function() {
                    const now = new Date();
                    dashboardDigitalClock.textContent = now.toLocaleTimeString('it-IT', {hour: '2-digit', minute: '2-digit', hour12: false});
                };

                updateDigitalClock();
                setInterval(updateDigitalClock, 1000);
            }

            const todoInput = document.getElementById('dashboardTodoInput');
            const todoAddButton = document.getElementById('dashboardTodoAdd');
            const todoList = document.getElementById('dashboardTodoList');
            const todoEmpty = document.getElementById('dashboardTodoEmpty');
            const todoEditorSaveButton = document.getElementById('dashboardTodoEditorSave');
            const todoDeleteConfirmButton = document.getElementById('dashboardTodoDeleteConfirm');
            if (!todoInput || !todoAddButton || !todoList || !todoEmpty) {
                return;
            }

            const todoBaseUrl = @json(backpack_url('dashboard/todos'));
            const csrfToken = '{{ csrf_token() }}';
            let todoEditingItem = null;
            let todoDeletingItem = null;
            let draggingTodoItem = null;

            $('#dashboardTodoEditor').summernote({
                lang: 'it-IT',
                height: 180,
                toolbar: [
                    ['history', ['undo', 'redo']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['codeview']]
                ],
                callbacks: {
                    onPaste: function(event) {
                        event.preventDefault();
                        const clipboardData = (event.originalEvent || event).clipboardData;
                        const plainText = clipboardData ? (clipboardData.getData('text/plain') || '') : '';
                        document.execCommand('insertText', false, plainText);
                    }
                }
            });

            const setTodoEmptyState = function() {
                todoEmpty.classList.toggle('d-none', todoList.children.length > 0);
            };

            const getPlainTextFromHtml = function(html) {
                const htmlWithBreaks = (html || '')
                    .replace(/<br\s*\/?>/gi, '\n')
                    .replace(/<\/(p|div|li|h1|h2|h3|h4|h5|h6)>/gi, '\n')
                    .replace(/<li[^>]*>/gi, '- ');

                const tmp = document.createElement('div');
                tmp.innerHTML = htmlWithBreaks;

                let text = (tmp.textContent || tmp.innerText || '');
                text = text.replace(/\u00a0/g, ' ');
                text = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n');
                text = text.replace(/[ \t]+\n/g, '\n').replace(/\n[ \t]+/g, '\n');
                text = text.replace(/\n{3,}/g, '\n\n');
                return text.trim();
            };

            const normalizeSpaces = function(text) {
                return (text || '').replace(/\s+/g, ' ').trim();
            };

            const getTodoPreview = function(html) {
                const plain = normalizeSpaces(getPlainTextFromHtml(html));
                if (plain.length <= 100) {
                    return plain;
                }
                return plain.substring(0, 100) + '...';
            };

            const setTodoDisplay = function(item, html) {
                const safeHtml = (html || '').trim();
                item.dataset.fullTitle = safeHtml;
                const title = item.querySelector('.dashboard-todo-title');
                if (title) {
                    title.textContent = getTodoPreview(safeHtml);
                }
            };

            const createTodoElement = function(todo) {
                const item = document.createElement('li');
                item.className = 'dashboard-todo-item' + (todo.is_done ? ' is-done' : '');
                item.dataset.id = String(todo.id);
                item.draggable = true;

                const createdAt = document.createElement('div');
                createdAt.className = 'dashboard-todo-date';
                createdAt.textContent = formatTodoDate(todo.created_at);

                const title = document.createElement('div');
                title.className = 'dashboard-todo-title';
                title.textContent = getTodoPreview(todo.title);

                const actions = document.createElement('div');
                actions.className = 'dashboard-todo-actions';

                const toggleBtn = document.createElement('button');
                toggleBtn.type = 'button';
                toggleBtn.className = 'btn btn-sm btn-outline-secondary';
                toggleBtn.dataset.action = 'toggle';
                toggleBtn.textContent = todo.is_done ? 'Riapri' : 'Fatto';

                const editBtn = document.createElement('button');
                editBtn.type = 'button';
                editBtn.className = 'btn btn-sm btn-light';
                editBtn.dataset.action = 'edit';
                editBtn.textContent = 'Modifica';

                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'btn btn-sm btn-outline-danger';
                deleteBtn.dataset.action = 'delete';
                deleteBtn.textContent = 'Elimina';

                actions.appendChild(toggleBtn);
                actions.appendChild(editBtn);
                actions.appendChild(deleteBtn);
                item.appendChild(createdAt);
                item.appendChild(title);
                item.appendChild(actions);
                item.dataset.fullTitle = todo.title || '';

                return item;
            };

            const applyTodoOnElement = function(item, todo) {
                item.classList.toggle('is-done', !!todo.is_done);
                const toggleBtn = item.querySelector('[data-action="toggle"]');
                setTodoDisplay(item, todo.title);
                if (toggleBtn) {
                    toggleBtn.textContent = todo.is_done ? 'Riapri' : 'Fatto';
                }
            };

            const todoRequest = async function(url, method, payload) {
                const options = {
                    method: method,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                };

                if (payload) {
                    options.headers['Content-Type'] = 'application/json';
                    options.body = JSON.stringify(payload);
                }

                const response = await fetch(url, options);
                if (!response.ok) {
                    throw new Error('Request failed');
                }

                return response.json();
            };

            const formatTodoDate = function(value) {
                if (!value) {
                    return '';
                }
                const date = new Date(value);
                if (Number.isNaN(date.getTime())) {
                    return '';
                }
                return date.toLocaleDateString('it-IT');
            };

            const addTodo = async function() {
                const title = todoInput.value.trim();
                if (!title) {
                    return;
                }

                todoAddButton.disabled = true;
                try {
                    const result = await todoRequest(todoBaseUrl, 'POST', { title: title });
                    if (result && result.todo) {
                        const item = createTodoElement(result.todo);
                        todoList.append(item);
                        todoInput.value = '';
                        setTodoEmptyState();
                    }
                } catch (error) {
                    alert('Errore nel salvataggio della nota.');
                } finally {
                    todoAddButton.disabled = false;
                    todoInput.focus();
                }
            };

            const persistTodoOrder = async function() {
                const ids = Array.from(todoList.querySelectorAll('.dashboard-todo-item'))
                    .map((el) => parseInt(el.dataset.id, 10))
                    .filter((id) => Number.isInteger(id));

                if (!ids.length) {
                    return;
                }

                try {
                    await todoRequest(todoBaseUrl + '/reorder', 'POST', { ids: ids });
                } catch (error) {
                    alert('Errore durante il salvataggio dell\'ordine note.');
                }
            };

            todoList.addEventListener('dragstart', function(event) {
                const item = event.target.closest('.dashboard-todo-item');
                if (!item) {
                    return;
                }
                draggingTodoItem = item;
                item.classList.add('is-dragging');
                if (event.dataTransfer) {
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/plain', item.dataset.id || '');
                }
            });

            todoList.addEventListener('dragover', function(event) {
                event.preventDefault();
                if (!draggingTodoItem) {
                    return;
                }

                const target = event.target.closest('.dashboard-todo-item');
                if (!target || target === draggingTodoItem) {
                    return;
                }

                const rect = target.getBoundingClientRect();
                const shouldInsertBefore = event.clientY < rect.top + (rect.height / 2);
                if (shouldInsertBefore) {
                    todoList.insertBefore(draggingTodoItem, target);
                } else {
                    todoList.insertBefore(draggingTodoItem, target.nextSibling);
                }
            });

            todoList.addEventListener('dragend', function() {
                if (!draggingTodoItem) {
                    return;
                }
                draggingTodoItem.classList.remove('is-dragging');
                draggingTodoItem = null;
                persistTodoOrder();
            });

            todoAddButton.addEventListener('click', addTodo);
            todoInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    addTodo();
                }
            });

            todoList.addEventListener('click', async function(event) {
                const button = event.target.closest('button[data-action]');
                if (!button) {
                    return;
                }

                const item = button.closest('.dashboard-todo-item');
                if (!item) {
                    return;
                }

                const todoId = item.dataset.id;
                const action = button.dataset.action;

                if (action === 'edit') {
                    todoEditingItem = item;
                    const currentTitleHtml = item.dataset.fullTitle || '';
                    const hasHtmlTag = /<\/?[a-z][\s\S]*>/i.test(currentTitleHtml);
                    const editorContent = hasHtmlTag
                        ? currentTitleHtml
                        : $('<div/>').text(currentTitleHtml).html().replace(/\n/g, '<br>');
                    $('#dashboardTodoEditor').summernote('code', editorContent);
                    $('#dashboardTodoEditorModal').modal('show');
                    return;
                }

                if (action === 'toggle') {
                    try {
                        const result = await todoRequest(todoBaseUrl + '/' + todoId + '/toggle', 'POST');
                        if (result && result.todo) {
                            applyTodoOnElement(item, result.todo);
                        }
                    } catch (error) {
                        alert('Errore durante l\'aggiornamento della nota.');
                    }
                    return;
                }

                if (action === 'delete') {
                    todoDeletingItem = item;
                    $('#dashboardTodoDeleteModal').modal('show');
                }
            });

            if (todoEditorSaveButton) {
                todoEditorSaveButton.addEventListener('click', async function() {
                    if (!todoEditingItem) {
                        return;
                    }

                    const todoId = todoEditingItem.dataset.id;
                    const html = $('#dashboardTodoEditor').summernote('code');
                    const plainText = getPlainTextFromHtml(html);
                    if (!plainText) {
                        alert('La nota non puo essere vuota.');
                        return;
                    }

                    todoEditorSaveButton.disabled = true;
                    try {
                        const result = await todoRequest(todoBaseUrl + '/' + todoId, 'PUT', { title: html });
                        if (result && result.todo) {
                            applyTodoOnElement(todoEditingItem, result.todo);
                        }
                        $('#dashboardTodoEditorModal').modal('hide');
                    } catch (error) {
                        alert('Errore durante la modifica della nota.');
                    } finally {
                        todoEditorSaveButton.disabled = false;
                    }
                });
            }

            $('#dashboardTodoEditorModal').on('hidden.bs.modal', function() {
                todoEditingItem = null;
                $('#dashboardTodoEditor').summernote('code', '');
            });

            if (todoDeleteConfirmButton) {
                todoDeleteConfirmButton.addEventListener('click', async function() {
                    if (!todoDeletingItem) {
                        return;
                    }

                    const todoId = todoDeletingItem.dataset.id;
                    todoDeleteConfirmButton.disabled = true;
                    try {
                        await todoRequest(todoBaseUrl + '/' + todoId, 'DELETE');
                        todoDeletingItem.remove();
                        setTodoEmptyState();
                        $('#dashboardTodoDeleteModal').modal('hide');
                    } catch (error) {
                        alert('Errore durante l\'eliminazione della nota.');
                    } finally {
                        todoDeleteConfirmButton.disabled = false;
                    }
                });
            }

            $('#dashboardTodoDeleteModal').on('hidden.bs.modal', function() {
                todoDeletingItem = null;
            });

            setTodoEmptyState();
        });
    </script>
@endsection

@section('footer')
@endsection



