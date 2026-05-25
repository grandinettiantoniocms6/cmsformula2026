﻿﻿﻿# Project Memory

## Aggiornato il
- 2026-05-25

## Snapshot tecnico
- Stack: Laravel + Backpack (tema `backpack.theme-coreuiv2`).
- Aree analizzate: `app/Models`, `app/Http/Controllers`, `app/Http/Requests`, `routes`, `database/migrations`, `tests`, config Backpack.
- Volumi:
  - `app/Models`: 179 file.
  - `Admin/*CrudController`: 148 file.
  - `database/migrations`: 571 file.
  - `tests`: 4 file, solo 2 test methods base.

## Convenzioni reali
- Pattern dominante model: `CrudTrait` + `protected $guarded = ['id']`.
- Translatable con Spatie (`HasTranslations`) molto diffuso.
- CRUD Backpack: `setupCreateOperation`/`setupUpdateOperation` con FormRequest dedicata.
- Personalizzazioni CRUD spesso in view custom (`setListView`, `setEditView`) e in metodi model (`getMenu`, `get_foto_*`).
- Routing centralizzato in `routes/web.php` con molte route custom admin + frontend multi-lingua.

## Pattern gia presenti
- Controllo autorizzazioni spesso hardcoded su `backpack_user()->roles[0]->id`.
- Logica business e operazioni bulk in controller CRUD (`actions`, `clone`, `destroy` custom).
- Forte uso di `whereRaw` su listing/search plugin prodotti.
- Caching frontend in `PluginProductsController` con `Cache::remember` e TTL via env.

## Aree fragili / rischi ricorrenti
- Query raw dinamiche su input runtime (slug, filtri, ricerca): rischio regressioni SQL/sicurezza.
- Dipendenza da `$_SERVER`/`HTTP_REFERER` in piu Request per ramificare la validazione.
- Presenza ampia di `die;`/`dd(...)` nei controller (admin e frontend).
- Coupling elevato Model <-> UI Backpack (HTML/JS nei model), con duplicazioni estese.
- `routes/web.php` include route di test/debug e blocchi multi-lingua duplicati.
- Copertura test quasi assente: alto rischio regressione su refactor.

## Incoerenze rilevate
- Prima della ricognizione mancavano i path documentali richiesti in AGENTS:
  - `docs/ai-memory/project-memory.md`
  - `docs/audits/`
- Migrazioni con stile misto (classico + anonymous) e una migration con `down()` vuoto.

