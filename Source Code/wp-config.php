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
define( 'DB_NAME', 'project4' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'Qassem123123' );

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
define( 'AUTH_KEY',         ':a>z+C]o%fWYsWxs_X}F(v2R&~k-0Bms*/%Zt.S/zsAv]0t4O;zyh4* J|%f^R>c' );
define( 'SECURE_AUTH_KEY',  'I]wzvi]8)ZB4C/>{(b=G*aMbnwn_gGfLRh7f=d`o(%|3jR]JZo3#C3`l1^7*io.u' );
define( 'LOGGED_IN_KEY',    'W!~}s<(2xt,>FF<9F^h lH>?MZXkV[R{oYM|IzcN}6I{+t<B8k]U!:[pqKkCeP]J' );
define( 'NONCE_KEY',        ')tBf4c%Gxi1<plMP+#@?T`V$XQ2MRjAgujk2CLTyKWSd?<DG8<~PH/L#f[KkpYjC' );
define( 'AUTH_SALT',        '4z{|5`e~rL)9@unC,=W<6rr>Y.E?zAC+@Wa<Xhc(Pozd*&PfR SB>4baR7#=UEp-' );
define( 'SECURE_AUTH_SALT', 'lu,*Ym@-,<`WfW>($(9{uQ*+VWqEK6=Y[Wd_%b0b1;/M^g}[3=/} _!PN~ED-^n_' );
define( 'LOGGED_IN_SALT',   'kHg@OF4N}~#_#%exc9/33S>80{o$<^:DH.q#%~VO*H*RIGrUMo+/ua2v.ft0 Xk$' );
define( 'NONCE_SALT',       '1lqc%Y^}f`~#$7E~3;cJGv>S_s_0BG}6dw%=r~)|{%77oUo] xj~H$$~.6cP)oc/' );

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
