<?php namespace Theme\Controllers;

use \WXP\WXP;

class ViewController extends BaseController{
    
    function common(){
        
        //the the default render path
        
        $this->View->set_render_path("#base");        

        //set the default template varialbes
        
        $this->Template->init(); 
        
        /*
         * We'll allow the plugin generated template directory override any 
         * content template defined in the ViewController methods to avoid
         * including default theme templates where plugin templates are actually
         * intended
         */
        
        add_action("WXP.DomRoute.after", array($this, 'plugin_template_override'));
    }
    
    function archive(){
        
        /*
         * Since there are several archive pages, we should bind this action to the archive
         * class after the common to assign all default options for archive pages  
         */
        
        /*
         * set base variables
         */
        
        $this->View->add("wxp_content_template", WXP::get_path("#loop")->dir());
        
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
            $this->View->add("wxp_content_template", 
                              WXP::get_path("#error")->name("no-posts")->dir());
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
            $this->Template->set_layout_header($post);
            
        } else {
            
            //use the regular blog info instead
            
            $this->View->add('layout_header_title', get_bloginfo("name"))
                       ->add('layout_header_subtitle', get_bloginfo("description"))
                       ->add('layout_header_tags', array());
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
        
        $this->View->add('layout_header_title', sprintf(__("Posts tagged: %s "), single_tag_title("", 0)));
    }
    
    
    function category(){
        
        /**
         * set the page header for the category archive
         */
                
        $this->View->add('layout_header_title', get_category(get_query_var('cat'))->name);
    }
    
    function author(){
        
        /**
         * set the page header for the author archive
         */
                
        $this->View->add('layout_header_title', sprintf(__("Posts by %s "), get_query_var('author_name')));        
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
        
        $this->View->add('layout_header_title', sprintf(__("Archive for %s "), $date));             
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
        $this->Template->set_layout_header($post);
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
            
            $this->Template->set_layout_heading(get_post($error404page));
            
    } else {
        
            $this->View->add("layout_header", "jumbotron")
                       ->add("page_header_title", "Ouch...")
                       ->add("page_header_desc", "I think we made a boo-boo");
            
        }
        
        $this->View->add("wxp_content_template", locate_template("views/content/error/error-404.php"));
    }

    
}

?>
