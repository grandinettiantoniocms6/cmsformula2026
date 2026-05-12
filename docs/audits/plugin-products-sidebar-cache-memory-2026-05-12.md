# Audit memoria sidebar prodotti (2026-05-12)

## Contesto
- Su `https://stage.plcshop.it/products` si verificava errore 500 intermittente:
  `Allowed memory size of 629145600 bytes exhausted`.
- Il punto di errore era `vendor/laravel/framework/src/Illuminate/Cache/FileStore.php:84`, coerente con lettura/scrittura di cache file molto grandi.

## Causa individuata
- `PluginProductsController` costruiva la sidebar prodotti tramite `Cache::remember()`.
- La chiave della cache includeva tutti gli ID dei prodotti filtrati e obbligava comunque a costruire `$products_processed` prima del cache hit.
- Il payload della sidebar deriva da una collection potenzialmente molto grande; con cache driver `file` questo aumenta rischio di file cache pesanti, I/O elevato e memory exhaustion.

## Implementazione
- Rimossa la `Cache::remember()` della sidebar prodotti.
- Rimossa la funzione `buildSidebarCacheKey()`, non piu usata.
- La sidebar viene ora calcolata nella richiesta corrente tramite `get_all_products_sidebar($products_processed, $plugin)` senza serializzare il risultato su disco.

## Verifiche
- Da eseguire dopo deploy: `php artisan cache:clear` per rimuovere i file cache gia generati.
- Verificare `/products` e filtri AJAX con catalogo reale.

## Rischi e controlli
- Rischio funzionale basso: i dati usati dalla view restano `tags`, `brands_ids`, `attributes_v` e `prices`.
- Rischio performance residuo: il metodo `get_all_products_sidebar()` contiene ancora query in loop e accessi a relazioni (`ShopAttributesOptions::find()`, brand/promozioni) che andrebbero ottimizzati in una fase successiva.
- La cache categorie e le cache piccole di impostazioni/menu restano attive perche non serializzano la collection filtrata dei prodotti.
