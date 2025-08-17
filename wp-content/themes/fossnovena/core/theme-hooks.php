<?php
/**
 * FOSS Template Hooks
 *
 * Action/filter hooks used for FOSS functions/templates
 *
 * @package 	FOSS
 *
 * @since     	FOSS 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*==================================================================================================
  Functions
  ==================================================================================================*/

if (!function_exists('foss_output_header')){
	function foss_output_header(){
		get_header();
	}
}

if (!function_exists('foss_output_header_content')){
	function foss_output_header_content(){
		get_template_part('template-parts/header/content', 'header');
	}
}

if (!function_exists('foss_output_footer')){
	function foss_output_footer(){
		get_footer();
	}
}

if (!function_exists('foss_output_footer_content')){
	function foss_output_footer_content(){
		get_template_part('template-parts/footer/content', 'footer');
	}
}

// Fossnovena Homepage Content Hooks
if (!function_exists('foss_homepage_banner')){
	function foss_homepage_banner(){
		get_template_part('template-parts/homepage/contents');
	}
}

// Fossnovena Contact Content Hooks
if (!function_exists('foss_register_contents')){
	function foss_register_contents(){
		get_template_part('template-parts/register/contents');
	}
}

/*==================================================================================================
  Hooks
  ==================================================================================================*/


/**
 * Metas and Links
 * @see  foss_add_meta()
 * @see  foss_add_links()
 */
add_action( 'foss_meta', 'foss_add_meta' );
add_action( 'foss_links', 'foss_add_links' );

/**
* Header / Footer Content
* @see foss_output_header_content()
* @see foss_output_footer_content()
*/
 add_action('foss_header_content', 'foss_output_header_content', 10);
 add_action('foss_footer_content', 'foss_output_footer_content', 10);

/**
 * Header / Footer  
 */
add_action( 'foss_header', 'foss_output_header');
add_action( 'foss_footer', 'foss_output_footer');

/**
 * Homepage Hook
 */
add_action( 'foss_homepage_content', 'foss_homepage_banner', 10 );

/**
 * Register Hook
 */
add_action( 'foss_register_content', 'foss_register_contents', 10 );