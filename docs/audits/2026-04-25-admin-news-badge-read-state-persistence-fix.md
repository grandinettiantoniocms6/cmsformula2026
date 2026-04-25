# Audit Admin News Badge Read-State Persistence Fix (2026-04-25)

## Contesto
- La campanellina news in topbar mostrava correttamente le news nuove durante la sessione corrente.
- Dopo logout/login, il badge tornava a mostrare news già lette.

## Errore riscontrato
- Badge "nuove news" non persistente tra sessioni utente.
- In casi reali l'admin rivedeva sempre lo stesso conteggio (es. `2`) anche dopo apertura del drawer news.

## Causa radice
- Lo stato "ultima lettura" veniva salvato solo in sessione:
  - `session('admin_news_last_seen_at_{userId}')`
- La sessione viene rigenerata/chiusa al logout, quindi l'informazione andava persa.

## Correzione applicata
- `DashboardController@mark_news_seen` ora salva `latestNewsCreatedAt` in cache persistente per utente (`Cache::forever`) e mantiene anche la sessione come supporto.
- Le view topbar (`base` e `theme-coreuiv2`) leggono prima da cache, con fallback alla sessione.

## Impatto
- Il badge riflette correttamente solo le news pubblicate dopo l'ultima apertura del drawer.
- Dopo nuovo accesso al pannello, le news già lette non vengono più conteggiate come nuove.

## Rischi residui
- Se la cache applicativa viene svuotata manualmente, il badge può ripartire mostrando tutte le news attive fino a nuova lettura.
