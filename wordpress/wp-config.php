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
define( 'DB_NAME', 'hot_living_pty_test' );

/** Database username */
define( 'DB_USER', 'hexauser' );

/** Database password */
define( 'DB_PASSWORD', '30011056.vic' );

/** Database hostname */
define( 'DB_HOST', '204.48.17.67' );

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
define( 'AUTH_KEY',         'Ii!it*TR~U6!$!qZREu{[N&&3))yIRVz!Y!x7s=1abTW obzsF4a 2$CTA3}1W?4' );
define( 'SECURE_AUTH_KEY',  '?w k[KTz;nZPg3R&?oM~Jp.b07fB|O?#29>vxql2:5fx63y18M&PEz&y9a(@?N&L' );
define( 'LOGGED_IN_KEY',    'Vb&L6yO^]= w_7{/xbj#n%zoVI>g+dS| &0?9YPIJcl0(zWSx9M.2}>L!<$SW{Ij' );
define( 'NONCE_KEY',        '+{2Wx5P)}Ts@L?Egtp@0HRTKFSU{9k^X]XccRi(r&*lgOaFy$ogcSDJA0}GuW8@E' );
define( 'AUTH_SALT',        'AV=^(NcX_+/v1I}8NEdmVK`V0YO:jBH<B{i1NYWe.RKiThxsNHJQ5LEtPg88s_}1' );
define( 'SECURE_AUTH_SALT', 'yQ ,[+tF-dw2K7A+r<uaH#WmSReLbkDIjL$kb;$6ZD+1e0THSv=fu|$`c!4#InY^' );
define( 'LOGGED_IN_SALT',   'OCpGnmv|cMhlS#+nOWeh/0k`tc!%CSz(AsxZO=.hZ^f^JUg!:XS]@1;NeC@=z9ff' );
define( 'NONCE_SALT',       'OblZ[2F{rvPgz0SLriy]&uY4PyfM&RBu+GDSOobdNjnGTAtp{p^t$1qTHT^4>-Ka' );

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


@ini_set( 'upload_max_filesize' , '128M' );
@ini_set( 'post_max_size', '128M');
@ini_set( 'memory_limit', '256M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );

define('FS_METHOD', 'direct');



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
