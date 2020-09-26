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
define( 'DB_NAME', 'karenhardinglaw' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         ',0>q;Z:NSQ%R5bjv<qV5E0GI}z~o7Rb-G%snQ-EE{YMmd[V#>yYXf6X5y7aj9w4v' );
define( 'SECURE_AUTH_KEY',  '%Ju75&#vQ?=F:?LU[2!?js0b#DCQf;%/Wmy4p@.Ol_48@bg&I>wU`Z#N/037gRh0' );
define( 'LOGGED_IN_KEY',    '_GE[A(-f L_k~XE?#%cCru:c4!%!PXWV:=HU,2:1bLi~pA0w$2d^P:KNj:mBI-v2' );
define( 'NONCE_KEY',        '$ZK(a8X:5Y(RIj+Kaut;}qR|K2n:K:IUC2^Cg2Q=rt0QRmt@kZT0qA:Htg.Bc3M2' );
define( 'AUTH_SALT',        'oj/P?@uWgN/`iz1%9,5um _B3kDhEtvD;/h^e*PjZKg4OQ<4J`>:HRx/k|s);vhx' );
define( 'SECURE_AUTH_SALT', ']gyy7dbws.Dns:u}]jd7O<{9yWYXaG8@6L;:=Z|]GV/Dvl?w({z2@3n!Y2c9b]h^' );
define( 'LOGGED_IN_SALT',   'Q,vO`[&sRLu)qC2]JJ[W0x:4ks@m.ARx$+)J;. d&eRL}$}R>VndpG=eP2<>E}r-' );
define( 'NONCE_SALT',       'K<GLoX9*GimqV&)E[/=O+xj!9H`;o1y#@+bt-T1}|o}jPWYPoy962MaM0,5u6tzO' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'khl_';

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
