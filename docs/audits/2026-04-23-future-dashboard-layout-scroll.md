# Audit Future Dashboard Layout Scroll (2026-04-23)

## Contesto
- Nel template admin `future`, la dashboard mostrava scroll verticale eccessivo con blocchi impilati "uno sotto l'altro" in alcune viewport desktop.

## Causa radice
- In `top_left.blade.php` la funzione JS `syncSidebarOffset()` applicava dinamicamente `main.style.marginLeft` e `main.style.width` anche per `future`.
- Il ricalcolo dinamico della larghezza del `main` poteva comprimere il contenuto e far scendere la griglia Bootstrap sotto le soglie dei breakpoint, causando stacking verticale anomalo.
- In `dashboard_future.blade.php` alcune colonne principali erano su breakpoint `xl`, quindi sotto 1200px si impilavano facilmente.

## Soluzione applicata
- Spostata la gestione offset della `main` per `future` su CSS statico desktop (`margin-left: 150px; width: calc(100% - 150px)`), con fallback a `width:100%` quando sidebar e' nascosta.
- Limitata la funzione `syncSidebarOffset()` al solo template `admin-modern-template`.
- Adeguati i breakpoint della dashboard `future` da `xl` a `lg` per le colonne principali (`9/3` e `6/6`) cosi' da mantenere affiancamento gia' da 992px.

## Rischio/Impatto
- Basso: modifica isolata da classi `admin-future-template` e non impatta `white`, `modern_01`, `modern_02`.
- Rischio residuo: eventuali personalizzazioni esterne che dipendono da width inline sul `main` in `future` potrebbero richiedere un allineamento CSS.
