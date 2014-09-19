<?php namespace WXP;


class Action {
    
    protected $action, $param;
    
    function __construct($callback, $param = array()) {
        $this->set($callback, $param);
    }
    
    function set($callback, $param = array()){
        $this->action = $callback;
        $this->param  = $param;
    }
    
    function __toString() {
        return (string) WXP::force_return($this->action, $this->param);
    }
    
    
}
