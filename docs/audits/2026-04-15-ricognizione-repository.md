# Audit Ricognizione Repository (2026-04-15)

## Obiettivo
- Ricognizione preventiva senza modifiche al codice applicativo, per consolidare memoria persistente.

## Scope analizzato
- `app/Models`
- `app/Http/Controllers`
- `app/Http/Requests`
- `routes/`
- `database/migrations`
- `tests/`
- configurazioni Backpack (`config/backpack/*`) e CRUD controllers admin.

## Evidenze principali
- Architettura fortemente CRUD-centrica su Backpack, con molta logica custom nei controller.
- `routes/web.php` monolitico (705 righe, 415 statement route), include route test/debug e blocchi multi-lingua ripetuti.
- Uso esteso di query raw:
  - `Controllers.whereRaw`: 168 occorrenze.
  - `Models.whereRaw`: 8 occorrenze.
- Uso esteso di `DB::table` nei controller (`Controllers.DBtable`: 100 occorrenze).
- FormRequest numerose (148), ma diverse con logica condizionale basata su URL/referrer (`Requests.ServerBased`: 31 occorrenze).
- Test quasi assenti (`TestMethods`: 2, entrambi example base).

## Fragilita tecniche
- Rischio regressioni in query/search prodotti per ampio uso di `whereRaw` con stringhe dinamiche.
- Rischio blocchi runtime/UX per presenza diffusa di `die;`/`dd(...)` (`Controllers.die_dd`: 123, `AdminControllers.die`: 97).
- Accoppiamento alto tra model e presentazione admin (HTML/JS in metodi model tipo `getMenu`).
- Duplicazione di utility immagine nei model (`resolveImagePath` presente in 47 model).
- Migrazioni molto numerose e storiche; una migration con rollback non implementato (`2022_01_27_091335_add_insert_ru_lang.php`).

## Incoerenze documentali risolte
- Erano assenti i percorsi documentali richiesti dalle istruzioni operative:
  - `docs/ai-memory/project-memory.md`
  - `docs/audits/`
- Sono stati creati per allineare il repository alle regole operative future.

## Nessuna modifica applicativa
- Nessuna modifica a `app/`, `routes/`, `database/` (eccetto lettura), `tests/` in questa fase.
