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
define( 'DB_NAME', 'markrosenthal' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'QBR_}^R7^6}~h!|kfdf9lW*zL|2sU_DM9BFUu5&ZK3xi[d|i-xhNyEv?{=(4;u;P' );
define( 'SECURE_AUTH_KEY',  'Zz8&S+!eHx#|Jp*W ;GC&;P(A!!u3L?N2^<`Y;*!NWo%o`4zEjp5X/l(lfm#07T:' );
define( 'LOGGED_IN_KEY',    'Xo?;YdiQffn8TMCFq(E2zqClJOhV<`1v14{%x?:|/%%XH6a{HHHEXCt3G1,+Jcsv' );
define( 'NONCE_KEY',        '%Ee:[Y,@.c$IHz,grEk{rl(To3onf-!O1w2Yg3$pY}8kDoK46+|b1<k,{[.7AFbh' );
define( 'AUTH_SALT',        '${Dm#{:E^Cyc1a$A<UWZXbd~au$T+$xF>d9h7I@TkBxlz+f4hq4[So{V=dig_(W&' );
define( 'SECURE_AUTH_SALT', 'x6S&@8HigfSUHE7?XfsC%OqP}Pd;Uc}v[~8b=LKYUUQKGCJIBnSw 8eE|J}|!mBP' );
define( 'LOGGED_IN_SALT',   'uF9u$|VT(/HxnuH|:SL0&gp(v^kNd1=I7Z~WODHoI*YqByk;8h63b/4J4~)@b^(Q' );
define( 'NONCE_SALT',       'U=<x*4L#5CHW@Ix&a_O3%pvhQ6=~gdn|I I+kd9{1S=x(Sz>rduhwCvm#p)?k&rl' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
