# Audit News mysql_2 configurabile via env (2026-04-15)

## Contesto
- Le news admin vengono lette dalla connessione `mysql_2` (DB gestionale esterno).
- In locale, con host fisso hardcoded, non era possibile puntare al DB corretto del gestionale.

## Causa radice
- Parametri `mysql_2` hardcoded in `config/database.php`:
  - host, database, username, password.
- Impossibilità di differenziare in modo pulito ambiente locale/staging/produzione.

## Soluzione applicata
- Resa `mysql_2` configurabile via variabili ambiente:
  - `DB_HOST_GEST`
  - `DB_PORT_GEST`
  - `DB_DATABASE_GEST`
  - `DB_USERNAME_GEST`
  - `DB_PASSWORD_GEST`
- Mantenuti fallback ai valori precedenti per retrocompatibilità.
- Aggiornato `.env.example` con le nuove chiavi.

## File coinvolti
- `config/database.php`
- `.env.example`

## Rischio/Impatto
- Basso: nessuna modifica di flusso applicativo, solo parametrizzazione.
- Richiede allineamento `.env` locale per vedere le news del gestionale.
