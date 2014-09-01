<?php namespace WXP;


class View {
    
    protected $data = array(),
              $render_path = "",
              $namespace;
    
    static protected $instance;
    
    static function __callStatic($name, $param)
    {
        if(method_exists(self, $name)){
            return call_user_func_array(array(static::getInstance(), $name), $param);
        }
    }
    
    static function getInstance(){
       
        if(!self::$instance){
            $class = __CLASS__;
            static::$instance = new $class("global");
        }
        return self::$instance;
    }
    
    function __construct($namespace = "", $render_path = null) {
        $this->namespace = $namespace;
        if(isset($render_path)){
            $this->set_render_path($render_path);
        }
    }
    
    function set_render_path($render_path){
        $this->render_path = WXP::DS($render_path);
    }
    
    function get_render_path($raw = false){
        if($raw){
            return $this->render_path;
        } else {
            return WXP::get_path($this->render_path)->dir();    
        }
    }
    
    function get_namespace(){
        return $this->namespace;
    }
    
    function __get($name) {
        return $this->get($name);
    }
    
    function __set($name, $value) {
        $this->add($name, $value);
    }
    
    function add($name, $value = null){
        if(is_array($name)){
            foreach($name as $k => $v){
                $this->add($k, $v);
            }
        } else {
            $this->data[(string) $name] = $value;
        }
        return $this;
    }
    
    function get($name){
        return apply_filters("WXP.view.{$this->namespace}.{$name}", @$this->data[$name]);
    }
    
    public function bind($template_path, $values = array()){
        add_action("WXP.set_view_{$template_path}", function($View) use ($values){
            $View->add($values);
        });
        return $this;
    }
    
    function render($path = null, $name = ""){
        $path = WXP::DS($path) ?: $this->render_path;
        
        //if path is only an alias 
        $path = WXP::get_path($path);
        
        //build view data array with filters applied
        $data = array();
        foreach($this->data as $k => $v){
            $data[$k] = $this->get($k);
        }
        
        extract($data, EXTR_OVERWRITE);
        require $path->name($name)->dir();
    }
}

?>
