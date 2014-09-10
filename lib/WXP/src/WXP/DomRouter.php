<?php namespace WXP;

use WXP\WXP;

class DomRouter {
    
    /**
     * an array of routes
     * @var array 
     */
    
    protected $routes     = array();
    
    /**
     * an associative array of all called callbacks
     * @var array
     */
    
    protected $called_callbacks = array();




    static protected $instance;
    
    
    static function getInstance(){
        
        if(!self::$instance){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }
    
    /**
     * check if classname is in Wordpress body class array
     * 
     * @param string $class
     * @return bool true if class is found in Wordpress body class 
     */
    
    static function hasClass($class){
        return in_array($class, get_body_class());
    }
    
    /**
     * fires actions bound to body class routes
     */
    
    function route(){
        
        do_action("WXP.DomRoute.before");
        
        $body_class = get_body_class();
        
        //add 'common' to the body class array 
        array_unshift($body_class, 'common');
        
        //apply filters to body classes
        $body_class = apply_filters("WXP.DomRoute.body_classes", $body_class);
        
        //return false if no routes set
        if(empty($this->routes)) return false;
            
            
        foreach($this->routes as $route_hook => $actions){
            
            //if $action has the class key that means an action
            //was bound to multiple classes and wont be fired unless
            //all of those classes are present 
            
            if(isset($actions["class"])){
                
                $found = true;
                
                foreach($actions["class"] as $cls){
                    $found = in_array($cls, $body_class);
                    if(!$found) break;
                }
                
                //if all classes are not found skip to next route
                if(!$found) continue;
                
                //else if all classes are found set $actions with the value
                $actions = (array) $actions['action'];
            }
            
            //otherwise this is a regular route, so instead we can
            //check to see if the class is in the body_class array
            
            else if(!in_array($route_hook, $body_class)){
                continue;
            }
            
            //fire actions if not in $called_callbacks array
            
            foreach($actions as $action){
                
                if(is_string($action) && isset($this->called_callbacks[$action])){
                    
                    //if value is set to true, that means the 
                    //callback has been called already
                    //skip to next action
                    
                    if($this->called_callbacks[$action] === true){
                        continue;
                    }
                    
                    //else the callback has not been fired yet
                    //set value to true to prevent it from being fired
                    //again in another route
                    
                    $this->called_callbacks[$action] = true;
                }
                
                //finally fire the callback/action
                
                WXP::call_target($action, array(View::getInstance()), true);
            }
        }
        
        do_action("WXP.DomRoute.after");
    }
    
    /**
     * bind action to a Wordpress body class, that will
     * be fired when the body has given class name(s)
     * 
     * 
     * @param string|array $class to bind action to
     * @param callable $callback action
     * @param bool $fire_once if set to true, and the $callback is a class#method string or function name string it will not be fired again on another route
     * @return \WXP\DomRouter
     */
    
    function on($class, $callback, $fire_once = true){
        
        //throw error if invalid class name is given
        if(!is_array($class) && !trim((string) $class)){
            throw new \InvalidArgumentException("First argument \$class must be a string body class name an array of string class names");
        }
        
        //add callback string to $called_callbacks array
        //if its a string reference to a function and $fire_once is true
        
        if($fire_once && is_string($callback)){
            $this->called_callbacks[$callback] = false;
        }
        
        $this->add_route($class, $callback);
        return $this;
    }
    
    /**
     * bind a single callback to any of the body classes passed as the first argument
     * 
     * @param array $classes an array of body classes to bind action to
     * @param callable $callback 
     * @param bool $fire_once if set to true, and the $callback is a class#method string or function name string it will not be fired again on another route
     * @return \WXP\DomRouter
     */
    
    function any(array $classes, $callback, $fire_once = true){
        foreach($classes as $cls){
            $this->on($cls, $callback, $fire_once);
        }
        return $this;
    }
    
    /**
     * unbinds actions assigned to given body class 
     * 
     * @param string $class route to remove
     */
    
    function unbind($class){
        if(!is_array($class)) $class = (array) $class;
        foreach($class as $cls){
            unset($this->routes[$cls]);
        }
    }
    
    /**
     * binds route to given body class name 
     * 
     * @param string|array $name name of class(es)
     * @param callable $callback action to fire
     */
    
    protected function add_route($name, $callback){
        
        //if array is passed we'll create a conditional
        //route that only fires when given classes are all
        //found in the body
        
        if(is_array($name)){
           $this->routes[] = array("class"  => $name,
                                   "action" => $callback); 
        } else {
            $this->routes[$name][] = $callback;
        }
        
    }

    
    
    
}

?>
