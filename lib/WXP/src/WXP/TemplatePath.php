<?php namespace WXP;


class TemplatePath {
    
    protected $ext  = "php",
              $name = null,
              $path = "",
              $fallback = true;
    
    function __construct($path) {
        //set path, strip template directory from it
        $dir  = array(WXP::DS(get_template_directory()), WXP::DS(get_stylesheet_directory()));
        $path = str_replace($dir, "", $path);
        $this->path = ltrim($path, "\/");
    }
    
    function __toString() {
        return $this->raw();
    }
    
    function raw(){
        return $this->path;
    }
    
    function absPath(){
        return locate_template($this->set_suffix($this->path));
    }
    
    function name($name){
        $this->name = $name;
        return $this;
    }
    
    function name_isset(){
        if((string) $this->name !== ""){
            return true;
        }
        return false;
    }
    
    protected function set_suffix($path){
        $name = "";
        if($this->name_isset()){
            $name = "-{$this->name}";
        } 
        return $this->strip_ext($path) .$name .".{$this->ext}";
    }
    
    protected function strip_ext($path){
        return \preg_replace("/\.[^$]*/", "", $path);
    }
    
    function dir(){
        $templates = array();
        $templates[] = $this->set_suffix($this->path);
        
        if($this->fallback === true && $this->name_isset()){
            $templates[] = $this->strip_ext($this->path) .".{$this->ext}";
        }
        return locate_template($templates);
    }
    
    
}
