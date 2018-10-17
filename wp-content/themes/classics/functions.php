<?php
/**
 * Classics Theme Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Classics Theme
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_CLASSICS_THEME_VERSION', '1.0.0' );



/**
 * Autoload Composer dependencies.
 */
if (file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
  require_once $composer;
}

/**
 * The $includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 */
$includes = [
  'lib/assets.php',         // Scripts and stylesheets
  'lib/extras.php',         // Custom functions
  'lib/setup.php',          // Theme setup
];

foreach ($includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
