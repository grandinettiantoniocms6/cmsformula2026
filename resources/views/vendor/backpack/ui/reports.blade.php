@extends(backpack_view('blank'))

@section('header')
    <section class="container-fluid reports-page-header">
        <h2>Reports</h2>
        <p class="text-muted mb-0">Visite e pagine viste del sito.</p>
    </section>
@endsection

@section('content')
    <div class="reports-page">
        <form method="GET" action="{{ backpack_url('reports') }}" class="reports-filter-panel mb-3">
            <div class="reports-filter-grid">
                <div>
                    <label for="reports_days">Periodo rapido</label>
                    <select id="reports_days" name="days" class="form-control">
                        @foreach($allowedDays as $allowedDay)
                            <option value="{{ $allowedDay }}" {{ (int) $days === (int) $allowedDay ? 'selected' : '' }}>
                                Ultimi {{ $allowedDay }} giorni
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="reports_from">Dal</label>
                    <input id="reports_from" type="date" name="from" value="{{ $fromDateString }}" class="form-control">
                </div>
                <div>
                    <label for="reports_to">Al</label>
                    <input id="reports_to" type="date" name="to" value="{{ $toDateString }}" class="form-control">
                </div>
                <div>
                    <label for="reports_page">Pagina</label>
                    <input id="reports_page" type="text" name="page" value="{{ $pageSearch }}" class="form-control" placeholder="Titolo, slug o ID">
                </div>
                <div class="reports-filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="la la-filter"></i> Filtra
                    </button>
                    <a href="{{ backpack_url('reports') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>

        <div class="reports-kpi-grid mb-3">
            <div class="reports-kpi">
                <span>Visite totali</span>
                <strong>{{ number_format($trafficTotal, 0, ',', '.') }}</strong>
                <small>{{ $selectedDays }} giorni analizzati</small>
            </div>
            <div class="reports-kpi">
                <span>Media giornaliera</span>
                <strong>{{ number_format($trafficAverage, 1, ',', '.') }}</strong>
                <small>Visite per giorno</small>
            </div>
            <div class="reports-kpi">
                <span>Pagine tracciate</span>
                <strong>{{ number_format($trackedPagesCount, 0, ',', '.') }}</strong>
                <small>{{ $pageSearch !== '' ? 'Filtro pagina attivo' : 'Nel periodo selezionato' }}</small>
            </div>
            <div class="reports-kpi">
                <span>Pagina top</span>
                <strong title="{{ $topPageLabel }}">{{ \Illuminate\Support\Str::limit($topPageLabel, 34) }}</strong>
                <small>{{ number_format($topPageVisits, 0, ',', '.') }} visite</small>
            </div>
        </div>

        <div class="card card-dashboard reports-card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0">Visite</h5>
                    <small class="text-muted">Andamento dal {{ \Carbon\Carbon::parse($fromDateString)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($toDateString)->format('d/m/Y') }}</small>
                </div>
            </div>
            <div class="card-body reports-chart-body">
                @if(!$hasFrontendVisitsTable)
                    <div class="reports-empty">Tabella visite non disponibile.</div>
                @elseif($trafficTotal === 0)
                    <div class="reports-empty">Nessuna visita registrata nel periodo selezionato.</div>
                @else
                    <canvas id="reportsTrafficChart" height="120"></canvas>
                @endif
            </div>
        </div>

        <div class="card card-dashboard reports-card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0">Pagine viste</h5>
                    <small class="text-muted">Tutte le pagine aggregate nel periodo selezionato</small>
                </div>
                <span class="reports-total-badge">{{ number_format($pageVisitsTotal, 0, ',', '.') }} visite</span>
            </div>
            <div class="card-body">
                @if(!$hasFrontendPageVisitsTable)
                    <div class="reports-empty">Tabella visite per pagina non disponibile.</div>
                @elseif(count($pageVisitsSeries) === 0)
                    <div class="reports-empty">Nessuna pagina trovata con i filtri selezionati.</div>
                @else
                    <div class="reports-page-bars">
                        @php $maxPageVisits = max(1, max($pageVisitsSeries)); @endphp
                        @foreach($pageVisitsLabels as $index => $pageLabel)
                            @php
                                $pageVisits = (int) ($pageVisitsSeries[$index] ?? 0);
                                $pageSlug = (string) ($pageVisitsSlugs[$index] ?? '');
                                $percent = max(2, round(($pageVisits / $maxPageVisits) * 100));
                            @endphp
                            <div class="reports-page-bar-row">
                                <span class="reports-page-rank">#{{ $index + 1 }}</span>
                                <div class="reports-page-bar-main">
                                    <div class="reports-page-bar-title">
                                        <span title="{{ $pageLabel }}">{{ $pageLabel }}</span>
                                        @if($pageSlug !== '')
                                            <small title="{{ $pageSlug }}">{{ $pageSlug }}</small>
                                        @endif
                                    </div>
                                    <div class="reports-page-bar-track">
                                        <div class="reports-page-bar-fill" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                                <strong>{{ number_format($pageVisits, 0, ',', '.') }}</strong>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        @if(count($pageVisitsSeries) > 0)
            <div class="card card-dashboard reports-card">
                <div class="card-header">
                    <h5 class="mb-0">Dettaglio pagine</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 reports-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pagina</th>
                                <th>Slug</th>
                                <th class="text-right">Visite</th>
                                <th class="text-right">% totale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pageVisitsLabels as $index => $pageLabel)
                                @php
                                    $pageVisits = (int) ($pageVisitsSeries[$index] ?? 0);
                                    $pageSlug = (string) ($pageVisitsSlugs[$index] ?? '');
                                    $share = $pageVisitsTotal > 0 ? round(($pageVisits / $pageVisitsTotal) * 100, 1) : 0;
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pageLabel }}</td>
                                    <td>{{ $pageSlug !== '' ? $pageSlug : '-' }}</td>
                                    <td class="text-right">{{ number_format($pageVisits, 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($share, 1, ',', '.') }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="reports-footer">
            <span>&copy; {{ now()->format('Y') }} {{ config('backpack.base.developer_name') }}</span>
            <span>{{ config('backpack.base.developer_name') }}</span>
        </div>
    </div>
@endsection

@section('after_styles')
    <style>
        .reports-page-header h2 { color: #1f3f70; font-weight: 800; margin-bottom: .15rem; }
        .reports-page { color: #243f66; }
        .reports-filter-panel { border: 1px solid #dce7fb; border-radius: 12px; background: #ffffff; padding: .9rem; box-shadow: 0 10px 22px rgba(13, 34, 74, .07); }
        .reports-filter-grid { display: grid; grid-template-columns: 1.1fr .8fr .8fr 1.2fr auto; gap: .75rem; align-items: end; }
        .reports-filter-grid label { color: #5f7397; font-size: .76rem; font-weight: 800; margin-bottom: .25rem; }
        .reports-filter-actions { display: inline-flex; gap: .45rem; align-items: center; white-space: nowrap; }
        .reports-kpi-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: .75rem; }
        .reports-kpi { border: 1px solid #dce7fb; border-radius: 12px; background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%); padding: .82rem .92rem; min-width: 0; box-shadow: 0 10px 22px rgba(13, 34, 74, .06); }
        .reports-kpi span { display: block; color: #61779f; font-size: .76rem; font-weight: 800; text-transform: uppercase; }
        .reports-kpi strong { display: block; color: #1f3f70; font-size: 1.35rem; line-height: 1.12; font-weight: 800; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .reports-kpi small { display: block; color: #7387aa; font-size: .76rem; margin-top: .2rem; }
        .reports-card { border-radius: 14px; border: 1px solid #dce7fb; box-shadow: 0 12px 24px rgba(13, 34, 74, .08); }
        .reports-card .card-header { background: linear-gradient(130deg, #f5f9ff 0%, #ffffff 100%); border-bottom: 1px solid #e0eafc; }
        .reports-chart-body { height: 360px; min-height: 360px; }
        .reports-chart-body canvas { width: 100%; display: block; }
        .reports-empty { color: #64748b; font-size: .9rem; text-align: center; padding: 2rem .75rem; }
        .reports-total-badge { display: inline-flex; align-items: center; border-radius: 999px; padding: .22rem .58rem; color: #15834b; background: #e8f8ef; font-weight: 800; font-size: .78rem; white-space: nowrap; }
        .reports-page-bars { max-height: 620px; overflow-y: auto; padding-right: .25rem; display: flex; flex-direction: column; gap: .5rem; }
        .reports-page-bar-row { display: grid; grid-template-columns: 44px minmax(0, 1fr) 82px; align-items: center; gap: .72rem; border: 1px solid #e1eaf8; border-radius: 12px; padding: .58rem .68rem; background: linear-gradient(180deg, #ffffff 0%, #f9fbff 100%); }
        .reports-page-rank { width: 32px; height: 32px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; background: #eaf5ef; color: #18864c; font-weight: 800; font-size: .78rem; }
        .reports-page-bar-main { min-width: 0; }
        .reports-page-bar-title { display: flex; align-items: baseline; gap: .6rem; min-width: 0; margin-bottom: .32rem; }
        .reports-page-bar-title span { color: #1f3f70; font-size: .88rem; font-weight: 800; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .reports-page-bar-title small { color: #7387aa; font-size: .74rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 0 1 34%; }
        .reports-page-bar-track { position: relative; height: 8px; border-radius: 999px; background: #edf4fb; overflow: hidden; }
        .reports-page-bar-fill { height: 100%; min-width: 6px; border-radius: inherit; background: linear-gradient(90deg, #2cad62 0%, #6bd291 100%); }
        .reports-page-bar-row strong { justify-self: end; color: #15834b; background: #e8f8ef; border-radius: 999px; padding: .2rem .52rem; font-size: .78rem; white-space: nowrap; }
        .reports-table th { color: #61779f; font-size: .76rem; text-transform: uppercase; }
        .reports-table td { color: #243f66; vertical-align: middle; }
        .reports-footer { display: flex; justify-content: space-between; align-items: center; color: #7e90b1; font-size: .74rem; font-weight: 600; padding: .9rem .2rem .4rem; }
        @media (max-width: 1199.98px) {
            .reports-filter-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .reports-filter-actions { grid-column: 1 / -1; }
            .reports-kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 767.98px) {
            .reports-filter-grid, .reports-kpi-grid { grid-template-columns: 1fr; }
            .reports-filter-actions { flex-wrap: wrap; }
            .reports-page-bar-row { grid-template-columns: 36px minmax(0, 1fr); }
            .reports-page-bar-row strong { grid-column: 2; justify-self: start; }
            .reports-page-bar-title { flex-direction: column; gap: .1rem; }
            .reports-page-bar-title small { max-width: 100%; flex-basis: auto; }
            .reports-footer { flex-direction: column; gap: .2rem; align-items: flex-start; }
        }
    </style>
@endsection

@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trafficCanvas = document.getElementById('reportsTrafficChart');
            if (!trafficCanvas || !trafficCanvas.getContext || !window.Chart) {
                return;
            }

            const labels = @json($trafficLabels);
            const series = @json($trafficSeries).map(function(value) {
                return Number(value) || 0;
            });

            new Chart(trafficCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        data: series,
                        borderColor: '#3f79ee',
                        backgroundColor: 'rgba(63,121,238,.16)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointRadius: 2.4,
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
                                    return Number(context.parsed.y || 0).toLocaleString('it-IT') + ' visite';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#60779f', maxTicksLimit: 12 }
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
        });
    </script>
@endsection
