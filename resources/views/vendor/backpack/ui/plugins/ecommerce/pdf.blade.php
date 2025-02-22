<html>

<head>
    <title>CMS-Formula 5.0 Admin Panel</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            font-size: 15px !important;
        }
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
        .table {
            margin: 0;
            width: 100%;
            font-size: 15px !important;
        }
        .table td, .table th {
            font-size: 15px !important;
        }
        .table-borderless td, .table-borderless th {
            border: 0;
        }
    </style>
</head>
<body>
    <?php $userOrder = \App\User::withTrashed()->find($order->user_id); ?>

        <h3 class="text-capitalize">N. Ordine #{{ $order->id }} - {{ $userOrder->name }}</h3>
        <hr>

        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td class="pl-0">
                        <table class="table table-sm table-bordered table-striped text-left">
                            <tbody>
                            <tr>
                                <th>Cliente</th>
                                <td>{{ $userOrder->name }}</td>
                            </tr>
                            <tr>
                                <th>E-Mail</th>
                                <td><a href="mailto:{{ $userOrder->email }}">{{ $userOrder->email }}</a></td>
                            </tr>
                            <tr>
                                <th>Telefono</th>
                                <td>{{ $userOrder->mobile }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td class="pl-0">
                        <table class="table table-sm table-bordered table-striped text-left">
                            <tbody>
                            <tr>
                                <th>Stato ordine</th>
                                <td><u>{{ $order->status->name }}</u></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        @if ($order->shippingAddress)
            <hr>
            <table class="table table-borderless">
                <tbody>
                <tr>
                    <td class="pl-0">
                        <h5>Indirizzo di spedizione</h5>
                        <table class="table table-sm table-bordered table-striped text-left">
                            <tr>
                                <th class="text-left">Nominativo</th>
                                <td>{{ $order->shippingAddress->name }}</td>
                            </tr>
                            <tr>
                                <th>Indirizzo</th>
                                <td>
                                    {{ $order->shippingAddress->address1 }}

                                    @if($order->shippingAddress->number_street)
                                        {{ $order->shippingAddress->number_street }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Nazione</th>
                                <td>
                                    @if($order->shippingAddress->country)
                                        {{ $order->shippingAddress->country->name }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Citt&aacute;</th>
                                <td>{{ $order->shippingAddress->city }}
                                    @if($order->shippingAddress->county)
                                        ({{ $order->shippingAddress->county }})
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Cap</th>
                                <td>{{ $order->shippingAddress->postal_code }}</td>
                            </tr>
                            <tr>
                                <th>Telefono</th>
                                <td>{{ $order->shippingAddress->phone }}</td>
                            </tr>
                            <tr>
                                <th>Cellulare</th>
                                <td>{{ $order->shippingAddress->mobile_phone }}</td>
                            </tr>
                            <tr>
                                <th>Note</th>
                                <td>{{ $order->shippingAddress->comment }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="pl-0">
                        @if ($order->billingCompanyInfo)
                            <h5>Indirizzo di fatturazione</h5>
                            <table class="table table-sm table-bordered table-striped text-left">
                                <tr>
                                    <th>Ragione sociale</th>
                                    <td>{{ $order->billingCompanyInfo->business_name }}</td>
                                </tr>
                                <tr>
                                    <th>Indirizzo</th>
                                    <td>
                                        {{ $order->billingCompanyInfo->address1 }}
                                        @if($order->billingCompanyInfo->number_street)
                                            {{ $order->billingCompanyInfo->number_street }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nazione</th>
                                    <td>
                                        @if($order->billingCompanyInfo->country)
                                            {{ $order->billingCompanyInfo->country->name }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Citt&aacute;</th>
                                    <td>{{ $order->billingCompanyInfo->city }}
                                        @if($order->billingCompanyInfo->county)
                                            ({{ $order->billingCompanyInfo->county }})
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Partita iva</th>
                                    <td>{{ $order->billingCompanyInfo->fiscal_code_vat }}</td>
                                </tr>
                                <tr>
                                    <th>Codice Fiscale</th>
                                    <td>{{ $order->billingCompanyInfo->fiscal_code }}</td>
                                </tr>
                                <tr>
                                    <th>Cellulare</th>
                                    <td>{{ $order->billingCompanyInfo->mobile }}</td>
                                </tr>
                                <tr>
                                    <th>PEC</th>
                                    <td>{{ $order->billingCompanyInfo->pec }}</td>
                                </tr>
                                <tr>
                                    <th>Codice SDI</th>
                                    <td>{{ $order->billingCompanyInfo->sdi }}</td>
                                </tr>
                            </table>
                        @endif

                        @if ($order->billingAddress)
                            <h4>{{ trans('order.billing_address') }}</h4>
                            <table class="table table-sm table-bordered table-striped text-left">
                                <tr>
                                    <th>{{ trans('address.contact_person') }}</th>
                                    <td>{{ $order->billingAddress->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('address.address') }}</th>
                                    <td>
                                        {{ $order->billingAddress->address1 }}
                                        @if($order->billingAddress->number_street)
                                            {{ $order->billingAddress->number_street }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nazione</th>
                                    <td>
                                        @if($order->billingAddress->country)
                                            {{ $order->billingAddress->country->name }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('address.city') }}</th>
                                    <td>{{ $order->billingAddress->city }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('address.postal_code') }}</th>
                                    <td>{{ $order->billingAddress->postal_code }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('address.phone') }}</th>
                                    <td>{{ $order->billingAddress->phone }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('address.mobile_phone') }}</th>
                                    <td>{{ $order->billingAddress->mobile_phone }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('address.comment') }}</th>
                                    <td>{{ $order->billingAddress->comment }}</td>
                                </tr>
                            </table>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        @endif

        @if($order->shipping)
            <h5>Spedizione</h5>
            <table class="table table-sm table-bordered table-striped text-left">
                <thead>
                <tr>
                    <th>Spedizione</th>
                    <th>Prezzo</th>
                    <th>Descrizione</th>
                </tr>
                </thead>
                <tr>
                    <td>{{ $order->shipping->name }}</td>
                    <td>{{ $order->total_shipping_tax }} EUR</td>
                    <td>{{ $order->shipping->delay_description }}</td>
                </tr>
            </table>
        @endif

        @if($payment)
            <hr>
            <h5>Metodo di pagamento</h5>
            <table class="table table-sm table-bordered table-striped text-left">
                <tbody>
                <tr>
                    <th class="py-1">Metodo</th>
                    <td class="py-1"><strong>{{ $payment->name }}</strong></td>
                </tr>
                @if($order->payment_date)
                <tr>
                    <th class="py-1">Data pagamento:</th>
                    <td class="py-1">{{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s" ,$order->payment_date)->format("d/m/Y") }}</td>
                </tr>
                @endif
                @if($order->paypal_payment_id)
                    <tr>
                        <th class="py-1">#IDPAYPAL:</th>
                        <td class="py-1">{{ $order->paypal_payment_id }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        @endif

        @if($order->code_referral or $order->code_coupon)
            <hr>
            <table class="table table-sm table-bordered table-striped text-left">
                <tbody>
                @if($order->code_coupon)
                    <tr>
                        <th class="py-1">Sconto coupon</th>
                        <td class="py-1">{{ $order->code_coupon }}</td>
                    </tr>
                @endif
                @if($order->code_referral)
                    <tr>
                        <th class="py-1">Codice referente</th>
                        <td class="py-1">{{ $order->code_referral }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        @endif

        @if(trim($order->comment) != "")
            <hr>
            <h5>Note</h5>
            {{ $order->comment }}
        @endif

        <hr>
        <h5>Prodotti</h5>
        <table class="table table-sm table-bordered table-striped text-left">
            <thead>
            <tr>
                <th>Prodotto</th>
                @if($price)
                    <th>Prezzo</th>
                    <th>Quantita</th>
                    <th class="text-right">Totale</th>
                @else
                    <th>Quantita</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @php
                $subTotal = 0;
                $total = 0;
            @endphp

            @foreach($order->products as $product)
                <?php
                if($order->currency->iso == "EUR"){
                    $order->currency->name = $order->currency->iso;
                }

                if($order->currency->iso == "DOL"){
                    $order->currency->name = $order->currency->iso;
                }
                ?>
                <tr>
                    <td>
                        {{ $product->pivot->name }}<br/>
                        <span class="font-12">SKU: {{ $product->pivot->sku }}</span>
                    </td>
                    @if($price)
                        <td>
                            @if(env('CALCULATE_IVA') == 1)
                                {{ number_format($product->pivot->price_with_tax,3, ',','.') }}
                            @else
                                {{ number_format($product->pivot->price,3, ',','.') }}
                            @endif
                        </td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td class="text-right">
                                @if(env('CALCULATE_IVA') == 1)
                                    {{ number_format($product->pivot->price_with_tax * $product->pivot->quantity,2, ',','.').' '.$order->currency->name }}
                                @else
                                    {{ number_format($product->pivot->price * $product->pivot->quantity,2, ',','.').' '.$order->currency->name }}
                                @endif
                        </td>
                    @else
                        <td>{{ $product->pivot->quantity }}</td>
                    @endif
                </tr>

                @php
                    $subTotal = $subTotal + $product->pivot->quantity * $product->pivot->price;
                    $total = $total + $product->pivot->quantity * $product->pivot->price_with_tax;
                @endphp

            @endforeach
            </tbody>


            @if($price)
            <tfoot>
            @if(env('HIDE_TASSE') == 0)
                <tr>
                    <th class="text-right" colspan="3">Imponibile</th>
                    <td class="text-right">{{ number_format(round($subTotal, 2),2, ',','.') }} {{ $order->currency->name }}</td>
                </tr>
                <tr>
                    <th class="text-right" colspan="3">Spese di spedizione @if($userOrder->type_client == 1) (iva escl.) @endif</th>
                    <td class="text-right">
                        @if($userOrder->type_client == 1)
                            {{ $order->total_shipping.' '.$order->currency->name }}
                        @else
                            {{ $order->total_shipping_tax.' '.$order->currency->name }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="text-right" colspan="3">IVA</th>
                    <td class="text-right">
                        @if($userOrder->type_client == 1)
                            {{  number_format(round($total - $subTotal + ($order->total_shipping_tax - $order->total_shipping), 2),2, ',','.') }} {{ $order->currency->name }}
                        @else
                            {{  number_format(round($total - $subTotal, 2),2, ',','.') }} {{ $order->currency->name }}
                        @endif
                    </td>
                </tr>
            @endif

            @if($order->code_coupon)
                <tr>
                    <th class="text-right" colspan="3">{{ trans('common.total') }} Coupon</th>
                    <td class="text-right">
                        <strong>{{ ($order->total_tax - $order->total_coupon).' '.$order->currency->name }}</strong>
                    </td>
                </tr>
                <?php
                if($order->extra){
                foreach ($order->extra as $extra){
                ?>
                <tr>
                    <th class="text-right" colspan="3">{{ $extra->name }}</th>
                    <td class="text-right">{{ number_format($extra->pivot->price,2, ".", ",") }} {{ $order->currency->name }}</td>
                </tr>
                <?php }
                } ?>
                <tr>
                    <th class="text-right" colspan="3">Totale</th>
                    <td class="text-right"><strong>{{ ($order->total_tax - $order->total_coupon) + $order->total_extra + $order->total_shipping_tax.' '.$order->currency->name }}</strong></td>
                </tr>

                @if($order->total_giftcard > 0)
                    <tr>
                        <th class="text-right" colspan="3"><strong>Totale da pagare</strong><br>({{ $order->number_giftcard }})</th>
                        <td class="text-right"><strong>{{ ($order->total_tax - $order->total_coupon - $order->total_giftcard) + $order->total_extra + $order->total_shipping_tax.' '.$order->currency->name }}</strong></td>
                    </tr>
                @endif
            @else
                @if(property_exists($order, "extra"))
                    <?php
                    if($order->extra){
                    foreach ($order->extra as $extra){
                    ?>
                    <tr>
                        <th class="text-right" colspan="3">{{ $extra->name }}</th>
                        <td class="text-right">{{ number_format($extra->pivot->price,2, ".", ",") }}</td>
                    </tr>
                    <?php
                    }
                    } ?>
                @endif
                <tr>
                    <th class="text-right" colspan="3">Totale:</th>
                    <td class="text-right"><strong>{{ number_format($order->total_tax + $order->total_shipping_tax + $order->total_extra, 2,",",".").' '.$order->currency->name }}</strong></td>
                </tr>

                @if($order->total_giftcard > 0)
                    <tr>
                        <th class="text-right" colspan="3"><strong>Totale con Gift Card:</strong><br>({{ $order->number_giftcard }})</th>
                        <td class="text-right"><strong>{{ $order->total_tax + $order->total_shipping_tax + $order->total_extra - $order->total_giftcard.' '.$order->currency->name }}</strong></td>
                    </tr>
                @endif
            @endif
            </tfoot>
           @endif
        </table>

</body>
</html>

