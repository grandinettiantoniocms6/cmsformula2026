# Audit queue database stage NANCY-BASTON-STAGE (2026-05-06)

## Contesto
- Su `stage.coachgenitorifiglinlinea.it` il worker Laravel falliva con `SQLSTATE[42S02]` per tabella `jobs` mancante.
- Lo stack trace parte da `Illuminate\Queue\DatabaseQueue->pop()`, quindi l'ambiente sta usando la queue database o un worker `queue:work` configurato sul driver database.

## Causa principale
- Il repository aveva la migration per `failed_jobs`, ma non la migration Laravel standard per la tabella `jobs`.
- Con `QUEUE_CONNECTION=database`, il worker non usa `failed_jobs` per leggere i job: interroga `jobs` con lock transazionale (`FOR UPDATE SKIP LOCKED`).

## Correzione applicata
- Aggiunta la migration `database/migrations/2026_05_06_120000_create_jobs_table.php` con schema standard Laravel:
  - `id`
  - `queue` indicizzato
  - `payload`
  - `attempts`
  - `reserved_at`
  - `available_at`
  - `created_at`

## Deploy richiesto su stage
- Eseguire `php artisan migrate` su `NANCY-BASTON-STAGE`.
- Riavviare il worker/supervisor queue dopo la migration (`php artisan queue:restart` o riavvio processo da Ploi/Supervisor).
- Se lo stage non deve processare job asincroni, alternativa operativa: impostare `QUEUE_CONNECTION=sync` e fermare il worker. Questa scelta va pero' allineata alla configurazione reale del sito.

## Rischi e controlli
- Basso rischio: la migration crea solo una tabella Laravel standard, senza toccare dati esistenti.
- Verificare dopo deploy che il worker non generi piu' eccezioni e che eventuali job pendenti vengano processati.
- Se ci sono piu' ambienti con `QUEUE_CONNECTION=database`, applicare la migration anche li.
