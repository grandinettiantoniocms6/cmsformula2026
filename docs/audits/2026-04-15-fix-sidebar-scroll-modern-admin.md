# Audit Fix Sidebar Scroll Modern Admin (2026-04-15)

## Contesto
- Nei template admin `Modern01` e `Modern02` la sidebar risultava non scrollabile (soprattutto su viewport piccoli), rendendo parte del menu non raggiungibile.

## Causa radice
- Con topbar fissa (`55px`) e sidebar in layout moderno, mancava una gestione esplicita e coerente dello scroll verticale su contenitore sidebar/nav in tutti i breakpoint.

## Soluzione applicata
- Aggiornati i layout:
  - `resources/views/vendor/backpack/theme-coreuiv2/layouts/top_left.blade.php`
  - `resources/views/vendor/backpack/base/layouts/top_left.blade.php`
- Aggiunte regole CSS per i template moderni:
  - `overflow-y: auto` e `-webkit-overflow-scrolling: touch` su sidebar.
  - `max-height: calc(100vh - 55px)` + `overflow-y: auto` su `.sidebar-nav`.
  - Su mobile (`max-width: 991.98px`) impostato `top: 55px` e `bottom: 0` per allineare la sidebar alla topbar fissa.

## Rischio/Impatto
- Basso: modifica solo presentazionale/layout admin, senza impatti su CRUD, query, validazione o permessi.

## Follow-up
- Dopo prima patch il problema risultava ancora presente in alcuni contesti.
- Rafforzato fix nei medesimi layout con:
  - `height: calc(100vh - 55px) !important` su sidebar.
  - `height: 100%` + `max-height` e `overflow-y: scroll !important` su `.sidebar-nav`.
  - `overscroll-behavior: contain` + `-webkit-overflow-scrolling: touch`.
  - gestione eventi `wheel`/`touchmove` su `.sidebar-nav` per evitare propagazione al contenuto principale.
