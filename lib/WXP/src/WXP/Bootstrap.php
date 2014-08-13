<?php namespace WXP;

use WXP\Autoloader;
use WXP\WXP;
use WXP\View;
use WXP\DomRouter;

class Bootstrap {
    
    protected $themes = array();
    
    /*************************************************
     * Register theme dir so that autoloader
     * will check the current theme directory for
     * controllers etc... 
     *************************************************/
    
    static function theme($path_to_classes = "", $config_path = ""){
        
        $path     = $c_path = WXP::DS(get_template_directory());
        $path    .= $path_to_classes ? WXP::DS('\\' .$path_to_classes) : "";
        $c_path  .= $config_path ? WXP::DS('\\' .$config_path) : "";
        
        
        spl_autoload_register(array(new Autoloader($path), "load"));
        
        static::register_paths($c_path); 
    }
    
    static function register_paths($path){
        
        /******************************************
         * Require init & constants files if exists
         ******************************************/
        
        add_action('after_setup_theme', function() use($path){

            if(file_exists(WXP::DS($path ."\config\constants.php"))){
                require WXP::DS($path ."\config\constants.php");
            }
            
            if(file_exists(WXP::DS($path ."\config\init.php"))){
                require WXP::DS($path ."\config\init.php");
            }
            
            //load scripts if exist

            if(file_exists(WXP::DS($path ."\config\scripts.php"))){
                add_action("wp_enqueue_scripts", function() use ($path){
                   require WXP::DS($path ."\config\scripts.php"); 
                });
            }
            
            //load dom routes if exist
            
            if(file_exists(WXP::DS($path ."\config\dom-routes.php"))){
                require WXP::DS($path ."\config\dom-routes.php");
            }
            
            //load options file if exists
            
            if(file_exists(WXP::DS($path ."\config\options.php"))){
                require WXP::DS($path ."\config\options.php");
            }
            
            //load meta bozes file if exists
            
            if(file_exists(WXP::DS($path ."\config\meta-boxes.php"))){
                require WXP::DS($path ."\config\meta-boxes.php");
            }
        });
    }
    
    function __construct() {
        add_action("after_setup_theme", array(&$this, "init"));
    }
    
    function init(){
        do_action("WXP.register_base_theme", $this);
        do_action("WXP.register_theme", $this);
        $this->include_config_files();
        add_action("template_include", array(&$this, "run"));
    }
    
    function run($default_template){
        
        //set template paths
        $Path = apply_filters("WXP.get_paths_object", new Path);
        do_action("WXP.set_template_paths", $Path);
                
        WXP::setPaths($Path);
        
        //allow override of global View object
        $View = apply_filters("WXP.get_global_view", View::getInstance());
        //set global View object variable for easy access
        $View->add("wxp_global_view", $View);
        
        //set default render path
        $View->set_render_path($default_template);
        
        //do dom routing action
        $router = apply_filters("WXP.get_dom_router", DomRouter::getInstance());
        do_action("WXP.set_dom_routes", $router);
        
        $router->route();
        
        //now include view.php; which will render the global view
 
        return apply_filters("WXP.view_render_page", WXP::DS(get_template_directory() ."/view.php"));
    }
    
    
    function register_theme($theme_handle, $class_path, $config_path){
        
        $tPath = new Path;
        
        //set paths
        $tPath->add("classes", $class_path, false)
              ->add("config", $config_path, false);
        
        //set autoload paths
        spl_autoload_register(array(new Autoloader($tPath->to("classes")), "load"));
        
        //set theme path
        $this->themes[$theme_handle] = $tPath;
        
        return $this;
    }
    
    function include_config_files(){

        foreach($this->themes as $theme => $path){

            $config_path = $path->to('config') .DIRECTORY_SEPARATOR;
            
            //allow developer to replace config paths, 
            //if false is returned, don't include it
            
            $scripts = $config_path .WXP::DS("config\scripts.php");
            $this->include_path($scripts, "WXP.{$theme}.include_scripts_path", function() use ($scripts){
                add_action("wp_enqueue_scripts", function() use ($scripts){
                        require $scripts;
                    });
            });
            
            //load dom routes if exist
            
            $domRoutes = $config_path .WXP::DS("config/dom-routes.php");
            $this->include_path($domRoutes, "WXP.{$theme}.include_dom_routes");
            
            //load options file if exists
            
            $theme_options = $config_path .WXP::DS("config/options.php");
            $this->include_path($theme_options, "WXP.{$theme}.include_theme_options");
            
            //load meta boxes file if exists
            
            $meta_boxes = $config_path .WXP::DS("config/meta-boxes.php");
            $this->include_path($meta_boxes, "WXP.{$theme}.include_meta_boxes");
            
            
            //load paths if set
            
            $t_paths = $config_path .WXP::DS("config/paths.php");
            $this->include_path($t_paths, "WXP.{$theme}.include_template_paths");
            
        }
    }
    
    protected function include_path($path, $filter_hook, $callback = false){
        if(file_exists($path)){
            $path = apply_filters($filter_hook, $path);
            if($path){
                if($callback){
                    call_user_func($callback);
                } else {
                    require $path;
                }
            }
        }
    }
    
}

?>
