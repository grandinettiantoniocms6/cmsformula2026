# Audit Crafto PageSpeed senza modifiche CSS/JS (2026-05-05)

## Contesto
- PageSpeed mobile su `stage.casabiancasociale.it` segnalava valori rossi su FCP, LCP, Speed Index, richieste di blocco rendering e cache asset.
- Vincolo operativo: non modificare, spostare o creare file CSS/JS per evitare regressioni su header/logo/menu.

## Causa principale affrontata
- `public/.htaccess` non impostava cache lunga/compressione per asset statici.
- `resources/views/Crafto/layout.blade.php` includeva `common.consent_solution_iubenda` in `<head>` e poi gestiva nuovamente il cookie banner a fondo pagina, con rischio di doppio caricamento e CSS/JS cookieconsent bloccanti.
- `resources/views/Crafto/inc_multilang/header_menu.blade.php` leggeva dimensioni logo con `getimagesize()` diretto e dipendente da `env('LOCAL')`, senza verifica filesystem robusta.
- I font Google configurati da admin non aggiungevano automaticamente `display=swap`.

## Correzione applicata
- Aggiunti header cache/Expires e compressione gzip in `public/.htaccess`.
- Nel layout Crafto, in `<head>` viene caricata solo la consent solution Iubenda quando `IUBENDA=1`; il banner cookie resta gestito nel blocco gia presente a fondo pagina.
- Nel layout Crafto il reCAPTCHA non viene piu caricato globalmente: il layout espone `@yield('recaptcha')` e `index.blade.php` lo abilita solo quando la pagina contiene blocchi `blockContact`, `blockPluginForm` o `blockPluginParking`.
- SweetAlert viene caricato solo insieme a reCAPTCHA/form; il CSS fallback cookieconsent viene caricato solo quando non e' presente un banner Iubenda; CSS/JS WhatsApp vengono caricati solo quando il widget e' attivo.
- Rimossi dal caricamento globale Crafto i CSS comuni non necessari su ogni pagina: `form_contact.css`, `sidebar.css`, `products.css`, `cart.css`, `glightbox.min.css`, cookieconsent e WhatsApp ora sono condizionali o spostati fuori dal percorso critico.
- I CSS non critici rimasti per form e WhatsApp sono caricati con `rel="preload" as="style"` e conversione a stylesheet su `onload`, con fallback `noscript`, cosi non bloccano il rendering iniziale.
- Per togliere completamente dal percorso critico le risorse ancora segnalate da PageSpeed, `form_contact.css` viene ora inserito via JavaScript dopo `window.load`; Google Fonts e FontAwesome usano `media="print"` con rimozione del media su `onload`; CSS e JS WhatsApp vengono inseriti dopo `window.load`.
- In `inc_multilang/head.blade.php` aggiunti preconnect per CDN/font e `display=swap` automatico sui Google Fonts configurati da admin.
- In `inc_multilang/header_menu.blade.php` le dimensioni dei loghi sono risolte con `public_path()`, `is_file()` e `@getimagesize()`, poi usate come `width`/`height`; aggiunti `loading="eager"`, `fetchpriority="high"` e `decoding="async"` sui loghi.

## Verifiche
- `php -l resources/views/Crafto/inc_multilang/head.blade.php`
- `php -l resources/views/Crafto/inc_multilang/header_menu.blade.php`
- `php -l resources/views/Crafto/layout.blade.php`

## Rischi residui
- Il warning PageSpeed sulle richieste di blocco rendering puo rimanere in parte, perche i CSS principali del tema restano caricati come stylesheet sincroni e non sono stati modificati per vincolo esplicito.
- Le regole `.htaccess` richiedono Apache con `mod_expires`, `mod_headers` e `mod_deflate` attivi; su Nginx o hosting che ignora `.htaccess` vanno replicate nella configurazione server.
- Il miglioramento effettivo va misurato su stage dopo deploy e svuotamento cache.
- Il caricamento asincrono dei CSS form/WhatsApp puo produrre un brevissimo ritardo di stile su quei componenti, ma non coinvolge header, logo o topbar.
- Il caricamento non bloccante di Google Fonts/FontAwesome puo produrre un breve flash con font o icone non ancora applicati; e' stato scelto per evitare interventi sui CSS strutturali Crafto.
