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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'customthemeprac' );

/** Database username */
define( 'DB_USER', 'admin3' );

/** Database password */
define( 'DB_PASSWORD', 'admin3' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'RIuonQ#<v<)glX #;jE/LxyPKAUY;lvc~b+JqZ)/Ay@Z.W1%r~0wkij:;CH7f]%;' );
define( 'SECURE_AUTH_KEY',  'U<C-]i{7&9>N_ue5=y||Ytm7 H}clBh_]}>bkd:!}vg}4L|!_ql_XMj`q]p;y?a-' );
define( 'LOGGED_IN_KEY',    'q3dp#R^P9Is9$k<ZpOIKs}SrH|rOwlH/yoH18dL?Rm_I6=?D=;l%SL&X^8?>n0h-' );
define( 'NONCE_KEY',        'FIv42m2(ff_&I@S(f*..M4k80p(@>+D8{epyS!__LRy1{FT?S9KuW/.<m~$v%F{x' );
define( 'AUTH_SALT',        'a0}vODvdm[+q_#c0E7jxd}u{2K >g&mE*xGx.oaV8%g$a6Y|UfLR<G.O)P%./]EO' );
define( 'SECURE_AUTH_SALT', '*aR?uxXBVLIGY*?su0%dqTw|W3y9.}ev2;$H(||kg~#_rquCc$wSS1.siVB#,zf2' );
define( 'LOGGED_IN_SALT',   '&&oTf]zcRrNCqSrg:{fqY`)f*9{QHSQ|ZS!,:jPu`r(5)t#V`~/C4=75U{XH-XVD' );
define( 'NONCE_SALT',       'g[[ CD/Kf1r1+AU4vt;9`4z&Y2?ElmJ<[_1 +B9RU/yYUZ3l&K5<$J(Q~$fuydk9' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

define('WP_DEBUG_LOG', true);

define ('JWT_AUTH_SECRET_KEY', 'DJHNJJEUWEDJ');

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
