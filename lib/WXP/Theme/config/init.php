<?php

   // Make theme available for translation
  load_theme_textdomain(WXP_TEXTDOMAIN, WXP_TEXTDOMAIN_PATH);

  // Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', WXP_TEXTDOMAIN),
    'resp_navigation' => __('Responsive Navigation', WXP_TEXTDOMAIN) 
  ));

    /**
     * Enable theme features
     */
  // add_theme_support('root-relative-urls');    // Enable relative URLs
  add_theme_support('bootstrap-top-navbar');  // Enable Bootstrap's top navbar
  add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery]
  add_theme_support('nice-search');           // Enable /?s= to /search/ redirect
  add_theme_support('jquery-cdn');            // Enable to load jQuery from the Google CDN
  
  // Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
  add_theme_support('post-thumbnails');
  //set_post_thumbnail_size(150, 150, false);
  add_image_size('dp-post-thumb', 650, 250);
  add_image_size('dp-post-thumb-header', 1500, 794);

  // Add post formats (http://codex.wordpress.org/Post_Formats)
  add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

  // Tell the TinyMCE editor to use a custom stylesheet
  // add_editor_style('/assets/css/editor-style.css');
  
  
?>
