# Conventions

- Prima di scrivere nuovo codice, leggere sempre `docs/conventions.md` e `docs/errors.md`.
- Ogni bugfix/refactor/pattern nuovo/problema ricorrente deve aggiornare almeno `docs/audit.md`.
- Se la modifica introduce una regola stabile, aggiornare anche `docs/conventions.md`.
- Se la modifica risolve un errore, aggiornare anche `docs/errors.md`.
- Modifiche documentali solo incrementali: non sovrascrivere contenuti esistenti, aggiungere nuove voci.
- Stile documentazione: conciso, strutturato a bullet, senza testo superfluo.
- Query SQL raw: non interpolare mai input utente (slug, filtri, query string) dentro `whereRaw`; usare sempre placeholder bindati (`?`) o metodi Eloquent parametrizzati.
