<?php
/**
 * Header Template
 * 
 * @package FOSS
 */
?>

<!doctype html>
<html lang="en">
	<head>
		<?php 
		/**
		 * foss_meta hook
		 *
		 * @hooked foss_add_meta
		 */
		do_action('foss_meta');

		/**
		 * foss_links hook
		 *
		 * @hooked foss_add_links
		 */
		do_action('foss_links');

		// Keep it for plugins.
		wp_head(); ?> 
	</head>

	<body class="flex flex-col min-h-screen">		
		
		<?php

			/**
			 * foss_header_content hook
			 *
			 * @hooked foss_output_header_content()
			 *
			 */
			do_action( 'foss_header_content' );

		?>