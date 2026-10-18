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
define( 'DB_NAME', 'u606581843_0kAbx' );

/** Database username */
define( 'DB_USER', 'u606581843_IaVLx' );

/** Database password */
define( 'DB_PASSWORD', '\\&:77#bfAP' );

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
define( 'AUTH_KEY',          ')@#6!>S%a`I$Umi@?Lw #ULiZ11z@_PBmSgWiOcG/03b*eY8b~aRM;<3e9)G}[~8' );
define( 'SECURE_AUTH_KEY',   'HnP!sw4[,<j.x{=XrUznPK7XHi<H,]<c ()UzuBgIB+UoT^%4OWKle^M:d#=Y -!' );
define( 'LOGGED_IN_KEY',     'X3/.rN7-h>/<{ KUU%9-<|0{>N*~3,0u`}ksf:p- y6OP1Z+=X-q@<dq$rnf*?,s' );
define( 'NONCE_KEY',         '3/%CC063 7#Ev3Pyu<`|l wHQ [~*{mr}wo#.E-eoK]Ko}pQ$}au$78h,h.J^25(' );
define( 'AUTH_SALT',         'M/ev]?!,CQ>K4/eMx,bsh3(qUdKZ8G]Q#5VT//ju(cLyjP(,$~&izN[#Kc[+~iP:' );
define( 'SECURE_AUTH_SALT',  'eMbY`%$ZDrp.yi)eo:wUYd<590teuQCR;Q@rTzP=bl&Nt^ot_]jMeMW{~,:LU%i[' );
define( 'LOGGED_IN_SALT',    ',nxBv6~jpc6sf%uI`nK=F.&?;Zk]00Kop+}wfB$H*V$*Xk3?J^SG?ylwSm&G^I`5' );
define( 'NONCE_SALT',        'HGkgQ+hP>M-/lp0K2z.ivI|1I2%yA4>LmH/B!!Ey]^!i`tr(VAgJ-*xn87mRZ,Zo' );
define( 'WP_CACHE_KEY_SALT', '!bhxJAYmuW;=W6MN#~c2v7v)uL]}jIjFu:(oKozj+UU,%?j~,k- J^AsIB@k7vh>' );


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
