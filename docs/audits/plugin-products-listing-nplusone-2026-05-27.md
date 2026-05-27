# Audit performance listing prodotti: N+1 sidebar e prezzi promo (2026-05-27)

## Contesto
- La pagina locale `http://cmsformula2025.test/prodotti/cappellini` impiegava circa 6,6 secondi al primo caricamento e circa 2,3 secondi con cache calda.
- Il controller coinvolto e' `PluginProductsController::pluginProducts()`.

## Causa individuata
- Dopo cache calda, Debugbar mostrava ancora 665 query, 1850 messaggi di warning e 3617 model retrieved.
- La costruzione della sidebar prodotti eseguiva centinaia di lookup singoli su `shop_attributes_options`.
- `PluginProducts::get_promo_price()` ripeteva per ogni prodotto query a `plugins_products_settings`, `admin_plugins` e il conteggio promozioni forzate.
- I tag null generavano warning ripetuti su `explode()`.

## Implementazione
- In `PluginProductsController::get_all_products_sidebar()` gli ID opzione vengono raccolti e risolti con una sola query `whereIn`.
- La risoluzione dei brand sidebar usa una query batch invece di `PluginProductsBrands::find()` in loop.
- Il parsing tag viene eseguito solo se `tags` e' valorizzato.
- In `PluginProducts::get_promo_price()` settings plugin, admin plugin e conteggio promozioni forzate sono memoizzati per la durata della richiesta.
- Aggiunta la tabella ponte indicizzata `plugins_products_search_categories` per interrogare categorie/lingue con `category_id` e `lang`, evitando `categories LIKE '%,id,%'` sulle query del listing quando la migration e' presente.
- `set:products_search` popola la nuova tabella sia in rebuild completo sia in aggiornamento incrementale, mantenendo i campi storici di `plugins_products_search` come compatibilita'.
- I conteggi della sidebar categorie usano la nuova tabella in batch quando disponibile, con fallback ai vecchi `count()` su `PluginProductsSearch`.

## Verifiche
- Eseguito lint PHP 8.2 su `PluginProductsController.php` e `PluginProducts.php`: nessun errore di sintassi.
- Dopo la modifica, Debugbar sulla pagina locale mostra 37 query, 4 messaggi, 3499 model retrieved, durata richiesta Laravel circa 1,2 secondi e query time circa 564ms.
- Misura HTTP locale dopo modifica: circa 1,5-1,7 secondi.
- Eseguita migration `2026_05_27_220000_create_plugins_products_search_categories_table`.
- Eseguito `set:products_search`: indicizzati 66894 prodotti e popolata la tabella ponte.
- Dopo pulizia cache Laravel, primo hit locale su `/prodotti/cappellini`: durata Laravel circa 1,5 secondi, 186 query, query time circa 458ms; seconda richiesta circa 739ms Laravel, 38 query, query time circa 168ms.

## Rischi e controlli
- Rischio funzionale basso: i dati sidebar restano derivati dalle stesse fonti, ma caricati in batch.
- Verificare una pagina con filtri attributi/brand/tag attivi e una pagina `luxury` Manega, perche' quel ramo usa ancora la relazione brand nel loop.
- La nuova tabella e' additiva: prima del deploy va eseguita la migration e poi `set:products_search` per popolarla; senza tabella il controller usa ancora il fallback storico.
- Rimane lavoro residuo sui filtri opzioni/tag/prezzi: la query `$products_processed` e' migliorata, ma carica ancora la collection necessaria alla sidebar.
