<?php 

/****************************************************
* Register your theme's scripts/styles in this file,
* then include them strictly on an as needed basis via
* the script includer.

* {frameworkfn} comes loaded with quite a few assets by 
* default that may be overkill or just unnessessary 
* for your project. To remove a single script/style you can use
* Wordpress' default wp_deregister_scipt function or
* you can remove all default scripts by adding this line
* of code to your theme's functions.php

add_filter({framework}.{framework_theme}.include_scripts_path, "__return_false");

*****************************************************/


        /*****************************************
         * Register Javascript files
         ****************************************/
        
        wp_register_script('theme_js', get_stylesheet_directory_uri() .'/public/js/theme.js', "", "", true);
        
        /*******************************************
         * Register CSS styles
         *******************************************/

        wp_register_style('theme_style', get_stylesheet_directory_uri() . '/public/css/theme.css');