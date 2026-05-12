# Audit export prodotti tax fallback (2026-05-12)

## Contesto
- Su `https://stage.plcshop.it/admin/plugin/pluginProducts/export` l'export prodotti falliva con:
  `Attempt to read property "value" on null`.
- Il punto di errore era `PluginProductsCrudController.php` nella generazione della colonna `tax` per plugin prodotti v3.

## Causa individuata
- L'export accedeva direttamente a `$product->tax->value`.
- Alcuni prodotti possono avere `tax_id` nullo, non valido o riferito a una tax cancellata, quindi la relazione `tax` restituisce `null`.

## Implementazione
- In `PluginProductsCrudController::export`, la relazione `tax` viene caricata con `with("tax")`.
- La colonna `tax` usa `optional($product->tax)->value ?? 22`, quindi esporta `22` quando la relazione non esiste.

## Verifiche
- Verificare l'export da `/admin/plugin/pluginProducts/export` su stage.
- Controllare nel CSV che i prodotti senza tax valida abbiano valore `22` nella colonna `tax`.

## Rischi e controlli
- Rischio basso: cambia solo il valore esportato nei casi che prima generavano errore.
- Controllo consigliato: individuare e correggere i prodotti con `tax_id` nullo/non valido se il dato fiscale deve essere normalizzato a database.
