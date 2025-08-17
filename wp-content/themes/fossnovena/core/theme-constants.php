<?php
/**
 * FOSS
 *
 * @package FOSS
 * 
 * @since FOSS 1.0
 *
 */

$get_theme = wp_get_theme();

define('FOSS_THEME_NAME', $get_theme);
define('FOSS_THEME_VERSION', '1.0.0');
define('FOSS_THEME_SLUG', 'DK');
define('FOSS_PREFIX', 'FOSS_');

define('FOSS_BASE_URL', get_template_directory_uri() );
define('FOSS_BASE', wp_normalize_path ( get_template_directory() ) );

define('FOSS_CORE', FOSS_BASE . '/core');
define('FOSS_FUNCTION', FOSS_BASE . '/core/functions');
define('FOSS_ADMIN_DIR', FOSS_CORE. '/admin' );

define('FOSS_THEME_ADMIN_URL', FOSS_BASE_URL . '/core/admin');
define('FOSS_THEME_LIBS_URL' , FOSS_BASE_URL . '/core/lib' );

define('FOSS_ASSEST_URI', FOSS_BASE_URL . '/assets');
define('FOSS_JS', FOSS_BASE_URL . '/assets/js');
define('FOSS_CSS', FOSS_BASE_URL . '/assets/styles');
define('FOSS_DIST_CSS', FOSS_BASE_URL . '/assets/dist/css');
define('FOSS_IMG', FOSS_BASE_URL . '/assets/images');
define('FOSS_FILE', FOSS_BASE_URL . '/assets/files');