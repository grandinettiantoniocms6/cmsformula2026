# Audit Product Search Post-Import Incrementale (2026-04-20)

## Contesto
- Nel metodo `importSpecialPostImportActions` veniva chiamato sempre `set:products_search` con `id=0`, quindi rebuild completo della tabella `plugins_products_search` anche dopo import parziali.
- Su cataloghi ampi il tempo di risposta lato admin diventava elevato.

## Causa radice
- La ricostruzione era sempre full (`truncate` + reindicizzazione totale), senza riuso del contesto del passo precedente (`importSpecialMapping`).
- Nel command `SetProductsSearch` erano presenti query per-prodotto (N+1) su categorie, lingue e attributi.
- Logging per-prodotto e JSON `vet_ids` in console aumentavano overhead I/O.

## Soluzione applicata
- Esteso `set:products_search` con opzione `--ids` per aggiornamento incrementale:
  - se `--ids` presente: delete/rebuild solo dei prodotti indicati;
  - se assente e `id=0`: comportamento legacy full rebuild;
  - se `id>0`: comportamento legacy single product.
- Ottimizzato il command:
  - elaborazione in `chunkById(200)`;
  - preload per chunk di categorie, lingue e attributi;
  - insert batch su `plugins_products_search` invece di `create()` per singola riga;
  - rimozione logging rumoroso per singolo prodotto/JSON.
- In `PluginProductImportCrudController`:
  - al termine di `importSpecialMapping` vengono salvati (cache + session key) gli ID realmente importati/aggiornati;
  - `importSpecialPostImportActions` usa questi ID per chiamare `set:products_search --ids=...`;
  - fallback automatico al rebuild completo quando non sono disponibili ID recenti.

## Rischio/Impatto
- Basso/medio: stessa logica funzionale di indicizzazione, ma con percorso incrementale preferito.
- Compatibilità mantenuta per tutte le chiamate esistenti a `set:products_search {id}`.
- Rischio residuo: se l'import modifica indirettamente prodotti non inclusi negli ID raccolti, il percorso incrementale non li rigenera finché non viene eseguito un rebuild completo.
