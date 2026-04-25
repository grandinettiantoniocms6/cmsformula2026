# Audit Website Setting Server Space Row Size Fix (2026-04-24)

## Contesto
- Aggiunto nuovo setting admin `Spazio server allocato` per la dashboard `future`.
- La migration iniziale tentava di aggiungere la colonna a `website_settings`.

## Errore riscontrato
- `SQLSTATE[42000] ... 1118 Row size too large` durante `php artisan migrate`.
- Anche con tipo `TEXT`, l'`ALTER TABLE website_settings` falliva sul database in uso.

## Causa radice
- `website_settings` e gia molto ampia; nuove alter possono superare i limiti fisici di InnoDB su quella installazione.
- Il progetto ha gia un pattern stabile con tabella esterna 1:1 (`website_setting_extras`) per campi aggiuntivi.

## Correzione applicata
- Migration `2026_04_24_191000...` convertita per aggiungere `server_allocated_space` in `website_setting_extras` (non in `website_settings`).
- Salvataggio in `WebsiteSettingCrudController@update` spostato su `website_setting_extras` con `updateOrInsert`.
- Lettura centralizzata in accessor model `WebsiteSetting::getServerAllocatedSpaceAttribute()` con fallback `500 MB`.

## Impatto
- `php artisan migrate` non tocca piu `website_settings` per questo campo.
- Il valore inserito in `/admin/websiteSetting` viene persistito correttamente.
- Dashboard `future` continua a leggere il setting nello stesso modo (`$websiteSetting->server_allocated_space`) tramite accessor.

## Rischi residui
- Se `website_setting_extras` non esiste in ambienti legacy, la migration lo crea e inizializza il campo; verificare permessi migration standard.
