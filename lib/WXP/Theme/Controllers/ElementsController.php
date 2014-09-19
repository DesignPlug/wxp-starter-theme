<?php namespace Theme\Controllers;
 
use WXP\Controller;
use WXP\View;
use WXP\WXP;
use WXP\Action;

/*************************************************************
 * The Elements Controller contains layout helper functions
 * that set and pass variables to view parts, like nav menus
 * social icons, page headers etc... 
 *************************************************************/


class ElementsController extends Controller{
    
    function set_defaults(){
     
        $this->set_base();            #base
        $this->set_base_header();     #base_header
        $this->set_layout_header();   #layout_header
        $this->set_layout_nav();      #layout_nav
        $this->set_layout_brand();    #brand
        $this->set_responsive_menu(); #menu-{drawer}
        $this->set_layout_column();   #layout_column
        $this->set_layout_sidebar();  #layout_sidebar
        $this->set_layout_wrapper();  #layout_wrapper
        $this->set_loop();            #loop
        $this->set_loop_header();     #loop_header
        $this->set_content();         #content
        $this->set_loop_footer();     #loop_footer
        
    }
    
    /**
     * 
     * sets default values for variables found in the base template
     * $layout_header - empty string by default, overridden in ::set_layout_header method
     * $layout_column - set to sidebar by default, overridden in ::set_layout_column
     * $layout_footer - blank by default, can be overridden in ::set_layout_footer
     * 
     */
    
    function set_base(){
       
        $this->View->add("layout_header", "")
                
                   ->add("layout_column", "sidebar")
                
                   ->add("layout_footer", "");
    }
    
    /**
     * method for setting #base_header variables
     * empty by default
     * override in your child class
     */
    function set_base_header(){
        
    }    
    
    /**
     * Determines the name of the #layout_header and passes respective View vars,
     * first it checks for a name from post_meta value of wxp_layout_header, if none is
     * given it defaults to #layout_header-post;
     * variables set are:
     * 
     * $layout_header - the name of the layout header used in #base view
     * $layout_header_title - the title of the header, set to current post title
     * $layout_header_subtitle - header subtitle, value of current post meta wxp_layout_header_subtitle
     * $layout_header_class - class of #layout_header, blank by default 
     * $layout_header_slider - parsed shortcode for header slider used in #layout_header-slider 
     * 
     */
    
    
    function set_layout_header(){
        
        switch($header_style = get_post_meta($post->ID, "wxp_layout_header", true)){
            
            case "slider":
                
                $this->View->add("layout_header_slider", get_post_meta($post->ID, "wxp_layout_header_slider_shortcode", true));
                
                /*
                * add a filter to parse the shortcode and return any generated 
                * html to the view 
                */
                
                add_filter("WXP.view.global.layout_header_slider", function($slider){
                    return do_shortcode($slider);
                });
                
            break;
            case "jumbotron":
   
                $this->View->add("layout_header_subtitle", get_post_meta($post->ID, "wxp_layout_header_subtitle", true));
                
            break;
            default:
              
                $this->View->add("layout_header_subtitle", get_post_meta($post->ID, "wxp_layout_header_subtitle", true))
                           ->add("layout_header_tags", wp_get_post_tags($post->ID) ?: array());
                
            break;
        
        }
        
        $this->View->add("layout_header", $header_style ?: "post")
                   ->add("layout_header_title", $post->post_title)
                   ->add("layout_header_class", "");
        
    }
    
    /**
     * Sets the properties of #layout_nav template. Checks defined theme options.
     * note: a binded variable can only be overridden by another binded variable to the same template
     * 
     * <b>$menu !!</b>  - binds the name of the #menu to #layout_nav view, blank by default
     * 
     * <b>$brand !!</b> - binds the name of the #brand template to #layout_nav, blank by default
     * 
     * <b>$menu_drawer_template</b> - the #menu-drawer View object if responsive menu is supported, blank otherwise, used in #layout_nav
     * 
     * <b>$responsive_menu_trigger</b> - the name of the #responsive_menu_trigger template if supported, _kill(ed) otherwise, used in #layout_nav 
     * 
     * <b>$layout_nav_brand_block_class</b> - the brand block class, set to bootstrap grid values by default
     * 
     * <b>$layout_nav_menu_block_class</b> - the menu block class, set to bootstrap grid values by default
     * 
     */
    
