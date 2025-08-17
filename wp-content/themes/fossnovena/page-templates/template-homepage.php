<?php
/**
 * Template Name: Homepage Layout
 */

do_action('foss_header'); ?>

<?php 
    /**
     * foss_homepage_content hook
     *
     */
    do_action( 'foss_homepage_content' );
?>

<?php do_action('foss_footer'); ?>