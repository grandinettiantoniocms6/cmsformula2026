## Scope
Questo progetto è un'applicazione Laravel che utilizza Backpack.
Le attività principali sono: CRUD, bugfix, refactor mirati, manutenzione e interventi su interfaccia amministrativa.

## Lingua
- Rispondi sempre in italiano.
- Scrivi in italiano analisi, piano di lavoro, riepiloghi finali, note sui rischi e spiegazioni delle modifiche.
- Mantieni nomi di classi, metodi, variabili e termini tecnici coerenti con il codice esistente.

## Stack tecnico
- Laravel + Backpack
- Preferire `composer` e `php artisan` per workflow e verifiche.
- Rispettare prima di tutto le convenzioni già presenti nel repository.

## Lettura obbligatoria prima delle modifiche
- Leggi `docs/ai-memory/project-memory.md` prima di proporre o applicare modifiche.
- Leggi l'ultimo file presente in `docs/audits/` prima di intervenire.
- Se documentazione e codice sono in conflitto, considera il codice come fonte primaria e segnala che la documentazione va aggiornata.

## Regole operative
- Favorisci modifiche minime, mirate e a basso rischio.
- Non fare refactor ampi se non esplicitamente richiesti.
- Non introdurre nuove astrazioni senza verificare prima se il progetto usa già un pattern equivalente.
- Non eseguire comandi distruttivi salvo richiesta esplicita.
- Preserva struttura, naming e convenzioni del progetto.

## Regole per bugfix
- Correggi la causa radice del problema, non solo il sintomo visibile.
- Valuta impatti collaterali su CRUD Backpack, validazione, permessi, filtri, salvataggi e aggiornamenti.
- Quando possibile, proponi o aggiungi un test di regressione.
- Se emerge una regola stabile, aggiorna `docs/ai-memory/project-memory.md` e crea o aggiorna un file in `docs/audits/`.

## Attenzioni Laravel / Backpack
- Fai attenzione a validazione, mass assignment, cast, accessor/mutator, scope, eventi dei model e observer.
- Fai attenzione a configurazioni Backpack: campi, colonne, filtri, operazioni CRUD, accesso e flussi di salvataggio.
- Evidenzia sempre rischi su query Eloquent, N+1, migration, permessi/policy e compatibilità retroattiva.

## Stile del codice
- Mantieni il codice leggibile e coerente con i pattern esistenti.
- Aggiungi commenti solo quando la logica non è immediata.
- Evita rinomine, spostamenti file o riscritture stilistiche non necessarie.

## Preferenze comandi
- Consentiti: `composer`, `php artisan`
- Evita altri tool salvo richiesta esplicita.

## Output atteso
- Riassumi sempre cosa hai modificato.
- Indica assunzioni, dubbi o punti da verificare.
- Evidenzia eventuali rischi di regressione o controlli successivi consigliati.

## Aggiornamento documentazione persistente
- Aggiorna i file in `docs/` solo quando dalla modifica emerge conoscenza stabile utile per future sessioni.
- Aggiorna `docs/ai-memory/project-memory.md` quando identifichi una convenzione reale del repository, un rischio ricorrente, un anti-pattern o una regola tecnica da ricordare.
- Crea o aggiorna un file in `docs/audits/` quando risolvi un bug significativo, una regressione o un errore con causa radice chiara.
- Aggiorna checklist o template solo se emerge un controllo mancante che può prevenire errori futuri.
- Non aggiornare la documentazione per modifiche locali, cosmetiche o prive di insegnamenti generali.
- Se aggiorni `docs/`, indica nel riepilogo finale cosa hai aggiornato e perché.
