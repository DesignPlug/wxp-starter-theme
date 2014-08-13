<?php

add_filter("WXP.set_template_paths", function($Path){
    
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

