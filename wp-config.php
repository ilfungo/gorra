<?php
/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file definisce le seguenti configurazioni: impostazioni MySQL,
 * Prefisso Tabella, Chiavi Segrete, Lingua di WordPress e ABSPATH.
 * E' possibile trovare ultetriori informazioni visitando la pagina: del
 * Codex {@link http://codex.wordpress.org/Editing_wp-config.php
 * Editing wp-config.php}. E' possibile ottenere le impostazioni per
 * MySQL dal proprio fornitore di hosting.
 *
 * Questo file viene utilizzato, durante l'installazione, dallo script
 * di creazione di wp-config.php. Non � necessario utilizzarlo solo via
 * web,� anche possibile copiare questo file in "wp-config.php" e
 * rimepire i valori corretti.
 *
 * @package WordPress
 */
 
//error_reporting(E_ALL & ~~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 

define( 'WP_MEMORY_LIMIT', '512M' );
// ** Impostazioni MySQL - E? possibile ottenere questoe informazioni
// ** dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
//define('DB_NAME', 'federico17947');
define('DB_NAME', 'federic6_gorra');

/** Nome utente del database MySQL */
//define('DB_USER', 'federico17947');
define('DB_USER', 'federic6_f43844');

/** Password del database MySQL */
//define('DB_PASSWORD', 'fede66187');
define('DB_PASSWORD', 'dSon3Fh3u55LBrL');

/** Hostname MySQL  */
//define('DB_HOST', 'sql.federicoporta.com');
define('DB_HOST', 'localhost');

/** Charset del Database da utilizare nella creazione delle tabelle. */
define('DB_CHARSET', 'utf8');

/** Il tipo di Collazione del Database. Da non modificare se non si ha
idea di cosa sia. */
define('DB_COLLATE', '');

/**#@+
 * Chiavi Univoche di Autenticazione e di Salatura.
 *
 * Modificarle con frasi univoche differenti!
 * E' possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 * E' possibile cambiare queste chiavi in qualsiasi momento, per invalidare tuttii cookie esistenti. Ci� forzer� tutti gli utenti ad effettuare nuovamente il login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'C#aiHicX4kZPi|>|XA(MZdb5+*s)]TKRRwp?=}1e?/*|EO(2wvT%o{|1$W$@!}{5');
define('SECURE_AUTH_KEY',  'AKV^zEnYUzI34$)Hk8pa|F<xfIM)Pt`dv.4};+SG#m*)PTMsby)-z7uYuZdDGd.>');
define('LOGGED_IN_KEY',    '4Z.U--B#[Mms*-a$tJf`R% >RnjgAnMHYYP|PZ./f75%ZI5j-3H[5N/f%Zh_08:^');
define('NONCE_KEY',        '`s@5dwK2W:jRC1V-D:-|6qM;8hz/8laBg7HO!ocEQD8ilp^JtN`>%R%?j9P>!w^5');
define('AUTH_SALT',        'uW+(S#YQ0y`L&2~O65p^-ip.hslqv:X(G$G*cPhx@+HaZ)L-fn+[G>=}/`Rmfaq7');
define('SECURE_AUTH_SALT', '-L3,_ ~]Iq-)B[=FOwb=eO$y:k&6HNoaO_CS:t)A31?=8#+wG29cb_&SBehi*LP9');
define('LOGGED_IN_SALT',   '}9v5SEf}#zX+$@JV/,e~fzS=}X{*t[9fl^^nUm:S9Y`RsFH0kKA}jU%D+A]0Om;C');
define('NONCE_SALT',       'h1U4GA76DqYCga?C[EQ85<$rE!}pCUO+ N<HXd<L9Ap7|B:D@dP%Dbr,U%qU[,1x');

/**#@-*/

/**
 * Prefisso Tabella del Database WordPress .
 *
 * E' possibile avere installazioni multiple su di un unico database if you give each a unique
 * fornendo a ciascuna installazione un prefisso univoco.
 * Solo numeri, lettere e sottolineatura!
 */
$table_prefix  = 'wp_';

/**
 * Lingua di Localizzazione di WordPress, di base Inglese.
 *
 * Modificare questa voce per localizzare WordPress. Occorre che nella cartella
 * wp-content/languages sia installato un file MO corrispondente alla lingua
 * selezionata. Ad esempio, installare de_DE.mo in to wp-content/languages ed
 * impostare WPLANG a 'de_DE' per abilitare il supporto alla lingua tedesca.
 *
 * Tale valore è già impostato per la lingua italiana
 */
define('WPLANG', 'it_IT');

/**
 * Per gli sviluppatori: modalità di debug di WordPress.
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi
 * durante lo sviluppo.
 * E' fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all'interno dei loro ambienti di sviluppo.
 */

//define('SAVEQUERIES', true);

//il debug � ridefinito in functions
// Enable WP_DEBUG mode
define('WP_DEBUG', true);

// Enable Debug logging to the /wp-content/debug.log file
define('WP_DEBUG_LOG', false);

// Disable display of errors and warnings 
//define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors',0);

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define('SCRIPT_DEBUG', false);


/* Finito, interrompere le modifiche! Buon blogging. */

/** Path assoluto alla directory di WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Imposta lle variabili di WordPress ed include i file. */
require_once(ABSPATH . 'wp-settings.php');
