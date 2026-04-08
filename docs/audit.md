# Audit

- 2026-04-07
  - Contesto: inizializzazione memoria persistente progetto in `docs/`.
  - Soluzione: creati `architecture.md`, `conventions.md`, `errors.md`, `audit.md`, `todo.md` con struttura base.
  - Note: definita regola di aggiornamento incrementale della documentazione.
- 2026-04-07
  - Contesto: restyling grafico dashboard Backpack (`resources/views/vendor/backpack/ui/dashboard.blade.php`).
  - Soluzione: introdotti hero card, quick action card moderne, miglioramenti visivi su card/tabelle/dropdown/progress con CSS scoped in `@section('after_styles')`, senza modifica della logica dati.
  - Rischio/Impatto: basso; possibile affinamento UI su viewport specifici da verificare in ambiente reale.
- 2026-04-07
  - Contesto: miglioramento grafico sidebar amministrativa (`resources/views/vendor/backpack/ui/inc/menu_items.blade.php`).
  - Soluzione: aggiunto CSS scoped alla sidebar Backpack (palette, hover, active state, dropdown items, badge) senza modifica di ruoli, permessi o routing.
  - Rischio/Impatto: basso; verificare contrasto colori su eventuali temi custom preesistenti.
- 2026-04-07
  - Contesto: fix regressione UI sidebar dopo primo tentativo di restyling.
  - Soluzione: aggiornati selettori CSS in `resources/views/vendor/backpack/ui/inc/menu_items.blade.php` per coprire `.sidebar/.sidebar-nav` reali e migliorato override stile dei link.
  - Rischio/Impatto: basso; impatto limitato alla resa grafica menu laterale.
- 2026-04-07
  - Contesto: richiesta utente di schiarire il fondo della sidebar admin.
  - Soluzione: aggiornato gradiente background in `resources/views/vendor/backpack/ui/inc/menu_items.blade.php` da palette blu notte a palette blu più chiara.
  - Rischio/Impatto: molto basso; variazione solo estetica.
- 2026-04-07
  - Contesto: affinamento grafico sidebar su richiesta utente (allineamento topbar + pulsanti chiari).
  - Soluzione: impostato sfondo sidebar a `#1B2A4E` (coerente con topbar), nav-link con sfondo bianco e testo blu, stato attivo/hover con sfondo grigio `#dfe3ea`.
  - Rischio/Impatto: molto basso; modifica solo cromatica e stato visivo dei menu.
- 2026-04-07
  - Contesto: richiesta di allineamento padding orizzontale nella sidebar.
  - Soluzione: uniformata la geometria dei pulsanti impostando sidebar-nav a `width: 100%` con `box-sizing: border-box` e allineata la freccia dei dropdown con `right: .78rem`.
  - Rischio/Impatto: molto basso; modifica solo di spaziatura/layout laterale.
- 2026-04-07
  - Contesto: rifinitura UI richiesta utente su sidebar e dashboard KPI.
  - Soluzione: submenu aperto sidebar reso con contenitore arrotondato (`border-radius`) e sfondo dedicato; in dashboard migliorata resa grafica dei box statistiche `Totale ordini` e `Totale prenotazioni` con card KPI interne, icone evidenziate e gerarchia tipografica più pulita.
  - Rischio/Impatto: basso; modifiche solo di presentazione CSS.
- 2026-04-07
  - Contesto: correzione difetto visivo su submenu aperto sidebar (angoli bianchi residui).
  - Soluzione: reso il contenitore `nav-dropdown.open` la superficie unica del blocco aperto (`border-radius` + `overflow: hidden`), rimosso fondo separato del link/header e del box interno.
  - Rischio/Impatto: molto basso; impatto solo estetico sullo stato open della sidebar.
- 2026-04-07
  - Contesto: richiesta utente di rendere più elegante e raffinata la sezione Top 10 in dashboard.
  - Soluzione: migliorato styling carousel Top 10 (header gradient, titoli, dropdown pill) e tabelle (`table-top-*`) con righe a card, tipografia più pulita, ranking evidenziato e maggiore gerarchia visiva.
  - Rischio/Impatto: basso; solo modifica UI/CSS senza impatto su query e logica dati.
