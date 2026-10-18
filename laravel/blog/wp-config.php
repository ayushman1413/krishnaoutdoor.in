<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u606581843_oHyOr' );

/** Database username */
define( 'DB_USER', 'u606581843_TJKOX' );

/** Database password */
define( 'DB_PASSWORD', 'k6e2O-Z(6]' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'bi|s{9^{1BgN@9!c9^RJ}#UK^tuw`H?|J$[-X_V?Dcp-8pK-P]*1d_mthuD;poA%' );
define( 'SECURE_AUTH_KEY',   'j{Ww]%1FK[$Hi8g?;vHlYv*P]r<KL0b%B0IL1EeQ{Vu]]e$tCIy;-HjIHlD09Z>,' );
define( 'LOGGED_IN_KEY',     '}0_}I&I=7)M`% nD`e3hk7d!yDY6bKe+`s%_~OOGVuek5HdO;oBD%(].F/({s7k/' );
define( 'NONCE_KEY',         'AJET6,R@UNaNFWPVpK?wTa?YYpcY4uOE#|4pB&8dzwkAPGR5/V91$G&IaEu860(a' );
define( 'AUTH_SALT',         '~gi`>R-9$[|6Fo!{LDlu>?H%1AX_kX.z%ZI&v#eq>t|w)Exg)7NZ7mgX1qBA,qC)' );
define( 'SECURE_AUTH_SALT',  'LaSvSl0wXmYoG2KghR.xKC;_~2bIe|@/Q5*{[Q50Z#^t} >)G;I`*yp6DRU7xT3>' );
define( 'LOGGED_IN_SALT',    '.=A;r}sx),akPsd~R *s5rrK|M>85~xK5F).pjrIghsIWnU2_#_ieVW.@@o4Uo7C' );
define( 'NONCE_SALT',        '}2$D`&Pr0;pn`WqJoIotkzx<0_- l!|lRXGeBBsaoq9TQz8A$}q2LK/W2qLvIAkX' );
define( 'WP_CACHE_KEY_SALT', 'ttX2b9oOkb{j:WfYKUSU5j jG` aL;ZrmzvaL &/e;$m$/|/<@1.kC=DL:UM8W|e' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'f7ea96ae6a43a181952d8cf60db00fc8' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
