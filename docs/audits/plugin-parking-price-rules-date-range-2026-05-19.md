# Audit regole prezzo plugin parking (2026-05-19)

## Contesto
- Endpoint analizzato: `/ajax/plugin_parking/calculate_price`.
- Con richiesta `type=1`, `date_start=19-05-2026`, `date_end=25-05-2026`, nella risposta comparivano rules future con `date_start`/`date_end` successive al periodo prenotato.

## Causa individuata
- In `PluginParkingController::calculate_price()` la stessa istanza `Carbon` veniva prima arretrata con `subDay()` e poi avanzata nel ciclo disponibilita con `addDay()`.
- Lo stesso oggetto veniva riutilizzato nel ciclo successivo delle rules, quindi il controllo promo partiva dopo la data di uscita e poteva intercettare regole future.
- Il campo JSON `rules` veniva inoltre popolato con tutte le rules della tariffa (`plugin_parking_price_id`) senza filtro su periodo o tipologia.

## Implementazione
- Separati i cursori data per controllo disponibilita e controllo rules usando `copy()`.
- Allineato il ciclo rules alla durata reale della prenotazione (`$i < $diff`), come gia avviene per la disponibilita.
- Limitato il campo JSON `rules` alle rules della stessa tipologia che si sovrappongono al periodo richiesto.

## Verifiche
- Eseguito lint PHP su `app/Http/Controllers/PluginParkingController.php`: nessun errore di sintassi.

## Rischi e controlli
- Rischio funzionale basso: non sono stati modificati listino base, formule sconto/sovrapprezzo o priorita della prima rule trovata.
- Controllo consigliato: provare dal form frontend una prenotazione `19-05-2026` - `25-05-2026` e verificare che non vengano restituite rules future, poi provare un intervallo che attraversa realmente una rule per confermare lo sconto.
