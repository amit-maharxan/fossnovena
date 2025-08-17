<?php

/**
 * FOSS enqueue functions and definitions
 *
 * @package FOSS
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Enqueue scripts and styles.
 */
function foss_scripts()
{
	wp_enqueue_style('foss-main-css', FOSS_CSS . '/main.css');
	wp_enqueue_style('foss-custom-css', FOSS_CSS . '/custom.css');

	// Enqueue script starts
	// Remove default jQuery.
	wp_deregister_script('jquery');

	wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.1.js', array(), 'v3.6.1', false);
	wp_enqueue_script('foss-custom-js', FOSS_JS . '/custom.js', array('jquery'), time(), true);
}
add_action('wp_enqueue_scripts', 'foss_scripts');
