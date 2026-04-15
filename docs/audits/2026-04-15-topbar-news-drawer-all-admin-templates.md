# Audit Topbar News Drawer All Admin Templates (2026-04-15)

## Contesto
- Richiesta di spostare le news admin dalla posizione attuale in fondo dashboard a un pannello più visibile, aperto dalla campanella in topbar, con comportamento valido per `White`, `Modern01`, `Modern02`.

## Causa radice
- Il blocco news in fondo alla dashboard aveva bassa visibilità.
- La campanella introdotta prima mostrava solo un contatore senza un contenitore UX dedicato per lettura news.

## Soluzione applicata
- Rimosso il blocco news dalla dashboard:
  - `resources/views/vendor/backpack/ui/dashboard.blade.php`
- Aggiunto drawer news (slide da destra) agganciato alla campanella topbar:
  - `resources/views/vendor/backpack/theme-coreuiv2/inc/topbar_right_content.blade.php`
  - `resources/views/vendor/backpack/base/inc/topbar_right_content.blade.php`
  - elenco news (`mysql_2.news`) in formato card moderno, overlay, apertura/chiusura (click, overlay, ESC).
- Gestione stato “letto” al click campanella (non più su apertura dashboard):
  - nuovo endpoint `POST /admin/dashboard/news/mark-seen`
  - route in `routes/web.php` (`dashboard.news.mark_seen`)
  - metodo controller `DashboardController@mark_news_seen`
  - aggiornamento sessione `admin_news_last_seen_at_{user_id}` con timestamp ultima news.
- Badge rosso numerico mostrato solo se ci sono news non lette (`created_at > last_seen`), con cap `99+`.

## Rischio/Impatto
- Basso-medio: modifica UI topbar + chiamata AJAX + sessione utente admin.
- Nessun impatto su CRUD/permessi/query business applicative.
- In caso di indisponibilità connessione `mysql_2`, drawer vuoto e badge non mostrato (fallback sicuro tramite `try/catch`).