    function set_layout_nav(){
        
        //set block classes
                    
                        //the brand block
        $this->View->add("layout_nav_brand_block_class", "col-12 col-md-4")
                
                        //the nav menu block
                   ->add("layout_nav_menu_block_class", "col-12 col-md-8");
        
        //bind blank values for menu and brand to the #layout_nav
        //to avoid name clashes
        
        $this->View->bind("#layout_nav", array("menu" => "", "brand" => ""));
        
        //if primary-menu is not defined _kill the #menu template
        $this->View->bind("#layout_nav", array("menu" => "_kill"));
        
        //if theme doesn't support responsive drawer nav
        
        if(!$this->Options->get("wxp_responsive_menu_support")){
        
                        //set menu drawer to empty string
            
            $this->View->add("menu_drawer_template", "")
                    
                        //prevent responsive menu trigger from being included 
                        //if no responsive nav support
                    
                       ->add("responsive_menu_trigger", "_kill");
                
            
        } else { //if theme does support responsive navigation
            
            //pass responsive drawer menu template to #layout_nav view
            
            $menu_drawer = new View("#menu");
            $menu_drawer->set_render_path("#menu", "drawer");
            
            $this->View->add("menu_drawer_template", $menu_drawer);
        }
    }
    
    
    function set_brand(){
        
    }
    
    /**
     * checks options and sets variables on #menu-drawer and #menu if responive nav menu is supported
     * the following view vars are defined:
     * 
     * $menu_drawer_template - sets menu_drawer_template value to null if no nav is created in #layout_nav
     * $menu_drawer_content  - the nav mark up generated by wp_nav_menu used in #menu-drawer
     * $menu_class      !!   - binds the classes for the menu to #menu view.
     * $responsive_menu_trigger_class - the menu class used in #menu-drawer view.
     * responsive_menu_position -  localized js variable passed to sidr plugin in common_js
     * responsive_menu_support  - localized js variable used to determine whether or not to initialize sidr plugin 
     */
    
    
    function set_responsive_menu(){
            
        //if theme supports responsive menu
        
        if($this->Options->get("wxp_responsive_menu_support")){
        
            //if user created a responsive menu use it, otherwise default 
            //to the primary navigation location

            $nav_location = has_nav_menu("responsive_navigation") ? "responsive_nagivation" : "primary_navigation";
            
            //if $nav_location still not found remove responsive menu template all together
            if(!has_nav_menu($nav_location)){
                
                $this->View->add("menu_drawer_template", null);
                return ;
                
            }
            
            //load the responsive menu
            ob_start();
            wp_nav_menu(array('theme_location' => $nav_location)); 
            $responsive_menu_html = ob_get_clean();
            
            //pass it to view
            $this->View->add('menu_drawer_content', $responsive_menu_html);

            // get the responsive navigation position, 
            // default to right, if no position given
            
            $menu_position = $this->Options->get("wxp_rnav_position", "right");
            
            //set menu support to true for js
            $menu_support  = "1";
            
            //set primary menu classes
            //main menu will disappear on small screen
            //and responsive will show instead 
            $this->View->bind("#menu", array("menu_class" => "pull-right visible-lg visible-md"));
            
            
            //let the responsive nav trigger show on small screens (bootstrap)
            $this->View->add("responsive_menu_trigger_class", "hidden-lg hidden-md");
            
        } else {
            
            $menu_position = "";
            $menu_support  = "0";
            
        }

        //pass resp nav position to inline js file

        add_action("wp_enqueue_scripts", function(){
            wp_localize_script("common_js", 
                               "wxp_local", 
                               array("responsive_menu_position" => $menu_position,
                                     "responsive_menu_support"  => $menu_support));                
        });
    }    
    
    /**
     * Sets the content layout to either single column or two column (sidebar) layout
     * This method sets the following View vars:
     * 
     * $layout_wrapper_class - set to bootstrap grid class in #layout_wrapper view
     * $layout_column - the name of the #layout_column view included in #base view
     * $layout_sidebar_class - set to bootstrap grid class in #layout_sidebar view
     * 
     * @param string $layout
     */
    
    function set_layout_column($layout = 'sidebar'){
        
        switch($layout){
            
            //single column layout
            case "one":
                
                $this->View->add("layout_wrapper_class", "col-sm-12")
                           ->add("layout_column", "one");
                
            break;
        
            //default to sidebar layout
            default:
                
                $this->View->add("layout_wrapper_class", "col-sm-8")
                           ->add("layout_sidebar_class", "col-sm-4")
                           ->add("layout_column", "sidebar");
                
            break;
            
        }
    }
    
    /**
     * sets the content of #layout_sidebar view if column sidebar is activated:
     * 
     * $layout_sidebar_content - set to the return value of dynamic_sidebar("sidebar-primary") in #layout_sidebar view  
     * 
     */
    
    function set_layout_sidebar(){
        
        if($this->View->get("layout_column") === "sidebar"){
            ob_start();
            dynamic_sidebar("sidebar-primary");
            $sidebar_content = ob_get_clean();

            $this->View->add("layout_sidebar_content", $sidebar_content); 
        }
    }
    
