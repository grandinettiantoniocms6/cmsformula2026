# Audit Crafto: feedback form contatti dopo honeypot (2026-05-26)

## Contesto
- Dopo la rimozione/condizionamento di Google reCAPTCHA e l'introduzione dell'honeypot, i form del template Crafto non mostravano correttamente i feedback nella pagina contatti.
- I sintomi erano: campi obbligatori non evidenziati visivamente e messaggio inviato senza conferma visibile.

## Causa individuata
- Il bottone del `blockPluginForm` Crafto usava la classe `.submit`, agganciata dal JavaScript del tema Crafto.
- L'handler AJAX del tema si aspetta una risposta JSON con `alert` e `message`, mentre i controller Laravel dei form (`contact_form_send`) restituiscono redirect con flash message.
- Il form `blockContact` Crafto non includeva l'honeypot e non aveva un marcatore dedicato per una validazione frontend scoped.

## Implementazione
- Aggiunto `data-crafto-contact-form="1"` ai form Crafto `blockContact` e `blockPluginForm`.
- Aggiunto `@honeypot` anche al form Crafto `blockContact`.
- Rimossa la classe `.submit` dal bottone Crafto `blockPluginForm`, lasciando il submit nativo Laravel con redirect e flash message.
- Aggiunta nel layout Crafto una validazione visuale scoped ai form marcati, con classe `is-invalid` sui campi obbligatori non validi.

## Verifiche
- Eseguito `php artisan view:clear`.
- Eseguito `php artisan view:cache`: compilazione Blade completata correttamente.

## Note
- Non e' stata eseguita una verifica browser end-to-end nella sessione.
- Se in futuro si vuole usare AJAX sui form Crafto, i controller dovranno restituire JSON coerente con l'handler del tema oppure l'handler dovra' gestire redirect/HTML.
