# Audit admin login: toggle password sposta il form (2026-05-26)

## Contesto
- In `/admin/login`, cliccando sull'icona occhio del campo password il form sembrava rompersi/spostarsi.
- Il problema era visibile soprattutto sul template admin `future`, dove la pagina login ha un layout a due colonne e contenuto verticale vicino ai limiti del viewport.

## Causa individuata
- L'icona occhio era un link con `href="#password"`.
- Il click handler cambiava correttamente il tipo dell'input tra `password` e `text`, ma non bloccava il comportamento predefinito del link.
- Dopo il click, il browser navigava all'ancora `#password`, aggiornando hash/scroll e spostando il layout della login.

## Implementazione
- Aggiunto `event.preventDefault()` nel click handler `.toggle-link` della view login Backpack custom:
  - `resources/views/vendor/backpack/theme-coreuiv2/auth/login.blade.php`

## Verifiche
- Da eseguire dopo la modifica: `php artisan view:clear` e `php artisan view:cache`.
- Verifica browser consigliata: aprire `/admin/login`, cliccare piu volte l'icona occhio e controllare che il form resti fermo e che l'input alterni correttamente `password`/`text`.

## Note
- La correzione e' volutamente minimale: mantiene markup, classi e logica esistenti, evitando impatti sui template admin `white`, `modern_01`, `modern_02` e `future`.
