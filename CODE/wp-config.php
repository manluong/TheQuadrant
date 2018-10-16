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
define('DB_NAME', 'wp_thequadrant');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Ea1c>?|C98;H4$l&]jS]!JJ~x[bXt^BElBWen3#}FA;C{Ib@{`wxs.GbYwG4.WR~');
define('SECURE_AUTH_KEY',  '=7NQf&WV0xRwu@Tw9]IJN_KPrf4-}%@gryP2}V AQ B9wR0XL$k.yKo^9C/x4pWv');
define('LOGGED_IN_KEY',    '`n~cA)z*t^C-.T_ens6Bj8WG]fr(H~Fh6LVu@r}@!Tc<)8B:t~o6+ldyfDj8De2-');
define('NONCE_KEY',        'DM$M:[qN$mbVl|o.8%7RoKD!#h@#GP.m_Et)jE$WnkOtQJND]x[0#$]n@9 &uTZd');
define('AUTH_SALT',        'n`37kRx3]ITp|.xpq|.UDhQNPU^.%%U5Ix~]g45EJFa7o=Guf z$;VTE_XF{`7U/');
define('SECURE_AUTH_SALT', 'sdJ=-|#m-&1_[<=d&.P{g3%rH|k3=uw|[Sy-*|&{x(C/NK4PE!;{fV_]]A+D2bid');
define('LOGGED_IN_SALT',   'hNRotjv=CzrL<[JA/4kcB/HRW5U+ekjDfWLysukz2d#1ka|P[hQ+Jf7]j{SC0g.<');
define('NONCE_SALT',       '@|Ykeu1JjV(!gb,0&&Z#{!Q~2nkHC|[-V-Lib:w*{%Ndkq}dyH@L,Bvm`xVC<GOv');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
