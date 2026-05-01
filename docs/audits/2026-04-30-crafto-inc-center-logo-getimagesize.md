# Audit Crafto inc_center logo getimagesize (2026-04-30)

## Contesto
- Nel template `resources/views/Crafto/inc_center/header_menu.blade.php` il logo del sito viene letto da un campo admin.
- In locale il database puo puntare a un file logo non presente sul filesystem.

## Errore riscontrato
- La view chiamava `getimagesize()` direttamente su `$website->logo` e `$website->logo2`.
- Se il file non esisteva o non era leggibile, il rendering poteva fallire con warning/errore PHP e bloccare l'admin/frontend collegato alla view.

## Causa radice
- Il codice assumeva che il path salvato da admin fosse sempre leggibile dal processo PHP.
- Mancava un controllo filesystem prima di leggere le dimensioni immagine.

## Correzione applicata
- Risoluzione del path tramite `public_path(ltrim(...))`.
- Controllo `is_file()` prima di chiamare `getimagesize()`.
- Uso difensivo di `@getimagesize()` e aggiunta degli attributi `width`/`height` solo quando le dimensioni sono disponibili.

## Impatto
- Se il logo manca in locale, la pagina non si rompe.
- Se il file esiste, gli attributi `width`/`height` continuano a essere valorizzati.

## Verifiche
- `C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.exe -l resources/views/Crafto/inc_center/header_menu.blade.php`

## Rischi residui
- Altri template contengono ancora chiamate dirette a `getimagesize()` e potrebbero avere lo stesso problema se usati con immagini mancanti.
