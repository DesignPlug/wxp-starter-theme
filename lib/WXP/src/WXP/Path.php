<?php namespace WXP;
use WXP\WXP;
use WXP\TemplatePath as TplPath;


class Path{
    
    protected $paths = array();
    
    function add($path_alias, $path, $template = true){
        if($template){
            $this->paths[$path_alias] = new TplPath(rtrim(WXP::DS($path), DIRECTORY_SEPARATOR));
        } else {
            $this->paths[$path_alias] = $path;
        }
        return $this;
    }
    
    function remove($path_alias){
        unset($this->paths[$path_alias]);
        return $this;
    }
    
    function exists($path_alias){
        if(isset($this->paths[$path_alias])){
            return true;
        }
        return false;
    }
    
    function to($path_alias){
        
        if($this->exists($path_alias)){
            return $this->paths[$path_alias]; 
        }
        throw new \Exception("Attempted to get undefined path #" .$path_alias);
    }
    
}
