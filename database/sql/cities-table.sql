CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `codice_istat` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nome_comune` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nome_comune_uri` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `capoluogo` enum('S','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `sigla_provincia` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sigla_regione` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `regione` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `regione_uri` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `prefisso_telefonico` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cap` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `codice_catastale` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;