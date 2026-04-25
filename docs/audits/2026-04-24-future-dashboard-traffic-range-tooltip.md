# Audit Future Dashboard Traffic Range Tooltip (2026-04-24)

## Contesto
- Nel widget "Traffico del sito" i pulsanti `7/30/90 giorni` erano solo estetici e il grafico non mostrava valore visite puntuale al passaggio mouse.

## Causa radice
- Rendering custom canvas statico senza stato range e senza gestione hover/tooltip.
- Dati inizialmente limitati a 7 giorni.

## Soluzione applicata
- Estesa serie dati a finestra 90 giorni da `frontend_page_visits_daily`.
- Integrato rendering con Chart.js (line chart) nel dashboard `future`.
- Pulsanti `7/30/90` collegati a update reale di labels/dataset.
- Tooltip attivo su hover con valore reale visite (`X visite`).

## Impatto/Rischio
- Basso: modifica limitata al widget grafico dashboard `future`.
- Nota: storico disponibile solo per i giorni presenti in tabella visite.
