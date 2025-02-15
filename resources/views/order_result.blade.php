<?php $thema = env('TEMA'); ?>
@extends("$thema.layout")

@section('head')
    @include("$thema.inc.head")
@endsection

@section('meta')
    @include("$thema.inc.meta")
@endsection

@if($website->is_online == 1 || backpack_user() || is_numeric(strpos(env('APP_URL'), "stage")))
    @section('topbar')
        @include("$thema.inc.topbar")
    @endsection

@section('topbar_ecommerce')
    @include("$thema.inc.topbar_ecommerce")
@endsection

    @section('header_menu')
        @include("$thema.inc.header_menu")
    @endsection

    @section('content_header')
        @if($page === null)
            <section class="page-title bg-overlay-black-60 parallax" data-jarallax='{"speed": 0.6}' style="background-image: url({{ url('img/header_vuota.jpg') }});">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-title-name">
                                  <h2 class="text-extra-dark-gray alt-font font-weight-500 letter-spacing-minus-1px line-height-50 sm-line-height-45 xs-line-height-30 no-margin-bottom">News</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
       @else
            @include("$thema.inc.content_header")
       @endif

    @endsection

    @section('content')
        @if(env('TEMA') == "Webshop")
            @include("$thema.plugins.pluginProducts.v3.order_result")
        @else
            @include("common.pluginProducts.order_result")
        @endif

        @include("$thema.inc.content")

        <script>
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            name: 'Ordine n.{{ $order->id }}',
                            description: '{{ env('PROJECT_NAME') }} ordine n.{{ $order->id }}',
                            amount:
                                {
                                    value:'{{ ($order->total_tax - $order->total_coupon - $order->total_giftcard) + $order->total_extra + $order->total_shipping_tax }}',
                                    breakdown:
                                        {
                                            'item_total':
                                                {
                                                    'currency_code':'EUR',
                                                    'value':'{{ ($order->total_tax - $order->total_coupon - $order->total_giftcard) + $order->total_extra }}'
                                                },
                                            'shipping':
                                                {
                                                    'currency_code':'EUR',
                                                    'value':'{{ $order->total_shipping_tax }}'
                                                }
                                        }
                                },
                        }]
                    });
                },
                /*onShippingChange: function(data,actions){
                    return actions.resolve();
                },*/
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(orderData) {
                        // Successful capture! For demo purposes:
                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                        var transaction = orderData.purchase_units[0].payments.captures[0];
                        console.log('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                        if(transaction.status == 'COMPLETED') {
                            var order_id = '{{ $order->id }}';
                            var token = '{{ csrf_token() }}';
                            $.ajax({
                                type: 'POST',
                                url: '/paypal-transaction-complete',
                                data: 'details='+JSON.stringify(orderData)+'&orderID='+transaction.id+'&order_id='+order_id+'&_token='+token,
                                success: function (msg) {
                                    window.location.href = '/order_result_paypal?order_id={{ $order->id }}';
                                },
                                error: function () {
                                    $('#error_payment').html('<div class="alert alert-danger">Errore pagamento! Contattaci tramite chat!</div>');
                                }
                            });
                        }else{
                            $('#error_payment').html('<div class="alert alert-danger">Errore pagamento! Contattaci tramite chat!</div>');
                        }
                        // Replace the above to show a success message within this page, e.g.
                        // const element = document.getElementById('paypal-button-container');
                        // element.innerHTML = '';
                        // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                        // Or go to another URL:  actions.redirect('thank_you.html');
                    });
                }
            }).render('#paypal-button-container');
        </script>
    @endsection

    @section('content_footer')
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif


