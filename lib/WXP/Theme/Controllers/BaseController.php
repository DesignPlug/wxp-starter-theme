<?php namespace Theme\Controllers;

use WXP\WXP;
use WXP\Controller;
use WXP\Observer;
use Theme\Controllers\Elements;


class BaseController extends Controller{
    
    function __construct() {
        parent::__construct();
        $templateCtrl = apply_filters("WXP.get_template_controller", new ElementsController);
        $templateCtrl = new Observer("Template", $templateCtrl);
        $this->add_object("Template", $templateCtrl);
        
        //save original content template
        $this->View->add("wxp_orig_content_template", $this->View->get_render_path());
        
    }
    
    
    function plugin_template_override(){
        
        /*
         * if the content template is included from a directory that
         * is not the theme directory, its more than likely that a plugin defined it
         * and we don't want our theme to override the plugin, so we'll set the
         * content_template back to the plugin's
         * 
         */
        
        $orig_tpl = WXP::DS(view_var("wxp_default_render_path"));
        $tpl_dir  = WXP::DS(get_template_directory());
        $ss_dir   = WXP::DS(get_stylesheet_directory());
        $override = view_var("wxp_allow_plugin_template_override");
       
        if(strpos($orig_tpl, $tpl_dir) === false
           && strpos($orig_tpl, $ss_dir) === false
           && $override === true){
            
            $this->View->add("wxp_content_template", $orig_tpl);
            
            //let plugin template be single column, just incase
            //it includes its own sidebar (like Woocommerce)
            //$this->Elements->set_layout("one");
        }
    }
    
}
