# Audit Crafto inc_center sticky mobile logo (2026-05-08)

## Contesto
- Su Casa Bianca, nel breakpoint mobile effettivo del template `inc_center` (`max-width:1450px`), il logo dell'header fisso dopo scroll usciva dalla fascia header e si sovrapponeva al testo della pagina.
- Il problema riguardava lo stato sticky/fixed del tema Crafto, non solo il caricamento iniziale.

## Causa individuata
- `inc_center` usava `website_settings.menubar_height` anche su mobile, valore adatto al desktop ma troppo alto/instabile nello sticky.
- Le regole Crafto per `header.sticky` e `sticky-active` potevano ripristinare logo e padding desktop.

## Implementazione
- In `resources/views/Crafto/inc_center/header_menu.blade.php` e' stata normalizzata l'altezza admin per lo stato iniziale.
- Sotto `1450px`, lo sticky header mantiene la stessa altezza del primo render usando `menubar_height` normalizzato, allineato al breakpoint in cui `inc_center` mostra l'hamburger.
- Nello sticky mobile vengono nascosti `default-logo`/`alt-logo` e viene mostrato solo `mobile-logo`, con `max-height: calc(menubar_height - 12px)`.
- Azzerati i margin/padding sticky di brand e toggler nel breakpoint mobile.
- Navbar/container usano `overflow: visible` per non tagliare il menu mobile aperto.
- Durante la fase Bootstrap `.navbar-collapse.collapsing`, il collapse usa `overflow:hidden` e lo stesso background del menu, cosi testo e sfondo si muovono insieme in apertura/chiusura.
- Nel range `992-1450px`, la colonna logo `col-lg-2` viene forzata ad auto-width per evitare taglio orizzontale del logo quando il menu e' gia in modalita hamburger.

## Verifiche
- `php artisan view:cache`

## Rischi e controlli
- Rischio medio-basso: modifica scope-ata a `Crafto inc_center` e al breakpoint mobile reale `max-width:1450px`.
- Verificare a 1450px, 991px, 768px e 390px dopo scroll che logo, hamburger e contenuto non si sovrappongano.
