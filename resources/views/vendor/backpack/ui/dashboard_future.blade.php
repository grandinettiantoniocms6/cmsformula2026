@extends(backpack_view('blank'))

<?php
    $websiteSetting = \App\Models\WebsiteSetting::first();
    $shopSetting = \App\Models\ShopSettings::first();
    $dashboardTodos = \App\Models\DashboardTodo::where('user_id', backpack_user()->id)
        ->orderBy('sort_order', 'asc')
        ->orderBy('id', 'asc')
        ->get();

    $hasPagesTable = \Schema::hasTable('pages');
    $hasOrdersTable = \Schema::hasTable('shop_orders');
    $hasProductsTable = \Schema::hasTable('plugins_products');
    $hasUsersTable = \Schema::hasTable('users');
    $hasPagesUpdatedByColumn = $hasPagesTable && \Schema::hasColumn('pages', 'updated_by');
    $hasPagesUpdatedContextColumn = $hasPagesTable && \Schema::hasColumn('pages', 'updated_context');
    $hasPagesUpdatedBlockTypeColumn = $hasPagesTable && \Schema::hasColumn('pages', 'updated_block_type');
    $hasFrontendVisitsTable = \Schema::hasTable('frontend_page_visits_daily');
    $hasShopDashboardPlugin = \App\Models\AdminPlugin::where('name', 'pluginProducts')
        ->where('is_active', 1)
        ->exists();

    $today = \Carbon\Carbon::today();
    $pageCount = $hasPagesTable ? \App\Models\Page::count() : 0;
    $maxPages = max(0, (int) ($websiteSetting->number_max_page ?? 0));
    $remainingPages = max(0, $maxPages - $pageCount);
    $pagesPercent = $maxPages > 0 ? min(100, round(($pageCount / $maxPages) * 100, 1)) : 0;
    $pagesSparkX = 2 + (116 * ($pagesPercent / 100));
    $ordersTodayCount = ($hasOrdersTable && $hasShopDashboardPlugin) ? \App\Models\Order::whereDate('created_at', $today->toDateString())->count() : 0;
    $ordersTodayRevenue = ($hasOrdersTable && $hasShopDashboardPlugin) ? (float) \App\Models\Order::whereDate('created_at', $today->toDateString())->sum('total') : 0.0;
    $productsCount = $hasProductsTable ? \App\Models\PluginProducts::count() : 0;
    $usersCount = $hasUsersTable ? \App\User::count() : 0;
    $pendingTodosCount = (int) $dashboardTodos->where('is_done', false)->count();
    $completedTodosCount = (int) $dashboardTodos->where('is_done', true)->count();

    $uploadsFolder = public_path('/uploads');
    $uploadsBytes = is_dir($uploadsFolder) ? (int) folderSize($uploadsFolder) : 0;
    $uploadsLabel = formatSize($uploadsBytes);
    $parseStorageLimitToBytes = static function ($value): int {
        $defaultBytes = 500 * 1024 * 1024;
        if ($value === null) {
            return $defaultBytes;
        }

        $rawValue = trim((string) $value);
        if ($rawValue === '') {
            return $defaultBytes;
        }

        $normalized = str_replace(',', '.', strtoupper($rawValue));
        if (!preg_match('/^\s*(\d+(?:\.\d+)?)\s*(B|KB|MB|GB|TB)?\s*$/', $normalized, $matches)) {
            return $defaultBytes;
        }

        $amount = (float) $matches[1];
        $unit = $matches[2] ?? 'MB';
        $multipliers = [
            'B' => 1,
            'KB' => 1024,
            'MB' => 1024 * 1024,
            'GB' => 1024 * 1024 * 1024,
            'TB' => 1024 * 1024 * 1024 * 1024,
        ];

        return (int) max(1, round($amount * ($multipliers[$unit] ?? $multipliers['MB'])));
    };
    $uploadsMaxBytes = $parseStorageLimitToBytes(optional($websiteSetting)->server_allocated_space ?? '500 MB');
    $uploadsPercent = $uploadsMaxBytes > 0 ? min(100, round(($uploadsBytes / $uploadsMaxBytes) * 100, 1)) : 0;
    $uploadsPercentLabel = rtrim(rtrim(number_format($uploadsPercent, 1, '.', ''), '0'), '.').'%';
    $uploadsSparkX = 2 + (116 * ($uploadsPercent / 100));

    $onlineStatus = ($websiteSetting && (int) $websiteSetting->is_online === 1);
    $alertsCount = ($onlineStatus ? 0 : 1) + ($pendingTodosCount > 0 ? 1 : 0);

    $orderChartLabels = [];
    $orderChartSeries = [];
    $trafficDaysWindow = 90;
    $trafficStartDate = $today->copy()->subDays($trafficDaysWindow - 1)->toDateString();
    $trafficRawByDate = $hasFrontendVisitsTable
        ? \DB::table('frontend_page_visits_daily')
            ->whereBetween('visit_date', [$trafficStartDate, $today->toDateString()])
            ->pluck('visits', 'visit_date')
            ->toArray()
        : [];
    $visitsTodayCount = (int) ($trafficRawByDate[$today->toDateString()] ?? 0);

    for ($i = $trafficDaysWindow - 1; $i >= 0; $i--) {
        $day = \Carbon\Carbon::today()->subDays($i);
        $orderChartLabels[] = $day->format('d M');
        $orderChartSeries[] = (int) ($trafficRawByDate[$day->toDateString()] ?? 0);
    }

    $trafficSparkWindow = 14;
    $trafficSparkSeries = array_slice($orderChartSeries, -$trafficSparkWindow);
    if (count($trafficSparkSeries) === 0) {
        $trafficSparkSeries = [0, 0];
    }

    $trafficSparkCount = count($trafficSparkSeries);
    $trafficSparkMin = min($trafficSparkSeries);
    $trafficSparkMax = max($trafficSparkSeries);
    $trafficSparkRange = max(1, $trafficSparkMax - $trafficSparkMin);
    $trafficSparkStep = $trafficSparkCount > 1 ? 114 / ($trafficSparkCount - 1) : 0;
    $trafficSparkPoints = [];

    foreach ($trafficSparkSeries as $sparkIndex => $sparkValue) {
        $sparkX = 2 + ($trafficSparkStep * $sparkIndex);
        $sparkNormalized = ($sparkValue - $trafficSparkMin) / $trafficSparkRange;
        $sparkY = 20 - ($sparkNormalized * 14);
        $trafficSparkPoints[] = number_format($sparkX, 2, '.', '').' '.number_format($sparkY, 2, '.', '');
    }

    $trafficSparkPath = 'M '.implode(' L ', $trafficSparkPoints);

    $recentPagesColumns = ['id', 'title', 'updated_at'];
    if ($hasPagesUpdatedByColumn) {
        $recentPagesColumns[] = 'updated_by';
    }
    if ($hasPagesUpdatedContextColumn) {
        $recentPagesColumns[] = 'updated_context';
    }
    if ($hasPagesUpdatedBlockTypeColumn) {
        $recentPagesColumns[] = 'updated_block_type';
    }

    $recentPages = $hasPagesTable
        ? \App\Models\Page::orderBy('updated_at', 'desc')->get($recentPagesColumns)
        : collect();
    $recentOrders = ($hasOrdersTable && $hasShopDashboardPlugin)
        ? \App\Models\Order::orderBy('created_at', 'desc')->get(['id', 'created_at', 'total'])
        : collect();
    $recentActivities = collect();
    $isSuperAdminName = static function ($name): bool {
        $normalized = strtoupper(trim((string) $name));
        return $normalized === 'SUPER ADMIN';
    };

    $pageActorsByUserId = collect();
    if ($hasUsersTable && $hasPagesUpdatedByColumn && $recentPages->isNotEmpty()) {
        $pageUpdatedByIds = $recentPages->pluck('updated_by')->filter()->unique()->values();
        if ($pageUpdatedByIds->isNotEmpty()) {
            $pageActorsByUserId = \DB::table('users')->whereIn('id', $pageUpdatedByIds)->pluck('name', 'id');
        }
    }

    if ($recentPages->isNotEmpty()) {
        foreach ($recentPages as $page) {
            $pageUrl = '/admin/page/'.$page->id.'/edit';
            $pageActor = trim((string) ($pageActorsByUserId[$page->updated_by ?? null] ?? ''));
            if ($isSuperAdminName($pageActor)) {
                $pageActor = '';
            }
            $isBlockUpdate = (string) ($page->updated_context ?? '') === 'block';
            $blockTypeLabel = trim((string) ($page->updated_block_type ?? ''));
            $pageTitle = \Illuminate\Support\Str::limit(strip_tags((string) $page->title), 52);
            $activityTitle = $pageTitle;
            if ($isBlockUpdate) {
                $activityTitle = $blockTypeLabel !== ''
                    ? ('Pagina: '.$pageTitle.' | Blocco: '.$blockTypeLabel)
                    : ('Pagina: '.$pageTitle);
            }

            $recentActivities->push([
                'icon' => 'hgi-file-01',
                'label' => $isBlockUpdate ? 'Blocco aggiornato' : 'Pagina aggiornata',
                'title' => $activityTitle,
                'date' => optional($page->updated_at)->format('d/m/Y H:i'),
                'sort_at' => optional($page->updated_at)->timestamp ?? 0,
                'url' => $pageUrl,
                'actor' => $pageActor !== '' ? $pageActor : null,
            ]);
        }
    }

    if ($hasShopDashboardPlugin && $recentOrders->isNotEmpty()) {
        foreach ($recentOrders as $order) {
            $recentActivities->push([
                'icon' => 'hgi-shopping-bag-02',
                'label' => 'Ordine ricevuto',
                'title' => '#'.$order->id.' - EUR '.number_format((float) $order->total, 2, ',', '.'),
                'date' => optional($order->created_at)->format('d/m/Y H:i'),
                'sort_at' => optional($order->created_at)->timestamp ?? 0,
                'url' => '/admin/shopOrders/'.$order->id.'/show',
                'actor' => null,
            ]);
        }
    }

    $recentActivities = $recentActivities
        ->sortByDesc('sort_at')
        ->values();

    $insights = collect();
    if (!$onlineStatus) {
        $insights->push([
            'type' => 'warning',
            'title' => 'Sito offline',
            'text' => 'La modalita manutenzione e attiva.',
            'url' => '/admin/websiteSetting/1/edit',
            'cta' => 'Verifica',
        ]);
    }
    if ($pendingTodosCount > 0) {
        $insights->push([
            'type' => 'info',
            'title' => 'Task da completare',
            'text' => $pendingTodosCount.' note aperte in bacheca.',
            'url' => '#dashboardFutureTasks',
            'cta' => 'Apri task',
        ]);
    }
    if ($hasShopDashboardPlugin && $ordersTodayCount === 0) {
        $insights->push([
            'type' => 'neutral',
            'title' => 'Ordini fermi oggi',
            'text' => 'Nessun ordine registrato nella giornata.',
            'url' => null,
            'cta' => null,
        ]);
    }
    if ($insights->isEmpty()) {
        $insights->push([
            'type' => 'success',
            'title' => 'Operatività regolare',
            'text' => 'Nessun alert prioritario rilevato.',
            'url' => null,
            'cta' => null,
        ]);
    }

    $kpiCards = [
        [
            'icon' => 'hgi-user-group',
            'class' => 'bg-green',
            'label' => 'Pagine viste (oggi)',
            'value' => number_format($visitsTodayCount, 0, ',', '.'),
            'delta' => null,
            'delta_class' => 'up',
            'spark_type' => 'dynamic_line',
            'spark_path' => $trafficSparkPath,
        ],
        [
            'icon' => 'la-server',
            'icon_library' => 'la',
            'class' => 'bg-blue',
            'label' => 'Spazio server utilizzato',
            'value' => $uploadsLabel,
            'delta' => null,
            'delta_class' => 'flat',
            'spark_type' => 'progress',
            'spark_x' => $uploadsSparkX,
            'spark_percent' => $uploadsPercent,
            'spark_color' => 'blue',
            'progress_text' => $uploadsPercentLabel,
        ],
        [
            'icon' => 'hgi-file-01',
            'class' => 'bg-violet',
            'label' => 'Pagine create',
            'value' => number_format($pageCount, 0, ',', '.'),
            'delta' => 'su '.number_format($maxPages, 0, ',', '.').' disponibili',
            'delta_class' => 'flat',
            'spark_type' => 'progress',
            'spark_x' => $pagesSparkX,
            'spark_percent' => $pagesPercent,
            'spark_color' => 'violet',
        ],
        [
            'icon' => 'la-users',
            'icon_library' => 'la',
            'class' => 'bg-amber',
            'label' => 'Utenti creati',
            'value' => number_format($usersCount, 0, ',', '.'),
            'delta' => null,
            'delta_class' => 'flat',
            'spark_type' => 'none',
        ],
    ];
