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
            font-size: 13px;
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
    </style>
</head>
<body>

<div class="page">
    <div class="content">
        @if($setting->logo_pdf)
            <img class="img-fluid" src="data:image/jpeg;base64,{{ base64_encode(@file_get_contents(url($setting->logo_pdf))) }}">
        @endif

        <table class="table table-borderless">
            <tbody>
            <tr>
                <td>
                    <table class="table table-borderless table-sm">
                        <tbody>
                        <tr>
                            <td colspan="2"><h2>Ordine n. {{ $order->id }}</h2></td>
                        </tr>
                        <tr>
                            <td>Cliente</td>
                            <td class="text-right">{{ $client->first_name }} {{ $client->last_name }}</td>
                        </tr>
                        <tr>
                            <td>Cellulare</td>
                            <td class="text-right">{{ $client->mobile_1 }}</td>
                        </tr>
                        <tr>
                            <td>Data consegna</td>
                            <td class="text-right">{{ \Carbon\Carbon::createFromFormat("Y-m-d", $order->date_delivery)->format("d/m/Y") }}
                                alle {{ \Carbon\Carbon::createFromFormat("H:i:s", $order->time_delivery)->format("H:i") }}</td>
                        </tr>
                        <tr>
                            <td>Luogo consegna</td>
                            <td class="text-right">{{ $order->place_ritiro }}</td>
                        </tr>
                        <tr>
                            <td>Indirizzo consegna</td>
                            <td class="text-right">
                                {{ $order->address }}
                            </td>
                        </tr>
                        <tr>
                            <td>Stato ordine</td>
                            <td class="text-right">{{ $status->name }}</td>
                        </tr>
                        <tr>
                            <td>Note ordine</td>
                            <td class="text-right">{!! $order->note !!}</td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                @if($details)
                                    <table width="100%">
                                        <thead>
                                        <tr>
                                            <th>Prodotto</th>
                                            <th>Reparto</th>
                                            <th>N.Persone</th>
                                            <th>Qta</th>
                                            <th>Prezzo</th>
                                        </tr>
                                        </thead>
                                        @foreach($details as $detail)
                                            <?php
                                            $product = \App\Models\PluginOrdersProducts::find($detail->plugin_product_id);
                                            $unit = \App\Models\PluginOrdersCategories::find($detail->plugin_category_id);
                                            ?>
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $unit->name }}</td>
                                                <td>{{ $detail->num }}</td>
                                                <td>{{ $detail->qty }}</td>
                                                <td>{{ number_format($detail->price, 2, ",", ".") }} &euro;</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><strong>Totale</strong></td>
                                            <td>{{ number_format($order->total, 2, ",", ".") }} &euro;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><strong>Acconto</strong></td>
                                            <td>{{ number_format($order->acconto, 2, ",", ".") }} &euro;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><strong>Totale da pagare</strong></td>
                                            <td><strong>{{ number_format($order->total - $order->acconto, 2, ",", ".") }} &euro;</strong></td>
                                        </tr>
                                    </table>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td  colspan="2">

                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
