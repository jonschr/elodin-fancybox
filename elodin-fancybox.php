<?php
/*
	Plugin Name: Elodin Fancybox
	Plugin URI: https://elod.in
    Description: Just add data-fancybox or .popup to a link to make it a popup. Enqueues FancyBox everywhere.
	Version: 0.1.3
    Author: Jon Schroeder
    Author URI: https://elod.in

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
*/


/* Prevent direct access to the plugin */
if ( !defined( 'ABSPATH' ) ) {
    die( "Sorry, you are not allowed to access this page directly." );
}

// Plugin directory
define( 'ELODIN_FANCYBOX', dirname( __FILE__ ) );
define( 'ELODIN_FANCYBOX_DIR', plugin_dir_path( __FILE__ ) );

// Define the version of the plugin
define ( 'ELODIN_FANCYBOX_VERSION', '0.1.3' );

// Enqueue everything
add_action( 'wp_enqueue_scripts', 'elodin_fancybox_enqueue' );
function elodin_fancybox_enqueue() {
	
	// Plugin styles
    wp_enqueue_style( 'fancybox-theme', plugin_dir_url( __FILE__ ) . 'fancybox/dist/jquery.fancybox.min.css', array(), ELODIN_FANCYBOX_VERSION, 'screen' );
    
    // Script
    wp_enqueue_script( 'fancybox-main', plugin_dir_url( __FILE__ ) . 'fancybox/dist/jquery.fancybox.min.js', array( 'jquery' ), ELODIN_FANCYBOX_VERSION, true );

    // Init the 'popup' class
    wp_enqueue_script( 'fancybox-init', plugin_dir_url( __FILE__ ) . 'js/fancybox-init.js', array( 'fancybox-main' ), ELODIN_FANCYBOX_VERSION, true );
	
}

// Set up galleries
// https://stackoverflow.com/questions/53763081/how-to-add-rel-atribute-to-the-links-in-gutenberg-gallery
add_filter( 'the_content', 'elodin_fancybox_support_gutenberg_galleries' );
function elodin_fancybox_support_gutenberg_galleries($content) {
	global $post;

	$pattern = '/<a([^>]*)href=([\'"])(.*?)\.(bmp|gif|jpeg|jpg|png)(\2)([^>]*)><img([^>]*)src=([\'"])(.*?)\.(bmp|gif|jpeg|jpg|png)(\8)([^>]*)><\/a>/i';

	$replacement = '<a$1href=$2$3.$4$5 data-fancybox="gallery" title="' . 
		$post->post_title . 
		'"$6><img$7src=$8$9.$10$11$12></a>';

	$content = preg_replace($pattern, $replacement, $content);

	return $content;
}
add_filter('the_content', 'elodin_fancybox_support_gutenberg_galleries');

// Load Plugin Update Checker.
require ELODIN_FANCYBOX_DIR . 'vendor/plugin-update-checker/plugin-update-checker.php';
$update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/jonschr/elodin-fancybox',
	__FILE__,
	'elodin-fancybox'
);

// Optional: Set the branch that contains the stable release.
$update_checker->setBranch( 'master' );
