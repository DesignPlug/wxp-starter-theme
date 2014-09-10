<?php namespace {themename}\Controllers;


class ScriptController {
    
        
    /*********************************
     *   ENQUEUE GLOBAL SCRIPTS/STYLES
     *********************************/
    
    function common(){
        
        add_action("wp_enqueue_scripts", function(){
        
          #register the scripts/styles that are common to all pages
          #here
          
          //  wp_enqueue_script("myscript");
          
        });

        #register top priority scripts/styles after routing is complete to make
        #sure they're included last
        
        add_action("WXP.DomRoute.after", array($this, 'lastCommon'));
    }
    
    /*************************************
     *   ENQUEUE HOMEPAGE SCRIPTS/STYLES
     *************************************/
    
    function home(){
        
        
    }
    
    function blog(){

    }
    
    function single(){
        
    }
    
    /******************************************
     *   ENQUEUE FINAL COMMON SCRIPTS/STYLES 
     *****************************************/    
    
    function lastCommon(){
        
        add_action("wp_enqueue_scripts", function(){
            wp_enqueue_script('theme_js');
            wp_enqueue_style('theme_style');  
        });
    }
    
}

?>
