# Audit Meta Title Fallback By Language (2026-04-18)

## Contesto
- In `admin/websiteSetting` viene impostato il titolo SEO globale (`title_{lang}`).
- In ogni pagina (`Page`) esiste `meta_title_{lang}`.
- Comportamento atteso: usare `meta_title_{lang}` solo se valorizzato, altrimenti fallback a `website->title` della stessa lingua.

## Causa radice
- Nei template `resources/views/*/inc/meta.blade.php` era presente una condizione errata:
  - `trim($page->meta_title != "")`
- La `trim()` veniva applicata al risultato booleano dell'espressione (`true/false`) invece che alla stringa `meta_title`.
- Inoltre, in vari temi il `<title>` concatenava automaticamente titolo sito + titolo pagina, non rispettando la regola richiesta.

## Soluzione applicata
- Aggiornati i meta template dei temi (`Bexo`, `Corporate1`, `Corporate2`, tutte le varianti `Crafto`, `Webshop`) con fallback esplicito:
  - `<title>{{ trim((string) $page->meta_title) !== "" ? $page->meta_title." - ".$website->title : $website->title }}</title>`
- In `Webshop/inc/meta.blade.php` allineato anche `og:title` alla stessa logica.
- Allineata la stessa regola anche ai template dettaglio NEWS (`blockNews`) che usano una sezione `@section('meta')` separata:
  - `resources/views/Bexo/blocks/blockNews/detail.blade.php`
  - `resources/views/Corporate1/blocks/blockNews/detail.blade.php`
  - `resources/views/Corporate2/blocks/blockNews/detail.blade.php`
  - `resources/views/Crafto/blocks/blockNews/detail.blade.php`
  - `resources/views/Webshop/news.blade.php` (ramo dettaglio)

## Rischio/Impatto
- Basso: modifica limitata al rendering meta lato frontend.
- Nessun impatto su CRUD Backpack, validazioni, migrazioni o query.
- Possibile differenza intenzionale rispetto al passato: nei template pagina si usa concatenazione solo quando `meta_title` pagina è valorizzato, nel formato `meta_title - titolo sito`.
