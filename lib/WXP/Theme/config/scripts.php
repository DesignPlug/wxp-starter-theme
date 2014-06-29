<?php 

        //jquery cdn
       // wp_deregister_script('jquery');
       // wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, null, false);
        

        /*****************************************
         * Register Javascript files
         ****************************************/
        
        wp_register_script("sidr", get_template_directory_uri() .'/public/js/vendor/sidr/dist/jquery.sidr.js');
        wp_register_script('bootstrap_dropdown', get_template_directory_uri() .'/public/js/vendor/bootstrap/dropdown.min.js', "", "", true);
        wp_register_script('common_js', get_template_directory_uri() .'/public/js/custom.js', "", "", true);
        
        /*******************************************
         * Register CSS styles
         *******************************************/
        
        
        wp_register_style('font_awesome', get_template_directory_uri() . '/public/css/font-awesome/css/font-awesome.min.css', false, '3.2');
        wp_register_style('animate-css', get_template_directory_uri() . '/public/css/animate/animate.min.css', false, '3.2');   
        wp_register_style('sidr-css', get_template_directory_uri() . '/public/js/vendor/sidr/dist/stylesheets/jquery.sidr.light.css', false, '3.2');
        wp_register_style('theme_style', get_template_directory_uri() . '/public/css/style.css', false, '6c39f42987ae297a5a21e2bb35bf3402');
        
?>