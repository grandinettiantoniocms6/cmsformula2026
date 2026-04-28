# Audit Dashboard pluginProducts su template admin (2026-04-28)

## Contesto
- Con template admin `white`, la Dashboard mostrava i widget ecommerce di `pluginProducts` v3: Top 10 Prodotti/Clienti, andamento ordini, totale ordini, prodotti inseriti, ordini ricevuti e ultimi ordini.
- Con template `modern_01`, `modern_02` o `future`, gli stessi widget potevano non comparire perche le bacheche alternative non riusavano quel blocco.

## Causa radice
- Il blocco ecommerce era implementato direttamente dentro `resources/views/vendor/backpack/ui/dashboard.blade.php`.
- `dashboard_future.blade.php` e la bacheca legacy `__dashboard.blade.php` avevano contenuti propri e non includevano il blocco condiviso.

## Correzione applicata
- Creato il partial condiviso `resources/views/vendor/backpack/ui/inc/dashboard_plugin_products_cards.blade.php`.
- Incluso il partial in:
  - `resources/views/vendor/backpack/ui/dashboard_future.blade.php`
  - `resources/views/vendor/backpack/ui/__dashboard.blade.php`
- Il partial mostra i widget solo con `pluginProducts` attivo in versione 3 e con le tabelle ecommerce disponibili.

## Verifiche
- `php -l resources/views/vendor/backpack/ui/inc/dashboard_plugin_products_cards.blade.php`
- `php -l resources/views/vendor/backpack/ui/dashboard_future.blade.php`
- `php -l resources/views/vendor/backpack/ui/__dashboard.blade.php`
- `php artisan view:cache`
- `php artisan view:clear`

## Rischi residui
- Verificare visivamente la resa responsive su `modern_01`, `modern_02` e `future`, perche il partial eredita gli stili del template corrente.
- Le query restano allineate alla logica storica del template White e dipendono dalle tabelle ecommerce v3.
