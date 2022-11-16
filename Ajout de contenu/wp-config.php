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
define( 'DB_NAME', 'charles Cantin' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         '8fa(5gHf_]})_tEV_t[!}*Wc&-Un[Lad@lJ?/huA5o<BNw9qyRuZ3_@^3gB<U&!E' );
define( 'SECURE_AUTH_KEY',  'z@kw+A,5Ju.vu@/W/gm1Nu/,fG,|Y&s#?#z8X7i4do]=Poe97`T{D^cU)u_f7 !+' );
define( 'LOGGED_IN_KEY',    'S/ZbvDTZs_qfnO&+0+~iP?RO9!9(nADv?2EM~5_9Ut84ZK@mT=7/!jFsxl,pY58,' );
define( 'NONCE_KEY',        'tHAEKs.PLfD?zK/A2;sk~k*H+*6hvH`-pjEZkKI*2j6:TjAQ;R[NG57tcL+e(hT#' );
define( 'AUTH_SALT',        'zQie/*9ita|?;d_(r~ P!Ty>WXet@+CZrNx)|}+ToML+(HbY*FBV<!HT}8w:@tDa' );
define( 'SECURE_AUTH_SALT', 'n;WqhtL^=O_]iVH58;5_SCtH8??yHO5!8VuF@.Ess:iX1vF3RH7Kdp4,moG_.^q5' );
define( 'LOGGED_IN_SALT',   'mV/@Hff_TflKO.>;iQ/UGYDjD${ygOjg(#skJX j|[X#zMA[M$e+v9CJ#s]ohQJd' );
define( 'NONCE_SALT',       'AEI-P-Jg7Q6VWS2s8:ehO/iVJoKjECN$DuTBr()`zxH!5w~/IdpHw^`hnOkRZxj ' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
