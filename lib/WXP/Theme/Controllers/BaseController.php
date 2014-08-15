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
        
        if(strpos(WXP::DS($this->View->get("wxp_orig_content_template")), WXP::DS(get_template_directory())) === false
           && strpos(WXP::DS($this->View->get("wxp_orig_content_template")), WXP::DS(get_stylsheet_directory())) === false
           && view_var("allow_plugin_template_override") === true){
            
            $this->View->add("wxp_content_template", view_var("wxp_orig_content_template"));
            
            //let plugin template be single column, just incase
            //it includes its own sidebar (like Woocommerce)
            //$this->Elements->set_layout("one");
        }
    }
    
}
