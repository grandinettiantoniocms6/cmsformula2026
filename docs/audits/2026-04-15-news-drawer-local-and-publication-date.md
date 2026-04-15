# Audit News Drawer: supporto locale e data pubblicazione (2026-04-15)

## Contesto
- Dopo introduzione campanella + drawer news in topbar admin, sono emerse tre esigenze:
  - consultare sempre anche le news vecchie (non solo le nuove),
  - visualizzare le news anche in ambiente locale,
  - mostrare in elenco la data di pubblicazione.

## Causa radice
- Era presente un gate hardcoded su `APP_URL == http://cmsformula2025.test` che disattivava la lettura news lato topbar e l'endpoint `mark-seen`.
- Questo impediva qualsiasi rendering news in locale, anche quando la connessione `mysql_2` era disponibile.

## Soluzione applicata
- Rimosso il blocco condizionale su `APP_URL`:
  - `resources/views/vendor/backpack/base/inc/topbar_right_content.blade.php`
  - `resources/views/vendor/backpack/theme-coreuiv2/inc/topbar_right_content.blade.php`
  - `app/Http/Controllers/Admin/DashboardController.php`
- Confermato comportamento drawer:
  - la campanella resta cliccabile anche con unread = 0,
  - il badge rosso resta visibile solo quando `unread > 0`.
- Aggiunta visualizzazione esplicita data pubblicazione in lista news con fallback campi:
  - `published_at` -> `publication_date` -> `data_pubblicazione` -> `created_at`.

## Rischio/Impatto
- Basso: modifica puntuale su vista topbar e endpoint di stato lettura.
- In locale, se `mysql_2` non è raggiungibile, resta fallback sicuro (`try/catch`) con lista vuota e nessun errore bloccante UI.
