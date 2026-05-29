# Audit popup avvisi Crafto (2026-05-29)

## Contesto
- Nel template frontend Crafto il tab "Avvisi" di `/admin/websiteSetting` deve mostrare una finestra modale con `website_settings.popup_text` nel periodo configurato da `popup_start` e `popup_end`.
- Il layout Crafto carica `jquery.js`, `vendors.min.js` e `main.js` con attributo `defer`.

## Causa individuata
- Il partial `resources/views/common/engine_popup_modal_crafto.blade.php` registrava l'apertura con `$(window).on('load', ...)` durante il parsing HTML.
- Con gli script esterni differiti, `jQuery` puo non essere ancora disponibile quando il partial inline viene eseguito, quindi l'apertura della modale fallisce lato front.
- Il controllo su `popup_end` usava la data a mezzanotte: nel giorno finale il popup poteva risultare gia scaduto dopo `00:00:00`.

## Implementazione
- La logica di visibilita viene calcolata lato Blade/PHP solo quando `popup_text`, `popup_start` e `popup_end` sono valorizzati.
- `popup_start` e `popup_end` vengono normalizzati con `startOfDay()` e `endOfDay()`, mantenendo inclusivo l'intero periodo scelto in admin.
- L'apertura della modale usa `window.addEventListener('load', ...)` e Bootstrap 5 (`window.bootstrap.Modal`) con fallback a `jQuery(...).modal('show')` solo se disponibile.
- La modale viene renderizzata solo quando e' effettivamente nel periodo e nella pagina prevista da `popup_pages`.

## Verifiche
- `php artisan view:cache` completato correttamente.

## Rischi e controlli
- Verificare in browser una pagina Crafto con `popup_pages = 1` sulla homepage e con `popup_pages = 2` su una pagina interna.
- Se un template Crafto custom include un partial diverso da `common.engine_popup_modal_crafto`, va allineato allo stesso pattern.