?>

@section('header')
    <meta charset="UTF-8">
    <div class="future-dashboard-header">
        <div class="future-dashboard-heading">
            <h3 class="page-title mb-0">
                <span class="text-capitalize">Bacheca</span>
            </h3>
            <small class="future-dashboard-subtitle">Panoramica generale del tuo sito</small>
        </div>
        <div class="future-dashboard-date text-right">
            <div>{{ \Carbon\Carbon::now()->locale('it')->isoFormat('D MMMM YYYY') }}</div>
            <small>{{ \Carbon\Carbon::now()->locale('it')->isoFormat('dddd') }}</small>
        </div>
    </div>
@endsection

@section('content')
    <div class="row gutter-3 future-kpi-layout mb-3">
        <div class="col-lg-9 mb-3 mb-lg-0">
            <div class="future-kpi-grid">
                @foreach($kpiCards as $card)
                    <div class="future-kpi-card">
                        <div class="future-kpi-icon {{ $card['class'] }}">
                            <i class="{{ ($card['icon_library'] ?? 'hgi') === 'la' ? 'la '.$card['icon'] : 'hgi hgi-stroke '.$card['icon'] }}"></i>
                        </div>
                        <div class="future-kpi-body">
                            <div class="future-kpi-label">{{ $card['label'] }}</div>
                            <div class="future-kpi-row">
                                <div class="future-kpi-value">{{ $card['value'] }}</div>
                                @if(!empty($card['delta']))
                                    <div class="future-kpi-delta {{ $card['delta_class'] }}">{{ $card['delta'] }}</div>
                                @endif
                            </div>
                            @if(($card['spark_type'] ?? 'line') === 'progress')
                                <div class="future-kpi-progress-row">
                                    <svg class="future-kpi-spark future-kpi-spark-progress {{ !empty($card['spark_color']) ? 'future-kpi-spark-progress-'.$card['spark_color'] : '' }}" viewBox="0 0 120 24" aria-hidden="true">
                                        <path class="future-kpi-spark-base" d="M2 14 L118 14" />
                                        <path class="future-kpi-spark-value" d="M2 14 L{{ number_format(max(2, min(118, (float) ($card['spark_x'] ?? 2))), 2, '.', '') }} 14" />
                                    </svg>
                                    @if(!empty($card['progress_text']))
                                        <div class="future-kpi-progress-text">{{ $card['progress_text'] }}</div>
                                    @endif
                                </div>
                            @elseif(($card['spark_type'] ?? 'line') === 'line')
                                <svg class="future-kpi-spark" viewBox="0 0 120 24" aria-hidden="true">
                                    <path d="M2 18 C14 18, 16 11, 28 12 C40 13, 44 20, 56 16 C68 12, 70 8, 82 9 C94 10, 98 17, 116 14" />
                                </svg>
                            @elseif(($card['spark_type'] ?? 'line') === 'dynamic_line')
                                <svg class="future-kpi-spark future-kpi-spark-dynamic" viewBox="0 0 120 24" aria-hidden="true">
                                    <path d="{{ $card['spark_path'] ?? 'M 2 14 L 118 14' }}" />
                                </svg>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-3 future-kpi-welcome-col">
            <div class="future-kpi-card future-kpi-card-welcome">
                <div class="future-kpi-welcome-title">Benvenuto <span aria-hidden="true">👋</span></div>
                <div class="future-kpi-welcome-name">{{ backpack_user()->name }}</div>
                <hr class="future-kpi-welcome-divider">
                <small class="future-kpi-welcome-clock-label">Ora locale</small>
                <div class="future-kpi-welcome-clock">
                    <i class="la la-clock" aria-hidden="true"></i>
                    <span id="dashboardDigitalClock">--:--</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row gutter-3">
        <div class="col-lg-9">
            <div class="row gutter-3">
                <div class="col-lg-8 mb-3">
                    <div class="card card-dashboard future-panel h-100">
                        <div class="card-header future-panel-header d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-0">Traffico del sito</h5>
                                <small id="futureTrafficSubtitle" class="text-muted">Visite frontend (ultimi 7 giorni)</small>
                            </div>
                            <div class="future-mini-tabs">
                                <button type="button" class="active future-traffic-range" data-days="7">7 giorni</button>
                                <button type="button" class="future-traffic-range" data-days="30">30 giorni</button>
                                <button type="button" class="future-traffic-range" data-days="90">90 giorni</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="futureOrdersChart" height="110"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="card card-dashboard future-panel h-100">
                        <div class="card-header future-panel-header d-flex align-items-center">
                            <h5 class="mb-0">Insight AI <span class="future-beta-badge">BETA</span></h5>
                        </div>
                        <div class="card-body">
                            <ul class="future-insight-list mb-0">
                                @foreach($insights as $insight)
                                    <li class="future-insight-item">
                                        <span class="future-insight-dot {{ $insight['type'] }}"></span>
                                        <div class="future-insight-content">
                                            <div class="future-insight-title">{{ $insight['title'] }}</div>
                                            <div class="future-insight-text">{{ $insight['text'] }}</div>
                                        </div>
                                        @if(!empty($insight['url']) && !empty($insight['cta']))
                                            <a class="btn btn-sm btn-light {{ $insight['url'] === '#dashboardFutureTasks' ? 'future-insight-open-task' : '' }}" href="{{ $insight['url'] }}" @if($insight['url'] === '#dashboardFutureTasks') data-open-filter="open" @endif>{{ $insight['cta'] }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="future-actions-grid mb-3">
                <a class="future-action" href="/admin/page/create">
                    <span class="future-action-icon future-action-icon-green"><i class="la la-file-alt"></i></span>
                    <span>Nuova pagina</span>
                </a>
                <a class="future-action" href="/admin/page">
                    <span class="future-action-icon future-action-icon-blue"><i class="la la-list-ul"></i></span>
                    <span>Elenco pagine</span>
                </a>
                <a class="future-action" href="/admin/elfinder">
                    <span class="future-action-icon future-action-icon-amber"><i class="la la-folder-open"></i></span>
                    <span>File Manager</span>
                </a>
                <a class="future-action" href="/admin/websiteSetting/1/edit">
                    <span class="future-action-icon future-action-icon-gray"><i class="la la-cog"></i></span>
                    <span>Impostazioni</span>
                </a>
                <a class="future-action" href="/admin/tutorials">
                    <span class="future-action-icon future-action-icon-violet"><i class="la la-book-open"></i></span>
                    <span>Tutorial</span>
                </a>
                <a class="future-action" href="#" data-admin-support-toggle="1">
                    <span class="future-action-icon future-action-icon-cyan"><i class="la la-headset"></i></span>
                    <span>Richiedi Assistenza</span>
                </a>
            </div>

            <div class="row gutter-3">
                <div class="col-lg-6 mb-3">
                    <div class="card card-dashboard future-panel h-100">
                        <div class="card-header future-panel-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Attivita recenti</h5>
                        </div>
                        <div class="card-body future-activity-scroll">
                            <ul class="future-activity-list mb-0">
                                @foreach($recentActivities as $activity)
                                    <li>
                                        <i class="hgi hgi-stroke {{ $activity['icon'] }}"></i>
                                        <div>
                                            <strong>{{ $activity['label'] }}:</strong>
                                            @if(!empty($activity['url']))
                                                <a href="{{ $activity['url'] }}">{{ $activity['title'] }}</a>
                                            @else
                                                {{ $activity['title'] }}
                                            @endif
                                            <small>
                                                {{ $activity['date'] }}
                                                @if(!empty($activity['actor']))
                                                    - da {{ $activity['actor'] }}
                                                @endif
                                            </small>
                                        </div>
                                    </li>
                                @endforeach
                                @if($recentActivities->isEmpty())
                                    <li class="text-muted">Nessuna attivita recente disponibile.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-3" id="dashboardFutureTasks">
                    <div class="card card-dashboard future-panel h-100">
                        <div class="card-header future-panel-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Note / Appunti</h5>
                            <div class="d-flex align-items-center" style="gap:.55rem;">
                                <small class="text-muted mb-0"><span id="dashboardTodoOpenCountHeader">{{ $pendingTodosCount }}</span> aperti</small>
                                <button type="button" class="btn btn-sm future-new-note-btn" id="dashboardTodoNewButton">
                                    <i class="la la-plus" aria-hidden="true"></i>
                                    <span>Nuova nota</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="future-task-tabs">
                                <button type="button" class="active" data-filter="all">Tutti <span id="dashboardTodoAllCount">{{ count($dashboardTodos) }}</span></button>
                                <button type="button" data-filter="open">Da fare <span id="dashboardTodoOpenCount">{{ $pendingTodosCount }}</span></button>
                                <button type="button" data-filter="done">Completati <span id="dashboardTodoDoneCount">{{ $completedTodosCount }}</span></button>
                            </div>

                            <ul class="dashboard-todo-list mb-0" id="dashboardTodoList">
                                @foreach($dashboardTodos as $todo)
                                    @php
                                        $todoPriority = in_array($todo->priority, ['bassa', 'media', 'alta'], true) ? $todo->priority : 'media';
                                        $todoPriorityClass = $todoPriority === 'alta' ? 'high' : ($todoPriority === 'bassa' ? 'low' : 'mid');
                                    @endphp
                                    <li class="dashboard-todo-item {{ $todo->is_done ? 'is-done' : '' }}" data-id="{{ $todo->id }}" data-is-done="{{ $todo->is_done ? '1' : '0' }}" data-priority="{{ $todoPriority }}" data-full-title="{{ e($todo->title) }}" draggable="true">
                                        <div class="dashboard-todo-row">
                                            <span class="dashboard-todo-title">{{ \Illuminate\Support\Str::words(trim(preg_replace('/\s+/', ' ', strip_tags((string) $todo->title))), 4, '...') }}</span>
                                            <span class="future-todo-badge {{ $todoPriorityClass }}" data-role="priority-badge">{{ ucfirst($todoPriority) }}</span>
                                            <span class="dashboard-todo-date">{{ optional($todo->created_at)->format('d/m/Y') }}</span>
                                            <div class="dashboard-todo-actions">
                                                <button type="button" class="btn btn-sm dashboard-todo-icon-btn dashboard-todo-icon-btn-toggle" data-action="toggle" title="{{ $todo->is_done ? 'Riapri' : 'Segna come fatto' }}"><i class="la {{ $todo->is_done ? 'la-undo' : 'la-check' }}"></i></button>
                                                <button type="button" class="btn btn-sm dashboard-todo-icon-btn dashboard-todo-icon-btn-edit" data-action="edit" title="Modifica"><i class="la la-pen"></i></button>
                                                <button type="button" class="btn btn-sm dashboard-todo-icon-btn dashboard-todo-icon-btn-delete" data-action="delete" title="Elimina"><i class="la la-trash"></i></button>
                                            </div>
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
        </div>
        <div class="col-lg-3">
            <div class="card card-dashboard future-side-card future-side-card-status mb-3">
                <div class="card-body">
                    <h6 class="mb-2">Stato del sito</h6>
                    <div class="future-status {{ $onlineStatus ? 'online' : 'offline' }}">
                        <span class="future-status-dot"></span>
                        {{ $onlineStatus ? 'Online' : 'Offline' }}
                    </div>
                    <small class="d-block mt-2 text-muted">
                        {{ $onlineStatus ? 'Tutto funziona correttamente.' : 'Verifica la tab Manutenzione.' }}
                    </small>
                </div>
            </div>

            @if($hasShopDashboardPlugin)
                <div class="card card-dashboard future-side-card mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">Ordini oggi</h6>
                        <div class="future-revenue-value">EUR {{ number_format($ordersTodayRevenue, 2, ',', '.') }}</div>
                        <small class="text-muted">Totale economico della giornata</small>
                    </div>
                </div>

                <div class="card card-dashboard future-side-card mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">Notifiche</h6>
                        <ul class="future-notify-list mb-3">
                            @if($recentOrders->isNotEmpty())
                                @foreach($recentOrders as $ord)
                                    <li>
                                        <span class="future-notify-dot blue"></span>
                                        <div>
                                            <strong>Ordine #{{ $ord->id }}</strong>
                                            <small>{{ optional($ord->created_at)->format('d/m/Y H:i') }} - EUR {{ number_format((float) $ord->total, 2, ',', '.') }}</small>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <span class="future-notify-dot gray"></span>
                                    <div>
                                        <strong>Nessun nuovo ordine</strong>
                                        <small>Nessuna notifica recente disponibile</small>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="card card-dashboard future-side-card">
                    <div class="card-body">
                        <h6 class="mb-2">Accessi rapidi</h6>
                        <ul class="future-quick-links mb-0">
                            <li><a href="/admin/websiteSetting/1/edit">Impostazioni generali</a></li>
                            <li><a href="/admin/userCustom">Gestione utenti</a></li>
                            <li><a href="/admin/pluginProducts">Catalogo prodotti</a></li>
                            <li><a href="/admin/page">Lista pagine</a></li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="future-dashboard-footer">
        <span>&copy; {{ now()->format('Y') }} Webisland S.r.l. - CMS-Formula</span>
        <span>Versione 3.2.0</span>
    </div>

    <div class="modal fade" id="dashboardTodoEditorModal" tabindex="-1" role="dialog" aria-labelledby="dashboardTodoEditorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dashboardTodoEditorModalLabel">Nuova nota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="dashboardTodoPriority">Priorita</label>
                        <select id="dashboardTodoPriority" class="form-control">
                            <option value="bassa">Bassa</option>
                            <option value="media" selected>Media</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>
                    <textarea id="dashboardTodoEditor"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Annulla</button>
                    <button type="button" class="btn btn-primary" id="dashboardTodoEditorSave">Salva</button>
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
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('packages/summernote/dist/summernote-bs4.css') }}">
    <style>
        .future-dashboard-header { display: flex; align-items: flex-end; justify-content: space-between; gap: 1rem; width: 100%; }
        .future-dashboard-heading { display: flex; flex-direction: column; align-items: flex-start; gap: .24rem; }
        .future-dashboard-status { display: inline-flex; align-items: center; border-radius: 999px; min-height: 24px; padding: .2rem .62rem; font-size: .67rem; font-weight: 800; letter-spacing: .03em; border: 1px solid #c8d8f3; }
        .future-dashboard-status.online { background: #e9f7ea; color: #2f8b54; }
        .future-dashboard-status.offline { background: #fff3ee; color: #b15437; }
        .future-dashboard-subtitle { color: #5f7397; font-size: .92rem; font-weight: 600; }
        .future-dashboard-date { color: #274371; font-weight: 700; margin-left: auto; text-align: right; }
        .future-dashboard-date small { color: #6f85ad; font-weight: 600; }
        .future-kpi-layout { align-items: stretch; --future-kpi-equal-height: 150px; }
        .future-kpi-welcome-col { display: flex; align-items: stretch; }
        .future-kpi-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: .62rem; }
        .future-kpi-card { display: flex; align-items: center; gap: .66rem; background: #fff; border: 1px solid #dbe6fb; border-radius: 14px; padding: .68rem .72rem; box-shadow: 0 8px 18px rgba(13, 34, 74, .08); min-height: var(--future-kpi-equal-height); height: 100%; }
        .future-kpi-icon { width: 42px; height: 42px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; color: #fff; font-size: 2.1rem; }
        .future-kpi-icon.bg-green { background: linear-gradient(135deg, #2cad62, #26a35b); }
        .future-kpi-icon.bg-blue { background: linear-gradient(135deg, #3d7df0, #2f6ad8); }
        .future-kpi-icon.bg-violet { background: linear-gradient(135deg, #8064e8, #6d53d4); }
        .future-kpi-icon.bg-amber { background: linear-gradient(135deg, #f6a43a, #e2942e); }
        .future-kpi-label { color: #5f7397; font-size: .68rem; text-transform: uppercase; font-weight: 800; letter-spacing: .04em; margin-bottom: .1rem; }
        .future-kpi-row { display: flex; align-items: baseline; gap: .48rem; }
        .future-kpi-value { font-size: 1.5rem; color: #1c3a68; font-weight: 800; line-height: 1.05; }
        .future-kpi-delta { font-size: .72rem; font-weight: 800; }
        .future-kpi-delta.up { color: #21a35f; }
        .future-kpi-delta.down { color: #d35757; }
        .future-kpi-delta.flat { color: #7b90b7; }
        .future-kpi-spark { width: 100%; height: 22px; margin-top: .18rem; }
        .future-kpi-spark path { fill: none; stroke: #86aef5; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }
        .future-kpi-spark-dynamic path { stroke: #57b380; stroke-width: 2.2; }
        .future-kpi-spark-progress .future-kpi-spark-base { stroke: #d6e3fa; stroke-width: 3; }
        .future-kpi-spark-progress .future-kpi-spark-value { stroke: #3d7df0; stroke-width: 3; }
        .future-kpi-spark-progress-violet .future-kpi-spark-value { stroke: #7f63e6; }
        .future-kpi-progress-row { display: flex; align-items: center; gap: .45rem; margin-top: .08rem; }
        .future-kpi-progress-row .future-kpi-spark { flex: 1 1 auto; margin-top: 0; }
        .future-kpi-progress-text { color: #4b6799; font-size: .72rem; font-weight: 700; white-space: nowrap; }
        .future-kpi-card-welcome { display: flex; flex-direction: column; align-items: flex-start; justify-content: center; gap: .15rem; min-height: var(--future-kpi-equal-height); height: 100%; width: 100%; margin-top: 0; }
        .future-kpi-welcome-title { color: #3f5c8f; font-weight: 700; font-size: .78rem; }
        .future-kpi-welcome-name { color: #1e3762; font-size: 1.875rem; font-weight: 800; line-height: 1; }
        .future-kpi-welcome-divider { width: 100%; border: 0; border-top: 1px solid #dde7f8; margin: .24rem 0 .18rem; }
        .future-kpi-welcome-clock-label { color: #6b81a9; font-size: .68rem; text-transform: uppercase; font-weight: 700; letter-spacing: .04em; }
        .future-kpi-welcome-clock { color: #1e3762; font-size: 1.77rem; font-weight: 800; line-height: 1; font-family: "Consolas","Menlo","Monaco",monospace; display: inline-flex; align-items: center; gap: .35rem; }
        .future-kpi-welcome-clock .la { font-size: 2.4rem; color: #5f78a8; }
        .future-panel { border-radius: 16px; border: 1px solid #dce7fb; box-shadow: 0 12px 24px rgba(13, 34, 74, .08); }
        .future-panel-header { background: linear-gradient(130deg, #f5f9ff 0%, #ffffff 100%); border-bottom: 1px solid #e0eafc; }
        .future-mini-tabs { display: inline-flex; align-items: center; gap: .25rem; }
        .future-mini-tabs button { border: 1px solid #dbe6fb; background: #ffffff; color: #61779f; font-size: .72rem; font-weight: 700; border-radius: 999px; padding: .2rem .56rem; }
        .future-mini-tabs button.active { background: #eaf1ff; color: #2b518d; border-color: #c6d7f8; }
        .future-link-more { color: #4a67a0; font-size: .78rem; font-weight: 700; text-decoration: none; }
        .future-link-more:hover { color: #35588e; text-decoration: underline; }
        .future-insight-list { list-style: none; padding: 0; }
        .future-insight-item { display: flex; align-items: flex-start; gap: .65rem; border: 1px solid #dce7fb; background: #f9fbff; border-radius: 12px; padding: .58rem .62rem; margin-bottom: .5rem; }
        .future-insight-dot { width: 9px; height: 9px; border-radius: 50%; margin-top: .44rem; flex: 0 0 auto; }
        .future-insight-dot.warning { background: #f39a25; }
        .future-insight-dot.info { background: #3f79ee; }
        .future-insight-dot.neutral { background: #8ca1c6; }
        .future-insight-dot.success { background: #2cad62; }
        .future-insight-content { flex: 1 1 auto; min-width: 0; }
        .future-insight-title { color: #1f3f70; font-weight: 700; font-size: .9rem; }
        .future-insight-text { color: #5f7397; font-size: .82rem; }
        .future-beta-badge { display: inline-flex; align-items: center; margin-left: .38rem; padding: .08rem .42rem; border-radius: 999px; font-size: .64rem; font-weight: 800; letter-spacing: .03em; color: #6b4e00; background: #fff2c9; border: 1px solid #f5d77a; vertical-align: middle; }
        .future-actions-grid { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: .7rem; }
        .future-action { border: 1px solid #dce7fb; border-radius: 12px; min-height: 66px; display: inline-flex; align-items: center; justify-content: flex-start; gap: .62rem; background: #fff; color: #1f3f70; font-weight: 700; font-size: .82rem; text-decoration: none !important; transition: all .2s ease; padding: .55rem .62rem; }
        .future-action i { font-size: 1rem; line-height: 1; }
        .future-action-icon { width: 34px; height: 34px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; flex: 0 0 auto; }
        .future-action-icon-green { background: #e9f7ef; color: #2d9f5f; }
        .future-action-icon-blue { background: #eaf0ff; color: #4d76e8; }
        .future-action-icon-amber { background: #fff4df; color: #d89a2b; }
        .future-action-icon-gray { background: #eef0f6; color: #707a94; }
        .future-action-icon-violet { background: #efeafd; color: #6f57d8; }
        .future-action-icon-cyan { background: #e8f8fb; color: #2f8faa; }
        .future-action:hover { transform: translateY(-2px); box-shadow: 0 12px 22px rgba(16, 41, 85, .12); border-color: #c9dbfb; }
        .future-activity-list, .future-quick-links { list-style: none; padding: 0; }
        .future-activity-list li { display: flex; gap: .6rem; align-items: flex-start; border-bottom: 1px solid #edf2fb; padding: .5rem 0; color: #21406f; font-size: .86rem; }
        .future-activity-list li:last-child { border-bottom: 0; }
        .future-activity-list li i { color: #3f79ee; margin-top: .2rem; }
        .future-activity-list li a { color: #21406f; font-weight: 500; text-decoration: none; }
        .future-activity-list li a:hover { color: #2c67d1; text-decoration: underline; }
        .future-activity-list li small { display: block; color: #6f85ad; }
        .future-activity-scroll { max-height: 420px; overflow-y: auto; padding-right: .35rem; }
        .future-activity-scroll::-webkit-scrollbar { width: 8px; }
        .future-activity-scroll::-webkit-scrollbar-thumb { background: #c9d5ec; border-radius: 10px; }
        .future-activity-scroll::-webkit-scrollbar-track { background: transparent; }
        .future-side-card { border-radius: 14px; border: 1px solid #dce7fb; }
        .future-side-card .card-body { padding: .9rem .95rem; }
        .future-side-card-status { width: 100%; max-width: 100%; margin-left: 0; }
        .future-side-label { color: #6a80a8; text-transform: uppercase; letter-spacing: .04em; font-size: .73rem; font-weight: 700; }
        .future-digital-clock { margin-top: .35rem; font-size: 1.9rem; font-weight: 800; color: #1b3b6d; font-family: "Consolas","Menlo","Monaco",monospace; line-height: 1; }
        .future-status { display: inline-flex; align-items: center; gap: .35rem; border-radius: 999px; padding: .25rem .62rem; font-weight: 700; font-size: .82rem; }
        .future-status.online { background: #e8f8ef; color: #1d8148; }
        .future-status.offline { background: #fff2ed; color: #ad4b2c; }
        .future-status-dot { width: 8px; height: 8px; border-radius: 50%; background: currentColor; }
        .future-revenue-value { font-size: 1.25rem; font-weight: 800; color: #1f3f70; margin-bottom: .15rem; }
        .future-notify-list { list-style: none; padding: 0; }
        .future-notify-list li { display: flex; gap: .5rem; align-items: flex-start; padding: .35rem 0; border-bottom: 1px solid #edf2fb; }
        .future-notify-list li:last-child { border-bottom: 0; }
        .future-notify-dot { width: 8px; height: 8px; border-radius: 50%; margin-top: .42rem; flex: 0 0 auto; }
        .future-notify-dot.blue { background: #3f79ee; }
        .future-notify-dot.gray { background: #94a3b8; }
        .future-notify-list strong { display: block; color: #21406f; font-size: .82rem; font-weight: 700; }
        .future-notify-list small { display: block; color: #6f85ad; font-size: .76rem; }
        .future-quick-links li a { display: block; color: #2c528d; font-weight: 600; padding: .22rem 0; text-decoration: none; }
        .future-quick-links li a:hover { color: #1f3f70; text-decoration: underline; }
        .future-dashboard-footer { display: flex; justify-content: space-between; align-items: center; color: #7e90b1; font-size: .74rem; font-weight: 600; padding: .15rem .2rem .4rem; }
        .future-task-tabs { display: flex; align-items: center; gap: .45rem; margin-bottom: .7rem; flex-wrap: wrap; }
        .future-task-tabs button { border: 1px solid #d7e4fb; background: #f5f9ff; color: #5877a8; font-size: .76rem; font-weight: 700; border-radius: 999px; padding: .2rem .58rem; line-height: 1.1; }
        .future-task-tabs button.active { color: #2f55d4; background: #eaf1ff; border-color: #c7d8fb; box-shadow: inset 0 0 0 1px rgba(79, 99, 242, .08); }
        .future-new-note-btn {
            display: inline-flex;
            align-items: center;
            gap: .28rem;
            border: 0;
            border-radius: 7px;
            padding: .26rem .7rem;
            min-height: 30px;
            background: linear-gradient(180deg, #7a67f2 0%, #6a56e7 100%);
            color: #ffffff;
            font-size: .76rem;
            font-weight: 700;
            box-shadow: 0 6px 14px rgba(97, 76, 215, .24);
            transition: filter .15s ease, transform .15s ease;
        }
        .future-new-note-btn:hover {
            color: #ffffff;
            filter: brightness(1.03);
            transform: translateY(-1px);
        }
        .future-new-note-btn:focus {
            outline: 0;
            box-shadow: 0 0 0 3px rgba(106, 86, 231, .25), 0 6px 14px rgba(97, 76, 215, .24);
        }
        .future-new-note-btn .la {
            font-size: .78rem;
            line-height: 1;
        }
        .dashboard-todo-list { list-style: none; padding: 0; max-height: 350px; overflow-y: auto; margin-top: .05rem; }
        .dashboard-todo-item { border: 0; border-radius: 0; padding: .36rem 0; background: transparent; margin-bottom: 0; cursor: move; border-bottom: 1px solid #edf2f8; }
        .dashboard-todo-item:last-child { border-bottom: 0; }
        .dashboard-todo-item.is-done .dashboard-todo-title { text-decoration: line-through; opacity: .7; }
        .dashboard-todo-item.is-dragging { opacity: .55; background: rgba(237, 244, 255, .45); }
        .dashboard-todo-row { display: flex; align-items: center; gap: .52rem; min-height: 24px; width: 100%; }
        .dashboard-todo-date { color: #7a8198; font-size: .66rem; font-weight: 700; flex: 0 0 auto; white-space: nowrap; }
        .dashboard-todo-title { font-weight: 600; color: #3b425a; white-space: nowrap; font-size: .79rem; line-height: 1.2; flex: 1 1 auto; min-width: 0; overflow: hidden; text-overflow: ellipsis; margin-bottom: 0; }
        .future-todo-badge { display: inline-flex; align-items: center; border-radius: 8px; padding: .05rem .42rem; font-size: .62rem; font-weight: 800; border: 1px solid transparent; background: #fff; }
        .future-todo-badge.mid { color: #9b6d24; border-color: #efd59f; background: #fffaf1; }
        .future-todo-badge.low { color: #2a7b4d; border-color: #bfe6ce; background: #f4fbf7; }
        .future-todo-badge.high { color: #b14a3b; border-color: #f0b6ad; background: #fff6f4; }
        .dashboard-todo-actions { display: inline-flex; align-items: center; justify-content: center; gap: .22rem; margin-left: auto; min-height: 22px; flex: 0 0 auto; }
        .dashboard-todo-icon-btn { width: 22px; height: 22px; min-width: 22px; border-radius: 50% !important; padding: 0 !important; display: inline-flex; align-items: center; justify-content: center; border: 1px solid transparent; background: #f3f5fa; color: #6e758d; }
        .dashboard-todo-icon-btn i { font-size: .73rem; line-height: 1; }
        .dashboard-todo-icon-btn-toggle { background: #edf7f0; color: #3f8e60; border-color: #dbeee2; }
        .dashboard-todo-icon-btn-edit { background: #f2f5fc; color: #6172b8; border-color: #e3e8f8; }
        .dashboard-todo-icon-btn-delete { background: #fff1ef; color: #bd5c4b; border-color: #f8dfdb; }
        .dashboard-todo-icon-btn:hover { filter: brightness(.97); }
        .dashboard-todo-empty { color: #64748b; font-size: .9rem; }
        #futureOrdersChart { width: 100%; display: block; }
        @media (max-width: 1199.98px) { .future-kpi-grid, .future-actions-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 767.98px) {
            .future-dashboard-header { flex-direction: column; align-items: flex-start; }
            .future-dashboard-date { margin-left: 0; text-align: left; }
            .future-kpi-grid, .future-actions-grid { grid-template-columns: 1fr; }
            .future-mini-tabs { width: 100%; justify-content: flex-start; margin-top: .35rem; }
            .future-dashboard-footer { flex-direction: column; gap: .2rem; align-items: flex-start; }
        }
    </style>
@endsection

@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script src="{{ asset('packages/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('packages/summernote/dist/lang/summernote-it-IT.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartCanvas = document.getElementById('futureOrdersChart');
            const chartLabels = @json($orderChartLabels);
            const rawChartSeries = @json($orderChartSeries);
            const chartSeries = rawChartSeries.map(v => Number(v) || 0);
            const trafficRangeButtons = document.querySelectorAll('.future-traffic-range');
            const trafficSubtitle = document.getElementById('futureTrafficSubtitle');
            const getRangeData = function(days) {
                const safeDays = Math.max(1, Math.min(chartSeries.length, Number(days) || 7));
                return {
                    labels: chartLabels.slice(-safeDays),
                    series: chartSeries.slice(-safeDays),
                    days: safeDays
                };
            };

            if (chartCanvas && chartCanvas.getContext && window.Chart) {
                const initialRange = getRangeData(7);
                const ctx = chartCanvas.getContext('2d');
                const trafficChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: initialRange.labels,
                        datasets: [{
                            data: initialRange.series,
                            borderColor: '#3f79ee',
                            backgroundColor: 'rgba(63,121,238,.16)',
                            fill: true,
                            tension: 0.35,
                            borderWidth: 2.5,
                            pointRadius: 2.6,
                            pointHoverRadius: 5,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#3f79ee',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(24, 42, 76, .96)',
                                titleColor: '#ffffff',
                                bodyColor: '#e7efff',
                                padding: 10,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        const visits = Number(context.parsed.y || 0);
                                        return visits + ' visite';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: '#60779f', maxTicksLimit: 8 }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(96,119,159,.16)' },
                                ticks: {
                                    color: '#60779f',
                                    precision: 0
                                }
                            }
                        }
                    }
                });

                const setActiveRange = function(days) {
                    const range = getRangeData(days);
                    trafficChart.data.labels = range.labels;
                    trafficChart.data.datasets[0].data = range.series;
                    trafficChart.update();

                    if (trafficSubtitle) {
                        trafficSubtitle.textContent = 'Visite frontend (ultimi ' + range.days + ' giorni)';
                    }

                    trafficRangeButtons.forEach(function(button) {
                        button.classList.toggle('active', Number(button.dataset.days) === range.days);
                    });
                };

                trafficRangeButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        setActiveRange(button.dataset.days);
                    });
                });
            }

            const clock = document.getElementById('dashboardDigitalClock');
            if (clock) {
                const tick = function() { clock.textContent = new Date().toLocaleTimeString('it-IT', {hour: '2-digit', minute: '2-digit', hour12: false}); };
                tick();
                setInterval(tick, 1000);
            }

            const todoNewButton = document.getElementById('dashboardTodoNewButton');
            const todoList = document.getElementById('dashboardTodoList');
            const todoEmpty = document.getElementById('dashboardTodoEmpty');
            const todoEditorTitle = document.getElementById('dashboardTodoEditorModalLabel');
            const todoPrioritySelect = document.getElementById('dashboardTodoPriority');
            const todoEditorSaveButton = document.getElementById('dashboardTodoEditorSave');
            const todoDeleteConfirmButton = document.getElementById('dashboardTodoDeleteConfirm');
            const todoFilterButtons = Array.from(document.querySelectorAll('.future-task-tabs [data-filter]'));
            const todoOpenCountHeader = document.getElementById('dashboardTodoOpenCountHeader');
            const todoAllCount = document.getElementById('dashboardTodoAllCount');
            const todoOpenCount = document.getElementById('dashboardTodoOpenCount');
            const todoDoneCount = document.getElementById('dashboardTodoDoneCount');
            if (!todoNewButton || !todoList || !todoEmpty || !todoPrioritySelect || !todoEditorSaveButton) return;

            const todoBaseUrl = @json(backpack_url('dashboard/todos'));
            const csrfToken = '{{ csrf_token() }}';
            let todoEditingItem = null;
            let todoDeletingItem = null;
            let draggingTodoItem = null;
            let currentTodoFilter = 'all';
            let todoEditorMode = 'create';
            let skipNextTodoItemClick = false;

            $('#dashboardTodoEditor').summernote({
                lang: 'it-IT',
                height: 180,
                toolbar: [['history', ['undo', 'redo']], ['font', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['view', ['codeview']]]
            });

            const getTodoCounts = function() {
                const items = Array.from(todoList.querySelectorAll('.dashboard-todo-item'));
                const total = items.length;
                const done = items.filter(function(item) { return item.dataset.isDone === '1'; }).length;
                const open = total - done;
                return { total: total, open: open, done: done };
            };
            const refreshTodoCounters = function() {
                const counts = getTodoCounts();
                if (todoOpenCountHeader) todoOpenCountHeader.textContent = String(counts.open);
                if (todoAllCount) todoAllCount.textContent = String(counts.total);
                if (todoOpenCount) todoOpenCount.textContent = String(counts.open);
                if (todoDoneCount) todoDoneCount.textContent = String(counts.done);
            };
            const setTodoEmptyState = function() {
                const visibleItems = Array.from(todoList.querySelectorAll('.dashboard-todo-item')).filter(function(item) {
                    return !item.classList.contains('d-none');
                }).length;
                if (visibleItems === 0) {
                    todoEmpty.textContent = currentTodoFilter === 'open'
                        ? 'Nessuna nota da fare.'
                        : (currentTodoFilter === 'done' ? 'Nessuna nota completata.' : 'Nessuna nota presente.');
                    todoEmpty.classList.remove('d-none');
                } else {
                    todoEmpty.classList.add('d-none');
                }
            };
            const applyTodoFilter = function(filter) {
                currentTodoFilter = ['all', 'open', 'done'].includes(filter) ? filter : 'all';
                const items = Array.from(todoList.querySelectorAll('.dashboard-todo-item'));

                items.forEach(function(item) {
                    const isDone = item.dataset.isDone === '1';
                    const shouldShow = currentTodoFilter === 'all'
                        || (currentTodoFilter === 'open' && !isDone)
                        || (currentTodoFilter === 'done' && isDone);
                    item.classList.toggle('d-none', !shouldShow);
                    item.draggable = currentTodoFilter === 'all';
                });

                todoFilterButtons.forEach(function(button) {
                    button.classList.toggle('active', button.dataset.filter === currentTodoFilter);
                });

                setTodoEmptyState();
            };
            const plain = function(html) { return $('<div>').html((html || '').replace(/<br\s*\/?>/gi, '\n')).text().replace(/\s+/g, ' ').trim(); };
            const preview = function(html) {
                const text = plain(html);
                if (!text) return '';
                const words = text.split(/\s+/).filter(Boolean);
                if (words.length <= 4) return words.join(' ');
                return words.slice(0, 4).join(' ') + '...';
            };
            const setTodoDisplay = function(item, html) { item.dataset.fullTitle = (html || '').trim(); const title = item.querySelector('.dashboard-todo-title'); if (title) title.textContent = preview(html); };
            const normalizePriority = function(priority) {
                const value = String(priority || '').toLowerCase();
                if (value === 'alta' || value === 'bassa' || value === 'media') return value;
                return 'media';
            };
            const priorityLabel = function(priority) {
                const value = normalizePriority(priority);
                if (value === 'alta') return 'Alta';
                if (value === 'bassa') return 'Bassa';
                return 'Media';
            };
            const priorityClass = function(priority) {
                const value = normalizePriority(priority);
                if (value === 'alta') return 'high';
                if (value === 'bassa') return 'low';
                return 'mid';
            };
            const setTodoPriorityDisplay = function(item, priority) {
                const normalized = normalizePriority(priority);
                item.dataset.priority = normalized;
                const badge = item.querySelector('[data-role=\"priority-badge\"]');
                if (badge) {
                    badge.classList.remove('low', 'mid', 'high');
                    badge.classList.add(priorityClass(normalized));
                    badge.textContent = priorityLabel(normalized);
                }
            };
            const formatDate = function(value) { const d = new Date(value); return Number.isNaN(d.getTime()) ? '' : d.toLocaleDateString('it-IT'); };
            const setTodoToggleButtonState = function(button, isDone) {
                if (!button) return;
                button.innerHTML = '<i class="la ' + (isDone ? 'la-undo' : 'la-check') + '"></i>';
                button.setAttribute('title', isDone ? 'Riapri' : 'Segna come fatto');
            };
            const todoRequest = async function(url, method, payload) {
                const options = { method: method, headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken } };
                if (payload) { options.headers['Content-Type'] = 'application/json'; options.body = JSON.stringify(payload); }
                const response = await fetch(url, options);
                if (!response.ok) throw new Error('Request failed');
                return response.json();
            };
            const createTodoElement = function(todo) {
                const item = document.createElement('li');
                item.className = 'dashboard-todo-item' + (todo.is_done ? ' is-done' : '');
                item.dataset.id = String(todo.id);
                item.dataset.isDone = todo.is_done ? '1' : '0';
                item.dataset.priority = normalizePriority(todo.priority);
                item.draggable = true;
                item.dataset.fullTitle = todo.title || '';
                item.innerHTML = '<div class="dashboard-todo-row">'
                    + '<span class="dashboard-todo-title">' + preview(todo.title) + '</span>'
                    + '<span class="future-todo-badge ' + priorityClass(todo.priority) + '" data-role="priority-badge">' + priorityLabel(todo.priority) + '</span>'
                    + '<span class="dashboard-todo-date">' + formatDate(todo.created_at) + '</span>'
                    + '<div class="dashboard-todo-actions">'
                    + '<button type="button" class="btn btn-sm dashboard-todo-icon-btn dashboard-todo-icon-btn-toggle" data-action="toggle" title="' + (todo.is_done ? 'Riapri' : 'Segna come fatto') + '"><i class="la ' + (todo.is_done ? 'la-undo' : 'la-check') + '"></i></button>'
                    + '<button type="button" class="btn btn-sm dashboard-todo-icon-btn dashboard-todo-icon-btn-edit" data-action="edit" title="Modifica"><i class="la la-pen"></i></button>'
                    + '<button type="button" class="btn btn-sm dashboard-todo-icon-btn dashboard-todo-icon-btn-delete" data-action="delete" title="Elimina"><i class="la la-trash"></i></button>'
                    + '</div>'
                    + '</div>';
                return item;
            };

            const persistOrder = async function() {
                if (currentTodoFilter !== 'all') return;
                const ids = Array.from(todoList.querySelectorAll('.dashboard-todo-item')).map(el => parseInt(el.dataset.id, 10)).filter(Number.isInteger);
                if (!ids.length) return;
                await todoRequest(todoBaseUrl + '/reorder', 'POST', { ids: ids });
            };

            const openTodoEditor = function(mode, item) {
                todoEditorMode = mode === 'edit' ? 'edit' : 'create';
                todoEditingItem = todoEditorMode === 'edit' ? item : null;

                if (todoEditorTitle) {
                    todoEditorTitle.textContent = todoEditorMode === 'edit' ? 'Modifica nota' : 'Nuova nota';
                }
                todoEditorSaveButton.textContent = todoEditorMode === 'edit' ? 'Salva modifiche' : 'Salva';

                if (todoEditorMode === 'edit' && item) {
                    $('#dashboardTodoEditor').summernote('code', item.dataset.fullTitle || '');
                    todoPrioritySelect.value = normalizePriority(item.dataset.priority || 'media');
                } else {
                    $('#dashboardTodoEditor').summernote('code', '');
                    todoPrioritySelect.value = 'media';
                }

                $('#dashboardTodoEditorModal').modal('show');
            };
            const saveTodo = async function() {
                const html = $('#dashboardTodoEditor').summernote('code');
                const priority = normalizePriority(todoPrioritySelect.value);
                if (!plain(html)) {
                    alert('La nota non puo essere vuota.');
                    return;
                }

                todoEditorSaveButton.disabled = true;
                try {
                    if (todoEditorMode === 'edit' && todoEditingItem) {
                        const todoId = todoEditingItem.dataset.id;
                        const result = await todoRequest(todoBaseUrl + '/' + todoId, 'PUT', { title: html, priority: priority });
                        if (result && result.todo) {
                            setTodoDisplay(todoEditingItem, result.todo.title);
                            setTodoPriorityDisplay(todoEditingItem, result.todo.priority);
                            refreshTodoCounters();
                            applyTodoFilter(currentTodoFilter);
                        }
                    } else {
                        const result = await todoRequest(todoBaseUrl, 'POST', { title: html, priority: priority });
                        if (result && result.todo) {
                            todoList.append(createTodoElement(result.todo));
                            refreshTodoCounters();
                            applyTodoFilter(currentTodoFilter);
                        }
                    }
                    $('#dashboardTodoEditorModal').modal('hide');
                } catch (error) {
                    alert(todoEditorMode === 'edit' ? 'Errore durante la modifica della nota.' : 'Errore nel salvataggio della nota.');
                } finally {
                    todoEditorSaveButton.disabled = false;
                }
            };
            todoNewButton.addEventListener('click', function() {
                openTodoEditor('create', null);
            });
            todoFilterButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    applyTodoFilter(button.dataset.filter || 'all');
                });
            });

            todoList.addEventListener('dragstart', function(e) { if (currentTodoFilter !== 'all') return; const item = e.target.closest('.dashboard-todo-item'); if (!item) return; draggingTodoItem = item; item.classList.add('is-dragging'); skipNextTodoItemClick = true; });
            todoList.addEventListener('dragover', function(e) {
                if (currentTodoFilter !== 'all') return;
                e.preventDefault();
                if (!draggingTodoItem) return;
                const target = e.target.closest('.dashboard-todo-item');
                if (!target || target === draggingTodoItem) return;
                const rect = target.getBoundingClientRect();
                todoList.insertBefore(draggingTodoItem, e.clientY < rect.top + (rect.height / 2) ? target : target.nextSibling);
            });
            todoList.addEventListener('dragend', async function() {
                if (!draggingTodoItem) return;
                draggingTodoItem.classList.remove('is-dragging');
                draggingTodoItem = null;
                setTimeout(function() { skipNextTodoItemClick = false; }, 120);
                try { await persistOrder(); } catch (e) {}
            });

            todoList.addEventListener('click', async function(e) {
                const button = e.target.closest('button[data-action]');
                if (!button) return;
                const item = button.closest('.dashboard-todo-item');
                if (!item) return;
                const todoId = item.dataset.id;
                const action = button.dataset.action;
                if (action === 'edit') { openTodoEditor('edit', item); return; }
                if (action === 'toggle') {
                    try {
                        const result = await todoRequest(todoBaseUrl + '/' + todoId + '/toggle', 'POST');
                        if (result && result.todo) {
                            item.classList.toggle('is-done', !!result.todo.is_done);
                            item.dataset.isDone = result.todo.is_done ? '1' : '0';
                            setTodoDisplay(item, result.todo.title);
                            setTodoPriorityDisplay(item, result.todo.priority);
                            setTodoToggleButtonState(button, !!result.todo.is_done);
                            refreshTodoCounters();
                            applyTodoFilter(currentTodoFilter);
                        }
                    } catch (error) { alert('Errore durante l\'aggiornamento della nota.'); }
                    return;
                }
                if (action === 'delete') { todoDeletingItem = item; $('#dashboardTodoDeleteModal').modal('show'); }
                return;
            });
            todoList.addEventListener('click', function(e) {
                const item = e.target.closest('.dashboard-todo-item');
                if (!item) return;
                if (e.target.closest('button[data-action]')) return;
                if (skipNextTodoItemClick) return;
                openTodoEditor('edit', item);
            });

            todoEditorSaveButton.addEventListener('click', saveTodo);
            if (todoDeleteConfirmButton) {
                todoDeleteConfirmButton.addEventListener('click', async function() {
                    if (!todoDeletingItem) return;
                    todoDeleteConfirmButton.disabled = true;
                    try {
                        await todoRequest(todoBaseUrl + '/' + todoDeletingItem.dataset.id, 'DELETE');
                        todoDeletingItem.remove();
                        refreshTodoCounters();
                        applyTodoFilter(currentTodoFilter);
                        $('#dashboardTodoDeleteModal').modal('hide');
                    }
                    catch (error) { alert('Errore durante l\'eliminazione della nota.'); }
                    finally { todoDeleteConfirmButton.disabled = false; }
                });
            }
            document.querySelectorAll('.future-insight-open-task[data-open-filter="open"]').forEach(function(link) {
                link.addEventListener('click', function() {
                    setTimeout(function() { applyTodoFilter('open'); }, 20);
                });
            });
            $('#dashboardTodoEditorModal').on('hidden.bs.modal', function() {
                todoEditingItem = null;
                todoEditorMode = 'create';
                $('#dashboardTodoEditor').summernote('code', '');
                todoPrioritySelect.value = 'media';
            });
            $('#dashboardTodoDeleteModal').on('hidden.bs.modal', function() { todoDeletingItem = null; });
            refreshTodoCounters();
            applyTodoFilter('all');
        });
    </script>
@endsection

@section('footer')
@endsection


