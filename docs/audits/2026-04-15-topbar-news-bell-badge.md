# Audit Topbar News Bell Badge (2026-04-15)

## Contesto
- Richiesta di aggiungere in topbar admin una campanella a sinistra di `Anteprima Sito`, con badge rosso numerico visibile solo in presenza di nuove news dashboard.

## Causa radice
- In topbar non esisteva alcun indicatore notifiche collegato alla sorgente news già mostrata in dashboard (`mysql_2.news`).

## Soluzione applicata
- Aggiornato `app/Http/Controllers/Admin/DashboardController.php`:
  - in `index()`, per utenti admin (`role_id < 5`), viene marcato come "letto" l'ultimo timestamp news in sessione utente (`admin_news_last_seen_at_{user_id}`) quando si entra in dashboard.
  - uso `try/catch` per non bloccare l'accesso admin se la connessione `mysql_2` non è disponibile.
- Aggiornate topbar dei due temi:
  - `resources/views/vendor/backpack/theme-coreuiv2/inc/topbar_right_content.blade.php`
  - `resources/views/vendor/backpack/base/inc/topbar_right_content.blade.php`
  - aggiunta icona campanella linkata a `admin/dashboard#accordion_news`;
  - calcolo conteggio news nuove come record `news` attivi/non cancellati con `created_at > admin_news_last_seen_at_{user_id}`;
  - badge rosso mostrato solo se conteggio > 0 (`99+` come cap).

## Rischio/Impatto
- Basso: modifica UI + sessione utente admin, senza impatti su CRUD, permessi o dati business.
- Se `mysql_2` è indisponibile, la campanella resta senza badge ma la topbar continua a funzionare.
