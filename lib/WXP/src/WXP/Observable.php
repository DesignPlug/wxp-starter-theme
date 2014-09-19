<?php namespace WXP;


abstract class Observable {
    
    protected $observable_actions = array();
    
    private function observe_action($tag, $method){
        if(!method_exists($this, $method)){
            throw new \Exception("Attempted to observe undefined method: " .$method);
        }
        $this->observable_actions[(string) $method] = $tag;
    }
    
    function __get_tag($method){
        if(isset($this->observable_actions[$method])){
            return $this->observable_actions[$method];
        }
        return false;
    }
    
    
    
}
