# Audit Rollout UI Create Blocchi Admin (2026-04-17)

## Contesto
- Dopo validazione positiva su `admin/blockImageLink/create`, era richiesto estendere il nuovo layout UI admin a tutti i CRUD blocchi in fase di creazione.

## Causa radice
- I controller `Block*CrudController` usavano ancora la view legacy `custom_create_multi`, con header/form styling non allineato al layout moderno admin.

## Soluzione applicata
- Creata view dedicata `resources/views/vendor/backpack/ui/custom_create_multi_enhanced.blade.php`:
  - mantiene logica multi-blocco (`block_id`, `block`, `page_id`) e save/cancel invariati;
  - applica il layout enhanced coerente con il nuovo UI admin.
- Aggiornati tutti i `Block*CrudController` che usavano `custom_create_multi`:
  - sostituito `setCreateView(backpack_view('custom_create_multi'))`
  - con `setCreateView(backpack_view('custom_create_multi_enhanced'))`.

## Rischio/Impatto
- Basso-medio: impatto UI su tutte le create dei blocchi, nessuna modifica al flusso di persistenza.
- Nessun impatto su query, permessi, policy o validazioni applicative.
- Verifica consigliata: smoke test create su 3-4 blocchi rappresentativi (con/senza upload, con campi lingua, con `multi`).
