# Audit avvisi errore SuperAdmin (2026-05-06)

## Contesto
- Gli avvisi email degli errori CMS Formula 6 erano configurati in `app/Exceptions/Handler.php` con destinatario hardcoded.
- Il SuperAdmin deve poter configurare destinatario, email in copia e intervallo di reinvio dello stesso errore dal tab "Avvisi errori" di `/admin/superadminsettings`.

## Implementazione
- Aggiunta pagina admin `SuperAdmin` sotto `Impostazioni`, visibile solo a `backpack_user()->id == 1`.
- La configurazione e' ora disponibile nel tab "Avvisi errori" di `/admin/superadminsettings`.
- I setting sono salvati in `website_setting_extras`:
  - `error_alert_enabled`
  - `error_alert_email`
  - `error_alert_cc`
  - `error_alert_repeat_hours`
- `Handler.php` legge i setting con fallback a invio abilitato, `info@webisland.it` e 4 ore.
- Il reinvio dello stesso errore e' limitato tramite cache Laravel, usando una chiave basata su messaggio, file e linea dell'eccezione.

## Deploy richiesto
- Eseguire `php artisan migrate` per aggiungere i nuovi campi in `website_setting_extras`.
- Dopo deploy, verificare che il cache driver dell'ambiente sia persistente tra richieste/processi se si vuole un throttling efficace.

## Rischi e controlli
- Rischio basso: le modifiche non toccano `website_settings`, ma aggiungono colonne alla tabella extra gia usata per setting admin estesi.
- Se `CACHE_DRIVER=array` o equivalente non persistente, lo stesso errore puo' continuare a inviare email a ogni richiesta.
- La chiave "stesso errore" include messaggio, file e linea: cambi di linea dopo deploy o cache view possono generare una nuova notifica.
