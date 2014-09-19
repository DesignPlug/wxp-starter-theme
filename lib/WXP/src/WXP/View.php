<?php namespace WXP;


class View {
    
    protected $data = array(),
              $render_path = "",
              $render_path_name = "",
              $namespace;
    
    static protected $instance;
    
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
    
    function set_render_path($render_path, $name = ""){
        $this->render_path = WXP::DS($render_path);
        $this->render_path_name = $name ?: $this->render_path_name;
        return $this;
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
    
    function __toString() {
        ob_start();
        $this->render();
        return ob_get_clean();
    }
    
    /**
     * get view data, with all filters applied
     * 
     * @return array View data
     */
    
    function get_data(){
        $data = array();
        foreach($this->data as $k => $v){
            $data[$k] = $this->get($k);
        }
        return $data;
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
        
        $name = $name ?: $this->render_path_name;
        
        $path = WXP::DS($path) ?: $this->render_path;
        
        //if path is an alias 
        $path = WXP::get_path($path);
        
        //get view data array with filters applied
        $data = $this->get_data();
        
        //if this is not the global view, extract
        //the global view vars
        // -- local view vars will overwrite any global view vars
        // -- in scope. Use view_var or __var function to access
        // -- the original global value
        
        if($this->namespace !== "global"){
            $global_view_data = View::getInstance()->get_data();
            extract($global_view_data);
        }
        
        //extract local view data vars if not empty
        if(!empty($data)) extract($data);
        
        require $path->name($name)->dir();
    }
}

?>
