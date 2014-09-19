<?php namespace WXP;

class Autoloader {
    
    public $path;
    
    function __construct($path) {
        $this->path = $path;
    }
    
    function load($class){
        $file = rtrim(preg_replace("/{([\s]*class[\s]*)}/", $class, $this->path), '\\') .'\\' .ltrim($class, '\\') .'.php';
        $file = str_replace("/", DIRECTORY_SEPARATOR, $file);
        if(!file_exists($file)) return false;
        require $file;
    }
    
    static function register($path){
        $loader = __CLASS__;
        $loader = new $loader($path);
        spl_autoload_register(array($loader, "load"));
        return $loader;
    }
    
}

?>
