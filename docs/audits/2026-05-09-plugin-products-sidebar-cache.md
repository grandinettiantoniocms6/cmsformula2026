# Audit pluginProducts cache sidebar cataloghi grandi (2026-05-09)

## Contesto
- Nei siti con `pluginProducts` attivo e cataloghi oltre 20.000 prodotti si verificavano errori 500 intermittenti.
- La cache Laravel su file arrivava a dimensioni anomale, con file/payload molto grandi.

## Causa individuata
- `PluginProductsController::pluginProducts()` caricava tutti i prodotti filtrati in `$products_processed`.
- `get_all_products_sidebar()` restituiva anche `productsAll`, cioe' l'intera collection Eloquent dei prodotti usati per calcolare la sidebar.
- Il risultato veniva salvato con `Cache::remember()` nella chiave `plugin_products:sidebar:*`; con cache driver `file`, questo serializzava su disco model Eloquent completi e campi pesanti del catalogo.

## Implementazione
- Alleggerita la select di `$products_processed` ai soli campi necessari alla sidebar.
- Rimosso `productsAll` dal payload salvato in cache.
- Reso obbligatorio il parametro `$products_processed` in `get_all_products_sidebar()`, coerentemente con l'unica chiamata esistente.

## Verifiche
- `php -l app/Http/Controllers/PluginProductsController.php`

## Rischi e controlli
- Rischio basso: il payload `productsAll` non era letto dopo il recupero dalla cache.
- Verificare su dev listing prodotti, filtri AJAX, brand, tag, attributi e prezzi sidebar.
- Dopo deploy, svuotare la cache esistente con `php artisan cache:clear` per rimuovere i payload gia' generati.
