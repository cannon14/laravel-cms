<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ccadmin');

/** MySQL database username */
define('DB_USER', 'dba');

/** MySQL database password */
define('DB_PASSWORD', 'dba');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ';w&8 {*wZF}/xt#oY^kRp.KrZ_A~=&&G0vF}s9TB/}hq)NREkw*PDlrt1V*xJR-q');
define('SECURE_AUTH_KEY',  'u`iwYK4n65)fxpnk27m7]+nho#:<XQRO 4[,UH<s++uKan-]Oj n<q|V2- qG)`<');
define('LOGGED_IN_KEY',    '_+:-:ugQzW`IodRU{_iOAgw+`vuPJ.`zcVAxB%`oH+N5G|jaUgr?o)L`eoee))!l');
define('NONCE_KEY',        ')U#+aRT0:ZU?Ok(R2|49?sn@>-[wg%w0-HypQq}[Q5C}MssP8^l-Z{y1X*>$~VN-');
define('AUTH_SALT',        'w(jFT<A*|@?MZ)NOAAN*GS>XXq8?]]W%/n3.Ua0tB?J!O1:@b]5XZjf|Leh0+~p{');
define('SECURE_AUTH_SALT', 'iyG8{b1dB+w=E7t|0}XP5(%I?^}3e`$*<xH`Ss|usgM{%[7f$+l_$0$zw[N<_XJ%');
define('LOGGED_IN_SALT',   '+2N/5A)eZ_x}D1-gc~{/%VyD>JT(.{#SYM+>^9~vg[S8,CSc2wnJw+E>QE1W1|Wl');
define('NONCE_SALT',       'QI}6]?^%<-Y==]+m]z:Rynka.4TZ+v/!L|-I+/V%chWVn9^#*}Oz-YE(vbyR#>$=');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
