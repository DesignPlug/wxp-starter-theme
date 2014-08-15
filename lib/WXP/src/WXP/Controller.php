<?php namespace WXP;

use \WXP\View;
use \WXP\Options;
use \WXP\Observer;
use \WXP\WXP;

class Controller {
    
    protected $objects;
    
    function __construct(){
        $Options = apply_filters("WXP.get_options_object", new Options);
        
        $this->add_object("View", view_var("wxp_global_view"));
        $this->add_object("Options", new Observer("Options", $Options));
        $this->add_object("Path", WXP::get_template_paths());
    }
    
    function __get($object){
        return $this->objects[$object];
    }
    
    protected function add_object($handle, $object){
        //place object in container to prevent 
        //fatal error on invalid method call, and to allow
        //hooks and filtxaers before and after each call.
        
        $this->objects[$handle] = $object;
    }
    
}

?>