## Regole pratiche per interventi futuri
- Prima di toccare prodotti/pagine: verificare impatti su route multi-lingua, query raw e CRUD admin.
- Evitare nuove astrazioni se non gia presenti nel modulo target.
- Per SQL dinamico: preferire binding parametrico o clausole Eloquent.
- Nei template `resources/views/*/inc/meta.blade.php`, il fallback SEO del `<title>` deve essere: `meta_title` pagina se valorizzato con formato `meta_title - website->title`, altrimenti solo `website->title` (stessa lingua corrente).
- Evitare gate hardcoded su `APP_URL` per feature admin (es. news topbar): in locale devono degradare via `try/catch`, non essere disattivate a priori.
- Per dipendenze DB esterne (`mysql_2`) in UI admin sincrona: usare probe TCP rapido + cache reachability (circuit breaker breve) prima delle query, per evitare timeout lunghi lato pagina.
- Le connessioni DB esterne del gestionale devono essere parametrizzate via `.env` (`*_GEST`) e non hardcoded in `config/database.php`.
- Nel layout frontend Bexo `header-1`, evitare `margin-left: auto` sul gruppo CTA desktop: sbilancia il flex e puo disallineare il menu centrale rispetto a logo/azioni.
- Se si cambia il breakpoint del menu mobile Bexo, allineare sempre CSS/Blade (`header_menu.blade.php`) e JS MeanMenu (`public/templates/Bexo/assets/js/main.js`, `meanScreenWidth`) per evitare menu vuoto in fasce intermedie.
- Nel layout Bexo con mobile esteso oltre `991px`, fissare una `min-height` coerente del `header-wrapper` (idealmente legata a `menubar_height`) per prevenire salti di altezza su tablet e piccoli smartphone.
- I valori admin di altezza (es. `menubar_height`) possono arrivare senza unita: normalizzarli in CSS (`px` se numerici) prima di usarli in `style` inline per evitare comportamenti incoerenti tra desktop e mobile.
- Nei file Blade frontend evitare blocchi `<?php ...` aperti in testa al template: usare direttive Blade o chiudere esplicitamente il tag PHP, altrimenti la compilazione puo fallire con `unexpected token "<"`.
- La sitemap XML deve usare `lastmod` basato su `updated_at`/`created_at` reale dei record e non su `Carbon::now()`: date uguali generate a ogni richiesta rendono il segnale poco affidabile per Google. Evitare query DB dentro `resources/views/sitemap.blade.php`.
- Per i CRUD blocchi (`Block*CrudController`) la create standard multi-blocco deve usare `custom_create_multi_enhanced` (non `custom_create_multi`) per coerenza col nuovo layout UI admin.
- Nel flusso import prodotti (`PluginProductImportCrudController`), le azioni post-import su `set:products_search` devono privilegiare aggiornamenti incrementali sugli ID toccati dall'ultimo `importSpecialMapping` (fallback full rebuild solo se manca il contesto IDs).
- Nel flusso import prodotti (`PluginProductImportCrudController`), i campi testuali traducibili opzionali del mapping (es. `description`) non sono sempre presenti in `$product`: prima di usarli per completare il prodotto padre verificare sempre la chiave e salvarli tramite istanza Eloquent, evitando `Undefined array key` e bypass dei mutator/translations.
- Nel flusso import prodotti, l'estensione `.xls` richiede un file Excel OLE reale: intercettare le eccezioni PhpSpreadsheet per file rinominati o in formato non coerente e mostrarle come errore di caricamento leggibile, senza HTTP 500.
- Per import prodotti SPECIAL con configurazione esistente e molti record, elaborare in coda `database_imports` con run persistita in `plugin_product_import_runs`; il worker deve usare `--queue=imports` e un `retry_after` superiore alla durata massima per evitare esecuzioni duplicate.
- Le run import prodotti devono poter essere annullate in modo cooperativo: eliminare subito dalla tabella `jobs` solo le run ancora `queued`, mentre quelle `processing` passano da `cancelling` a `cancelled` al successivo checkpoint, senza rollback delle righe gia' elaborate.
- Il campo `website_settings.admin_panel_template` supporta anche `future`: gli stili del tema devono essere sempre scope-ati su `body.admin-future-template` e non devono alterare `white`, `modern_01`, `modern_02`.
- Nel template admin `future`, evitare offset dinamici JS su `.app-body > .main`: usare offset CSS desktop stabile della sidebar e breakpoint `lg` per la dashboard, per prevenire stacking verticale e scroll eccessivo.
- Nel template admin `future`, sotto `1200px` il toggler puo usare classi diverse (`sidebar-show` o `sidebar-lg-show`): le regole CSS offcanvas devono considerarle entrambe per evitare sidebar non apribile.
- Nel template admin `future`, per stabilita responsive `<1200px` conviene normalizzare via JS lo stato sidebar su una sola classe (`sidebar-show`) intercettando eventuali click su toggler `sidebar-lg-show`.
- Nel template admin `future`, evitare media query responsive sovrapposte per la sidebar: mantenere un solo blocco `<1200px` offcanvas riduce conflitti tra `transform`, `margin-left` e offset del `main`.
- Nel template admin `future`, se UX richiede sidebar responsive non sovrapposta, sotto `1200px` usare modalita "push": apertura sidebar con offset coerente di `main` e `header` (stessa larghezza sidebar) invece di overlay.
- Nel dashboard `future`, il widget "Traffico del sito" deve leggere visite frontend reali da tabella giornaliera `frontend_page_visits_daily` (non da ordini o dati fittizi).
- I widget Dashboard di `pluginProducts` v3 (Top 10 Prodotti/Clienti, andamento ordini, totale ordini, prodotti inseriti, ordini ricevuti e ultimi ordini) devono essere disponibili anche sui template admin `modern_01`, `modern_02` e `future`: usare il partial condiviso `resources/views/vendor/backpack/ui/inc/dashboard_plugin_products_cards.blade.php` quando si aggiungono nuove bacheche.
- Nel dashboard `future`, i pulsanti `7/30/90 giorni` del grafico traffico devono aggiornare realmente il range dati e mostrare tooltip con conteggio visite puntuale sul punto.
- Nel dashboard `future`, per mostrare "chi ha modificato" nelle attivita pagine usare un campo persistente `pages.updated_by`; non usare `users_navigations` (stato URL corrente, non storico modifiche).
- Nel backend admin, la modifica di un blocco pagina (`/admin/{blockType}/{id}` con `blockType` registrato in `admin_blocks`) deve aggiornare anche `pages.updated_by`/`updated_at` della pagina collegata via `blocks_pages`, cosi la dashboard riflette la modifica reale.
- Per distinguere in dashboard tra edit pagina ed edit blocco, usare metadati persistenti su `pages` (`updated_context`, `updated_block_type`) e non inferenze da URL/sessione.
- Per tracciamento blocchi robusto, considerare sia update `PUT/PATCH` sia `POST` su URL con id, e nei blocchi multi risalire da record figlio (`name_table.block_id`) al blocco padre (`blocks_pages.obj_id`).
- Su installazioni con tabella `website_settings` molto ampia, nuove colonne possono fallire in migration con `SQLSTATE[42000] 1118 Row size too large`: per nuovi setting admin usare preferibilmente `website_setting_extras` (tabella 1:1 esterna) invece di estendere `website_settings`.
- Per la campanellina news admin, lo stato "letto" deve essere persistente per utente oltre la sessione (cache/DB): evitare solo `session('admin_news_last_seen_at_*')` perche al logout il badge torna a conteggi errati.
- In `admin/page`, `website_settings.number_max_page` vuoto/0 significa pagine illimitate: non confrontare `null <= 0`, altrimenti si blocca erroneamente creazione/duplicazione e compare il warning limite raggiunto.
- Nei template frontend, non chiamare `getimagesize()` direttamente su path salvati da admin: risolvere il file con `public_path()`, verificare `is_file()` e aggiungere `width`/`height` solo se le dimensioni sono disponibili, cosi immagini mancanti in locale non rompono il rendering.
- Se un ambiente usa `QUEUE_CONNECTION=database` o un worker `queue:work`, deve esistere la tabella Laravel `jobs`: il repository include `failed_jobs`, ma il worker legge comunque `jobs` per estrarre i job pendenti.
- Gli avvisi errore di `app/Exceptions/Handler.php` sono configurabili dal tab "Avvisi errori" di `/admin/superadminsettings`, visibile solo a `backpack_user()->id == 1`: abilitazione invio, destinatario, email in copia e intervallo di reinvio dello stesso errore sono salvati in `website_setting_extras`.
- La pagina `/admin/superadminsettings`, visibile solo a `backpack_user()->id == 1`, e' il contenitore generale per impostazioni SuperAdmin spostate fuori da `/admin/websiteSetting`: nel tab "Sito web" gestisce `website_settings.number_max_page`, `website_settings.whatsapp_active` e `website_setting_extras.server_allocated_space`, nel tab "Template Admin" gestisce i campi admin/template ex tab `Extra` di `websiteSetting`, e nel tab "Prodotti V2/V3/V4" gestisce `website_settings.is_megamenu`, `website_settings.is_search_one_col`, le azioni operative ex tab `Impostazioni Extra` e i campi watermark (`watermark_url`, `watermark_position`, `watermark_x`, `watermark_y`).
- Il reinvio dello stesso avviso errore usa cache Laravel con chiave basata su messaggio, file e linea dell'eccezione; se il cache driver non e' persistente tra richieste/processi, il throttling degli avvisi puo' non essere efficace.
- In `PluginProductsController`, non cacheare la sidebar prodotti calcolata da `$products_processed` con cache driver `file`: su cataloghi grandi il payload serializzato e le chiavi basate sugli ID prodotto possono generare file cache enormi e memory exhaustion in `Illuminate\Cache\FileStore`.
- Nell'export prodotti v3 (`PluginProductsCrudController::export`), i prodotti senza relazione `tax` valida devono esportare IVA `22` come fallback, evitando accessi diretti a `$product->tax->value`.
- Nel calcolo prezzi del plugin parking, non riusare la stessa istanza `Carbon` tra ciclo disponibilita e ciclo regole prezzo: `addDay()`/`subDay()` mutano l'oggetto e possono spostare il controllo promo oltre il periodo richiesto. Usare `copy()` e cursori separati per ogni ciclo.
- Nel layout frontend Crafto evitare doppio caricamento del cookie banner: `common.consent_solution_iubenda` include anche fallback/banner cookie e puo introdurre CSS/JS bloccanti in `<head>`; se il layout gestisce gia il banner in fondo pagina, caricare in head solo la consent solution Iubenda quando serve.
- Nel layout frontend Crafto non caricare reCAPTCHA globalmente: usare `@yield('recaptcha')` e attivarlo dalle view solo quando la pagina contiene blocchi form/contatto, altrimenti peggiora FCP/LCP con script terzi inutili.
- Nel layout/frontend Crafto caricare risorse SweetAlert e WhatsApp solo quando servono: SweetAlert insieme a reCAPTCHA/form, WhatsApp solo con `website->whatsapp_active == 1` ed `env('WAPP')`.
- Nel layout Crafto evitare `common.css_common` globale: caricare `sidebar.css`, `products.css`, `cart.css`, `form_contact.css`, `glightbox.min.css`, cookieconsent e WhatsApp in modo condizionale in base a template/blocchi pagina, senza toccare CSS strutturali del tema/header.
- Prima di caricare script Google esterni che possono usare WebAuthn (`recaptcha/api.js`, Google Maps/Places, GTM/Ads che possono iniettare script Google), includere `common.google_public_key_credential_fallback`: alcuni browser/webview non espongono `PublicKeyCredential` e gli script Google possono generare `ReferenceError` se manca la globale. Il fallback deve essere il primo script dei layout e va escluso dall'autoblocking Iubenda con `data-cmp-ab`/skip comments. Evitare `NoCaptcha::renderJs()` legacy nei layout quando e' gia presente `common.recaptcha`, perche' puo caricare `https://www.google.com/recaptcha/api.js?` anche con site key vuota.
- Su Crafto `inc_multilang` di Casa Bianca non sostituire `style.css`/`responsive.css` con `style.min.css`/`responsive.min.css`: il cambio ha rotto resa header, dimensione logo e posizione social.
- Su Crafto `inc_multilang`, `icon.min.css`, `vendors.min.css`, `crafto_custom.css` e GLightbox non sono risorse critiche per il primo render mobile: caricare i CSS non strutturali via preload/onload, preconnettere CDN/font, pre-caricare il logo e caricare GLightbox solo quando la pagina ha blocchi lightbox, con guard `typeof GLightbox` in `main.js`.
- Su Crafto `inc_center`, lo sticky header sotto il breakpoint mobile reale (`max-width:1450px`) deve mantenere la stessa altezza/logo del primo render usando `menubar_height` normalizzato, con background opaco e `overflow: visible` su navbar/container per non tagliare il collapse; durante `.navbar-collapse.collapsing` usare invece `overflow:hidden` e stesso background del menu per far muovere testo e sfondo insieme. Nascondere `default-logo`/`alt-logo`, mostrare solo `mobile-logo` e azzerare i padding sticky della brand. Nel range `992-1450px`, la colonna logo `col-lg-2` va forzata ad auto-width, altrimenti Bootstrap la stringe e taglia il logo.
- Per PageSpeed senza toccare CSS/JS, preferire interventi su header HTTP/cache, preconnect/font `display=swap`, attributi HTML immagine (`width`/`height`, `fetchpriority`, `decoding`) e caricamento condizionale di terze parti.
- Se emerge una regola stabile o un bug ricorrente: aggiornare subito `docs/ai-memory/project-memory.md` e un file in `docs/audits/`.
