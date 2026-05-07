# Audit Crafto mobile PageSpeed Casa Bianca (2026-05-07)

## Contesto
- La pagina Casa Bianca con template Crafto `inc_multilang` risultava buona su desktop, ma molto lenta su Lighthouse mobile.
- Dagli screenshot: mobile Performance 33, FCP 4,5s, LCP 6,5s, TBT 1160ms; desktop Performance 95.

## Causa individuata
- `icon.min.css` di Crafto veniva caricato come stylesheet render-blocking pur essendo un asset icon-font non critico per il primo render.
- GLightbox veniva scaricato nel layout Crafto anche su pagine senza blocchi gallery/portfolio/reference.
- `main.js` inizializzava GLightbox senza verificare che la libreria fosse disponibile.
- Uno script inline nel layout usava `$` prima dell'esecuzione dei file jQuery caricati con `defer`, con possibile errore runtime.

## Implementazione
- In `resources/views/Crafto/inc_multilang/head.blade.php`, `icon.min.css` viene caricato con `preload` + `onload`, mantenendo fallback `noscript`.
- Dopo il secondo controllo Lighthouse, anche `vendors.min.css` e `crafto_custom.css` vengono caricati con `preload` + `onload`, per ridurre ulteriormente le richieste render-blocking.
- Aggiunti `preconnect` verso CDN/font e `preload` del logo mobile/primario per anticipare le risorse del primo viewport.
- In `resources/views/Crafto/layout.blade.php`, lo script GLightbox viene caricato solo quando la pagina contiene blocchi che richiedono lightbox.
- In `public/templates/Crafto/js/main.js`, l'inizializzazione lightbox ora verifica anche `typeof GLightbox === 'function'`.
- Lo script inline degli alert ora aspetta `window.load` e verifica `window.jQuery`.

## Verifiche
- `php artisan view:clear`
- `php artisan view:cache`

## Rischi e controlli
- Rischio basso: le pagine con gallery continuano a caricare GLightbox; le pagine senza gallery evitano il download.
- Su pagine che usano classi icona nel primo viewport puo comparire un breve ritardo nella resa dell'icona, ma il layout non dipende da `icon.min.css`.
- Su pagine che dipendono da CSS plugin sopra la piega, verificare che il caricamento differito di `vendors.min.css` non introduca flash visivo; Casa Bianca usa soprattutto header/logo/testo nel primo viewport.
- Rieseguire Lighthouse mobile su URL pubblico con cache pulita per misurare il miglioramento effettivo.
