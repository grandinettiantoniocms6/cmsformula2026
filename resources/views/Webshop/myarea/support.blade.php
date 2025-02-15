<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();  ?>

<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h3>{{ @$labels['shop-myarea-assistenza'] }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="bi bi-chevron-left d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['shop-myarea-assistenza'] }}</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-4">
    <div class="container">

        <div class="row">
            <aside class="col-12 col-xl-3">
                @include("$thema.inc.myarea_menu")
            </aside>
            <div class="col-12 col-xl-9">
                <div class="card card-myarea">
                    <div class="card-header">
                        <h5>{{ @$labels['shop-myarea-info-ordine-1'] }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row gx-2">
                            <div class="col-sm my-1">
                                <a class="btn btn-primary btn-lg w-100" href="mailto:{{ env('SHOP_SUPPORT_EMAIL') }}">
                                    <span class="d-block"><i class="bi bi-envelope fa-lg"></i></span>
                                    <span class="d-block">{{ @$labels['shop-myarea-scrivici'] }}</span>
                                </a>
                            </div>
                            <div class="col-sm my-1">
                                <a class="btn btn-secondary btn-lg w-100" href="tel:{{ env('SHOP_SUPPORT_TEL') }}">
                                    <span class="d-block"><i class="bi bi-telephone fa-lg"></i></span>
                                    <span class="d-block">{{ @$labels['shop-myarea-chiamaci'] }} {{ env('SHOP_SUPPORT_TEL') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @if(count($orders))
                    <form class="form" method="post" action="{{ route('myarea.message_save') }}">
                        {{ csrf_field() }}

                        <div class="card card-myarea">
                            <div class="card-header">
                                @if(count($orders))
                                    <h5>{{ @$labels['shop-myarea-supporto-ordine'] }}</h5>
                                @else
                                    <h5>{{ @$labels['shop-myarea-compila-modulo-assistenza'] }}</h5>
                                @endif
                            </div>
                            <div class="card-body">
                                @if(session()->has('message'))
                                    <div class="alert alert-info text-center">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif

                                @if(count($orders))
                                    <div class="form-group">
                                        <label class="form-label font-sm">{{ @$labels['shop-myarea-numero-ordine'] }}</label>
                                        <select name="order_id" id="order_id" class="form-select">
                                            <option value=""></option>
                                            @foreach ($orders as $order)
                                                <option value="{{ $order->id }}">{{ @$labels['shop-myarea-ordine-num'] }}# {{ $order->id }} {{ @$labels['shop-myarea-del'] }} {{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $order->created_at)->format("d/m/Y H:i") }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">{{ @$labels['shop-myarea-supporto-ordine-2'] }}</small>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label font-sm">{{ @$labels['shop-myarea-oggetto-richiesta'] }}</label>
                                        <select name="name_support" id="name" class="form-select">
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
                                    <label class="form-label font-sm">{{ @$labels['shop-myarea-supporto-messaggio'] }}</label>
                                    <textarea class="form-control" name="content_support" id="content" rows="5"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row gx-2 justify-content-end">
                            <div class="col"></div>
                            <div class="col-sm-auto my-1">
                                <button type="submit" class="btn btn-primary w-100">{{ @$labels['shop-myarea-supporto-invia-richiesta'] }}</button>
                            </div>
                        </div>

                    </form>
                @endif
            </div>
        </div>

    </div>
</section>
