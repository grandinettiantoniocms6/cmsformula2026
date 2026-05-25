@php
    $dashboardProductsPlugin = \App\Models\AdminPlugin::where('name', 'pluginProducts')
        ->where('is_active', 1)
        ->where('version', 3)
        ->first();

    $canShowProductsDashboardCards = $dashboardProductsPlugin
        && \Schema::hasTable('shop_orders')
        && \Schema::hasTable('shop_order_product')
        && \Schema::hasTable('plugins_products')
        && \Schema::hasTable('users');

    $shopDashboardSettings = $canShowProductsDashboardCards && class_exists(\App\Models\ShopSettings::class)
        ? \App\Models\ShopSettings::first()
        : null;

    $orderStatusDashboardId = optional($shopDashboardSettings)->status_default_order_dashboard;

    $topProductsDashboard = $canShowProductsDashboardCards
        ? \App\Models\OrderProduct::selectRaw('COUNT(*) as tot, product_id, plugins_products.name')
            ->join('shop_orders', 'shop_orders.id', '=', 'shop_order_product.order_id')
            ->join('plugins_products', 'plugins_products.id', '=', 'shop_order_product.product_id')
            ->whereNull('shop_orders.deleted_at')
            ->groupBy('product_id')
            ->groupBy('plugins_products.name')
            ->orderBy('tot', 'desc')
            ->take(10)
            ->get()
        : collect();

    $topClientsDashboard = $canShowProductsDashboardCards
        ? \App\Models\Order::selectRaw('COUNT(*) as tot, shop_orders.user_id, users.name')
            ->join('users', 'users.id', '=', 'shop_orders.user_id')
            ->whereNull('shop_orders.deleted_at')
            ->groupBy('shop_orders.user_id')
            ->groupBy('users.name')
            ->orderBy('tot', 'desc')
            ->take(10)
            ->get()
        : collect();

    $currentYearDashboard = \Carbon\Carbon::now()->format('Y');
    $monthlyOrdersDashboard = $canShowProductsDashboardCards
        ? \App\Models\Order::selectRaw('SUBSTRING(created_at,6,2) as date_order_month, sum(total) as sum_total')
            ->whereYear('created_at', $currentYearDashboard)
            ->groupBy('date_order_month')
            ->get()
            ->pluck('sum_total', 'date_order_month')
            ->toArray()
        : [];

    $monthLabelsDashboard = [
        '01' => 'Gennaio',
        '02' => 'Febbraio',
        '03' => 'Marzo',
        '04' => 'Aprile',
        '05' => 'Maggio',
        '06' => 'Giugno',
        '07' => 'Luglio',
        '08' => 'Agosto',
        '09' => 'Settembre',
        '10' => 'Ottobre',
        '11' => 'Novembre',
        '12' => 'Dicembre',
    ];

    $lastSevenDaysDashboard = [];
    if ($canShowProductsDashboardCards) {
        for ($i = 6; $i >= 0; $i--) {
            $day = \Carbon\Carbon::today()->subDays($i);
            $lastSevenDaysDashboard[$day->toDateString()] = \App\Models\Order::whereDate('created_at', $day->toDateString())->sum('total');
        }
    }

    $ordersQueryDashboard = $canShowProductsDashboardCards ? \App\Models\Order::query() : null;
    $orderSumDashboard = 0;
    $orderCountDashboard = 0;
    if ($ordersQueryDashboard) {
        if ($orderStatusDashboardId) {
            $orderSumDashboard = (float) \App\Models\Order::where('status_id', $orderStatusDashboardId)->sum('total_tax');
            $orderCountDashboard = (int) \App\Models\Order::where('status_id', $orderStatusDashboardId)->count();
        } else {
            $orderSumDashboard = (float) \App\Models\Order::sum('total_tax');
            $orderCountDashboard = (int) \App\Models\Order::count();
        }
    }

    $parentProductCountDashboard = $canShowProductsDashboardCards
        ? \App\Models\PluginProducts::where('is_variant', 0)->count()
        : 0;
    $variantProductCountDashboard = $canShowProductsDashboardCards
        ? \App\Models\PluginProducts::where('is_variant', 1)->count()
        : 0;
    $latestOrdersDashboard = $canShowProductsDashboardCards
        ? \App\Models\Order::with('user')->orderBy('created_at', 'desc')->take(5)->get()
        : collect();

    $dashboardProductName = static function ($value): ?string {
        $decoded = json_decode((string) $value, true);
        if (is_array($decoded)) {
            $locale = app()->getLocale();
            return trim((string) ($decoded[$locale] ?? $decoded['it'] ?? reset($decoded)));
        }

        $raw = trim((string) $value);
        return $raw !== '' ? $raw : null;
    };

    $dashboardProductsInitialSlide = $dashboardProductsInitialSlide ?? 'products';
    $dashboardProductsSlides = ['products', 'clients', 'monthly', 'last_7_days'];
    if (!in_array($dashboardProductsInitialSlide, $dashboardProductsSlides, true)) {
        $dashboardProductsInitialSlide = 'products';
    }
