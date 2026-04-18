# Audit Bexo Header Menu Desktop Centering (2026-04-17)

## Contesto
- Dopo le ultime modifiche a `resources/views/Bexo/inc/header_menu.blade.php`, su desktop il menu top non risultava piu centrato e andava in sovrapposizione visiva con il logo.

## Causa radice
- Nel nuovo wrapper CTA desktop (`.bexo-header-cta-group`) era stato introdotto `margin-left: auto`.
- Su `header-1`, combinato con il layout flex della `header-wrapper`, questo rompeva l'equilibrio tra blocco sinistro (logo), blocco centrale (menu) e blocco destro (CTA/lingua), spostando il menu verso sinistra.

## Soluzione applicata
- Rimosso `margin-left: auto` da `.bexo-header-cta-group`.
- Aggiunte regole desktop minime per stabilizzare il layout:
  - `header-wrapper` senza wrap su desktop.
  - `site_logo` e `bexo-header-cta-group` come blocchi non flessibili.
  - `menu-area` flessibile e centrata (`justify-content: center` + `min-width: 0`).
  - centratura esplicita di `mainmenu > ul`.
- Introdotto breakpoint custom menu a `1340px` nel template Bexo:
  - visualizzazione desktop da `1341px` in su;
  - visualizzazione mobile fino a `1340px`.
- Allineato il breakpoint JS del plugin MeanMenu in `public/templates/Bexo/assets/js/main.js` (`meanScreenWidth: "1340"`), per evitare menu mobile vuoto nella fascia `991-1340`.
- Stabilizzata l'altezza del `header-wrapper` nelle fasce mobili estese:
  - override `<=1340` con layout coerente (no-wrap, padding orizzontale costante);
  - `min-height` del wrapper basata su `menubar_height` (fallback `96px`) per evitare abbassamenti tra `1340-991` e `<=575`.
- Normalizzato `menubar_height` in CSS (aggiunta automatica `px` se valore numerico) e applicato sia a `header` sia a `header-wrapper`, per evitare regressioni quando il valore admin e privo di unita.
- Ripristinato gap sotto header su mobile esteso (`margin-bottom` su `header-1`).

## Rischio/Impatto
- Basso: modifica CSS/markup locale + allineamento JS menu mobile nel template Bexo frontend.
- Nessun impatto su CRUD Backpack, permessi, validazioni o query.
- Da verificare solo resa visuale su desktop con logo molto largo o menu molto estesi.
