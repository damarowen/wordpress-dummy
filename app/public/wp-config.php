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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'UD1%O)sL e@yI%A$c_^[%F^G;5:<VPs8vWyKdJDi$Oz)R{~;3{]aE&@oe}[7mNcQ' );
define( 'SECURE_AUTH_KEY',   'd?6Me=.;5WaE,Z]%dk!b9U0}(3Ufb{+u1<}/%+zsHko>`a}9B9=z|z8PSk)~16nX' );
define( 'LOGGED_IN_KEY',     '6f-)OyKJ^n@V4SiF)X`E7e`+40G@4^ioTe^&Ix.1Uz].q-?(W!4I;Z]YP>Q^&rQ{' );
define( 'NONCE_KEY',         'J y2 ;&P6Nwvd+}`|wu<D,#{&p(XA]T{}6pmkw1i+;l/[x%VQ(cnV?$+flY(ddw<' );
define( 'AUTH_SALT',         'R3+jaoD?AV8Gu>k@i)Q^a nD9s0<S:@ JfD/&HW3`NWK<0?Ny{!CO_8jwB}Z*e$w' );
define( 'SECURE_AUTH_SALT',  'gJHMkd,C!:#VF!z#Ed!bSrTX?Y-uS`,k(9HZ#}on$S<.G/U+5+ivCl8=M]TsNlR!' );
define( 'LOGGED_IN_SALT',    '!heiP*M|O?-#%t KL5ryhuaB]l_v(lskP5=*pcjgO5d?W,U}RQs9D,jn=2ug]>[T' );
define( 'NONCE_SALT',        'GuAgjSHpDbYwac|>HFPxXc{9]WMvr@f5B+F@pO/|Ma[vAE^AlfuFPeuq[6z4-0gr' );
define( 'WP_CACHE_KEY_SALT', 'n}53lGH 6Nhul!TC0q@$Ay%`dimx?`RbVL[%=2SNUa}@W9n&lO=,=|;~Gr<k~l;K' );


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
	define( 'WP_DEBUG', true );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
