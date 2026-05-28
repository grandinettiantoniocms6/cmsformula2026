# Audit import normale prodotti in coda (2026-05-28)

## Contesto
- La pagina admin `/admin/plugin/pluginProducts/import_export` aveva due flussi separati: import normale sincrono e import SPECIAL in coda.
- L'import normale eseguiva molte query ripetute durante il parsing CSV e chiamava `set:products_search` per ogni prodotto importato.

## Causa individuata
- Il flusso normale non usava la run persistita `plugin_product_import_runs` gia' introdotta per lo SPECIAL.
- L'indicizzazione prodotto veniva aggiornata riga per riga, moltiplicando il costo dei command Artisan.
- Lookup ripetuti su brand, tasse, SKU, categorie, attributi e thumb generavano query evitabili.

## Implementazione
- L'import normale viene accodato su `database_imports` con `ProcessPluginProductImport` e `plugin_product_import_id = null`.
- Aggiunta la colonna `plugin_product_import_runs.import_options` per conservare opzioni del form, come `edit_foto`.
- Il job distingue import SPECIAL e normale: SPECIAL continua a usare `PluginProductImportCrudController`, normale usa `PluginProductsCrudController::processQueuedNormalImport()`.
- Il flusso normale aggiorna avanzamento e ID importati nella run, poi il job esegue automaticamente `set:products_search --ids=...` e `set:products_categories_search`.
- Ridotte query ripetute con cache runtime per brand, tasse, prodotti per SKU, categorie, attributi/opzioni e configurazione thumb.
- La generazione delle righe `plugins_products_langs` mancanti usa batch per chunk invece di query per prodotto/lingua.
- La UI mostra/disabilita anche il pulsante dell'import normale quando una run e' attiva; se `IMPORT_SPECIAL` e' spento, lo storico run resta visibile anche per il normale.

## Verifiche
- Lint PHP sui controller, job, model e migration modificati: nessun errore di sintassi.
- `php artisan view:cache` con PHP 8.2 completato correttamente, poi `view:clear`.
- Eseguito `php artisan migrate` con PHP 8.2: applicata la nuova migration `2026_05_28_000000_add_import_options_to_plugin_product_import_runs_table`; risultavano pendenti anche `2026_05_26_120000_create_frontend_page_visits_by_page_daily_table` e `2026_05_27_220000_create_plugins_products_search_categories_table`, applicate nello stesso batch.

## Rischi e controlli
- Serve un worker attivo con connessione/coda corretta: `database_imports`, queue `imports`.
- L'import normale resta CSV con separatore `;`; non e' stato esteso a Excel.
- Verificare un import reale con e senza `edit_foto`, soprattutto su righe con allegati multilingua e varianti senza SKU.
