<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ebookvie' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'VNU/ML:Md~y!)N>bxiTxu*p_k.lM<~aGciR[j8e,z~8#w-i,=/DIpQ^96} qXCrZ' );
define( 'SECURE_AUTH_KEY',  'zet$}vJhz^f[z0F[>-sbg8b@P2gf2%h~WZ0VUy*vA{i2F +A {TX~ZWZ7d%J!Fc:' );
define( 'LOGGED_IN_KEY',    'p+Wp_>`tMsP8p/}}ybTXu/[(V6`b/A[RT7E2b&W;9eJ(){0./Q6bq3{hq~;y<@qh' );
define( 'NONCE_KEY',        '7}zX uu,$7^iiJ/FqR<3=,J?xuK^Mfazv <LSp;Fjv]&| FZ{//]LcyjbE+T]&!2' );
define( 'AUTH_SALT',        '9}q`D1,g<5TYi{vYB)5i:oicAD~xox!6CKJBIK95ksX7L*v%fxPk!zNpoaQi3Fg7' );
define( 'SECURE_AUTH_SALT', 'pI{i+yL+!$%Ex8XXn6|ReGr>AvY3y5VP*.z4` L_-/y]bmEgFWQhz:#[0b1[XdOi' );
define( 'LOGGED_IN_SALT',   ':<6)I;9?B]o::!qN3#dMYvlex3#/?]D&:D*suMn;KxE+1|M7s/zj37T8HpjFXyJ!' );
define( 'NONCE_SALT',       '`^^T`jHQnxq[sF0iKt-#^_v?Uls|T!bQL4&[QmdZ=,ba0,CV0Kk34N*Qgi|cMA~E' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
