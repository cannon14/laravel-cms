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
define('AUTH_KEY',         'q/L+,cf*4`1k;+e-A=0RiTmzL`bjPG@,vd:6q{BAoYo(=}+7},i$/#PtmyK%)(}#');
define('SECURE_AUTH_KEY',  'a9WR<(Y+mWjeT5g?*h+jdBa%zuR(g755+bKAvz*!h>>UJ79{$GmbfJfH]OiyHy*,');
define('LOGGED_IN_KEY',    'X1B*ku6S[I(yC:/~5`aR;?Ee*&E cNI.NwwLHuIY2vu sU;0V|6UR*T?Rd+h+|Vq');
define('NONCE_KEY',        'cKvdY:F&wFvUt.n~Re_}1#M[ :A{3,TvPM+7$mXvc7b0@iP)y]%0k=[<iz2NLRJ[');
define('AUTH_SALT',        '+xrlVq/*)ldM+W+KbhJSKK@<(G[T-4L,]TbN{U TSIu#YgE1n,.R-SxvOK)q+;P!');
define('SECURE_AUTH_SALT', 'oKYwQIdiY7|WY08t9v3X+S~wa!nM=`HTnjKCE%$X]!-ZJ8(p)yn<i%}F%gSj~*6)');
define('LOGGED_IN_SALT',   ']8u2k)!ptK3xEp+2Nw8^|V!-js=p>#/vvuUU`onIs,erXTth,n^^+=a&OmmCJ7O/');
define('NONCE_SALT',       '%5sEs~!^m|ep{R5W1mN<ZcZj=oa&a/_:z|- d=3NF<FbIf|?r|X:ckqK5n*OTs;+');

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
