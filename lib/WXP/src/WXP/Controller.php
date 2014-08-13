<?php namespace WXP;

use \WXP\View;
use \WXP\Options;
use \WXP\WXP;

class Controller {
    
    protected $objects;
    
    function __construct(){
        $this->add_object("View", apply_filters("WXP.get_global_view", View::getInstance()));
        $this->add_object("Options", apply_filters("WXP.get_options_object", new Options));
        $this->add_object("Path", WXP::get_template_paths());
    }
    
    function __get($object){
        return $this->objects[$object];
    }
    
    protected function add_object($handle, $object){
        $this->objects[$handle] = $object;
    }
    
}

?>
