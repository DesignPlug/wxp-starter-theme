<?php namespace WXP;


class Observer {
    
    protected $object, $handle;
    
    function __construct($handle, $object) {
        $this->handle = (string) $handle;
        $this->object = $object;
    }
    
    function __call($fn, $param){
        
        //if the object method is allowed, allow call to place
        //if method exists
        
        $run = apply_filters("WXP.{$this->handle}.{$fn}.allow", true, $this, $param);
        
        if($run !== false){
            
            //give an error if the method does not exist, and 
            //method call is allowed
            
            if(!method_exists($this->object, $fn)){
                throw new BadMethodCallException("Call to undefined method {$this->handle}::{$fn}");
            }
            
            //if method does exist do .before action
            
            do_action("WXP.{$this->handle}.{$fn}.before", $this, $param);
            
            //now call method and apply filters to the result
            
            $result = call_user_func_array(array($this->object, $fn), $param);
            
            $result = apply_filters("WXP.{$this->handle}.{$fn}.result", $result, $this, $param);
            
            //finally do .after action, (passing the result and object)
            
            do_action("WXP.{$this->handle}.{$fn}.after", $result, $this, $param);
            
            //return result
            
            return $result;
        } else {
            //use filter to determine what is returned when 
            //run call for this object is disallowed, by default null is
            //returned; but this might cause an error if a different
            //value (like an object) is expected
            
            return apply_filters("WXP.{$this->handle}.{$fn}.disallow.return", null, $this, $param);
        }
        
    }
    
    function __isObserved(){
        return true;
    }
    
    function __toString() {
        echo $this->object;
    }
    
    function __get($name){
        return $this->object->$name;
    }
    
    function __set($var, $value){
        return $this->object->$var = $value;
    }
    
    function __instanceof($type){
        return $this->object instanceof $type;
    }
    
    function __getObject(){
        return $this->object;
    }
    
}
