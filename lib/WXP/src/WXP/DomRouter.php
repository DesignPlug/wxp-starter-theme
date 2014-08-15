<?php namespace WXP;


class DomRouter {
    
    protected $routes, $default_template;
    static protected $instance;
    
    static function getInstance(){
        
        if(!self::$instance){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }
    
    static function hasClass($class){
        return in_array($class, get_body_class());
    }
    
    
    function route(){
        
        do_action("WXP.DomRoute.before");
        
        $body_class   = get_body_class();
        array_unshift($body_class, 'common');
        $body_class = apply_filters("WXP.DomRoute.body_classes", $body_class);
        
        if(!empty($this->routes)){
            foreach($this->routes as $route_hook => $actions){
                if(in_array($route_hook, $body_class)){
                    foreach($actions as $action){
                        $this->callTarget($action);
                    }
                }
            }
        }
        
        do_action("WXP.DomRoute.after");
    }
    
    function on($class, $callback){
        if(is_array($class)){
            foreach($class as $cls){
                $this->add_route($cls, $callback);
            }
        } else {
            $this->add_route($class, $callback);
        }
        return $this;
    }
    
    function unbind($class){
        if(!is_array($class)) $class = (array) $class;
        foreach($class as $cls){
            unset($this->routes[$cls]);
        }
    }
    
    protected function add_route($name, $callback){
        $name = strtolower($name);
        $this->routes[$name][] = $callback;
    }
    
    protected function callTarget($target){

        if(!is_callable($target)){
            $target = explode('#', trim($target));
            $target[0] = new $target[0];
        }
        
        return call_user_func($target);
    }
    
    
    
}

?>
