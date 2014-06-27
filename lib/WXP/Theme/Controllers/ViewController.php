<?php namespace Theme\Controllers;

use \WXP\Controller;

class ViewController extends Controller{
    
    function common(){
        
        /**
         * Set all the default options common to every page
         * in this method. Values set in common can be overridden 
         * at anytime in methods called afterwards
         */
        
        $this->View->add('nav', 'primary_navigation')
                   ->add('layout', 'sidebar')
                   ->add('main_sidebar', 'sidebar-primary')
                   ->add('main_class', 'col-sm-8')
                   ->add('read_more_text', 'MORE')
                   ->add('content_template', $this->View->get("base_template"))
                   ->add('allow_plugin_template_override', true)
                   ->add('orig_content_template', view_var("content_template"))
                   ->add('copyright_footer', $this->Options->get("wxp_copyright"))
                   ->add('base_template', locate_template("base.php"));
        /**
         * Load brand name or logo
         **/
        
        $logo = ($src = ot_get_option("wxp_company_logo"))? '<img src="' .$src .'"/>' : get_bloginfo("name"); 
        $this->View->add("brand_logo", $logo);
        
        /*
         * set the navigation vars
         */
        $this->set_nav();
        
        /*
         * add social links to the view
         */
        
        $this->View->add("social_links", $this->get_social_links());
        
        /*
         * We'll allow the plugin generated template directory override any 
         * content template defined in the ViewController methods to avoid
         * including default theme templates where plugin templates are actually
         * intended
         */
        
        add_action("WXP.DomRoute.after", array($this, 'plugin_template_override'));
        
        
        /* 
         * Add a filter to content_type variable so that it returns 
         * the current post_format, and if format is standard it will instead
         * return the post type
         */
        
        add_filter("WXP.var.content_type", function(){
            if(!$format = get_post_format()) 
                return get_post_type();
            return $format;
        });
    }
    
    function archive(){
        
        /*
         * Since there are several archive pages, we should bind this action to the archive
         * class after the common to assign all default options for archive pages  
         */
        
        /*
         * set the layout and template options
         */
        
        
        $this->View->add("layout_header", "post")
                   ->add('page_header_tags', array())
                   ->add('post_loop_content_read', 'excerpt')
                   ->add('post_loop_show_thumb', true)
                   ->add("content_template", locate_template("views/content/content-loop.php"));
        
        /*
         * if posts exceed the amount of that allotted per page,
         * tell view to include the pager nav 
         */
        
        global $wp_query;
        
        if($wp_query->max_num_pages > 1){
            $this->View->add("paged_archive", true);
        }
        
        /*
         * include the error no posts template if the archive has no posts
         */
        
        if(!have_posts()){
            $this->View->add("content_template", 
                             locate_template("views/content/error/error-no-posts.php"));
        }  
        
        
    }
    
    function blog(){
        
        /**
         * fire the archive method so that the blog homepage has the same variables
         * as the archive, since, by default, the blog homepage is an archive of
         * all latest posts
         */
        
        $this->archive();
        
        /**
         * if the user chooses to display a static front page
         * we will use the content from the chosen static page
         * to fill in header values. Else, we'll just use the
         * blog name and description
         */
        
        if('page' == get_option("show_on_front")){
            
            //use content from page for posts, to fill in header values
            
            $post = get_post(get_option('page_for_posts', true));
            $this->set_layout_heading($post);
            
        } else {
            
            //use the regular blog info instead
            
            $this->View->add('page_header_title', get_bloginfo("name"))
                       ->add('page_header_subtitle', get_bloginfo("description"))
                       ->add('page_header_tags', array());
        }           
    }
    
    /**
     * you can override the defaults set in the archive method in any one
     * of these archive methods below;
     */
    
    function tag(){
        
        /**
         * set the page header for the tag archive
         */
        
        $this->View->add('page_header_title', sprintf(__("Posts tagged: %s "), single_tag_title("", 0)));
    }
    
    
    function category(){
        
        /**
         * set the page header for the category archive
         */
                
        $this->View->add('page_header_title', get_category(get_query_var('cat'))->name);
    }
    
    function author(){
        
        /**
         * set the page header for the author archive
         */
                
        $this->View->add('page_header_title', sprintf(__("Posts by %s "), get_query_var('author_name')));        
    }
    
    function date(){
        
        /**
         * set the page header for the date archive
         */
        
        //get the date format for archive, day, month, or year
        
        if(is_year()){
            $date = get_the_time('Y');
        } elseif(is_month()){
            $date = get_the_time('F, Y');
        } else {
            $date = get_the_time('F jS, Y');
        }
        
        $this->View->add('page_header_title', sprintf(__("Archive for %s "), $date));             
    }
    
    
    function search(){
        
        /*
         * treat the search results page the same way 
         * an archive is treated, since there are only
         * marginal differences between the search page
         * and regular archives
         */
        
        $this->archive();
        
        $this->View->add("page_header_title", sprintf(__('Search Results For "%s"'), get_search_query()));
        
        /*
         *  add filter to the content that hilights search results
         */
        
        add_filter("the_excerpt", function($content){
            $query_words = explode(" ", get_search_query());
            foreach($query_words as $word){
                $content = str_replace($word, "<strong class='search-keyword-result'>" .$word ."</strong>", $content);
            }
            return $content;
        });
        
    }
    
    function single(){
        
        /*
         * all single posts inherit the default variables of the 
         * archive, since the single post, still uses the loop
         */
        
        $this->archive();
        
        global $post;
        $this->set_layout_heading($post);
        $this->View->add("post_loop_content_read", "full");
    }
    
    function page(){
        
        /*
         * the page should behave the same as the single post,
         * we can override the defaults here
         */
        $this->single();
        
    }
    
    function error404(){
        
        if($error404page = $this->Options->get("wxp_error404_template")){
            
            $this->set_layout_heading(get_post($error404page));
            
        } else {
        
            $this->View->add("layout_header", "jumbotron")
                       ->add("page_header_title", "Ouch...")
                       ->add("page_header_desc", "I think we made a boo-boo");
            
        }
        
        $this->View->add("content_template", locate_template("views/content/error/error-404.php"));
    }
    
    function plugin_template_override(){
        
        /*
         * if the content template is included from a directory that
         * is not the theme directory, its more than likely that a plugin defined it
         * and we don't want our theme to override the plugin, so we'll set the
         * content_template back to the plugin's
         * 
         */
        
        if(strpos($this->View->get("orig_content_template"), \WXP\WXP::DS(get_template_directory())) === false
           && view_var("allow_plugin_template_override") === true){
            
            $this->View->add("content_template", view_var("orig_content_template"));
            
            //let plugin template be single column, just incase
            //it includes its own sidebar (like Woocommerce)
            $this->set_layout("one");
        }
    }
    
    function set_layout($layout = 'sidebar'){
        
        switch($layout){
            
            case "one":
                
                $this->View->add("main_class", "col-sm-12")
                           ->add("layout", "one");
                
            break;
            default:
                
                $this->View->add("main_class", "col-sm-8")
                           ->add("layout", 'sidebar');
                
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

            wp_localize_script("common_js", 
                               "wxp_local", 
                               array("rnav_position" => view_var("rnav_position"),
                                     "rnav_support"  => "1"));

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
                
                add_filter("WXP.var.header_slider", function($slider){
                    
                    ob_start();
                    do_shortcode($slider);
                    $slider = ob_get_contents();
                    ob_end_clean();
                    return $slider;
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
    
}

?>