- 2026-04-07
  - Contesto: richiesta gestione GIF dashboard configurabile da `Website Setting > Extra`.
  - Soluzione: aggiunto campo `dashboard_gif` nel CRUD `WebsiteSetting` (tab Extra), creata migration per colonna `website_settings.dashboard_gif`, aggiornata dashboard per usare la GIF configurata e fallback automatico a `img/dashboard.gif` se non valorizzata.
  - Rischio/Impatto: basso; necessario eseguire migration prima dell'uso del nuovo campo.
- 2026-04-07
  - Contesto: fix migration fallita per aggiunta campo `dashboard_gif` su `website_settings`.
  - Soluzione: modificata migration `2026_04_07_120000_add_dashboard_gif_website_settings_table` usando `TEXT` invece di `VARCHAR` per evitare errore MySQL `1118 Row size too large`.
  - Rischio/Impatto: basso; nessun impatto logico applicativo, solo tipo colonna DB.
- 2026-04-07
  - Contesto: fix errore SQL 1064 su dettaglio prodotto quando lo slug URL contiene apici/caratteri inattesi.
  - Soluzione: in app/Http/Controllers/PluginProductsController.php sostituite query whereRaw con interpolazione slug in query bindate (LIKE ?) nei lookup slug del dettaglio prodotto.
  - Rischio/Impatto: basso; comportamento invariato sugli slug validi, sugli slug malformati si torna al flusso 404 senza eccezione SQL.


- 2026-04-07
  - Contesto: richiesta impostazione font dedicato al pannello admin da Website Setting > Google Font.
  - Soluzione: aggiunto campo admin_panel_font nel CRUD WebsiteSetting, creata migration 2026_04_07_130500_add_admin_panel_font_website_settings_table e applicato il font nel layout admin (menu_items.blade.php) con validazione URL su dominio fonts.googleapis.com e parsing della family.
  - Rischio/Impatto: basso; impatto solo UI admin, font applicato solo quando URL e family sono validi.

- 2026-04-07
  - Contesto: richiesta miglioramento grafico pagine admin login e recupero password.
  - Soluzione: restyling delle view Backpack `auth/login`, `auth/passwords/email` e `auth/passwords/reset` con nuovo layout visuale (gradient background, card moderne, tipografia Manrope, miglioramento gerarchia visiva e campi form), mantenendo invariata la logica di autenticazione.
  - Rischio/Impatto: basso; modifica solo presentazionale sulle pagine auth admin, nessun impatto su validazione/route/controller.

- 2026-04-07
  - Contesto: richiesta miglioramento UI topbar admin su link `Anteprima Sito` e dropdown utente (click sulla lettera/avatar).
  - Soluzione: aggiornati `inc/topbar_right_content` e `inc/menu_user_dropdown` del tema Backpack CoreUIv2 con stile moderno (pill button, avatar circolare gradient, dropdown card con hover e icone più leggibili), senza modificare destinazioni link o permessi.
  - Rischio/Impatto: basso; impatto solo estetico sulla topbar admin.

- 2026-04-07
  - Contesto: richiesta personalizzazione grafica admin con controlli da `Website Setting > Extra` (topbar, leftbar, sfondo login).
  - Soluzione: aggiunti campi `admin_topbar_background`, `admin_leftbar_background`, `admin_login_background` nel CRUD `WebsiteSetting`, creata migration dedicata e collegata la resa UI: gradient dinamico topbar/leftbar basato sui colori scelti, hover link anteprima coerente col colore topbar, login con sfondo immagine responsive e fallback bianco se non configurato.
  - Rischio/Impatto: basso; impatto solo presentazionale su pannello admin.

- 2026-04-07
  - Contesto: correzione regressioni UI dopo primo rilascio personalizzazione admin (color picker con alpha, avatar `W`, apertura menu Catalogo).
  - Soluzione: normalizzazione colori admin estesa a formato HEX 8 cifre (`#RRGGBBAA`) per evitare fallback involontario; raffinato stile avatar topbar per eliminare effetto quadrato; aggiornato criterio apertura `Catalogo Prodotti` per aprirsi solo su route del suo sottomenu (allineato al comportamento di `ShopFormula`).
  - Rischio/Impatto: basso; modifica mirata a logica visuale menu e resa cromatica admin.

