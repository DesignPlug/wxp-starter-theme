<?php namespace Theme\Controllers;
 
use WXP\Controller;

/*************************************************************
 * The Elements Controller contains layout helper functions
 * that set and pass variables to view parts, like nav menus
 * social icons, page headers etc... 
 *************************************************************/


class ElementsController extends Controller{
    
    function set_layout($layout = 'sidebar'){
        
        switch($layout){
            
            case "one":
                
                $this->View->bind("#content_wrapper", array("main_class" => "col-sm-12"))
                           ->add("layout", "one");
                
            break;
            default:
                
                $this->View->bind("#content_wrapper", array("main_class" => "col-sm-8"))
                           ->add("layout", "sidebar");
                
            break;
            
        }
        
    }
    
    function set_nav(){
        if($this->Options->get("wxp_rnav_support")){
            
            $this->View->add('use_rnav', true);
            
            /*
             * If responsive nav is set use that navigation, else
             * default to primary_navigation
             */
            
            $nav_location = has_nav_menu("responsive_navigation") ? "responsive_nagivation" : "primary_navigation";
            $this->View->add('rnav', $nav_location);
            
            /*
             * get the responsive navigation position, 
             * default to right, if no position given
             */
                       
            $this->View->add("rnav_position", $this->Options->get("wxp_rnav_position", "right"));
            
            /*
             * pass responsive classes to the default nav menu so that 
             * it disappears when responsive nav is visible
             */
            
            $this->View->add("primary_nav_class", " visible-lg visible-md ");
            
            //pass resp nav position to inline js file

            add_action("wp_enqueue_scripts", function(){
                wp_localize_script("common_js", 
                                   "wxp_local", 
                                   array("rnav_position" => view_var("rnav_position"),
                                         "rnav_support"  => "1"));                
            });

            //include responsive nav near the nav menu

            add_filter("get_template_part_views/base/layouts/parts/navtop", function($nav){
               get_template_part("views/menus/rnav"); 
               return $nav;
            });        
            
        }
    }
    
    function set_layout_heading($post){
        
        switch($header_style = get_post_meta($post->ID, "wxp_page_header_style", true)){
            
            case "slider":
                
                $this->View->add("header_slider", get_post_meta($post->ID, "wxp_page_slider_shortcode", true));
                
                /*
                * add a filter to parse the shortcode and return any generated 
                * html to the view 
                */
                
                add_filter("WXP.view.global.header_slider", function($slider){
                    return do_shortcode($slider);
                });
                
            break;
            case "jumbotron":
               
                $this->View->add("page_header_desc", get_post_meta($post->ID, "wxp_page_subheading", true));
                
            break;
            default:
              
                $this->View->add("page_header_subtitle", get_post_meta($post->ID, "wxp_page_subheading", true))
                           ->add("page_header_tags", wp_get_post_tags($post->ID) ?: array());
                
            break;
        
        }
        
        $this->View->add("layout_header", $header_style ?: "post")
                   ->add("page_header_title", $post->post_title);

    }
    
    function get_social_links(){
        $networks = array('facebook', 
                          'twitter', 
                          'googleplus' => 'Google +',
                          'instagram',
                          'pinterest',
                          'vimeo',
                          'dribbble');
        
        $icons    = array('vimeo'      => 'vimeo-square',
                          'googleplus' => 'google-plus');
        
        $social_links = array();
        
        foreach($networks as $k => $v){
            
            //if the key is numeric, then treat the value
            // like the network's name, else we'll just use 
            //the key
            
            $social_id = $k;
            $social_name = $v;
            
            if(is_numeric($k)){
                $social_id   = $v;
                $social_name = ucfirst($v);
            }
            
            
            //if network is set add it to social link array
            if($link = $this->Options->get("wxp_social_" .$social_id)){
                $social_links[$social_id] = new \stdClass();
                $social_links[$social_id]->name = $social_name;
                $social_links[$social_id]->link = $link; 
                $social_links[$social_id]->id   = @$icons[$social_id] ?: $social_id; 
            }
        }
        
        return $social_links;
    }
    
    function set_footer(){
        
    }
}





