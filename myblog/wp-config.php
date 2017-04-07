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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ctoblog');

/** MySQL database username */
define('DB_USER', 'ctoblog');

/** MySQL database password */
define('DB_PASSWORD', '81796b574859');

/** MySQL hostname */
define('DB_HOST', 'ctoblog.db.5330536.hostedresource.com');

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
define('AUTH_KEY',         ';yzP-eiia#r-@fwHZJC4F|7^XOEOh`PcD~:v{^%}/A+9Id63jyNrs5`:tCxLIzS[');
define('SECURE_AUTH_KEY',  'q`-$fi,]U3E&`dbMw9mI@6gd=v:vq4%!S2j]-gA-F(&BxZ*EN{|;UVUYDszMv+.z');
define('LOGGED_IN_KEY',    '4w[<ugYy:k{ _T3|sR}4$N8KVxrG6A1FLk]lJ:LvOdQ+x`xrwP:%7UPl`ZPVIH5`');
define('NONCE_KEY',        'c[*qm)*plXO|8}G~=}hB]yQ/.m{f Xeazk0A%ta^O#THgH<!_.xKD2X5hQ`*?b>s');
define('AUTH_SALT',        'Sk<EkjEQA%t)VuI*%! :78o^1e s|_e1a,poL{%DPS0IV;pablHTyPr6?&Jna.&]');
define('SECURE_AUTH_SALT', ',b;C@Kzz-Kb$`GXABp/iBbx;-iX{Yl/![*wbS;vEe#i|M*L?/PmMF}1&<yF}[N7j');
define('LOGGED_IN_SALT',   '+(~/O7(lONX/|rJ*:R*Zt=yTN)|dw*&>O9Vo~v5k%L07_pS?:=9eNR&+b~,JW4e|');
define('NONCE_SALT',       '53E(ab*NKWlQWXR:2uc?r|oTP<qHe_6,>+gihVC[(yCt`a.yQiL5u5O4$=sRSho^');

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
