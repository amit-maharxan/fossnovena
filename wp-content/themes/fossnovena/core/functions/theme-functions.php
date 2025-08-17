<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package FOSS
 */

if( !function_exists( 'foss_add_meta' ) ) :
	function foss_add_meta() { ?>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Fossnovena</title>
	<?php }
endif;

if ( !function_exists( 'foss_add_links' ) ) :
	function foss_add_links() { ?>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap" rel="stylesheet">
	<?php }
endif;

function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Fossnovena';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

/* Disable WordPress Admin Bar for all users */
add_filter( 'show_admin_bar', '__return_false' );