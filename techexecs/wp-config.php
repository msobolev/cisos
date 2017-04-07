<?php

/**

 * The base configurations of the WordPress.

 *

 * This file has the following configurations: MySQL settings, Table Prefix,

 * Secret Keys, WordPress Language, and ABSPATH. You can find more information

 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing

 * wp-config.php} Codex page. You can get the MySQL settings from your web host.

 *

 * This file is used by the wp-config.php creation script during the

 * installation. You don't have to use the web site, you can just copy this file

 * to "wp-config.php" and fill in the values.

 *

 * @package WordPress

 */

if ( $_SERVER['HTTP_HOST'] == 'dev.ctosonthemove.com' ) {
   define('WP_HOME','http://dev.ctosonthemove.com/techexecs');
   define('WP_SITEURL','http://dev.ctosonthemove.com/techexecs');
}


// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define('DB_NAME', 'techexecs');



/** MySQL database username */

define('DB_USER', 'ctou2');



/** MySQL database password */

define('DB_PASSWORD', 'wTjP!399RD');



/** MySQL hostname */

define('DB_HOST', 'localhost');



/** Database Charset to use in creating database tables. */

define('DB_CHARSET', 'utf8');



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

define('AUTH_KEY',         'EzN%Ihr-vsP=+*j2aEsL');

define('SECURE_AUTH_KEY',  'FgttO!w6a3mgK9OBRdIt');

define('LOGGED_IN_KEY',    'V)6V3_9gwn$cSLIKqJm_');

define('NONCE_KEY',        '8V1pFJ27r+-+xFDmmcr8');

define('AUTH_SALT',        'r-gR(4kh6gF(0+***HII');

define('SECURE_AUTH_SALT', 'IQBI!HF&@/7vN)rHG)_1');

define('LOGGED_IN_SALT',   ')+%9ZqxXYbRRrskUDI$q');

define('NONCE_SALT',       '7hzGCVNa&t%y$&7(9@gI');



/**#@-*/



/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each a unique

 * prefix. Only numbers, letters, and underscores please!

 */

$table_prefix  = 'wp_';



/**

 * WordPress Localized Language, defaults to English.

 *

 * Change this to localize WordPress. A corresponding MO file for the chosen

 * language must be installed to wp-content/languages. For example, install

 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German

 * language support.

 */

define('WPLANG', '');



/**

 * For developers: WordPress debugging mode.

 *

 * Change this to true to enable the display of notices during development.

 * It is strongly recommended that plugin and theme developers use WP_DEBUG

 * in their development environments.

 */

define('WP_DEBUG', false);



/* That's all, stop editing! Happy blogging. */



/** Absolute path to the WordPress directory. */

if ( !defined('ABSPATH') )

	define('ABSPATH', dirname(__FILE__) . '/');



/** Sets up WordPress vars and included files. */

require_once(ABSPATH . 'wp-settings.php');

