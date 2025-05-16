@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.list') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <?php $userOrder = \App\User::withTrashed()->find($order->user_id); ?>
    <div class="container-fluid">
        <h3>
            <span class="text-capitalize">#{{ $order->id }} - {{ $userOrder->name }}</span>
        </h3>
        <hr>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9">

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tab-shipping-address" role="tab" aria-controls="pills-home" aria-selected="true">Spedizione & Fatturazione</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab-history-info" role="tab" aria-controls="pills-profile" aria-selected="false">Storico Ordini</a></li>
                    </ul>
                </div>
                @if ($order->shippingAddress)
                    <div class="tab-content border-left-0 border-right-0 py-0">
                        <div class="tab-pane active" id="tab-shipping-address">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Indirizzo di spedizione</h5>
                                    <table class="table table-sm table-striped">
                                        <tr>
                                            <td>Nominativo</td>
                                            <td>{{ $order->shippingAddress->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Indirizzo</td>
                                            <td>
                                                {{ $order->shippingAddress->address1 }}

                                                @if($order->shippingAddress->number_street)
                                                    {{ $order->shippingAddress->number_street }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nazione</td>
                                            <td>
                                                @if($order->shippingAddress->country)
                                                    {{ $order->shippingAddress->country->name }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Città</td>
                                            <td>{{ $order->shippingAddress->city }}
                                                @if($order->shippingAddress->county)
                                                    ({{ $order->shippingAddress->county }})
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Cap</td>
                                            <td>{{ $order->shippingAddress->postal_code }}</td>
                                        </tr>
                                        <tr>
                                            <td>Telefono</td>
                                            <td>{{ $order->shippingAddress->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cellulare</td>
                                            <td>{{ $order->shippingAddress->mobile_phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Note</td>
                                            <td>{{ $order->shippingAddress->comment }}</td>
                                        </tr>
                                        @if($order->shippingAddress->custom_fields_shipping)
                                            <?php
                                            $custom_fields = json_decode($order->shippingAddress->custom_fields_shipping, true);
                                            ?>

                                            @if($custom_fields)
                                                @foreach($custom_fields as $kF=>$vF)
                                                    <tr>
                                                        <td>{{ ucfirst(str_replace("_", " ", $kF)) }}</td>
                                                        <td>{{ $vF }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endif
                                    </table>

                                    <textarea class="form-control opacity-0" rows="1" readonly id="copy-input-1">{{ $order->shippingAddress->name }}&#13;&#10;{{ $order->shippingAddress->address1 }} @if($order->shippingAddress->number_street) {{ $order->shippingAddress->number_street }} @endif &#13;&#10;{{ $order->shippingAddress->city }}  @if($order->shippingAddress->county) ({{ $order->shippingAddress->county }}) @endif {{ $order->shippingAddress->postal_code }} &#13;&#10;{{ $order->shippingAddress->phone }} {{ $order->shippingAddress->mobile_phone }}</textarea>
                                    <button data-clipboard-target="#copy-input-1" class="btn btn-block btn-sm btn-primary btn-clipboard"><i class="fa fa-copy"></i> Copia indirizzo</button>

                                </div>
                                <div class="col-md-6">
                                    @if ($order->billingCompanyInfo)
                                        <h5>Indirizzo di fatturazione</h5>
                                        <table class="table table-sm table-striped">
                                            <tr>
                                                <td>Ragione sociale</td>
                                                <td>{{ $order->billingCompanyInfo->business_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Indirizzo</td>
                                                <td>
                                                    {{ $order->billingCompanyInfo->address1 }}
                                                    @if($order->billingCompanyInfo->number_street)
                                                        {{ $order->billingCompanyInfo->number_street }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nazione</td>
                                                <td>
                                                    @if($order->billingCompanyInfo->country)
                                                        {{ $order->billingCompanyInfo->country->name }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Città</td>
                                                <td>{{ $order->billingCompanyInfo->city }}
                                                    @if($order->billingCompanyInfo->county)
                                                        ({{ $order->billingCompanyInfo->county }})
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Partita iva</td>
                                                <td>{{ $order->billingCompanyInfo->fiscal_code_vat }}</td>
                                            </tr>
                                            <tr>
                                                <td>Codice Fiscale</td>
                                                <td>{{ $order->billingCompanyInfo->fiscal_code }}</td>
                                            </tr>
                                            <tr>
                                                <td>Cellulare</td>
                                                <td>{{ $order->billingCompanyInfo->mobile }}</td>
                                            </tr>
                                            <tr>
                                                <td>PEC</td>
                                                <td>{{ $order->billingCompanyInfo->pec }}</td>
                                            </tr>
                                            <tr>
                                                <td>Codice SDI</td>
                                                <td>{{ $order->billingCompanyInfo->sdi }}</td>
                                            </tr>

                                            @if($order->billingCompanyInfo->custom_fields_checkout)
                                                <?php
                                                $custom_fields = json_decode($order->billingCompanyInfo->custom_fields_checkout, true);
                                                ?>

                                                @if($custom_fields)
                                                    @foreach($custom_fields as $kF=>$vF)
                                                        <tr>
                                                            <td>{{ ucfirst(str_replace("_", " ", $kF)) }}</td>
                                                            <td>{{ $vF }}</td>
                                                        </tr>
                                                  @endforeach
                                                @endif
                                            @endif
                                        </table>

                                        <textarea class="form-control opacity-0" rows="1" readonly id="copy-input-2">{{ $order->billingCompanyInfo->business_name }} {{ $order->billingCompanyInfo->address1 }} @if($order->billingCompanyInfo->number_street) {{ $order->billingCompanyInfo->number_street }} @endif  @if($order->billingCompanyInfo->country) {{ $order->billingCompanyInfo->country->name }} @endif {{ $order->billingCompanyInfo->city }}  @if($order->billingCompanyInfo->county) ({{ $order->billingCompanyInfo->county }}) @endif {{ $order->billingCompanyInfo->fiscal_code_vat }} {{ $order->billingCompanyInfo->mobile }} {{ $order->billingCompanyInfo->pec }} {{ $order->billingCompanyInfo->sdi }}</textarea>
                                        <button data-clipboard-target="#copy-input-2" class="btn btn-block btn-sm btn-primary btn-clipboard"><i class="fa fa-copy"></i> Copia indirizzo</button>
                                    @endif



                                    @if ($order->billingAddress)
                                        <h4>{{ trans('order.billing_address') }}</h4>
                                        <table class="table table-condensed table-hover">
                                            <tr>
                                                <td>{{ trans('address.contact_person') }}</td>
                                                <td>{{ $order->billingAddress->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('address.address') }}</td>
                                                <td>
                                                    {{ $order->billingAddress->address1 }}
                                                    @if($order->billingAddress->number_street)
                                                        {{ $order->billingAddress->number_street }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nazione</td>
                                                <td>
                                                    @if($order->billingAddress->country)
                                                        {{ $order->billingAddress->country->name }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('address.city') }}</td>
                                                <td>{{ $order->billingAddress->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('address.postal_code') }}</td>
                                                <td>{{ $order->billingAddress->postal_code }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('address.phone') }}</td>
                                                <td>{{ $order->billingAddress->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('address.mobile_phone') }}</td>
                                                <td>{{ $order->billingAddress->mobile_phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('address.comment') }}</td>
                                                <td>{{ $order->billingAddress->comment }}</td>
                                            </tr>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-history-info">
                            @if(count($history) > 0)
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Data ordine</th>
                                        <th>Status</th>
                                        <th>Totale</th>
                                        <th>Spedizione</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($history as $his)
                                        <tr>
                                            <td><a href="/admin/orders/{{ $his->id }}">{{ $his->id }}</a></td>
                                            <td>
                                                @if($his->created_at)
                                                    {{ $his->created_at }}
                                                @endif
                                            </td>
                                            <td><span class="label label-{{ $his->class }}">{{ $his->name }}</span></td>
                                            <td>{{ $his->total_tax }}</td>
                                            <td>{{ $his->total_shipping_tax }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-info my-0">Nessun altro ordine precedente</div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="card">
                <div class="card-header"><h4 class="my-0">Spedizione</h4></div>
                @if($order->shipping)
                    <table class="table my-0">
                        <thead>
                        <tr>
                            <th>Spedizione</th>
                            <th>Prezzo</th>
                            <th>Descrizione</th>
                        </tr>
                        </thead>
                        <tr>
                            <td class="vertical-align-middle">{{ $order->shipping->name }}</td>
                            <td class="vertical-align-middle">{{ $order->total_shipping_tax.' '.$order->currency->name }}</td>
                            <td class="vertical-align-middle">{{ $order->shipping->delay_description }}</td>
                        </tr>
                    </table>
                @endif
            </div>

            <div class="card">
                <div class="card-header"><h4 class="my-0">Metodo di pagamento</h4></div>

                <div class="box-body">
                     @if($payment)
                        <table class="table my-0">
                            <tbody>
                            <tr>
                                <th class="py-1">Metodo</th>
                                <td class="py-1"><strong>{{ $payment->name }}</strong></td>
                            </tr>
                            @if($order->payment_date)
                            <tr>
                                <th class="py-1">Data pagamento:</th>
                                <td class="py-1">
                                    {{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s" ,$order->payment_date)->format("d/m/Y") }}
                                </td>
                            </tr>
                            @endif
                                @if($order->paypal_payment_id)
                                    <tr>
                                        <th class="py-1">#IDPAYPAL:</th>
                                        <td class="py-1">{{ $order->paypal_payment_id }}</td>
                                    </tr>
                                @endif

                            @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                                @if($order->status_id == 5)
                                    <tr>
                                        <th class="py-1">Link da copiare al cliente:</th>
                                        <td class="py-1"><a href="{{ route('index') }}/order_result?order_id={{ $order->id }}">{{ route('index') }}/order_result?order_id={{ $order->id }}</a></td>
                                    </tr>
                                @endif
                            @endif
                            </tbody>
                        </table>
                     @endif

                         @if($order->code_referral or $order->code_coupon)
                             <table class="table my-0">
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
                </div>
            </div>

            @if(trim($order->comment) != "")
                <div class="card">
                    <div class="card-header"><h4 class="my-0">Note</h4></div>
                    <div class="card-body">{{ $order->comment }}</div>
                </div>
            @endif

            <div class="card">
                <div class="card-header"><h4 class="my-0">Prodotti</h4></div>
                <table class="table table-striped table-striped my-0">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Prodotto</th>
                        <th>Prezzo</th>
                        <!--<th>Prezzo con iva</th>-->
                        <th>Quantità</th>
                        <th class="text-right">Totale</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $subTotal = 0;
                        $total = 0;

                        $order_products = \App\Models\OrderProduct::where("order_id", $order->id)->get();

                    @endphp
                    @foreach($order_products as $op)
                        <?php
                        $product = \App\Models\PluginProducts::withTrashed()->where("id", $op->product_id)->first();

                        $cover = $product->getCover();
                        $extra_list = \App\Models\ShopOrderProductExtra::where("shop_order_id", $order->id)->where("shop_product_id", $product->id)
                            ->get()->pluck("value", "extra_id")->toArray();
                        ?>
                        <tr>
                            <td>
                                @if($product->is_variant == 1)
                                    <?php
                                    $padre = \App\Models\PluginProducts::where("group_id", $product->group_id)->where("is_variant", 0)->first();
                                    if($padre && $product->include_photo_padre == 1){
                                        $coverPadre = $padre->getCover();
                                        echo "<img width='35' class='card' src='$coverPadre'>";
                                    }
                                    ?>
                                    <img width="35" src="{{ $cover }}" alt="{{ $product->name }}">
                                @else
                                    <img width="35" src="{{ $cover }}" alt="{{ $product->name }}">
                                @endif
                            </td>
                            <td>
                                {{ $op->name }}<br/>
                                <span class="font-12">SKU: {{ $op->sku }}</span>

                                @if($op->custom_label_1 !== null && trim($op->custom_label_1) != "")
                                    <br><label class="badge badge-primary">{{ $op->custom_label_1 }}</label>
                                @endif
                                @if($op->custom_label_2 !== null && trim($op->custom_label_2) != "")
                                    <br><label class="badge badge-primary">{{ $op->custom_label_2 }}</label>
                                @endif

                                @if($extra_list)
                                    <br>
                                    @foreach($extra_list as $extra_id => $value)
                                        <?php
                                        $extra = \App\Models\ShopExtra::find($extra_id);
                                        ?>
                                        {{ $extra->name }}<br>
                                        <small>{{ $value }}</small>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                    {{ number_format($op->price_with_tax,3, ',','.') }}
                            </td>
                            <td>{{ $op->quantity }}</td>
                            <td class="text-right">
                                    {{ number_format($op->price_with_tax * $op->quantity,2, ',','.').' '.$order->currency->name }}
                            </td>
                        </tr>
                        @php
                            $subTotal = $subTotal + $op->quantity * $op->price;
                            $total = $total + $op->quantity * $op->price_with_tax;
                        @endphp
                    @endforeach
                    </tbody>


                    <tfoot>

                    @if(env('HIDE_TASSE') == 0)
                        <tr>
                            <th class="text-right" colspan="4">Imponibile:</th>
                            <td class="text-right">{{ number_format(round($subTotal, 2),2, ',','.') }} {{ $order->currency->name }}</td>
                        </tr>

                        <tr>
                            <th class="text-right" colspan="4">Spese di spedizione @if($userOrder->type_client == 1) (iva escl.) @endif:</th>
                            <td class="text-right">
                                @if($userOrder->type_client == 1)
                                    {{ $order->total_shipping.' '.$order->currency->name }}
                                @else
                                    {{ $order->total_shipping_tax.' '.$order->currency->name }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="text-right" colspan="4">IVA:</th>
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
                            <th class="text-right" colspan="4">Sconto Coupon:</th>
                            <td class="text-right">
                                <strong>- {{ (number_format($order->total_coupon,2, ",", ".")).' '.$order->currency->name }}</strong>
                            </td>
                        </tr>

                        @if(property_exists($order, "extra"))
                            <?php
                            if($order->extra){
                            foreach ($order->extra as $extra){
                            ?>
                            <tr>
                                <th class="text-right" colspan="4">{{ $extra->name }}:</th>
                                <td class="text-right">{{ number_format($extra->pivot->price,2, ".", ",") }} {{ $order->currency->name }}</td>
                            </tr>
                            <?php }
                            } ?>
                        @endif
                        <tr>
                            <th class="text-right" colspan="4">Totale:</th>
                            <td class="text-right"><strong>{{ ($order->total_tax - $order->total_coupon) + $order->total_extra + $order->total_shipping_tax.' '.$order->currency->name }}</strong></td>
                        </tr>

                        @if($order->total_giftcard > 0)
                            <tr>
                                <th class="text-right" colspan="4"><strong>Totale da pagare:</strong><br>({{ $order->number_giftcard }})</th>
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
                                <th class="text-right" colspan="4">{{ $extra->name }}:</th>
                                <td class="text-right">{{ number_format($extra->pivot->price,2, ".", ",") }}</td>
                            </tr>
                            <?php
                            }
                            } ?>
                        @endif
                        <tr>
                            <th class="text-right" colspan="4">Totale:</th>
                            <td class="text-right"><strong>{{ number_format($order->total_tax + $order->total_shipping_tax + $order->total_extra, 2,",",".").' '.$order->currency->name }}</strong></td>
                        </tr>

                        @if($order->total_giftcard > 0)
                            <tr>
                                <th class="text-right" colspan="4"><strong>Totale con Gift Card:</strong><br>({{ $order->number_giftcard }})</th>
                                <td class="text-right"><strong>{{ $order->total_tax + $order->total_shipping_tax + $order->total_extra - $order->total_giftcard.' '.$order->currency->name }}</strong></td>
                            </tr>
                        @endif
                    @endif
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Cliente</div>
                <table class="table my-0">
                    <tbody>
                    <tr>
                        <th class="py-1">Cliente</th>
                        <td class="py-1">{{ $userOrder->name }}</td>
                    </tr>
                    <tr>
                        <th class="py-1">Mail</th>
                        <td class="py-1"><a href="mailto:{{ $userOrder->email }}">{{ $userOrder->email }}</a></td>
                    </tr>
                    <tr>
                        <th class="py-1">Telefono</th>
                        <td class="py-1">{{ $userOrder->mobile }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="card">
                    <div class="card-header">Status Ordine</div>
                    <table class="table my-0">
                        <tbody>
                        <tr>
                            <th>Stato ordine</th>
                            <td><span class="badge badge-default">{{ $order->status->name }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <a href="/admin/shopOrders/printPDF/{{ $order->id }}" class="btn btn-primary btn-sm" target="_blank">Stampa PDF</a>
                            </td>
                            <td>
                                <a href="/admin/shopOrders/printPDF/{{ $order->id }}?no-price" class="btn btn-primary btn-sm" target="_blank">Stampa No Prezzi</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                <div class="card">
                    <div class="card-header">Cronologia Status</div>
                    <div class="card-body">
                        @if (count($order->statusHistory) > 0)
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Stato</th>
                                    <th>Data modifica</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->statusHistory as $statusHistory)
                                    <tr>
                                        <td>{{ $statusHistory->status->name }}</td>
                                        <td>{{ $statusHistory->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger py-1">Nessuna cronologia</div>
                        @endif

                        @if (count($orderStatuses) > 0)
                            <form action="{{ route('updateOrderStatus') }}" method="POST">
                                {!! csrf_field() !!}
                                <input type="hidden" name="order_id" value="{{ $order->id }}">

                                <div class="form-group">
                                    <select name="status_id" id="status_id" class="custom-select" required>
                                        <option value=""></option>
                                        @foreach($orderStatuses as $orderStatus)
                                            <option value="{{ $orderStatus->id }}">{{ $orderStatus->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                   <input type="checkbox" name="notify" value="1" checked> Inviare notifica al Cliente via E-Mail, per il Cambio stato ordine?
                                </div>

                                <button type="submit" class="btn btn-block btn-primary">Modifica</button>
                            </form>
                        @else
                            <div class="alert alert-info py-1">
                                {{ trans('order.no_order_statuses') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Modifica metodo di pagamento</div>
                    <div class="card-body">
                        <form action="{{ route('updateOrderPayment') }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="order_id" value="{{ $order->id }}">

                            <div class="form-group">
                                <select name="payment_id" id="payment_id" class="custom-select">
                                    @foreach($payments as $itemPayment)
                                        @if($payment)
                                            @if($payment->id == $itemPayment->id)
                                                <option value="{{ $itemPayment->id }}" selected>{{ $itemPayment->name }}</option>
                                            @else
                                                <option value="{{ $itemPayment->id }}">{{ $itemPayment->name }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $itemPayment->id }}">{{ $itemPayment->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-block btn-primary">Modifica</button>
                        </form>
                    </div>
                </div>
            @endif
            <!--<div class="card">
                <div class="card-header">Messaggi</div>
                <div class="card-body">
                    @if(count($messages))
                        @foreach($messages as $message)
                            <div class="list-group">
                                <div class="list-group-item">
                                    <h5>{!! $message->content !!} </h5>
                                    <span><em>{{ $message->created_at }}</em></span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-danger my-0 py-1">Nessun messaggio</div>
                    @endif
                        {{--
                            <form method="post" action="{{ route('sendOrderMessage') }}">
                                {{ csrf_field() }}
                                <div class="hidden">
                                    <input type="hidden" name="from" value="{{ backpack_user()->id }}" class="form-control">
                                    <input type="hidden" name="to" value="{{ $order->user_id }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Template Messaggio</label>
                                    <select name="template" id="message_template_id" class="custom-select">
                                        <option value="">Template vuoto</option>
                                        @if($templates)
                                            @foreach($templates as $template)
                                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <input type="hidden" name="name" value="" id="message_name"
                                       class="form-control">
                                <div class="form-group">
                                    <label>Contenuto</label>
                                    <textarea name="content" id="message_content" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Invia comunicazione</button>
                            </form>
                        --}}
                </div>
            </div>-->

        </div>
    </div>
@endsection


@section('after_styles')
    <!-- DATA TABLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/list.css') }}">

    <!-- CRUD LIST CONTENT - crud_list_styles stack -->
    @stack('crud_list_styles')
@endsection

@section('after_scripts')
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
    <script>
        $( document ).ready(function() {
            new ClipboardJS('.btn-clipboard');
        });
    </script>
@endsection

