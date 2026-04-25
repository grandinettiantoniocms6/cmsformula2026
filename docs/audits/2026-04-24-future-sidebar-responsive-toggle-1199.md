# Audit Future Sidebar Responsive Toggle 1199 (2026-04-24)

## Contesto
- Nel template admin `future`, tra `992px` e `1199.98px` il click sull'hamburger non mostrava la sidebar.

## Causa radice
- Il toggler desktop usa `data-toggle="sidebar-lg-show"`.
- Nel CSS Future (`@media (max-width: 1199.98px)`) la sidebar veniva aperta solo con `body.sidebar-show`.
- Nello stesso blocco era presente una regola che nascondeva esplicitamente `body.sidebar-lg-show:not(.sidebar-show)`.

## Soluzione applicata
- Nel blocco `<1200px`, apertura sidebar consentita sia con `sidebar-show` sia con `sidebar-lg-show`.
- Rimossa la regola che forzava la chiusura quando era presente solo `sidebar-lg-show`.
- Follow-up rapido: in `inc/sidebar.blade.php` aggiunta normalizzazione JS per `future` sotto `1200px`:
  - rimozione di `sidebar-lg-show` in responsive;
  - intercettazione del toggler `data-toggle="sidebar-lg-show"` con toggle esplicito su `sidebar-show`.
  Questo evita conflitti tra stato desktop (`sidebar-lg-show`) e offcanvas responsive.
- Follow-up 2: forzato anche il reset inline del `main` sotto `1200px` (`margin-left:0`, `width:100%`) su resize e click toggler, per evitare residui di offset/layout a destra quando la sidebar si apre in offcanvas.
- Pulizia definitiva CSS in `top_left.blade.php`: rimossi i blocchi media query duplicati (`max-width: 991.98px` e `992px-1199.98px`) e mantenuta una sola regola offcanvas per `<1200px` con comportamento coerente.
- Follow-up 3 richiesto UX: sotto `1200px` la sidebar `future` ora usa apertura "push" (non overlay). Quando e' aperta, `main` e `header` vengono spostati a destra (`240px`) con larghezza `calc(100% - 240px)`, sia via CSS che via sync JS su classi `sidebar-show`/`sidebar-lg-show`.

## Impatto/Rischio
- Basso: modifica scoped a `body.admin-future-template` e solo responsive `<1200px`.
- Nessun impatto previsto su template `white`, `modern_01`, `modern_02`.
