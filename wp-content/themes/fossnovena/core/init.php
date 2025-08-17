<?php
/**
 * FOSS functions and definitions
 *
 * @package FOSS
 * 
 * @since FOSS 1.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) { 
 	exit; // disable direct access 
 }

/*
 * Load theme constants
 */
require trailingslashit( get_template_directory() ) . 'core/theme-constants.php';

/**
 * Theme setup functions
 */
require_once ( FOSS_CORE.'/theme-setup.php' );

/**
 * Register widget area and nav.
 */
require_once ( FOSS_CORE.'/theme-register.php' );

/**
 * Enqueue scripts and styles.
 */
require_once ( FOSS_CORE.'/enqueue.php' );

/**
 * Theme functions
 */
require_once ( FOSS_FUNCTION.'/theme-functions.php' );

/**
 * Custom functions that act independently of the theme templates.
 */
require_once ( FOSS_FUNCTION.'/extras.php' );
require_once ( FOSS_FUNCTION.'/ajax-functions.php' );

/**
 * Custom post types
 */
require_once ( FOSS_CORE.'/post_types/type_entry.php' );

/**
 * Theme Hooks
 */
require_once ( FOSS_CORE.'/theme-hooks.php' );

/**
 * Aqua Resizer
 */
require_once ( FOSS_CORE.'/lib/aq_resizer.php' );

/**
 * Customizer additions.
 */
require_once ( FOSS_CORE.'/lib/bs4navwalker.php');
require_once ( FOSS_CORE.'/lib/customizer.php');