<?php namespace WXP\Generator;
use WXP\WXP;

class Generator {
    
    protected $path;
            
    function __construct($gPath = "/", $mkPath = false) {
        
        $gPath = WXP::DS($gPath);
        
        //if dir does not exist, and mkPath is set to = false
        //throw error
        
        if(!is_dir($gPath) && $mkPath == false){
            throw new \InvalidArgumentException("Path: {$gPath}, does not exist, first arg \$gPath must be a real path");
        } 
        
        //if mkPath is set to = true, create the dir
        
        else if(!is_dir($gPath)){
            if(!$this->makeDir($gPath)){
                throw new \Exception("An error, occurred, path not created");
            }
        }
        
        $this->path = $gPath;
    }
    
    /**
     * creates the $path if it doesn't exist
     * 
     * @param string $path
     */
    
    function makeDir($path, $perm = 0777){
        if(!is_dir($path) && !is_file($path)){
            return @mkdir(WXP::DS($path), $perm, true);
        }   
        return true;
    }
    
    /**
     * Gets the $path variable, and appends $file to the end of the path if $file
     * is passed
     * 
     * 
     * @param string $file
     * @return string path
     */
    
    function getPath($file = ""){
        return WXP::DS($this->path ."\\" .$file);
    }
    
    /**
     * Gets the contents of file if it exists,
     * else returns false
     * 
     * @param string $file filename
     * @return string|false file contents or false if file doesn't exist
     */
    
    function getFile($file){
        return file_get_contents($this->getPath($file));
    }
    
    /**
     * creates a new file, and parent directories if
     * they don't exist
     * 
     * @param string $file 
     * return int|false number of bytes or false if error occurred
     * 
     */
    
    function makeFile($file, $contents = ""){
        $path = $this->getPath($file);
        
        //if path has no extension throw an error
        if(!$this->pathinfo($file, "extension")){
            throw new \InvalidArgumentException("first argument \$file must have an extension, none given");
        }
        
        //create path
        $this->makeDir(dirname($path));
        
        //create file
        file_put_contents($path, $contents);
    }
    
    /**
     * get an element from the pathinfo array, or the whole array
     * 
     * 
     * @param string $path path to get info from
     * @param string $key returns a specific key from the path info array
     */
    
    function pathinfo($path, $key = false){
        $pathinfo = pathinfo($path);
        if($key){
            return @$pathinfo[$key];
        }
        return $pathinfo;
    }
    
    /**
     * builds a folder structure of files and directories
     * allows callbacks to be fired on the creation of certain
     * files
     * 
     * @param array $folder_structure
     * @param array $callbacks
     */
    
    function build($folder_structure, $callbacks = array()){
        foreach($folder_structure as $handle => $path){
            
            $contents = "";
            
            if(isset($callbacks["_all"])){
                $contents = WXP::call_target($callbacks["_all"], array($this, $path)) ?: ""; 
            }
            
            if(isset($callbacks[$handle])){
                $contents = WXP::call_target($callbacks[$handle], array($this, $path)) ?: "";
            }

            
            //create file or path

            $this->pathinfo($path, "extension") ? $this->makeFile($path, $contents) : $this->makeDir($path);
        }
    }
    
}
