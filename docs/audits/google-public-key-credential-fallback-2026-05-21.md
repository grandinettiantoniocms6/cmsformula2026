# Audit fallback PublicKeyCredential per script Google (2026-05-21)

## Contesto
- In console compariva `Uncaught ReferenceError: PublicKeyCredential is not defined` da uno script Google minificato (`index.js`) durante il caricamento di risorse collegate a Google Maps/reCAPTCHA.

## Causa individuata
- Alcuni browser o webview non espongono la globale WebAuthn `PublicKeyCredential`.
- Gli script Google esterni possono accedere a `PublicKeyCredential` senza un guard completo, generando `ReferenceError` prima del resto del codice pagina.
- Su `/contatti` lo script era ancora caricato da `NoCaptcha::renderJs()` legacy in `resources/views/index.blade.php`, attivato quando la pagina contiene un form. In `Webshop/layout.blade.php` la stessa chiamata era dentro un commento HTML: Blade la valutava comunque lato server.

## Implementazione
- Creato il partial `resources/views/common/google_public_key_credential_fallback.blade.php`.
- Il fallback definisce una compatibilita' minima solo se `window.PublicKeyCredential` non esiste gia'.
- Incluso il partial prima di `recaptcha/api.js`, `recaptcha_ajax` e dello script Google Maps Places del campo Backpack `address_google`.
- Spostato lo stesso fallback come primo script nei layout frontend `Webshop`, `Bexo`, `Corporate1`, `Corporate2` e `Crafto`, per coprire anche script Google caricati da Iubenda/Tag Manager prima del blocco `recaptcha`.
- Aggiunto fallback anche all'inizio di `common.tag_analytics`, per coprire Google Tag Manager/Google Ads che possono iniettare script Google con dipendenze WebAuthn.
- Convertito il fallback in asset locale `public/js_common/public-key-credential-fallback.js` e marcato il partial con esclusione autoblocking Iubenda (`data-cmp-ab="2"` e commenti `IUB-COOKIE-BLOCK-SKIP`), per evitare che la CMP blocchi proprio lo shim.
- Rimosso il caricamento duplicato `NoCaptcha::renderJs()` da `resources/views/index.blade.php`, lasciando `common.recaptcha` come unico punto di gestione.
- Convertiti i commenti HTML con `NoCaptcha::renderJs()` in commenti Blade nei layout `Webshop`, `Bexo`, `Corporate1` e `Corporate2`, e rimossi i caricamenti legacy diretti dai layout Bexo/Corporate.

## Verifiche
- Eseguito lint PHP sui Blade modificati con PHP 8.2 Laragon: nessun errore di sintassi.
- Eseguito `php artisan view:clear`.
- Verificata `http://cmsformula2025.test/contatti` nel browser: non viene piu' renderizzato `https://www.google.com/recaptcha/api.js?` e non risultano errori console.
- Dopo ulteriore segnalazione con stack da `map.js`, verificata la pagina con fallback anticipato e marcato per Iubenda: nessun errore console nel browser di test.

## Rischi e controlli
- Rischio basso: nei browser moderni con WebAuthn reale il fallback non interviene.
- Controllo consigliato: ricaricare la pagina che mostrava l'errore con cache svuotata e verificare che reCAPTCHA/Google Places continuino a funzionare dove presenti.
