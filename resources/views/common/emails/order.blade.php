@extends('common.emails.layout')

@section('content')

    <?php
        $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
    ?>
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
                                    <p style="text-align: center!important; font-size:18px !important; font-family: Georgia"><em>{{ @$labels['shop-email-benvenuto'] }} {{ env('PROJECT_NAME') }}</em></p>
                                    <p style="text-align: center!important; font-size:18px !important; font-family: Helvetica">
                                        {{ @$labels['shop-email-grazie-primo-ordine'] }} </p>
                                    <p style="text-align: center!important; font-size:18px !important; font-family: Helvetica">
                                        <strong>{{ @$labels['shop-email-mail'] }} </strong> {{ $user->email}}<br/>
                                        <strong>{{ @$labels['shop-email-psw'] }} </strong> {{ $code_psw }}</p>
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

            <!--Spazio-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                <tbody class="mcnDividerBlockOuter">
                <tr>
                    <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px 18px 0px;">
                        <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <span></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

            <!--Bottone-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
                <tbody class="mcnButtonBlockOuter">
                <tr>
                    <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                        <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #f7931e;">
                            <tbody>
                            <tr>
                                <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Helvetica; font-size: 18px; padding: 18px;">
                                    @if($user->active == 1)
                                        <a class="mcnButton " title="Let's Get Started" href="{{ route('login') }}" target="_blank" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">{{ @$labels['shop-email-login-page'] }} </a>
                                    @else
                                        <a class="mcnButton " title="Let's Get Started" href="{{ route('index.activate', $user->code) }}" target="_blank" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">{{ @$labels['shop-email-attivazione'] }}</a>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
                                    <strong style="color: #000000">{{ @$labels['shop-email-num-ordine'] }} {{ $order->id }}</strong><br/>
                                        {{ @$labels['shop-email-data-ordine'] }} {{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $order->created_at)->format("d/m/Y H:i") }}
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
                                            <p style="text-align: center!important; font-size:18px !important; font-family: Helvetica; margin-bottom: 0"><strong>{{ @$labels['shop-email-gift-card'] }} </strong></p>
                                            <h3 style="text-align: center!important; font-size:22px !important; font-family: Helvetica"> {{ $order->number_giftcard }} </h3>
                                            <p style="text-align: center!important; font-size:18px !important; font-family: Helvetica">{{ @$labels['shop-myarea-valore-consumato'] }}  <strong>{{ number_format($order->total_giftcard,2, ",", ".") }} &euro;</strong></p>
                                        </div>
                                    @endif

                                    @if($order->payment)
                                    <p style="font-size:14px !important; font-family: Helvetica">
                                        {{ @$labels['shop-myarea-metodo-di-pagamento'] }} {{ $order->payment->name }}<br/>
                                    <small>{{ $order->payment->info }}</small><br/>
                                        @if($order->shipping)
                                            {{ @$labels['shop-partials-metodo-spedizione'] }} {{ $order->shipping->name }}
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
                                                        <a class="mcnButton " title="" href="{{ env('APP_URL') }}/order_result?order_id={{ $order->id }}" target="_blank" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">{{ @$labels['shop-myarea-paga-adesso'] }} </a>
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
                                <td valign="top" class="mcnTextContent" style="width:50%;padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px; border:1px solid #dddddd">
                                    <strong>{{ @$labels['shop-indirizzo-spedizione'] }}</strong><br/>
                                    {{ @$order->shippingAddress->name }}<br/>
                                    {{ @$order->shippingAddress->country->name }}<br/>
                                    {{ @$order->shippingAddress->city }} ({{ @$order->shippingAddress->county }})<br/>
                                    {{ @$order->shippingAddress->address1 }}
                                    @if($order->shippingAddress->number_street)
                                        {{ $order->shippingAddress->number_street }}
                                    @endif
                                    <br/>
                                    {{ @$order->shippingAddress->postal_code }}
                                    <p>{{ @$order->note }}</p>
                                </td>
                                <td valign="top" class="mcnTextContent" style="width:50%;padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px; border:1px solid #dddddd">
                                    <strong>{{ @$labels['shop-checkout-dati-fatturazione'] }} </strong><br/>
                                    @if($order->billingCompanyInfo->business_name)
                                        {{ $order->billingCompanyInfo->business_name }}<br/>
                                    @else
                                        {{ $order->billingCompanyInfo->name }}<br/>
                                    @endif
                                    @if($order->billingCompanyInfo->fiscal_code_vat)
                                        {{ $order->billingCompanyInfo->business_name }}<br/>
                                    @endif

                                    {{ @$order->billingCompanyInfo->country->name }}<br/>
                                    {{ @$order->billingCompanyInfo->city }} ({{ @$order->billingCompanyInfo->county }})<br/>
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
