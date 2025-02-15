<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
<main>
    <section class="py-4">
        <div class="container">
            <div class="card my-3">
                <div class="card-body">
                    <div class="alert alert-danger text-center">
                        <div class="display-4"><i class="fas fa-exclamation-triangle"></i></div>
                        <h4>{{ @$labels['shop-errore-facebook'] }}</h4>
                    </div>
                    <h5 class="text-center"><a href="{{ route('login') }}">{{ @$labels['shop-login'] }}</a> o <a href="{{ route('register') }}">{{ @$labels['shop-registrati'] }}</a> {{ @$labels['shop-tramite-form'] }}</h5>
                </div>
            </div>
        </div>
    </section>
</main>
