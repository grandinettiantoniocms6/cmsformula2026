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

    $today = \Carbon\Carbon::today();
    $pageCount = $hasPagesTable ? \App\Models\Page::count() : 0;
    $ordersTodayCount = $hasOrdersTable ? \App\Models\Order::whereDate('created_at', $today->toDateString())->count() : 0;
    $ordersTodayRevenue = $hasOrdersTable ? (float) \App\Models\Order::whereDate('created_at', $today->toDateString())->sum('total') : 0.0;
    $productsCount = $hasProductsTable ? \App\Models\PluginProducts::count() : 0;
    $usersCount = $hasUsersTable ? \App\User::count() : 0;
    $pendingTodosCount = (int) $dashboardTodos->where('is_done', false)->count();
    $completedTodosCount = (int) $dashboardTodos->where('is_done', true)->count();

    $uploadsFolder = public_path('/uploads');
    $uploadsBytes = is_dir($uploadsFolder) ? (int) folderSize($uploadsFolder) : 0;
    $uploadsLabel = formatSize($uploadsBytes);
    $uploadsMaxBytes = 200 * 1024 * 1024 * 1024;
    $uploadsPercent = $uploadsMaxBytes > 0 ? min(100, round(($uploadsBytes / $uploadsMaxBytes) * 100, 1)) : 0;

    $onlineStatus = ($websiteSetting && (int) $websiteSetting->is_online === 1);
    $alertsCount = ($onlineStatus ? 0 : 1) + ($pendingTodosCount > 0 ? 1 : 0);

    $orderChartLabels = [];
    $orderChartSeries = [];
    for ($i = 6; $i >= 0; $i--) {
        $day = \Carbon\Carbon::today()->subDays($i);
        $orderChartLabels[] = $day->format('d M');
        $orderChartSeries[] = $hasOrdersTable ? \App\Models\Order::whereDate('created_at', $day->toDateString())->count() : 0;
    }

    $recentPages = $hasPagesTable
        ? \App\Models\Page::orderBy('updated_at', 'desc')->take(5)->get(['id', 'title', 'updated_at'])
        : collect();
    $recentOrders = $hasOrdersTable
        ? \App\Models\Order::orderBy('created_at', 'desc')->take(4)->get(['id', 'created_at', 'total'])
        : collect();

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
    if ($ordersTodayCount === 0) {
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
            'title' => 'Operativita regolare',
            'text' => 'Nessun alert prioritario rilevato.',
            'url' => null,
            'cta' => null,
        ]);
    }

    $kpiCards = [
        [
            'icon' => 'hgi-user-group',
            'class' => 'bg-green',
            'label' => 'Visitatori (oggi)',
            'value' => number_format($usersCount, 0, ',', '.'),
            'delta' => '+ 18,2%',
            'delta_class' => 'up',
        ],
        [
            'icon' => 'hgi-shopping-bag-02',
            'class' => 'bg-blue',
            'label' => 'Ordini (oggi)',
            'value' => number_format($ordersTodayCount, 0, ',', '.'),
            'delta' => '+ 12,5%',
            'delta_class' => 'up',
        ],
        [
            'icon' => 'hgi-file-01',
            'class' => 'bg-violet',
            'label' => 'Pagine attive',
            'value' => number_format($pageCount, 0, ',', '.'),
            'delta' => '0%',
            'delta_class' => 'flat',
        ],
        [
            'icon' => 'hgi-alert-02',
            'class' => 'bg-amber',
            'label' => 'Alert sistema',
            'value' => number_format($alertsCount, 0, ',', '.'),
            'delta' => '- 2',
            'delta_class' => $alertsCount > 0 ? 'down' : 'flat',
        ],
    ];
?>

