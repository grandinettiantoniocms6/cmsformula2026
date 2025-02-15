<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>PDF</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            font-size: 16px;
        }
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
        .content {
            padding: 0;
            background: white;
        }
        .table {
            margin: 0;
        }
        .table-borderless td, .table-borderless th {
            border: 0;
        }
    </style>

    <style type="text/css" media="print">
        div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
            overflow: hidden;
        }
    </style>
</head>
<body>

<?php
$setting = \App\Models\PluginInterventionsSetting::first();
?>

<!-- Se il logo lo voglio ciclare per ogni intervento lo sposto a riga 59 come era in origine -->
@if($setting->logo)
    <img class="img-fluid" src="data:image/jpeg;base64,{{ base64_encode(@file_get_contents(url($setting->logo))) }}">
@endif

<br><br>

@if($list)
    @foreach($list as $intervention)
        <div class="page">
            <div class="content">

                - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                <tr>
                                    <th>Mezzo:</th>
                                    <td class="text-left" style="font-weight: bold;">{{ $intervention->vehicle->name }}</td>

                                    <th>Autista:</th>
                                    <td class="text-left" style="font-weight: bold;">
                                        @if($intervention->driver)
                                            {{ $intervention->driver->first_name }} {{ $intervention->driver->last_name }}
                                        @endif
                                    </td>

                                    <th>Manovale:</th>
                                    <td class="text-left" style="font-weight: bold;">
                                        @if($intervention->laborer)
                                            {{ $intervention->laborer->first_name }} {{ $intervention->laborer->last_name }}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Data intervento:</th>
                                    <td class="text-left" style="font-weight: bold;">
                                        {{ \Carbon\Carbon::createFromFormat("Y-m-d", $intervention->date_intervention)->format("d/m/Y") }}

                                    </td>

                                    <th>Orario:</th>
                                    <td class="text-left" style="font-weight: bold;">
                                            <?php
                                            if($intervention->is_all_day){
                                                echo "Tutto il giorno";
                                            }else{
                                                $start = "";
                                                $end = "";
                                                if($intervention->start){
                                                    $start = \Carbon\Carbon::createFromFormat("H:i:s", $intervention->start)->format("H:i");
                                                }
                                                if($intervention->end){
                                                    $end = \Carbon\Carbon::createFromFormat("H:i:s", $intervention->end)->format("H:i");
                                                }

                                                echo "Dalle $start alle $end";
                                            }
                                            ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%">Cliente:</td>
                                    <td class="text-left">{{ $intervention->first_name }} {{ $intervention->last_name }}</td>

                                    <td>Cellulare:</td>
                                    <td class="text-left">{{ $intervention->mobile }}</td>
                                </tr>

                                <tr>
                                    <td style="font-weight: bold;">Indirizzo:</td>
                                    <td class="text-left" style="font-weight: bold;">{{ $intervention->address }}</td>

                                    <td style="font-weight: bold;">Civico:</td>
                                    <td class="text-left" style="font-weight: bold;">{{ $intervention->civico }}</td>

                                </tr>

                                <tr>

                                    <td style="font-weight: bold;">Frazione:</td>
                                    <td class="text-left" style="font-weight: bold;">{{ $intervention->frazione }}</td>

                                    <td style="font-weight: bold;">Comune:</td>
                                    <td class="text-left" style="font-weight: bold;">{{ $intervention->comune }}</td>


                                <!--
                                    <td>Provincia:</td>
                                    <td class="text-left">{{ $intervention->provincia }}</td>
                                -->
                                </tr>


                                </tbody>
                            </table>
                        </td>
                    </tr>

                    @if(trim($intervention->note) != "" && $intervention->note !== null)
                        <tr>
                            <td  colspan="2">
                                <h5 style="font-weight: bold;">Note intervento</h5>
                                <h4>{!! $intervention->note !!}</h4>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!--
        Senza il commento genera una pagina per intervento
        <div style="page-break-after:always;"></div> -->
    @endforeach

@endif

</body>
</html>
