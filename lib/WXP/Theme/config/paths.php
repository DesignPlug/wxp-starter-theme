<?php

add_filter("WXP.set_template_paths", function($Path){
    
    $Path->add("base", "base")
            
            
         ->add("custom", "template")
            
        
         ->add("base_header", "views/base/header")
        
        
         ->add("base_footer", "views/base/footer")
        
        
         ->add("layout_column", "views/base/layout/columns/column")
            
            
         ->add("layout_footer", "views/base/layout/footers/footer")
            
            
         ->add("layout_header", "views/base/layout/headers/header")
        

         ->add("layout_nav", "views/base/layout/navs/nav")
        
        
         ->add("layout_sidebar", "views/base/layout/sidebars/sidebar")
        
        
         ->add("layout_wrapper", "views/base/layout/wrappers/wrapper")
        
         
         ->add("brand", "views/brand/brand")
        
        
         ->add("error", "views/content/error/error")
        
            
         ->add("loop", "views/loops/loop")
            
            
         ->add("loop_header", "views/loops/headers/header")  
            
            
         ->add("loop_footer", "views/loops/footers/footer")     
            
            
         ->add("content", "views/content/content")
            
            
         ->add("content_header", "views/content/headers/header")
            
            
         ->add("content_body", "views/content/body/body")
            
            
         ->add("content_meta", "views/content/meta/meta")
            
            
         ->add("content_thumbnail", "views/content/thumbnail/thumbnail")
            
            
         ->add("content_footer", "views/content/footers/footer")
            
        
         ->add("form", "views/forms/form")
        
            
         ->add("menu", "views/menus/menu")
        
        
         ->add("responsive_menu_trigger", "views/menus/rmenu_trigger")
        
        
         ->add("social_networks", "views/social/networks");   
});

