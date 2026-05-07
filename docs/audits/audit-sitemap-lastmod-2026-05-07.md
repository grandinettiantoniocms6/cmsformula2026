# Audit sitemap lastmod (2026-05-07)

## Contesto
- La route `sitemap.xml` genera la sitemap pubblica da inviare a Google.
- Tutti gli URL avevano `<lastmod>` valorizzato con `Carbon::now()`, quindi ogni richiesta produceva la stessa data/ora corrente per pagine, categorie e prodotti.
- La view `resources/views/sitemap.blade.php` conteneva anche una query DB dentro il loop prodotti per recuperare la categoria.

## Implementazione
- La costruzione degli URL sitemap e' stata spostata in `app/Http/Controllers/SitemapController.php`.
- `<lastmod>` usa ora `updated_at` del record, con fallback a `created_at`.
- Il formato scelto e' `Y-m-d`, stabile e sufficiente quando non serve una granularita' oraria affidabile.
- Rimossi `<changefreq>` e `<priority>` dalla sitemap, perche' non sono segnali utili per Google.
- Rimossa la query DB dalla view: le categorie prodotto vengono recuperate in batch nel controller.

## Rischi e controlli
- Rischio basso: le route pubbliche restano le stesse.
- Per prodotti associati a piu categorie viene mantenuta una sola categoria, come nel comportamento precedente; ora viene presa la prima associazione ordinata per id pivot.
- Verificare in ambiente con DB reale che `/sitemap.xml` restituisca XML valido e che gli URL prodotto abbiano categoria corretta.
