# Errors

- Nessun errore storico registrato al bootstrap della documentazione.
- Regola: quando emerge un errore, aggiungere una voce con:
  - data
  - contesto
  - causa radice
  - soluzione
  - prevenzione
- 2026-04-07
  - Contesto: restyling sidebar non visibile dopo prima modifica.
  - Causa radice: selettori CSS troppo specifici (`.app-body .sidebar.sidebar-pills`) non allineati al markup effettivo della sidebar renderizzata.
  - Soluzione: adottati selettori più robusti (`.sidebar`, `.sidebar-nav`, `.sidebar .nav-link`) con priorità `!important` solo dove necessario.
  - Prevenzione: prima di applicare tema sidebar, verificare sempre classi reali nel DOM renderizzato e non solo convenzioni attese.
- 2026-04-07
  - Contesto: migration `add_dashboard_gif_website_settings_table` fallita in produzione locale.
  - Causa radice: tabella `website_settings` vicina al limite MySQL di dimensione riga (65535 byte), aggiunta colonna `VARCHAR` non consentita.
  - Soluzione: cambiata colonna `dashboard_gif` da `string` a `text` nella migration.
  - Prevenzione: su tabelle legacy molto larghe, preferire `TEXT` per nuovi campi opzionali di tipo path/url.
- 2026-04-07
  - Contesto: errore SQL 1064 su URL prodotto con slug malformato (decreaseValue(') nella route dettaglio shop.
  - Causa radice: interpolazione diretta dello slug in whereRaw("slug LIKE ...") in PluginProductsController, con apice non escapato che spezza la query.
  - Soluzione: sostituite le query raw con placeholder bindati (whereRaw("slug LIKE ?", [...])) nei punti di lookup slug coinvolti nel flusso dettaglio.
  - Prevenzione: per qualunque whereRaw con valori dinamici usare sempre binding parametrico ed evitare concatenazione stringhe SQL.
- 2026-04-08
  - Contesto: warning PHP su header frontend Crafto durante render logo (`getimagesize(...): Failed to open stream: No such file or directory`).
  - Causa radice: `getimagesize` invocato su path relativo DB (`uploads/...`) non risolto come path locale assoluto e senza verifica esistenza file.
  - Soluzione: conversione preventiva del path con `public_path(ltrim(...))` e guardia `is_file(...)` prima della lettura dimensioni immagine.
  - Prevenzione: nelle view Blade evitare `getimagesize` su URL/path relativi non verificati; usare sempre path filesystem assoluto e fallback senza warning se risorsa assente.
- 2026-04-08
  - Contesto: eccezione `UrlGenerationException` su route `pluginProducts.detail.*` dopo ottimizzazione del listing.
  - Causa radice: nel mapping categorie prodotto veniva passato a `route()` lo slug JSON multilingua completo (es. `{"it":"...","en":"..."}`) invece della stringa slug della lingua corrente.
  - Soluzione: introdotta risoluzione traduzioni in controller per `slug` e `name` (`resolveTranslatedText` con fallback lingua), usando valori scalari nei partial listing.
  - Prevenzione: quando si estraggono campi translatable direttamente da query SQL raw, normalizzare sempre il valore per lingua prima di usarlo in URL o route params.
- 2026-04-08
  - Contesto: errore PHP `Undefined array key "it"` durante rendering listing prodotti.
  - Causa radice: accesso a cache statica per lingua (`listingLangImagesByProduct[$lang]`) senza inizializzazione preventiva della chiave lingua.
  - Soluzione: inizializzazione del bucket lingua prima di lettura/scrittura in `preloadForListing` e `getListingLangImageForProduct`.
  - Prevenzione: su cache statiche multidimensionali indicizzate per lingua/tenant, inizializzare sempre la chiave padre prima di `array_key_exists`/assegnazioni annidate.


- 2026-04-08
  - Contesto: progress bar upload import prodotti parte subito da 100% pur con attesa di diversi secondi.
  - Causa radice: il 100% dell'evento `uploadProgress` indica fine trasferimento file, non fine elaborazione backend dell'import.
  - Soluzione: introdotto avanzamento visuale controllato fino a ~95% e stato `Elaborazione...`; 100% impostato solo in callback `success`/redirect.
  - Prevenzione: nei flussi di upload+processing non usare il solo `uploadProgress` come indicatore di completamento totale, separare fase upload da fase elaborazione server.

- 2026-04-08
  - Contesto: logo topbar admin renderizzato con URL contenente `/public/` (`.../public/img/...`).
  - Causa radice: path logo salvato o fallback già prefissato con `public/` e poi passato a `url(...)` senza normalizzazione.
  - Soluzione: introdotta normalizzazione path (`^/?public/` rimosso) prima del render e uso di `asset(...)` nei main header Backpack.
  - Prevenzione: per asset pubblici in Blade, evitare hardcode `public/...` negli URL finali e centralizzare una normalizzazione del path.


