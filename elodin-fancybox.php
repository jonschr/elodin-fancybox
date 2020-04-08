<?php
/*
	Plugin Name: Elodin Fancybox
	Plugin URI: https://elod.in
    Description: Just add data-fancybox or .popup to a link to make it a popup. Enqueues FancyBox everywhere.
	Version: 0.1
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

// Define the version of the plugin
define ( 'ELODIN_FANCYBOX_VERSION', '0.1' );

// Enqueue everything
add_action( 'wp_enqueue_scripts', 'elodin_fancybox_enqueue' );
function elodin_fancybox_enqueue() {
	
	// Plugin styles
    wp_enqueue_style( 'fancybox-theme', plugin_dir_url( __FILE__ ) . '/fancybox/dist/jquery.fancybox.min.css', array(), ELODIN_FANCYBOX_VERSION, 'screen' );
    
    // Script
    wp_enqueue_script( 'fancybox-main', plugin_dir_url( __FILE__ ) . '/fancybox/dist/jquery.fancybox.min.js', array( 'jquery' ), ELODIN_FANCYBOX_VERSION, true );

    // Init the 'popup' class
    wp_enqueue_script( 'fancybox-init', plugin_dir_url( __FILE__ ) . '/js/fancybox-init.js', array( 'fancybox-main' ), ELODIN_FANCYBOX_VERSION, true );
	
}

