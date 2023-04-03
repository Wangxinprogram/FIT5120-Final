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

 * @link https://wordpress.org/support/article/editing-wp-config-php/

 *

 * @package WordPress

 */


// ** Database settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define( 'DB_NAME', 'bitnami_wordpress' );


/** Database username */

define( 'DB_USER', 'bn_wordpress' );


/** Database password */

define( 'DB_PASSWORD', '07fbb579f4736b81ca0cf78f3335b76a7908f02aa2a8eff3f2be858ddcce0da3' );


/** Database hostname */

define( 'DB_HOST', '127.0.0.1:3306' );


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

define( 'AUTH_KEY',         'D]]U2 `R4HQfx AqF{-ud},$QR4O%8|iKYS;+TmRXGIIxw.pg2H]p]lr]{[,.~4(' );

define( 'SECURE_AUTH_KEY',  '=inkMPmr(P[}eEiOo}_]s)c}G?6?MP)tVlB_c9xAgVmJ4Cy_.}4@a&,iGrT{{p*A' );

define( 'LOGGED_IN_KEY',    'tYwYfLPMy)3~8aPsm>oCnw+I#wbdOcMJB)|;21owvDIO4$#*y`pDge1PuTLi}YI.' );

define( 'NONCE_KEY',        '-Ej{FTH4Cufi^0K2kjSIm?X+j6N]bQXhIN//lIOCPoUckqALMP^O2|bz+E|juEr*' );

define( 'AUTH_SALT',        'WST>E l**{kwgY[^9?&<zm66XHpf%4k/gc7+D]&9Dx.:W[qNoNLRj,8**rwx2i=r' );

define( 'SECURE_AUTH_SALT', 'mi?ad[#+rYW5y~a;96?xK88lE8Q1cqU3xnWfX?|pLiNJ0od.}T#G9^otI7,y$_ar' );

define( 'LOGGED_IN_SALT',   '@g8(_Av(Kg&O#(YZ0&n:H?gmwUg#!l02[T56F&nuO.q+YHMHWhW(Zsq$TAG_<M6t' );

define( 'NONCE_SALT',       'cw!{f&a}n4%&%l[E}jk6~`IqA):J{geH]?owkwE,:AB,~W8Eq/=W!#)4jdQh]BPL' );


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

 * @link https://wordpress.org/support/article/debugging-in-wordpress/

 */

define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */




define( 'FS_METHOD', 'direct' );
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','http://example.com');
 *  define('WP_SITEURL','http://example.com');
 *
 */
if ( defined( 'WP_CLI' ) ) {
	$_SERVER['HTTP_HOST'] = '127.0.0.1';
}

define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/' );
define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}


/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';

/**
 * Disable pingback.ping xmlrpc method to prevent WordPress from participating in DDoS attacks
 * More info at: https://docs.bitnami.com/general/apps/wordpress/troubleshooting/xmlrpc-and-pingback/
 */
if ( !defined( 'WP_CLI' ) ) {
	// remove x-pingback HTTP header
	add_filter("wp_headers", function($headers) {
		unset($headers["X-Pingback"]);
		return $headers;
	});
	// disable pingbacks
	add_filter( "xmlrpc_methods", function( $methods ) {
		unset( $methods["pingback.ping"] );
		return $methods;
	});
}
