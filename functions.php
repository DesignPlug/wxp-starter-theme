<?php

use WXP\WXP;

require "lib\wxp-dom-router.php";

\WXP\Bootstrap::theme("lib\WXP", "lib\WXP\Theme");

require_once locate_template('/lib/cleanup.php');         // Cleanup
require_once locate_template('/lib/relative-urls.php');   // Root relative URLs

/***********************************************
 * WP UI COMPONENTS
 * - widgets, sidebars, nav etc...
 **********************************************/

require WXP::DS("lib\WXP\Theme\ui\comments.php");
require WXP::DS("lib\WXP\Theme\ui\gallery.php");
require WXP::DS("lib\WXP\Theme\ui\\nav.php");
require WXP::DS("lib\WXP\Theme\ui\sidebar.php");
require WXP::DS("lib\WXP\Theme\ui\widgets.php");


/************************************************
 * THE OPTIONS FRAMEWORK
 ***********************************************/

/*
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/lib/options-framework/' );
require_once dirname( __FILE__ ) . '/lib/options-framework/options-framework.php';
*/

add_filter( 'ot_theme_mode', '__return_true' );
//add_filter( 'ot_show_pages', '__return_false' );
//add_filter( 'ot_show_options_ui', '__return_false');
//add_filter( 'ot_show_docs', '__return_true' );

require( trailingslashit( get_template_directory() ) . 'lib/option-tree/ot-loader.php' );


