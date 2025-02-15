@extends('common.emails.layout')

@section('content')
    <div class="col-12 col-md-9">
    @if($send_psw == 1)
        <!--Contenuto-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                <tbody class="mcnTextBlockOuter">
                <tr>
                    <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                        <!--[if mso]>
                        <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                            <tr>
                        <![endif]-->

                        <!--[if mso]>
                        <td valign="top" width="600" style="width:100%;">
                        <![endif]-->
                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                            <tbody>
                            <tr>
                                <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                    <p style="text-align: center!important; font-size:18px !important; font-family: Georgia"><em>Questo è il tuo primo ordine su {{ env('PROJECT_NAME') }} per {{ $user->email}}</em></p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!--[if mso]>
                        </td>
                        <![endif]-->

                        <!--[if mso]>
                        </tr>
                        </table>
                        <![endif]-->
                    </td>
                </tr>
                </tbody>
            </table>

    @else
        <!--Contenuto-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                <tbody class="mcnTextBlockOuter">
                <tr>
                    <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                        <!--[if mso]>
                        <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                            <tr>
                        <![endif]-->

                        <!--[if mso]>
                        <td valign="top" width="600" style="width:100%;">
                        <![endif]-->
                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                            <tbody>
                            <tr>
                                <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                    <p style="text-align: center!important; font-size:18px !important; font-family: Georgia"><em>Nuovo ordine su {{ env('PROJECT_NAME') }} per {{ $user->email}}</em></p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!--[if mso]>
                        </td>
                        <![endif]-->

                        <!--[if mso]>
                        </tr>
                        </table>
                        <![endif]-->
                    </td>
                </tr>
                </tbody>
            </table>
    @endif

        <!--Contenuto box n ordine-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
            <tbody class="mcnTextBlockOuter">
            <tr>
                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                    <!--[if mso]>
                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                        <tr>
                    <![endif]-->

                    <!--[if mso]>
                    <td valign="top" width="600" style="width:100%;">
                    <![endif]-->
                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="background:#f7f7f7; max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                        <tbody>
                        <tr>
                            <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                <p style="text-align: center!important; font-size:18px !important; font-family: Helvetica">
                                    <strong style="color: #000000">Ordine n. #{{ $order->id }}</strong><br/>
                                    Data: {{ $order->created_at }}
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--[if mso]>
                    </td>
                    <![endif]-->

                    <!--[if mso]>
                    </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
            </tbody>
        </table>

        <!--Tabella ordine-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
            <tbody class="mcnTextBlockOuter">
            <tr>
                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                    <!--[if mso]>
                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                        <tr>
                    <![endif]-->

                    <!--[if mso]>
                    <td valign="top" width="600" style="width:100%;">
                    <![endif]-->
                    @include('common.pluginProducts.partials.checkout.detail_order_email')
                    <!--[if mso]>
                    </td>
                    <![endif]-->

                    <!--[if mso]>
                    </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
            </tbody>
        </table>

        <!--Contenuto box metodo pagamento spedizione-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
            <tbody class="mcnTextBlockOuter">
            <tr>
                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                    <!--[if mso]>
                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                        <tr>
                    <![endif]-->

                    <!--[if mso]>
                    <td valign="top" width="600" style="width:100%;">
                    <![endif]-->
                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="background:#f7f7f7; max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                        <tbody>
                        <tr>
                            <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                @if($order->total_giftcard > 0)
                                    <div style="text-align:center; padding:15px; margin-bottom:10px; border-radius:5px; border:1px solid #ddd;">
                                        <p style="text-align: center!important; font-size:18px !important; font-family: Helvetica; margin-bottom: 0"><strong>Gift Card numero:</strong></p>
                                        <h3 style="text-align: center!important; font-size:22px !important; font-family: Helvetica"> {{ $order->number_giftcard }} </h3>
                                        <p style="text-align: center!important; font-size:18px !important; font-family: Helvetica">Valore consumato: <strong>{{ number_format($order->total_giftcard,2, ",", ".") }} &euro;</strong></p>
                                    </div>
                                @endif

                                @if($order->payment)
                                <p style="font-size:14px !important; font-family: Helvetica">
                                    Metodo di pagamento: {{ $order->payment->name }}<br/>
                                    <small>{{ $order->payment->info }}</small><br/>
                                    @if($order->shipping)
                                    Metodo di spedizione: {{ $order->shipping->name }}
                                    @endif
                                </p>
                                @endif
                            </td>
                            <!--Bottone-->
                            @if(($order->payment_id == 2 || $order->payment_id == 4) && !$order->paypal_payment_id)
                                <td style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                                    <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #f7931e;">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Helvetica; font-size: 18px; padding: 18px;">
                                                <a class="mcnButton " title="" href="{{ env('APP_URL') }}/order_result?order_id={{ $order->id }}" target="_blank" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Paga adesso</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            @endif
                        </tr>
                        </tbody>
                    </table>
                    <!--[if mso]>
                    </td>
                    <![endif]-->

                    <!--[if mso]>
                    </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
            </tbody>
        </table>

        <!--Contenuto fatturazione spedizione-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
            <tbody class="mcnTextBlockOuter">
            <tr>
                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                    <!--[if mso]>
                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                        <tr>
                    <![endif]-->

                    <!--[if mso]>
                    <td valign="top" width="600" style="width:100%;">
                    <![endif]-->
                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                        <tbody>
                        <tr>
                            <td valign="top" class="mcnTextContent" style="width:50%; padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px; border:1px solid #dddddd">
                                <strong>Indirizzo di spedizione</strong><br/>
                                {{ @$order->shippingAddress->name }}<br/>
                                {{ @$order->shippingAddress->country->name }}<br/>
                                {{ @$order->shippingAddress->city }} ({{ @$order->shippingAddress->county }})<br/>
                                {{ @$order->shippingAddress->address1 }}
                                @if($order->shippingAddress->number_street)
                                    {{ $order->shippingAddress->number_street }}
                                @endif
                                <br/>
                                {{ @$order->shippingAddress->postal_code }}

                                <p>{{ $order->note }}</p>
                            </td>
                            <td valign="top" class="mcnTextContent" style="width:50%;padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px; border:1px solid #dddddd">
                                <strong>Dati di fatturazione</strong><br/>
                                @if($order->billingCompanyInfo->business_name)
                                    {{ $order->billingCompanyInfo->business_name }}<br/>
                                @else
                                    {{ $order->billingCompanyInfo->name }}<br/>
                                @endif
                                @if($order->billingCompanyInfo->fiscal_code_vat)
                                    {{ $order->billingCompanyInfo->business_name }}<br/>
                                @endif

                                {{ @$order->billingCompanyInfo->country->name }}<br/>
                                {{ @$order->billingCompanyInfo->city }} ({{ $order->billingCompanyInfo->county }})<br/>
                                {{ @$order->billingCompanyInfo->address1 }}
                                @if($order->billingCompanyInfo->number_street)
                                    {{ $order->billingCompanyInfo->number_street }}<br/>
                                    @endif

                                    @if($order->billingCompanyInfo->pec)
                                    {{ $order->billingCompanyInfo->pec }}</li>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--[if mso]>
                    </td>
                    <![endif]-->

                    <!--[if mso]>
                    </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
            </tbody>
        </table>
@endsection