    /**
     * empty - extend Element Controller and override this method in your theme
     */
        
    function set_layout_wrapper(){
        
    }
    
    /**
     * sets variables of the #loop view which include
     * 
     * $loop_header - the name of the #loop_header template, _kill(ed) by default
     * $loop_footer - the name of the #loop_footer template, _kill(ed) by default 
     * $content !!  - the name of the #content view being looped, binded to the #loop template
     * 
     */
    
    function set_loop(){
       
        $this->View->add("loop_header", "_kill")
            
                   ->bind("#loop", array("content" => ""))
                
                   ->add("loop_footer", "_kill");
    }
    
    /**
     * method for setting the variables of #loop_header template
     * - empty by default as there are no loop header templates.
     * to create loop header file create a file called header.php in
     * your child theme in the following dir:
     * 
     * views/loops/headers/header-{$name}.php
     * 
     * and override this method in a child class to set any default values.
     * Make sure you set the global view var $loop_header to the name of the template
     * or an empty string, as it is _kill(ed) by default in #loop
     */
    
    function set_loop_header(){
        
    }
    
    /**
     * sets the following variables found in the #content view:
     * 
     * <b> $content_header </b> - the name of the #content_header view, Action object that returns the post format or posttype if format is standard
     * 
     * <b> $content_body </b>   - the name of the #content_body view, Action object that returns the post format or posttype if format is standard
     * 
     * <b> $content_footer </b> - the name of the #content_footer view, Action object that returns the post format or posttype if format is standard
     * 
     * 
     */
    
    function set_content(){
        
        //get post format or return post type if no format set
        $post_format = new Action(function(){
            return get_post_format() ?: get_post_type();
        });
        
        $this->View->add("post_format", $post_format)
                
                   ->add("content_header", $post_format)
                
                   ->add("content_body", $post_format)
                
                   ->add("content_footer", $post_format);
    }
    
    /**
     * sets the following variables found in the #content_header view:
     * 
     * <b> $content_header_title </b> - a call to the the_title() function 
     * 
     * <b> $content_meta </b> - the name of the #content_meta template, inherits value of $post_format set in ::set_content method 
     * 
     * <b> $content_thumbnail </b> - the name of the #content_thumbnail template, inherits value of $post_format set in ::set_content method 
     * 
     */
        
    function set_content_header(){
        
        $the_title = new Action(function(){
            
            $before = "<h3>";
            $after  = "</h3>";
            
            //if this is not a single post we wrap 
            //the title in an anchor link to the single post
            
            if(!is_single()){
                $link    = get_the_permalink();
                $before .= "<a href='{$link}'>";
                $after   = "</a>" .$after;
            }
            
            the_title($before, $after);
        });
        
        $post_format = view_var("post_format");
        
        $this->View->add("content_header_title", $the_title)
                
                   ->add("content_meta", $post_format)
                
                   ->add("content_thumbnail", $post_format);
    }
    
    /**
     * 
     */
    
    function set_content_thumbnail(){
        
        $this->View->add("content_thumbnail_size", "medium")
                
                   ->add("content_thumbnail_attr", array())
            
                   ->add("content_thumbnail_class", "post-thumbnail");
    }
    
    /**
     * 
     */
    
    function set_content_body(){
        
    }
    
    function set_content_error(){
        
    }
    
    function set_content_footer(){
        
    }
    
    function set_content_meta(){
        
    }
    
    /**
     * method for setting the variables of #loop_footer template
     * - empty by default as there are no loop footer templates.
     * to create loop footer file create a file called footer.php in
     * your child theme in the following dir:
     * 
     * views/loops/footers/footer-{$name}.php
     * 
     * and override this method in a child class to set any default values.
     * Make sure you set the global view var $loop_footer to the name of the template
     * or an empty string, as it is _kill(ed) by default in #loop
     */
    
    function set_loop_footer(){
        
    }    
    
    /**
     * method for setting variables of the #layout_footer template
     * - empty by default
     * override this in your child class
     */
    
    function set_layout_footer(){
        
    }
    
    function set_base_footer(){
        
    }
    
    function set_form_search(){
        
    }
    
    function set_menu_nav(){
        
    }
    
    function set_social(){
        
    }
    
    
    function set_layout($layout = 'sidebar'){
        
        switch($layout){
            
            case "one":
                
                $this->View->bind("#content_wrapper", array("main_class" => "col-sm-12"))
                           ->add("layout_column", "one");
                
            break;
            default:
                
                $this->View->bind("#content_wrapper", array("main_class" => "col-sm-8"))
                           ->add("layout_column", "sidebar");
                
            break;
            
        }
        
    }
    
    function set_nav(){

    }
    
    function set_layout_heading($post){
        


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
}





