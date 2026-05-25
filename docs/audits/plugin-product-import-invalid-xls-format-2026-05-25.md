# Audit import prodotti: file XLS non valido (2026-05-25)

## Contesto
- Il caricamento Import SPECIAL di un file con estensione `.xls` restituiva HTTP 500.
- L'errore mostrato da PhpSpreadsheet era `not recognised as an OLE file`.

## Causa individuata
- Un file `.xls` Excel 97-2003 deve essere un documento binario OLE.
- Il file caricato aveva estensione `.xls`, ma contenuto non riconoscibile dal reader XLS; il caso tipico e' un CSV, HTML o `.xlsx` rinominato anziche' salvato nel formato corretto.
- L'eccezione del reader non era intercettata dal controller e veniva quindi esposta come errore server.

## Implementazione
- Intercettata `PhpOffice\PhpSpreadsheet\Reader\Exception` nei due punti di lettura Excel dell'import speciale.
- In caso di formato non valido il controller risponde con HTTP 422 e un messaggio operativo, invece di generare una pagina 500.
- Normalizzata l'estensione del file in minuscolo, cosi' `.XLS`/`.XLSX` vengono trattati come formati Excel.
- L'interfaccia ora mostra il testo dell'errore restituito dal server in modo escapato e indica esplicitamente il supporto a `.csv`, `.xls` e `.xlsx`.

## Verifiche
- Eseguito lint PHP su `app/Http/Controllers/Admin/PluginProductImportCrudController.php` e `resources/views/vendor/backpack/ui/plugins/pluginProducts/import_export.blade.php`: nessun errore di sintassi.
- Controllo funzionale consigliato: caricare un file non OLE rinominato `.xls` e verificare la comparsa dell'avviso; quindi caricare un `.xls` o `.xlsx` esportato realmente da Excel/LibreOffice.

## Rischi e controlli
- Rischio basso: i file validi continuano a essere letti dallo stesso flusso.
- Un file con estensione incoerente viene rifiutato con istruzioni per salvarlo nel formato corretto, anziche' essere interpretato automaticamente in modo ambiguo.
