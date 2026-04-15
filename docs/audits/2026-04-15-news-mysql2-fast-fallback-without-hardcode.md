# Audit News mysql_2: fallback veloce senza hardcode locale (2026-04-15)

## Contesto
- Con hardcode locale disattivato, la Bacheca poteva restare in loading ~20s quando `mysql_2` non era raggiungibile.
- Obiettivo: evitare blocchi prestazionali senza tornare a una condizione legata ad `APP_URL`.

## Causa radice
- Le query news in topbar e l'endpoint `mark_news_seen` tentavano direttamente la connessione a `mysql_2`.
- In caso di host non raggiungibile, il timeout di connessione MySQL introduceva rallentamenti visibili.

## Soluzione applicata
- Aggiunto controllo di reachability rapido con `fsockopen(host, port, timeout)` prima delle query news.
- Introdotta cache applicativa della reachability (`admin_news_mysql2_reachable`):
  - successo: cache 60 secondi,
  - fallimento: cache 180 secondi.
- Se il DB news non è raggiungibile:
  - topbar mostra lista vuota/badge a 0 senza bloccare la pagina,
  - `mark_news_seen` risponde subito con `ok=true, unread=0`.
- Variabile ambiente opzionale:
  - `ADMIN_NEWS_DB_PROBE_TIMEOUT` (default `0.35` secondi).

## File coinvolti
- `resources/views/vendor/backpack/base/inc/topbar_right_content.blade.php`
- `resources/views/vendor/backpack/theme-coreuiv2/inc/topbar_right_content.blade.php`
- `app/Http/Controllers/Admin/DashboardController.php`

## Rischio/Impatto
- Basso: modifica locale alla feature news admin.
- Vantaggio: eliminazione freeze da connessione remota assente, mantenendo compatibilità multi-ambiente senza hardcode su URL.
