# Audit Dashboard "Attivita recenti" utente modifica (2026-04-25)

## Contesto
- In dashboard `future`, la sezione "Attivita recenti" doveva mostrare anche l'utente che ha apportato la modifica.
- In test reale (utente id `3` che modifica una pagina), il nome non compariva.

## Errore riscontrato
- Attribuzione utente non affidabile nelle attivita "Pagina aggiornata".

## Causa radice
- La logica usava `users_navigations`, che salva solo l'URL corrente per utente (stato runtime), non uno storico modifiche.
- Dopo il cambio pagina (es. ritorno in dashboard), l'informazione non rappresenta piu chi ha salvato davvero la pagina.

## Correzione applicata
- Aggiunta colonna persistente `pages.updated_by` tramite migration:
  - `database/migrations/2026_04_25_194500_add_updated_by_pages_table.php`
- Aggiornato `Page` model:
  - su `saving`, se autenticato in Backpack e colonna presente, imposta `updated_by = backpack_user()->id`.
- Estensione tracciamento anche ai blocchi pagina:
  - in `CheckIfAdmin` su richieste `PUT/PATCH` ai CRUD blocchi (`/admin/{blockType}/{id}`), se `blockType` appartiene ad `admin_blocks`, viene aggiornata la pagina collegata (`blocks_pages`) impostando `pages.updated_by` e `pages.updated_at`.
- Distinzione tipo modifica pagina/blocco:
  - aggiunte colonne `pages.updated_context` e `pages.updated_block_type`,
  - `Page::saving` imposta contesto `page`,
  - `CheckIfAdmin` su edit blocco imposta contesto `block` + `updated_block_type`.
- Aggiornata dashboard `future`:
  - le attivita pagine leggono l'attore da `pages.updated_by` (join su `users`),
  - esclusione esplicita del nome `SUPER ADMIN`,
  - stampa utente resa esplicita con formato `- da {nomeUtente}`,
  - quando il contesto e `block`, la voce diventa `Blocco aggiornato`,
  - per le attivita ordini non viene mostrato attore (dato non coerente con "modifica admin").

## Impatto
- Il nome utente nelle attivita recenti delle pagine riflette la modifica reale.
- Eliminata la dipendenza da un segnale volatile (`users_navigations`) per questa funzione.

## Rischi residui
- Le pagine modificate prima della migration restano senza `updated_by` valorizzato.
- Serve eseguire la migration in ambiente per attivare il tracciamento persistente.
- Alcuni CRUD blocco possono salvare in `POST` (con/ senza `_method`) e, nei blocchi multi, l'ID editato puo essere figlio (`block_id`) e non `obj_id`: il tracking middleware ora gestisce entrambi i casi.
