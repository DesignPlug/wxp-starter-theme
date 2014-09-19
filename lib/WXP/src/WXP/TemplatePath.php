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
    
    /**
     * get the raw path, without added extension or base path prefix
     * 
     * @return string the path
     */
    
    function raw(){
        return $this->path;
    }
    
    /**
     * performs locate template on given template path. Note: this method
     * does not default to a nameless version of the template path if 
     * name is assigned to template path
     * 
     * @return string|false returns absolute path to template file or false if doesn't exist
     */
    
    function absPath(){
        return locate_template($this->set_suffix($this->path));
    }
    
    /**
     * set the template name
     * 
     * @param string $name
     * @return \WXP\TemplatePath
     */
    
    function name($name){
        $this->name = $name;
        return $this;
    }
    
    /**
     * check if path has a name
     * 
     * @return boolean true if template has a name set, false if not
     */
    
    function name_isset(){
        if((string) $this->name !== ""){
            return true;
        }
        return false;
    }
    
    /**
     * adds the extension and template name to the end of the given
     * path string
     * 
     * @param string $path
     * @return string $path with suffix
     */
    
    protected function set_suffix($path){
        $name = "";
        if($this->name_isset()){
            $name = "-{$this->name}";
        } 
        return $this->strip_ext($path) .$name .".{$this->ext}";
    }
    
    
    /**
     * strips the extension from given path
     * 
     * @param string $path
     * @return string path without extension
     */
    
    protected function strip_ext($path){
        return \preg_replace("/\.[^$]*/", "", $path);
    }
    
    
    /**
     * Performs locate template on the template path
     * 
     * @return string|false absolute path to template file or false if file doesn't exist
     */
    
    function dir(){
        $templates = array();
        $templates[] = $this->set_suffix($this->path);
        
        if($this->fallback === true && $this->name_isset()){
            $templates[] = $this->strip_ext($this->path) .".{$this->ext}";
        }
        
        return locate_template($templates);
    }
    
    
}
