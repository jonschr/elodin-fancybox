<?php
/*
	Plugin Name: Elodin Fancybox
	Plugin URI: https://elod.in
    Description: Just add data-fancybox or .popup to a link to make it a popup. Enqueues FancyBox everywhere.
	Version: 0.1.2
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
define ( 'ELODIN_FANCYBOX_VERSION', '0.1.2' );

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
function elodin_fancybox_support_gutenberg_galleries( $content ) {
    global $post;

    $pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";

	// <a: This part looks for the opening anchor tag.
	// (.*?): This captures any attributes and their values within the anchor tag (non-greedily).
	// href=('|\"): This looks for the href attribute with a value enclosed in single or double quotes.
	// (.*?): This captures the content of the href attribute.
	// .(bmp|gif|jpeg|jpg|png): This looks for a period followed by one of the specified image file extensions.
	// ('|\"): This looks for the closing single or double quote after the image file extension.
	// (.*?): This captures any additional attributes and their values within the anchor tag.

    $replacement = '<a$1href=$2$3.$4$5 data-fancybox="gallery" title="'.$post->post_title.'"$6>';

	// <a: This is the opening anchor tag.
	// $1: This is a placeholder for the captured attributes and their values from the original tag.
	// href=: This is the href attribute.
	// $2: This is a placeholder for the quote (single or double) used in the original href attribute.
	// $3.$4$5: This concatenates the captured content of the href attribute with the period and image file extension, preserving the original file path.
	// data-fancybox="gallery": This adds a data-fancybox attribute with the value "gallery" to the anchor tag.
	// title="'.$post->post_title.'": This adds a title attribute with the value of $post->post_title enclosed in double quotes.
	// $6: This is a placeholder for any additional attributes and their values from the original tag.
	
    $content = preg_replace( $pattern, $replacement, $content );
    return $content;
}

// Load Plugin Update Checker.
require ELODIN_FANCYBOX_DIR . 'vendor/plugin-update-checker/plugin-update-checker.php';
$update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/jonschr/elodin-fancybox',
	__FILE__,
	'elodin-fancybox'
);

// Optional: Set the branch that contains the stable release.
$update_checker->setBranch( 'master' );
