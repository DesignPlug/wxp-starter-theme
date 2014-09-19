<?php namespace WXP;

class WXP {
    
    protected static $objects = array();
    
    public static function __callStatic($name, $arguments = array()) {
        if(isset(static::$objects[$name])){
            return static::$objects[$name];
        }
        throw new \BadMethodCallException("Call to undefined method " .$name);
    }
    
    public static function setPaths($paths_object){
        if(isset(static::$objects['Path'])){
            throw new \Exception("Paths object already set; Cannot set Paths Object again");
        } else {
            static::$objects['Path'] = $paths_object;
        }
    }
    
    public static function get_path($path){
        
        //if path is prefixed by hashtag
        //it is an alias, get actual TemplatePath Object
        //else create 
        
        if(strpos($path, "#") === 0){
            return static::Path()->to(substr($path, 1));
        } else {
            return new TemplatePath($path);
        }
    }
    
    public static function get_template_paths(){
        return static::Path();
    }
    
    /**
     * if path is an absolute path it will be included
     * else if the path is a path alias, prefixed with a
     * pound character, get_view will be used to render view
     * 
     * @param string $path absolute path or path alias
     */
    
    public static function include_view($path){
        if(static::has_prefix("#", $path)){
            static::get_view($path);
        } else {
            include $path;
        }
    }
    
    /**
     * works as get_template_part with some significant enhancements.
     * unlinke get_template_part get_view supports variable parameters.
     * In addition generated view has direct access to global view variables
     * within it's scope. for example:
     * 
     * //passing a var to the View objects global scope like so:
     * View->add("foo", "bar");
     * 
     * //can be accessed directly in view template like so:
     * <?php echo $foo; ?>
     * 
     * changing the value of $foo in the template will not overwrite the value of
     * view elsewhere.
     * 
     * you can overwrite the value of $foo in the template by passing an array with the
     * key "foo" and a new value like so:
     * WXP::get_view("#template_path", $template_name, array("foo" => "not bar"));
     * 
     * in the template the value of $foo would be "not bar"
     *
     * 
     * @param string $path path to template or path alias
     * @param string $name name of given template
     * @param array $param an array of variables to pass to view
     * @return null
     */
    
    public static function get_view($path, $name = null, $param = array()){
        
        //if $name is set to _kill return null
        if(strtolower(trim($name)) === "_kill") return null;
        
        //if path var is prefixed by hashtag
        //it is read as a path alias instead of 
        //a regular path, replace the alias value with
        //actual path
        $path_alias = null;
        
        if(strpos($path, "#") === 0){
            $path_alias = $path;
            $path = static::Path()->to(substr($path, 1));
        }
        
        if(isset($path_alias)){
            //Also allow users to bind actions to the alias like so
            do_action("get_template_part_{$path_alias}");
        }
        
        //behaves as normal get_template_part function
        //would
        do_action("get_template_part_{$path}");

        
        //now set the templates for wp to locate
        //just as the default get_template_part
        $templates = array();
        
        if((string) $name !== ""){
            $templates[] = "{$path}-{$name}.php";
        }
        
        $templates[] = "{$path}.php";
        
        //apply filters to the templates array
        $templates = apply_filters("WXP.view_templates", $templates);
        
        //allow more specific filter WXP.view_templates{$path} to override WXP.view_templates hook
        
        if(isset($path_alias)){
            $templates = apply_filters("WXP.view_templates_{$path_alias}", $templates);
        }
        
        $templates = apply_filters("WXP.view_templates_{$path}", $templates);
        
        //now use WP's locate template to get the absolute path of 
        //the template. But do not include it via locate template
        //because then passed param will be out of scope
        
        $located_path = locate_template($templates);
        
        //if template is located, apply all filters to view that is bound to 
        //the path and/or the path alias 
        
        if($located_path){
            
            //let default View be overridden
            
            $ns = $path_alias ?: $path;
            $View = apply_filters("WXP.get_view", new View($ns, $located_path));
            
            //make new View observable
            $View = new Observer("View", $View);
        
            //apply all filters
            if(isset($path_alias)){
                do_action("WXP.set_view_{$path_alias}", $View);
            }
            
            do_action("WXP.set_view_{$path}", $View);

            //add param to View
            foreach($param as $k => $v){
                $View->add($k, $v);
            }
            
            //render View
            $View->render();

            //fire after action 
            
            if(isset($path_alias)){
                //Also allow users to bind actions to the alias like so
                do_action("get_template_part_{$path_alias}_after");
            }
            
            do_action("get_template_part_{$path}_after");
        }
        
    }
    
    public static function render_view($View){
        //if raw render path has # prefix, apply set view action
        //to path alias
        $alias = $View->get_render_path(true);
        if(strpos($alias, "#") === 0){
            do_action("WXP.set_view_{$alias}", $View);
        }
        //get path object now
        $path = static::get_path($alias);
        
        //do action to direct path now
        do_action("WXP.set_view_{$path}", $View);
        
        //render View
        $View->render();
    }
    
    /**
     * calls callable callbacks, and instantiates and calls 
     * Class#Method strings. 
     * 
     * @param mixed callable | string $target
     * @param bool $observe if $observe is true, and the callback is an object, it will be wrapped in the WXP\Observer object
     * @return void
     * 
     */
    
    public static function call_target($target, $param = array(), $observe = false){

        if(!is_callable($target)){ //it is call to Object#method
            $target = explode('#', trim($target));
            $target[0] = new $target[0]; //instantiate class
        }
        
        if(is_array($target) && $observe != false){
            //namespace will be separated by . instead of slashes in handle
            $class_name = str_replace("\\", ".", get_class($target[0]));
            $target[0] = new Observer ($class_name, $target[0]);
        }
        
        return call_user_func_array($target, $param);
    }
    
    /**
     * forces shortcode to 'return' string instead of
     * echoing
     * 
     * @param string $shortcode
     * @return string shortcode output
     */
    
    public static function do_shortcode($shortcode){
        ob_start();
        $returned_content = do_shortcode($shortcode);
        $content = trim(ob_get_clean()) ?: $returned_content;
        return $content;
    }
    
    public static function DS($dir){
        $ds = DIRECTORY_SEPARATOR;
        return trim(str_replace(array("/","\\"), $ds, $dir));
    }
    
    public static function has_prefix($prefix, $subject){
        $subject = trim($subject);
        return strpos($prefix, $subject) === 0;
    }
    
    public static function force_return($callback, $param){
        ob_start();
        
        //defualt function return value
        $r = static::call_target($callback, $param);
        
        //buffered content
        $clean = ob_get_clean();
        
        //if function already returns value just return that
        //else return the buffered content
        $content = isset($r) ? $r : $clean;
    }
}

?>
