# Audit import prodotti: coda e monitor esecuzioni (2026-05-25)

## Contesto
- Un import SPECIAL di circa 5000 righe rimaneva agganciato alla richiesta HTTP per tutta l'elaborazione.
- L'utente non poteva lasciare la pagina con tranquillita' ne' verificare stato e avanzamento delle esecuzioni precedenti.

## Causa individuata
- `PluginProductImportCrudController::importSpecialMapping()` svolgeva parsing e salvataggio prodotti interamente in richiesta sincrona.
- La pagina mostrava il progresso dell'upload/elaborazione corrente, ma non aveva uno storico persistente delle esecuzioni.

## Implementazione
- Aggiunta tabella `plugin_product_import_runs` per file, configurazione, utente, stato, avanzamento, errore e timestamp.
- Creato il job `ProcessPluginProductImport`, inviato alla connessione `database_imports` e coda `imports`.
- Per import con configurazione esistente, l'endpoint salva il file, crea una run e risponde subito con conferma di accodamento.
- Il processo in background riutilizza la logica import esistente e aggiorna il progresso ogni 25 righe.
- Il CSV viene letto dal file specifico della run, evitando collisioni sul precedente file pubblico fisso.
- Aggiunto endpoint stato e pannello nella pagina Import SPECIAL con polling, badge di stato e progress bar.
- Gli ID prodotti importati continuano a essere conservati per l'aggiornamento incrementale post-import.
- Aggiunta la tabella `plugin_product_import_run_steps`: ogni run espone le fasi `Import file prodotti`, `Aggiorna indice prodotti` e `Aggiorna indice categorie` con stato e avanzamento.
- Alla conclusione della fase import il worker esegue automaticamente `set:products_search` limitato agli ID importati e poi `set:products_categories_search`; la UI non richiede piu' il lancio manuale.
- Un nuovo import viene impedito quando ne esiste gia' uno attivo, sia lato controller sia lato interfaccia, per evitare scritture concorrenti sul catalogo.
- Il file temporaneo di una run completata viene eliminato dallo storage; i file delle run fallite restano disponibili per diagnosi e richiedono pulizia periodica.
- Memorizzato l'id del job database sulla run: un import ancora in coda puo' essere annullato rimuovendo il job prima dell'esecuzione.
- Per una run gia' in lavorazione l'annullamento e' cooperativo: passa a `Annullamento richiesto` e il job si ferma al checkpoint successivo, senza rollback delle righe gia' salvate.
- Il monitor consente l'eliminazione dallo storico delle sole run concluse, fallite o annullate.
- L'avvio del job aggiorna lo stato da `queued` a `processing` in modo condizionale, cosi' una cancellazione concorrente non puo' essere sovrascritta dal worker.

## Requisiti operativi
- Eseguire le migration per creare `plugin_product_import_runs`, `plugin_product_import_run_steps` e assicurare la presenza di `jobs`.
- Avviare un worker per la coda dedicata: `php artisan queue:work database_imports --queue=imports --timeout=7200`.
- In produzione gestire il worker con Supervisor/Ploi e riavviarlo dopo il deploy.

## Verifiche
- Eseguito lint PHP 8.2 su controller, model run, job, migration, configurazione queue, routes e view Blade: nessun errore di sintassi.
- Verificata la route `pluginProducts.importSpecialRuns` con `php artisan route:list`.
- Applicata localmente la migration `2026_05_25_120000_create_plugin_product_import_runs_table`.
- Applicata localmente la migration `2026_05_25_130000_add_queue_job_id_to_plugin_product_import_runs_table` e verificate le route di annullamento/eliminazione run.
- Applicata localmente la migration `2026_05_25_140000_create_plugin_product_import_run_steps_table`; l'indice usa un nome esplicito breve compatibile con il limite MySQL sugli identificatori.
- Verificati lint PHP del job, controller, model run/step, migration e view Blade dopo l'introduzione delle fasi automatiche.
- La verifica visuale della pagina locale si arresta al login admin, non essendo stata utilizzata una sessione autenticata.

## Rischi e controlli
- Senza worker attivo le esecuzioni rimangono nello stato `In coda` e non vengono processate.
- Il `retry_after` della connessione import e' impostato a 7500 secondi, superiore al timeout worker/job di 7200 secondi, per evitare che import lunghi vengano avviati due volte.
- Testare un file piccolo e uno voluminoso, verificando transizioni `In coda` -> `In lavorazione` -> `Completata` e il conteggio righe.
- Testare `Annulla` sia su una run ancora in coda sia durante l'elaborazione; nel secondo caso verificare lo stato finale `Annullata` e considerare che i record gia' elaborati restano nel catalogo.
- L'annullamento e' cooperativo anche tra le fasi: un comando Artisan di indicizzazione gia' avviato termina prima che il worker possa arrestare la fase successiva.
