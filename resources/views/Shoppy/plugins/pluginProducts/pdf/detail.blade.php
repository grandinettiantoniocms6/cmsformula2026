<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>PDF</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
        <table class="table table-borderless">
            <tbody>
            <tr>
                <td class="w-50">
                    @if($setting->foto_pdf)
                        <img class="img-fluid" src="{{ url($setting->foto_pdf) }}">
                    @else
                        @if($website->logo)
                            <img class="img-fluid" src="{{ url($website->logo) }}">
                        @else
                            {{ $website->title }}
                        @endif
                    @endif

                </td>
                <td class="w-50">
                    <table class="table table-borderless table-sm">
                        <tbody>
                        <tr>
                            <td colspan="2"><h2>{{ $itemProduct->name }}</h2></td>
                        </tr>
                        <tr>
                            <td>{{ @$labels['sku'] }}</td>
                            <td class="text-right">{{ $itemProduct->sku }}</td>
                        </tr>
                        <tr>
                            <td>{{ @$labels['categoria'] }}</td>
                            <td class="text-right">{{ $itemProduct->category->name }}</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td  colspan="2"><h4>{{ $itemProduct->name }}</h4></td>
            </tr>

            <tr>
                <td class="w-50">
                    @if(count($itemProduct->options))
                        <table class="table table-bordered table-striped table-sm">
                            <tbody>
                            @foreach($itemProduct->options as $option)
                                <?php
                                $name = json_decode($option->name, true);
                                ?>
                                <tr>
                                    <td> {{ $name[\App::getLocale()] }}</td>
                                    <td>{{ $option->value }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </td>
                <td class="w-50">
                    @if($itemProduct->images)
                        <?php
                            $i = 0;
                        ?>
                        @foreach($itemProduct->images as $image)
                            <?php
                            if($i > count($itemProduct->images)-2){
                                break;
                            }
                            ?>
                            <img class="img-fluid" src="{{ url("uploads/products/$image->image") }}" width="300">
                            <?php $i++; ?>
                        @endforeach
                    @endif
                </td>
            </tr>
            </tbody>
        </table>


        @if($itemProduct->images)
            <?php
            $i = 0;
            ?>
            @foreach($itemProduct->images as $image)
                <?php
                if($i > count($itemProduct->images)-2){
                   echo '<div style="page-break-after:always;"></div>';
                   ?>
                    <img class="img-fluid" src="{{ url("uploads/products/$image->image") }}">
                    <div style="page-break-after:always;"></div>
                    <?php
                }
                ?>
                <?php $i++; ?>
            @endforeach
        @endif


        @if(count($itemProduct->related))
            <table class="table table-borderless">
                <tbody>
                <tr>
                    <td colspan="4"><h3>{{ $labels['accessori'] }}</h3></td>
                </tr>
                    @foreach($itemProduct->related as $related)
                        @if($related->product)
                            <tr>
                                <td>
                                    @if($related->product->cover)
                                        <img class="img-fluid mx-auto" src="{{ $related->product->cover }}" alt="" width="200">
                                    @else
                                        <img class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="" width="200">
                                    @endif
                                </td>
                                <td>{{ $related->product->name }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>


</div>

</body>
</html>
