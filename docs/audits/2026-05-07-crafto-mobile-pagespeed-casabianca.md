# Audit Crafto mobile PageSpeed Casa Bianca (2026-05-07)

## Contesto
- La pagina Casa Bianca con template Crafto `inc_multilang` risultava buona su desktop, ma molto lenta su Lighthouse mobile.
- Dagli screenshot: mobile Performance 33, FCP 4,5s, LCP 6,5s, TBT 1160ms; desktop Performance 95.

## Causa individuata
- Casa Bianca usa il partial Crafto `inc_center`, non `inc_multilang`; le prime ottimizzazioni su `inc_multilang` non incidevano sulla pagina reale.
- `responsive.css`, `icon.min.css` e `vendors.min.css` di Crafto venivano caricati come stylesheet render-blocking pur non essendo tutti critici per il primo render.
- I CSS form, WhatsApp, custom e Google Fonts erano nel percorso critico mobile.
- GLightbox veniva scaricato nel layout Crafto anche su pagine senza blocchi gallery/portfolio/reference.
- `main.js` inizializzava GLightbox senza verificare che la libreria fosse disponibile.
- Uno script inline nel layout usava `$` prima dell'esecuzione dei file jQuery caricati con `defer`, con possibile errore runtime.

## Implementazione
- In `resources/views/Crafto/inc_center/head.blade.php`, `vendors.min.css`, `icon.min.css`, `responsive.css`, CSS WhatsApp e CSS custom vengono caricati con `preload` + `onload`, mantenendo fallback `noscript`.
- Il CSS form viene caricato dopo `window.load`, con fallback `noscript`.
- I Google Fonts sono caricati con `display=swap`, `media=print` + `onload`.
- Aggiunti `preconnect` verso CDN/font e `preload` del logo mobile/primario per anticipare le risorse del primo viewport.
- In `resources/views/Crafto/layout.blade.php`, `website->custom_css` viene caricato con `preload` + `onload`.
- In `resources/views/Crafto/layout.blade.php`, lo script GLightbox viene caricato solo quando la pagina contiene blocchi che richiedono lightbox.
- In `public/templates/Crafto/js/main.js`, l'inizializzazione lightbox ora verifica anche `typeof GLightbox === 'function'`.
- Lo script inline degli alert ora aspetta `window.load` e verifica `window.jQuery`.

## Verifiche
- `php artisan view:clear`
- `php artisan view:cache`

## Rischi e controlli
- Rischio basso: le pagine con gallery continuano a caricare GLightbox; le pagine senza gallery evitano il download.
- Su pagine che usano classi icona nel primo viewport puo comparire un breve ritardo nella resa dell'icona, ma il layout non dipende da `icon.min.css`.
- Su Casa Bianca resta volutamente sincrono `style.css`, perche governa header/logo/menu: differirlo richiede prima CSS critico inline dedicato e test visuale desktop/mobile.
- Verificare che il caricamento differito di `responsive.css` non introduca flash visivo su mobile; se succede, estrarre un CSS critico mobile per header/logo/navbar prima di differire `style.css`.
- Rieseguire Lighthouse mobile su URL pubblico con cache pulita per misurare il miglioramento effettivo.
