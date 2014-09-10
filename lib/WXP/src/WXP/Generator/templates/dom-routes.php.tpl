<?php


/** uncomment these routes and create your own

add_action("WXP.set_dom_routes", function($router){
    
            # any callback you bind to the 'common' class will be fired first on every page

     $router->on('common', '{themename}\Controllers\ViewController#common')
            ->on('common', '{themename}\Controllers\ScriptController#common')
            
            #bind action to the the body class. That will fire when bodyclass set
            
            ->on('archive', '{themename}\Controllers\ViewController#archive')
            ->on('category', '{themename}\Controllers\ViewController#category')
            ->on('author', '{themename}\Controllers\ViewController#author')
            ->on('blog', '{themename}\Controllers\ViewController#blog')
            ->on('tag', '{themename}\Controllers\ViewController#tag')
            ->on('date', '{themename}\Controllers\ViewController#date')
            ->on('search', '{themename}\Controllers\ViewController#search')
            ->on('single', '{themename}\Controllers\ViewController#single')
            ->on('page', '{themename}\Controllers\ViewController#page')
            
            #you can also bind closures, and any other callible function to a class
            #or combination of classes
            
            ->on(array('single'), function($View){
                $View->add("layout_header", "jumbotron");
            })
            
            #fire this action when page is 404
            
            ->on('error404', '{themename}\Controllers\ViewController#error404');
});

*/