@section('header')
    <meta charset="UTF-8">
    <div class="future-dashboard-header">
        <div>
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
    <div class="future-kpi-grid mb-3">
        @foreach($kpiCards as $card)
            <div class="future-kpi-card">
                <div class="future-kpi-icon {{ $card['class'] }}"><i class="hgi hgi-stroke {{ $card['icon'] }}"></i></div>
                <div class="future-kpi-body">
                    <div class="future-kpi-label">{{ $card['label'] }}</div>
                    <div class="future-kpi-row">
                        <div class="future-kpi-value">{{ $card['value'] }}</div>
                        <div class="future-kpi-delta {{ $card['delta_class'] }}">{{ $card['delta'] }}</div>
                    </div>
                    <svg class="future-kpi-spark" viewBox="0 0 120 24" aria-hidden="true">
                        <path d="M2 18 C14 18, 16 11, 28 12 C40 13, 44 20, 56 16 C68 12, 70 8, 82 9 C94 10, 98 17, 116 14" />
                    </svg>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row gutter-3">
        <div class="col-lg-9">
            <div class="row gutter-3">
                <div class="col-lg-8 mb-3">
                    <div class="card card-dashboard future-panel h-100">
                        <div class="card-header future-panel-header d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-0">Traffico ordini</h5>
                                <small class="text-muted">Trend operativo</small>
                            </div>
                            <div class="future-mini-tabs">
                                <button type="button" class="active">7 giorni</button>
                                <button type="button">30 giorni</button>
                                <button type="button">90 giorni</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="futureOrdersChart" height="110"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="card card-dashboard future-panel h-100">
                        <div class="card-header future-panel-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Insight AI</h5>
                            <a href="/admin/websiteSetting/1/edit" class="future-link-more">Vedi tutto</a>
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
                                            <a class="btn btn-sm btn-light" href="{{ $insight['url'] }}">{{ $insight['cta'] }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="future-actions-grid mb-3">
                @if(env('NASCONDI_FRONTEND') == 0)
                    <a class="future-action" href="/admin/page/create"><i class="hgi hgi-stroke hgi-add-circle"></i><span>Nuova pagina</span></a>
                    <a class="future-action" href="/admin/pluginProducts"><i class="hgi hgi-stroke hgi-shopping-bag-02"></i><span>Nuovo prodotto</span></a>
                    <a class="future-action" href="/admin/page"><i class="hgi hgi-stroke hgi-file-01"></i><span>Nuovo articolo</span></a>
                    <a class="future-action" href="/admin/elfinder"><i class="hgi hgi-stroke hgi-folder-open"></i><span>File Manager</span></a>
                @endif
                <a class="future-action" href="/admin/websiteSetting/1/edit"><i class="hgi hgi-stroke hgi-settings-05"></i><span>Impostazioni</span></a>
            </div>

            <div class="row gutter-3">
                <div class="col-lg-6 mb-3">
                    <div class="card card-dashboard future-panel h-100">
                        <div class="card-header future-panel-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Attivita recenti</h5>
                        </div>
                        <div class="card-body">
                            <ul class="future-activity-list mb-0">
                                @foreach($recentPages as $page)
                                    <li>
                                        <i class="hgi hgi-stroke hgi-file-01"></i>
                                        <div>
                                            <strong>Pagina aggiornata:</strong> {{ \Illuminate\Support\Str::limit(strip_tags((string) $page->title), 52) }}
                                            <small>{{ optional($page->updated_at)->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </li>
                                @endforeach
                                @if($recentPages->isEmpty())
                                    <li class="text-muted">Nessuna attivita recente sulle pagine.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-3" id="dashboardFutureTasks">
                    <div class="card card-dashboard future-panel h-100">
                        <div class="card-header future-panel-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Task e Note</h5>
                            <small class="text-muted">{{ $pendingTodosCount }} aperti</small>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="future-task-tabs">
                                <a href="#" class="active">Tutti</a>
                                <a href="#">Da fare {{ $pendingTodosCount }}</a>
                                <a href="#">Completati {{ $completedTodosCount }}</a>
                            </div>
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
                                        <div class="dashboard-todo-meta">
                                            <span class="future-todo-badge {{ $todo->is_done ? 'low' : 'mid' }}">{{ $todo->is_done ? 'Bassa' : 'Media' }}</span>
                                            <span class="future-todo-deadline">{{ optional($todo->created_at)->addDays(7)->format('d/m/Y') }}</span>
                                        </div>
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
        </div>
        <div class="col-lg-3">
            <div class="card card-dashboard future-side-card mb-3">
                <div class="card-body">
                    <small class="future-side-label">Benvenuto</small>
                    <h5 class="mb-1">{{ backpack_user()->name }}</h5>
                    <div class="future-digital-clock" id="dashboardDigitalClock">--:--</div>
                </div>
            </div>

            <div class="card card-dashboard future-side-card mb-3">
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

            <div class="card card-dashboard future-side-card mb-3">
                <div class="card-body">
                    <h6 class="mb-2">Ordini oggi</h6>
                    <div class="future-revenue-value">EUR {{ number_format($ordersTodayRevenue, 2, ',', '.') }}</div>
                    <small class="text-muted">Totale economico della giornata</small>
                </div>
            </div>

            <div class="card card-dashboard future-side-card mb-3">
                <div class="card-body">
                    <h6 class="mb-2">Spazio server utilizzato</h6>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong>{{ $uploadsLabel }}</strong>
                        <small class="text-muted">{{ $uploadsPercent }}%</small>
                    </div>
                    <div class="progress progress-xs mb-2">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $uploadsPercent }}%" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted">{{ $productsCount }} prodotti censiti</small>
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
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('packages/summernote/dist/summernote-bs4.css') }}">
    <style>
        .future-dashboard-header { display: flex; align-items: flex-end; justify-content: space-between; gap: 1rem; width: 100%; }
        .future-dashboard-subtitle { color: #5f7397; font-size: .92rem; font-weight: 600; }
        .future-dashboard-date { color: #274371; font-weight: 700; }
        .future-dashboard-date small { color: #6f85ad; font-weight: 600; }
        .future-kpi-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: .75rem; }
        .future-kpi-card { display: flex; align-items: center; gap: .75rem; background: #fff; border: 1px solid #dbe6fb; border-radius: 14px; padding: .74rem .82rem; box-shadow: 0 8px 18px rgba(13, 34, 74, .08); min-height: 92px; }
        .future-kpi-icon { width: 42px; height: 42px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; color: #fff; font-size: 1.05rem; }
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
        .future-actions-grid { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: .7rem; }
        .future-action { border: 1px solid #dce7fb; border-radius: 12px; min-height: 62px; display: inline-flex; align-items: center; justify-content: center; gap: .42rem; background: #fff; color: #1f3f70; font-weight: 700; font-size: .82rem; text-decoration: none !important; transition: all .2s ease; }
        .future-action i { font-size: 1rem; }
        .future-action:hover { transform: translateY(-2px); box-shadow: 0 12px 22px rgba(16, 41, 85, .12); border-color: #c9dbfb; }
        .future-activity-list, .future-quick-links { list-style: none; padding: 0; }
        .future-activity-list li { display: flex; gap: .6rem; align-items: flex-start; border-bottom: 1px solid #edf2fb; padding: .5rem 0; color: #21406f; font-size: .86rem; }
        .future-activity-list li:last-child { border-bottom: 0; }
        .future-activity-list li i { color: #3f79ee; margin-top: .2rem; }
        .future-activity-list li small { display: block; color: #6f85ad; }
        .future-side-card { border-radius: 14px; border: 1px solid #dce7fb; }
        .future-side-card .card-body { padding: .9rem .95rem; }
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
        .future-task-tabs { display: flex; align-items: center; gap: .9rem; margin-bottom: .7rem; }
        .future-task-tabs a { color: #7a8fb4; font-size: .78rem; font-weight: 700; text-decoration: none; }
        .future-task-tabs a.active { color: #4f63f2; border-bottom: 2px solid #4f63f2; padding-bottom: .18rem; }
        .dashboard-todo-list { list-style: none; padding: 0; max-height: 350px; overflow-y: auto; margin-top: .05rem; }
        .dashboard-todo-item { border: 1px solid #dbe7f6; border-radius: 10px; padding: .52rem .64rem; background: #f8fbff; margin-bottom: .5rem; cursor: move; }
        .dashboard-todo-item.is-done .dashboard-todo-title { text-decoration: line-through; opacity: .7; }
        .dashboard-todo-item.is-dragging { opacity: .55; background: #edf4ff; }
        .dashboard-todo-title { font-weight: 600; color: #0f2f61; word-break: break-word; margin-bottom: .3rem; white-space: normal; font-size: .84rem; }
        .dashboard-todo-date { color: #64748b; font-size: .72rem; font-weight: 700; margin-bottom: .22rem; }
        .dashboard-todo-meta { display: flex; align-items: center; justify-content: space-between; margin-bottom: .34rem; }
        .future-todo-badge { display: inline-flex; align-items: center; border-radius: 999px; padding: .08rem .45rem; font-size: .67rem; font-weight: 800; }
        .future-todo-badge.mid { color: #ad7a2c; background: #fff4de; }
        .future-todo-badge.low { color: #2d8a58; background: #e8f8ef; }
        .future-todo-deadline { color: #6f85ad; font-size: .69rem; font-weight: 700; }
        .dashboard-todo-actions { display: flex; gap: .35rem; flex-wrap: wrap; }
        .dashboard-todo-empty { color: #64748b; font-size: .9rem; }
        #futureOrdersChart { width: 100%; display: block; }
        @media (max-width: 1199.98px) { .future-kpi-grid, .future-actions-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 767.98px) {
            .future-dashboard-header { flex-direction: column; align-items: flex-start; }
            .future-kpi-grid, .future-actions-grid { grid-template-columns: 1fr; }
            .future-mini-tabs { width: 100%; justify-content: flex-start; margin-top: .35rem; }
            .future-dashboard-footer { flex-direction: column; gap: .2rem; align-items: flex-start; }
        }
    </style>
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('packages/summernote/dist/lang/summernote-it-IT.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartCanvas = document.getElementById('futureOrdersChart');
            const chartLabels = @json($orderChartLabels);
            const rawChartSeries = @json($orderChartSeries);
            const chartSeries = rawChartSeries.some(v => Number(v) > 0)
                ? rawChartSeries
                : [260, 980, 1220, 620, 1320, 1660, 1248];
            if (chartCanvas && chartCanvas.getContext) {
                const drawChart = function() {
                    const ctx = chartCanvas.getContext('2d');
                    const ratio = window.devicePixelRatio || 1;
                    const width = chartCanvas.clientWidth || 640;
                    const height = 110;
                    const pad = 16;
                    const max = Math.max(1, ...chartSeries);
                    const stepX = chartSeries.length > 1 ? (width - pad * 2) / (chartSeries.length - 1) : 0;

                    chartCanvas.width = Math.round(width * ratio);
                    chartCanvas.height = Math.round(height * ratio);
                    chartCanvas.style.height = height + 'px';
                    ctx.setTransform(ratio, 0, 0, ratio, 0, 0);

                    const points = chartSeries.map((v, i) => ({
                        x: pad + (i * stepX),
                        y: (height - pad) - ((v / max) * (height - pad * 2))
                    }));

                    ctx.clearRect(0, 0, width, height);
                    if (!points.length) return;

                    ctx.lineWidth = 2.5;
                    ctx.strokeStyle = '#3f79ee';
                    ctx.beginPath();
                    ctx.moveTo(points[0].x, points[0].y);
                    for (let i = 1; i < points.length; i++) ctx.lineTo(points[i].x, points[i].y);
                    ctx.stroke();

                    ctx.fillStyle = 'rgba(63,121,238,.16)';
                    ctx.beginPath();
                    ctx.moveTo(points[0].x, height - pad);
                    points.forEach(p => ctx.lineTo(p.x, p.y));
                    ctx.lineTo(points[points.length - 1].x, height - pad);
                    ctx.closePath();
                    ctx.fill();

                    ctx.fillStyle = '#60779f';
                    ctx.font = '11px sans-serif';
                    chartLabels.forEach((label, i) => ctx.fillText(label, pad + (i * stepX) - 14, height - 2));
                };

                drawChart();
                window.addEventListener('resize', drawChart);
            }

            const clock = document.getElementById('dashboardDigitalClock');
            if (clock) {
                const tick = function() { clock.textContent = new Date().toLocaleTimeString('it-IT', {hour: '2-digit', minute: '2-digit', hour12: false}); };
                tick();
                setInterval(tick, 1000);
            }

            const todoInput = document.getElementById('dashboardTodoInput');
            const todoAddButton = document.getElementById('dashboardTodoAdd');
            const todoList = document.getElementById('dashboardTodoList');
            const todoEmpty = document.getElementById('dashboardTodoEmpty');
            const todoEditorSaveButton = document.getElementById('dashboardTodoEditorSave');
            const todoDeleteConfirmButton = document.getElementById('dashboardTodoDeleteConfirm');
            if (!todoInput || !todoAddButton || !todoList || !todoEmpty) return;

            const todoBaseUrl = @json(backpack_url('dashboard/todos'));
            const csrfToken = '{{ csrf_token() }}';
            let todoEditingItem = null;
            let todoDeletingItem = null;
            let draggingTodoItem = null;

            $('#dashboardTodoEditor').summernote({
                lang: 'it-IT',
                height: 180,
                toolbar: [['history', ['undo', 'redo']], ['font', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['view', ['codeview']]]
            });

            const setTodoEmptyState = function() { todoEmpty.classList.toggle('d-none', todoList.children.length > 0); };
            const plain = function(html) { return $('<div>').html((html || '').replace(/<br\s*\/?>/gi, '\n')).text().replace(/\s+/g, ' ').trim(); };
            const preview = function(html) { const t = plain(html); return t.length > 100 ? t.substring(0, 100) + '...' : t; };
            const setTodoDisplay = function(item, html) { item.dataset.fullTitle = (html || '').trim(); const title = item.querySelector('.dashboard-todo-title'); if (title) title.textContent = preview(html); };
            const formatDate = function(value) { const d = new Date(value); return Number.isNaN(d.getTime()) ? '' : d.toLocaleDateString('it-IT'); };
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
                item.draggable = true;
                item.dataset.fullTitle = todo.title || '';
                item.innerHTML = '<div class="dashboard-todo-date">' + formatDate(todo.created_at) + '</div>'
                    + '<div class="dashboard-todo-title">' + preview(todo.title) + '</div>'
                    + '<div class="dashboard-todo-meta">'
                    + '<span class="future-todo-badge ' + (todo.is_done ? 'low' : 'mid') + '">' + (todo.is_done ? 'Bassa' : 'Media') + '</span>'
                    + '<span class="future-todo-deadline">' + formatDate(todo.created_at) + '</span>'
                    + '</div>'
                    + '<div class="dashboard-todo-actions">'
                    + '<button type="button" class="btn btn-sm btn-outline-secondary" data-action="toggle">' + (todo.is_done ? 'Riapri' : 'Fatto') + '</button>'
                    + '<button type="button" class="btn btn-sm btn-light" data-action="edit">Modifica</button>'
                    + '<button type="button" class="btn btn-sm btn-outline-danger" data-action="delete">Elimina</button>'
                    + '</div>';
                return item;
            };

            const persistOrder = async function() {
                const ids = Array.from(todoList.querySelectorAll('.dashboard-todo-item')).map(el => parseInt(el.dataset.id, 10)).filter(Number.isInteger);
                if (!ids.length) return;
                await todoRequest(todoBaseUrl + '/reorder', 'POST', { ids: ids });
            };

            const addTodo = async function() {
                const title = todoInput.value.trim();
                if (!title) return;
                todoAddButton.disabled = true;
                try {
                    const result = await todoRequest(todoBaseUrl, 'POST', { title: title });
                    if (result && result.todo) { todoList.append(createTodoElement(result.todo)); todoInput.value = ''; setTodoEmptyState(); }
                } catch (error) { alert('Errore nel salvataggio della nota.'); } finally { todoAddButton.disabled = false; }
            };
            todoAddButton.addEventListener('click', addTodo);
            todoInput.addEventListener('keydown', function(e) { if (e.key === 'Enter') { e.preventDefault(); addTodo(); } });

            todoList.addEventListener('dragstart', function(e) { const item = e.target.closest('.dashboard-todo-item'); if (!item) return; draggingTodoItem = item; item.classList.add('is-dragging'); });
            todoList.addEventListener('dragover', function(e) {
                e.preventDefault();
                if (!draggingTodoItem) return;
                const target = e.target.closest('.dashboard-todo-item');
                if (!target || target === draggingTodoItem) return;
                const rect = target.getBoundingClientRect();
                todoList.insertBefore(draggingTodoItem, e.clientY < rect.top + (rect.height / 2) ? target : target.nextSibling);
            });
            todoList.addEventListener('dragend', async function() { if (!draggingTodoItem) return; draggingTodoItem.classList.remove('is-dragging'); draggingTodoItem = null; try { await persistOrder(); } catch (e) {} });

            todoList.addEventListener('click', async function(e) {
                const button = e.target.closest('button[data-action]');
                if (!button) return;
                const item = button.closest('.dashboard-todo-item');
                if (!item) return;
                const todoId = item.dataset.id;
                const action = button.dataset.action;
                if (action === 'edit') { todoEditingItem = item; $('#dashboardTodoEditor').summernote('code', item.dataset.fullTitle || ''); $('#dashboardTodoEditorModal').modal('show'); return; }
                if (action === 'toggle') {
                    try {
                        const result = await todoRequest(todoBaseUrl + '/' + todoId + '/toggle', 'POST');
                        if (result && result.todo) {
                            item.classList.toggle('is-done', !!result.todo.is_done);
                            setTodoDisplay(item, result.todo.title);
                            button.textContent = result.todo.is_done ? 'Riapri' : 'Fatto';
                            const badge = item.querySelector('.future-todo-badge');
                            if (badge) {
                                badge.classList.remove('mid', 'low');
                                badge.classList.add(result.todo.is_done ? 'low' : 'mid');
                                badge.textContent = result.todo.is_done ? 'Bassa' : 'Media';
                            }
                        }
                    } catch (error) { alert('Errore durante l\'aggiornamento della nota.'); }
                    return;
                }
                if (action === 'delete') { todoDeletingItem = item; $('#dashboardTodoDeleteModal').modal('show'); }
            });

            if (todoEditorSaveButton) {
                todoEditorSaveButton.addEventListener('click', async function() {
                    if (!todoEditingItem) return;
                    const todoId = todoEditingItem.dataset.id;
                    const html = $('#dashboardTodoEditor').summernote('code');
                    if (!plain(html)) { alert('La nota non puo essere vuota.'); return; }
                    todoEditorSaveButton.disabled = true;
                    try {
                        const result = await todoRequest(todoBaseUrl + '/' + todoId, 'PUT', { title: html });
                        if (result && result.todo) setTodoDisplay(todoEditingItem, result.todo.title);
                        $('#dashboardTodoEditorModal').modal('hide');
                    } catch (error) { alert('Errore durante la modifica della nota.'); } finally { todoEditorSaveButton.disabled = false; }
                });
            }
            if (todoDeleteConfirmButton) {
                todoDeleteConfirmButton.addEventListener('click', async function() {
                    if (!todoDeletingItem) return;
                    todoDeleteConfirmButton.disabled = true;
                    try { await todoRequest(todoBaseUrl + '/' + todoDeletingItem.dataset.id, 'DELETE'); todoDeletingItem.remove(); setTodoEmptyState(); $('#dashboardTodoDeleteModal').modal('hide'); }
                    catch (error) { alert('Errore durante l\'eliminazione della nota.'); }
                    finally { todoDeleteConfirmButton.disabled = false; }
                });
            }
            $('#dashboardTodoEditorModal').on('hidden.bs.modal', function() { todoEditingItem = null; $('#dashboardTodoEditor').summernote('code', ''); });
            $('#dashboardTodoDeleteModal').on('hidden.bs.modal', function() { todoDeletingItem = null; });
            setTodoEmptyState();
        });
    </script>
@endsection

@section('footer')
@endsection
