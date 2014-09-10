<?php

# Register {themename} theme 

add_action("WXP.register_theme", function($bootstrap){
    $class_dir = get_stylesheet_directory() ."/lib/";
    $bootstrap->register_theme("{themename}", $class_dir, "{$class_dir}/{themename}/");
});

?>