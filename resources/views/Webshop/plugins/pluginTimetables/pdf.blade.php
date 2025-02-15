<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>PDF</title>
    @if(env('LOCAL') == 1)
        <link href="{{ url("css/bootstrap4.min.css") }}" rel="stylesheet">
    @else
        <link href="{{ public_path('css/bootstrap4.min.css') }}" rel="stylesheet">
    @endif
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
            }
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            font-size: 14px;
        }
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .table-borderless, .table-borderless td {
            border: 0;
            line-height: 1.3;
        }
        .table tr td:first-child, .table tr th:first-child {
            padding-left: 1rem;
        }
        .table tr td:last-child, .table tr th:last-child {
            padding-right: 1rem;
        }
        .table.table-day {
            border-color: #000;
            line-height: 1.3;
        }
        .table.table-day th {
            border-bottom-width: 0;
        }
        .table.table-day td {
            border-color: #000;
        }
        .table.table-day th.th-border-1, .table.table-day th.th-border-2, .table.table-day th.th-border-3, .table.table-day th.th-border-4, .table.table-day th.th-border-5, .table.table-day th.th-border-6 {
            border-top: 2px solid #e6e02d !important;
        }
        .table.table-day th.th-border-7 {
            border-top: 2px solid #000 !important;
        }
        .table.table-day td p {
            margin: 0;
        }
        .bg-color {
            background-color:  #e6e02d;
        }
        .bg-white {
            background-color:  #ffffff;
        }
        .border-black {
            border: 2px solid #000;
            padding: 2px;
        }
        #timetables_days {
            padding: 0;
            width: 100%;
            height: 1px;
        }
        #timetables_days > tbody > tr {
            height: 1px;
        }
        #timetables_days > tbody > tr > td {
            padding: 0;
            border: 0;
        }
    </style>
</head>
<body>

<div class="page">
    <table class="table table-borderless table-sm">
        <tbody>
            <tr>
                @if($timetable->logo)
                    <td class="text-left align-middle border-0">
                        @if(env('LOCAL') == 1)
                            <?php $url_logo = url($timetable->logo); ?>
                        @else
                            <?php $url_logo = public_path($timetable->logo); ?>
                        @endif
                        <img src="{{ $url_logo }}" width="auto" class="logo">
                    </td>
                    <td class="text-right align-middle border-0">
                        <h3 class="font-weight-bold mb-0">{{ $timetable->title }}</h3>
                        <div>{{ $timetable->abstract }}</div>
                    </td>
                @else
                    <td>
                        <h3 class="font-weight-bold mb-0 border-0">{{ $timetable->title }}</h3>
                        <div>{{ $timetable->abstract }}</div>
                    </td>
                @endif
            </tr>
        </tbody>
    </table>

    @if($timetables_days)
        <table id="timetables_days">
            <tbody>
                @foreach($timetables_days as $t)
                    <?php
                    $orari = \App\Models\PluginTimetablesDay::where("plugin_timetable_id",  $timetable->id)
                        ->where("day", $t->day)
                        ->where("is_special", "!=", 1)
                        ->get();

                    $orari_special = \App\Models\PluginTimetablesDay::where("plugin_timetable_id",  $timetable->id)
                        ->where("day", $t->day)
                        ->where("is_special", "=", 1)
                        ->get();
                    ?>

                    <?php if(in_array($t->day, array(1, 4) )): ?><tr><td width="300" class="align-top"><?php endif; ?>
                    <?php if(in_array($t->day, array(2, 3, 5, 6) )): ?><td width="300" class="align-top"><?php endif; ?>

                            <?php if(in_array($t->day, array(1, 2, 3, 4, 5, 6) )): ?><div class="border-black m-1 h-100"><?php endif; ?>
                                <table class="table table-sm table-day mb-0">
                                    <thead>
                                    <tr>
                                        <th class="bg-color th-border-{{ $t->day }}">
                                            @if(key_exists($t->day, config("config.days")))
                                                {{ config("config.days")[$t->day] }}
                                            @endif
                                        </th>
                                        <th class="bg-color th-border-{{ $t->day }}"></th>
                                    </tr>
                                    </thead>
                                    @if($orari)
                                        <tbody>
                                        @foreach($orari as $o)
                                            <tr>
                                                <td class="align-top bg-white" width="150">{{ $o->title }}</td>
                                                <td class="align-top bg-white">{!! $o->description !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    @endif
                                    @if($orari_special)
                                        @if(count($orari_special) > 0)
                                            <tfoot>
                                            @foreach($orari_special as $o)
                                                <tr>
                                                    <td class="bg-color align-top" width="150">{{ $o->title }}</td>
                                                    <td class="bg-color align-top">{!! $o->description !!}</td>
                                                </tr>
                                            @endforeach
                                            </tfoot>
                                        @endif
                                    @endif
                                </table>
                            <?php if(in_array($t->day, array(1, 2, 3, 4, 5, 7) )): ?></div><?php endif; ?>

                    <?php if(in_array($t->day, array(1, 2, 4, 5) )): ?></td><td class="align-top border-0" width="10"></td><?php endif; ?>
                    <?php if(in_array($t->day, array(3, 7) )): ?></td></tr><tr><td colspan="3" class="align-top border-0"><br></td></tr><?php endif; ?>

                @endforeach
            </tbody>
        </table>
    @endif
</div>

</body>
</html>
