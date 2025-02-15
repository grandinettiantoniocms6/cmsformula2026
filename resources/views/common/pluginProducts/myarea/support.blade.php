<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>

<main>

    <section class="section-page-header bg-light py-4 border-bottom">
        <div class="container">
            <h2 class="h3">{{ @$labels['shop-myarea-assistenza'] }}</h2>
            <nav>
                <ol class="breadcrumb bg-transparent p-0 my-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-angle-left mr-2 d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                    <li class="breadcrumb-item active d-none d-md-block" aria-current="page">{{ @$labels['shop-myarea-assistenza'] }}</li>
                </ol>
            </nav>
        </div> <!-- container //  -->
    </section>

    <section class="py-4">
        <div class="container">

            <div class="row">
                <aside class="col-12 col-lg-3">
                    @include("common.pluginProducts.inc.myarea_menu")
                </aside> <!-- col.// -->
                <main class="col-12 col-lg-9 mt-4 mt-lg-0">

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="my-0">{{ @$labels['shop-myarea-info-ordine-1'] }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm my-1">
                                    <a class="btn btn-primary btn-block" href="mailto:{{ env('SHOP_SUPPORT_EMAIL') }}">
                                        <span class="d-block"><i class="far fa-envelope fa-lg"></i></span>
                                        <span class="d-block">{{ @$labels['shop-myarea-scrivici'] }}</span>
                                    </a>
                                </div>
                                <div class="col-sm my-1">
                                    <a class="btn btn-outline-primary btn-block" href="tel:{{ env('SHOP_SUPPORT_TEL') }}">
                                        <span class="d-block"><i class="fas fa-phone fa-lg"></i></span>
                                        <span class="d-block">{{ @$labels['shop-myarea-chiamaci'] }} {{ env('SHOP_SUPPORT_TEL') }}</span>
                                    </a>
                                </div>
                            </div>

                        </div> <!-- card-body .// -->
                    </div> <!-- card.// -->

                    @if(count($orders))
                    <div class="card mb-3">
                        <div class="card-header">
                            @if(count($orders))
                                <h5 class="my-0">{{ @$labels['shop-myarea-supporto-ordine'] }}</h5>
                            @else
                                <h5 class="my-0">{{ @$labels['shop-myarea-compila-modulo-assistenza'] }}</h5>
                            @endif
                        </div>
                        <div class="card-body">

                            @if(session()->has('message'))
                                <div class="alert alert-info text-center">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            <form class="form" method="post" action="{{ route('myarea.message_save') }}">
                                {{ csrf_field() }}

                                @if(count($orders))
                                    <div class="form-group">
                                        <label for="order_id">{{ @$labels['shop-myarea-numero-ordine'] }}</label>
                                        <select name="order_id" id="order_id" class="custom-select">
                                            <option value=""></option>
                                            @foreach ($orders as $order)
                                                <option value="{{ $order->id }}">{{ @$labels['shop-myarea-ordine-num'] }}# {{ $order->id }} {{ @$labels['shop-myarea-del'] }} {{ $order->created_at }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">{{ @$labels['shop-myarea-supporto-ordine-2'] }}</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">{{ @$labels['shop-myarea-oggetto-richiesta'] }}</label>
                                        <select name="name_support" id="name" class="custom-select">
                                            <option value="Modifica ordine">{{ @$labels['shop-myarea-supporto-modifica-ordine'] }}</option>
                                            <option value="Cancellazione ordine">{{ @$labels['shop-myarea-supporto-cancella-ordine'] }}</option>
                                            <option value="Spedizione ordine">{{ @$labels['shop-myarea-supporto-spedizione-ordine'] }}</option>
                                            <option value="Pagamento ordine">{{ @$labels['shop-myarea-supporto-pagamento-ordine'] }}</option>
                                            <option value="Altro">{{ @$labels['shop-myarea-supporto-altro'] }}</option>
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="name_support" value="Altro">
                                @endif

                                <div class="form-group">
                                    <label for="content">{{ @$labels['shop-myarea-supporto-messaggio'] }}</label>
                                    <textarea class="form-control" name="content_support" id="content"></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="ti-headphone-alt fa-lg"></i> {{ @$labels['shop-myarea-supporto-invia-richiesta'] }}</button>
                                </div>

                            </form>

                        </div>
                    </div>
                    @endif

                </main>
            </div>

        </div>
    </section>

</main>