@endphp

@if($canShowProductsDashboardCards)
    <div class="row gutter-3 dashboard-products-summary">
        <div class="col-xl-6 mb-4">
            <div class="card card-dashboard">
                <div id="carousel-top-plugin-products" class="carousel slide carousel-dash" data-ride="carousel" data-interval="6000">
                    <div class="carousel-inner">
                        <div class="carousel-item flex-column {{ $dashboardProductsInitialSlide === 'products' ? 'active' : '' }}">
                            <div class="card-header">
                                <div class="row gutter-1 align-items-center flex-grow-1">
                                    <div class="col">
                                        <h5 class="line-height-xs my-0">Top 10 Prodotti</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Prodotti</button>
                                            <div class="dropdown-menu dropdown-menu-right font-sm">
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="0" disabled>Prodotti</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="1">Clienti</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="2">Andamento Mensile</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="3">Ultimi 7 Giorni</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body py-2">
                                <table class="table table-borderless line-height-sm mb-0" id="table-top-prodotti">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Prodotto</th>
                                        <th>N.Acq.</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($topProductsDashboard as $index => $productRow)
                                        @php($productNameDashboard = $dashboardProductName($productRow->name))
                                        @if($productNameDashboard)
                                            <tr>
                                                <td width="50">{{ $index + 1 }}&deg;</td>
                                                <td>{{ $productNameDashboard }}</td>
                                                <td width="50">{{ $productRow->tot }}</td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted">Nessun prodotto acquistato.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="carousel-item flex-column {{ $dashboardProductsInitialSlide === 'clients' ? 'active' : '' }}">
                            <div class="card-header">
                                <div class="row gutter-1 align-items-center flex-grow-1">
                                    <div class="col">
                                        <h5 class="line-height-xs my-0">Top 10 Clienti</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Clienti</button>
                                            <div class="dropdown-menu dropdown-menu-right font-sm">
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="0">Prodotti</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="1" disabled>Clienti</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="2">Andamento Mensile</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="3">Ultimi 7 Giorni</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body py-2">
                                <table class="table table-borderless line-height-sm mb-0" id="table-top-clienti">
                                    <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Cliente</th>
                                        <th width="50">N.Acq.</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($topClientsDashboard as $index => $clientRow)
                                        <tr>
                                            <td>{{ $index + 1 }}&deg;</td>
                                            <td>{{ $clientRow->name }}</td>
                                            <td>{{ $clientRow->tot }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted">Nessun cliente presente.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="carousel-item flex-column {{ $dashboardProductsInitialSlide === 'monthly' ? 'active' : '' }}">
                            <div class="card-header">
                                <div class="row gutter-1 align-items-center flex-grow-1">
                                    <div class="col">
                                        <h5 class="line-height-xs my-0">Andamento Mensile {{ $currentYearDashboard }}</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Andamento Mensile</button>
                                            <div class="dropdown-menu dropdown-menu-right font-sm">
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="0">Prodotti</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="1">Clienti</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="2" disabled>Andamento Mensile</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="3">Ultimi 7 Giorni</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body py-2">
                                <table class="table table-borderless line-height-sm mb-0" id="table-top-mensile">
                                    <thead>
                                    <tr>
                                        <th>Mese</th>
                                        <th width="150">Totale</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($monthlyOrdersDashboard as $monthKey => $monthValue)
                                        <tr>
                                            <td>{{ $monthLabelsDashboard[$monthKey] ?? $monthKey }}</td>
                                            <td>{{ number_format($monthValue, 2, ',', '.') }} &euro;</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-muted">Nessun ordine mensile presente.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="carousel-item flex-column {{ $dashboardProductsInitialSlide === 'last_7_days' ? 'active' : '' }}">
                            <div class="card-header">
                                <div class="row gutter-1 align-items-center flex-grow-1">
                                    <div class="col">
                                        <h5 class="line-height-xs my-0">Ultimi 7 Giorni</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn py-1 font-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Ultimi 7 Giorni</button>
                                            <div class="dropdown-menu dropdown-menu-right font-sm">
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="0">Prodotti</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="1">Clienti</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="2">Andamento Mensile</a>
                                                <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-plugin-products" data-slide-to="3" disabled>Ultimi 7 Giorni</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body py-2">
                                <table class="table table-borderless line-height-sm mb-0" id="table-top-giorno">
                                    <thead>
                                    <tr>
                                        <th>Giorno</th>
                                        <th width="150">Totale</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lastSevenDaysDashboard as $dayKey => $dayValue)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $dayKey)->format('d/m/Y') }}</td>
                                            <td>{{ number_format($dayValue, 2, ',', '.') }} &euro;</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
                    <div class="row align-items-end border-bottom">
                        <div class="col-sm mb-3">
                            <div class="media align-items-center">
                                <i class="hgi hgi-stroke hgi-coins-euro font-5xl line-height-sm"></i>
                                <div class="media-body ml-3">
                                    <h4 class="font-3xl mb-0 line-height-sm">&euro; {{ number_format($orderSumDashboard, 2, ',', '.') }}</h4>
                                    <div class="text-uppercase">Ad oggi</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-auto mb-3">
                            <div class="media align-items-center">
                                <i class="hgi hgi-stroke hgi-sharp hgi-delivery-box-01 font-5xl line-height-sm"></i>
                                <div class="media-body ml-3">
                                    <div class="d-flex">
                                        <div class="mr-4">
                                            <h4 class="font-2xl mb-0 line-height-sm">{{ $parentProductCountDashboard }}</h4>
                                            <div class="text-uppercase font-sm">Prodotti padre</div>
                                        </div>
                                        <div>
                                            <h4 class="font-2xl mb-0 line-height-sm">{{ $variantProductCountDashboard }}</h4>
                                            <div class="text-uppercase font-sm">Varianti</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-auto mb-3">
                            <div class="media align-items-center">
                                <i class="hgi hgi-stroke hgi-shopping-cart-check-in-02 font-5xl line-height-sm"></i>
                                <div class="media-body ml-3">
                                    <h4 class="font-2xl mb-0 line-height-sm">{{ $orderCountDashboard }}</h4>
                                    <div class="text-uppercase font-sm">Ordini ricevuti</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($latestOrdersDashboard->isNotEmpty())
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
                                <tbody>
                                @foreach($latestOrdersDashboard as $order)
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
                                        <td>{{ number_format($order->total_shipping_tax, 2, ',', '.') }}</td>
                                        <td>{{ optional($order->created_at)->format('d/m/Y') }}</td>
                                        <td class="text-right"><a class="font-xs" href="/admin/shopOrders/{{ $order->id }}/show">Visualizza</a></td>
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
@endif