- 2026-04-07
  - Contesto: richiesta pulsante `torna su` nelle pagine admin con scrollbar.
  - Soluzione: aggiunto bottone fixed con comparsa dinamica al superamento della soglia di scroll e scroll smooth verso l'alto, implementato nei layout `top_left` tema CoreUIv2 e Base.
  - Rischio/Impatto: basso; modifica solo UX/UI lato admin, senza impatto su logica business.

- 2026-04-07
  - Contesto: richiesta default logo admin nei campi `Logo pannello admin` e `Logo accesso admin`.
  - Soluzione: impostati default nei campi CRUD (`public/img/commons/admin/logo-dashboard-CMS6_s2.png` e `public/img/commons/admin/logo-dashboard-CMS6_s2_login.png`) e allineati i fallback visuali in header admin/login/reset password.
  - Rischio/Impatto: basso; impatto solo presentazionale, nessuna modifica a permessi o flussi auth.

- 2026-04-08
  - Contesto: warning PHP in frontend su `getimagesize(uploads/logo/logo-sbalchiero.png): Failed to open stream` in `resources/views/Crafto/inc/header_menu.blade.php`.
  - Soluzione: introdotto controllo su path filesystem reale con `public_path(...)` + `is_file(...)` prima di invocare `getimagesize`, con fallback sicuro senza attributi `width/height` quando il file non esiste.
  - Rischio/Impatto: basso; modifica locale alla view Crafto, elimina warning mantenendo invariata la resa quando il logo è presente.

- 2026-04-08
  - Contesto: richiesta ottimizzazione query in `PluginProductsController` mantenendo logica e risultati invariati.
  - Soluzione: rimosso doppio filtro categorie ridondante nelle query principali del listing prodotti e aggiunta migration `2026_04_08_121500_add_performance_indexes_plugin_products_queries.php` con indici mirati su tabelle coinvolte (`plugins_products`, `plugins_products_search`, `plugins_products_categories`, `pages`, `shop_attributes_products`, `plugins_products_categories_products`, `shop_promotions`).
  - Rischio/Impatto: medio-basso; nessuna modifica funzionale lato business, ma aumento costo scrittura su tabelle indicizzate e possibile variazione piani query da validare in staging.

- 2026-04-08
  - Contesto: ulteriore ottimizzazione performance frontend (document `/balconiere`) su `PluginProductsController`.
  - Soluzione: ridotte query N+1 su menu frontend introducendo helper `getFrontendMenuTree()` (2 query totali invece di 1+N), ridotto N+1 nel recupero figli categorie in listing, interrotto lookup lingua al primo match e stabilizzato generazione `special_urls` evitando crescita durante iterazione.
  - Rischio/Impatto: basso; output invariato, possibile minima differenza solo in casi anomali di slug duplicati su più lingue (ora ci si ferma al primo match).

- 2026-04-08
  - Contesto: richiesta miglioramento layout moderno per pagina admin Elfinder (`/admin/elfinder`).
  - Soluzione: restyling scoped in `resources/views/vendor/elfinder/elfinder.blade.php` (shell card con gradient, toolbar rifinita, sidebar/cartelle, tabella file, stati hover/selected, status bar e responsive), senza modificare logica JS e funzioni file manager.
  - Rischio/Impatto: basso; modifica solo visuale sulla schermata Elfinder standalone.
- 2026-04-08
  - Contesto: regressione leggibilità UI Elfinder dopo restyling (icone toolbar poco visibili, testo cartelle/file non leggibile in hover/selected).
  - Soluzione: aggiornato CSS scoped in `resources/views/vendor/elfinder/elfinder.blade.php` aumentando contrasto toolbar (background scuro + hover coerente) e forzando colori testo su tree/cwd per stati normal/hover/selected.
  - Rischio/Impatto: molto basso; fix solo visuale su pagina Elfinder.
