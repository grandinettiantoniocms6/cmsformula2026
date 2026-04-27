# Audit admin/page limite pagine illimitato (2026-04-27)

## Contesto
- Durante il miglioramento UX della sezione `admin/page`, la lista pagine mostrava il chip "pagine illimitate" quando `website_settings.number_max_page` non era valorizzato.
- Nello stesso flusso, pero, la logica trattava il valore `null` come limite esaurito.

## Errore riscontrato
- Warning "limite pagine" visibile anche con pagine illimitate.
- Pulsante create rimosso nel CRUD pagine quando il limite non era impostato.
- Azione "Duplica" nascosta nel menu gestione pagina quando il limite non era impostato.

## Causa radice
- `number_max_page` vuoto lasciava `$number = null`.
- Il confronto `$number <= 0` valutava il caso illimitato come limite raggiunto.
- Il menu model mostrava "Duplica" solo con `$number > 0`, escludendo il caso illimitato.

## Correzione applicata
- Introdotta variabile esplicita `$hasPageLimit` in:
  - `resources/views/vendor/backpack/ui/pages.blade.php`
  - `app/Http/Controllers/Admin/PageCrudController.php`
  - `app/Models/Page.php`
- Il warning e la rimozione del create scattano solo se esiste un limite reale e il residuo e `<= 0`.
- L'azione "Duplica" resta disponibile quando il limite e illimitato.

## Impatto
- Le installazioni senza limite pagine continuano a creare e duplicare pagine.
- Il chip UX distingue limite residuo, limite raggiunto e pagine illimitate.

## Verifiche
- `php -l app/Http/Controllers/Admin/PageCrudController.php`
- `php -l app/Models/Page.php`

## Rischi residui
- Verifica Artisan non completata in CLI locale per estensione PHP `fileinfo` non attiva (`Class "finfo" not found`).
