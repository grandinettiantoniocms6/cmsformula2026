# Audit Future Dashboard Frontend Traffic Counter (2026-04-24)

## Contesto
- Nel template admin `future`, il box grafico mostrava "Traffico ordini" con dati ordini giornalieri, non visite reali del frontend.

## Causa radice
- Mancava una persistenza locale per il conteggio visite frontend.
- La serie del grafico usava `Order::whereDate(...)->count()` e fallback dati fittizi lato JS.

## Soluzione applicata
- Creata tabella giornaliera `frontend_page_visits_daily` tramite migration:
  - `visit_date` (unique)
  - `visits`
- Aggiunto tracking in `IndexController@index`:
  - incremento atomico giornaliero via `INSERT ... ON DUPLICATE KEY UPDATE`.
  - tracking non blocca il frontend in caso di errore.
- Dashboard `future` aggiornata:
  - titolo widget: `Traffico del sito`
  - sottotitolo: `Visite frontend (ultimi 7 giorni)`
  - serie grafico letta da `frontend_page_visits_daily`
  - rimosso fallback numeri demo.

## Impatto/Rischio
- Basso: cambiamento scoped a dashboard admin `future` e al rendering frontend `IndexController@index`.
- Nota funzionale: i dati sono reali da ora in avanti (non retroattivi per i giorni precedenti alla migration).
