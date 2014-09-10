<?php

use WXP\WXP;

require "lib\wxp-dom-router.php";

add_action("WXP.register_base_theme", function($bootstrap){
    $class_dir = get_template_directory() ."/lib/WXP/";
    $bootstrap->register_theme("wxp-startertheme", $class_dir, "{$class_dir}/Theme/");
});

/************************************************
 * WP Utilities/Helpers
 ************************************************/

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
 * THE OPTIONS TREE FRAMEWORK
 ***********************************************/


add_filter( 'ot_theme_mode', '__return_true' );
//add_filter( 'ot_show_pages', '__return_false' );
//add_filter( 'ot_show_options_ui', '__return_false');
//add_filter( 'ot_show_docs', '__return_true' );

require( trailingslashit( get_template_directory() ) . 'lib/option-tree/ot-loader.php' );


add_filter("WXP.DomRouter.on.allow", function($orig, $param){
    return $orig;
}, 10, 2);

add_filter("WXP.DomRouter.on.disallow.return", function($orig, $obj){
    return $obj;
}, 10, 2);