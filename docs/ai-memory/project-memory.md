# Project Memory

## Aggiornato il
- 2026-04-15

## Snapshot tecnico
- Stack: Laravel + Backpack (tema `backpack.theme-coreuiv2`).
- Aree analizzate: `app/Models`, `app/Http/Controllers`, `app/Http/Requests`, `routes`, `database/migrations`, `tests`, config Backpack.
- Volumi:
  - `app/Models`: 179 file.
  - `Admin/*CrudController`: 148 file.
  - `database/migrations`: 571 file.
  - `tests`: 4 file, solo 2 test methods base.

## Convenzioni reali
- Pattern dominante model: `CrudTrait` + `protected $guarded = ['id']`.
- Translatable con Spatie (`HasTranslations`) molto diffuso.
- CRUD Backpack: `setupCreateOperation`/`setupUpdateOperation` con FormRequest dedicata.
- Personalizzazioni CRUD spesso in view custom (`setListView`, `setEditView`) e in metodi model (`getMenu`, `get_foto_*`).
- Routing centralizzato in `routes/web.php` con molte route custom admin + frontend multi-lingua.

## Pattern gia presenti
- Controllo autorizzazioni spesso hardcoded su `backpack_user()->roles[0]->id`.
- Logica business e operazioni bulk in controller CRUD (`actions`, `clone`, `destroy` custom).
- Forte uso di `whereRaw` su listing/search plugin prodotti.
- Caching frontend in `PluginProductsController` con `Cache::remember` e TTL via env.

## Aree fragili / rischi ricorrenti
- Query raw dinamiche su input runtime (slug, filtri, ricerca): rischio regressioni SQL/sicurezza.
- Dipendenza da `$_SERVER`/`HTTP_REFERER` in piu Request per ramificare la validazione.
- Presenza ampia di `die;`/`dd(...)` nei controller (admin e frontend).
- Coupling elevato Model <-> UI Backpack (HTML/JS nei model), con duplicazioni estese.
- `routes/web.php` include route di test/debug e blocchi multi-lingua duplicati.
- Copertura test quasi assente: alto rischio regressione su refactor.

## Incoerenze rilevate
- Prima della ricognizione mancavano i path documentali richiesti in AGENTS:
  - `docs/ai-memory/project-memory.md`
  - `docs/audits/`
- Migrazioni con stile misto (classico + anonymous) e una migration con `down()` vuoto.

## Regole pratiche per interventi futuri
- Prima di toccare prodotti/pagine: verificare impatti su route multi-lingua, query raw e CRUD admin.
- Evitare nuove astrazioni se non gia presenti nel modulo target.
- Per SQL dinamico: preferire binding parametrico o clausole Eloquent.
- Se emerge una regola stabile o un bug ricorrente: aggiornare subito `docs/ai-memory/project-memory.md` e un file in `docs/audits/`.
