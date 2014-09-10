<?php

/***********************************************************
* This file is for creating path aliases that you can reference
* in your theme via {frameworkfn} get_view function, example:

{framework_lc}_get_view(#base_header, "example");

* would be equivalent to Wordpress' 

get_template_part("views/base/header", "example");

* Along with providing an easier to remember shorthand, this allows
* you to change the #base_header path without having to replace every 
* instance of "view/base/header" in your theme that is hardcoded into 
* a get_template_part call. Additionally you can take advantage of the
* shorthand in get_template_part hooks, like so:

add_action("get_template_part_#base_header", "{themename}_action");

*******************************************************************/



/** uncomment to create your own paths and/or override the default paths

add_filter("{framework}.set_template_paths", function($Path){
    
    $Path->add("base", "base")
            
            
         ->add("custom", "template")
            
        
         ->add("base_header", "views/base/header")
        
        
         ->add("base_footer", "views/base/footer")
        
        
         ->add("layout_column", "views/base/layouts/column")
            
            
         ->add("layout_footer", "views/base/layouts/parts/footers/footer")
            
            
         ->add("layout_header", "views/base/layouts/parts/headers/header")
        

         ->add("layout_nav", "views/base/layouts/parts/navs/nav")
        
        
         ->add("layout_sidebar", "views/base/layouts/parts/sidebars/sidebar")
        
        
         ->add("content_wrapper", "views/base/layouts/parts/wrappers/wrapper")
        
         
         ->add("brand", "views/brand/brand")
        
        
         ->add("error", "views/content/error/error")
        
        
         ->add("content", "views/content/content")
        
        
         ->add("form", "views/forms/form")
        
            
         ->add("menu", "views/menus/nav")
        
            
         ->add("responsive_menu", "views/menus/rnav")
        
        
         ->add("responsive_menu_trigger", "views/menus/rnav_trigger")
        
        
         ->add("responsive_menu", "views/menus/rnav")
        
        
         ->add("social_networks", "views/social/networks");   
});

*/