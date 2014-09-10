<?php

add_action("WXP.set_dom_routes", function($router){
    
     $router->on('common', 'Theme\Controllers\ViewController#common')
            ->on('common', 'Theme\Controllers\ScriptController#common')
            ->on('archive', 'Theme\Controllers\ViewController#archive')
            ->on('category', 'Theme\Controllers\ViewController#category')
            ->on('author', 'Theme\Controllers\ViewController#author')
            ->on('blog', 'Theme\Controllers\ViewController#blog')
            ->on('tag', 'Theme\Controllers\ViewController#tag')
            ->on('date', 'Theme\Controllers\ViewController#date')
            ->on('search', 'Theme\Controllers\ViewController#search')
            ->on('single', 'Theme\Controllers\ViewController#single')
            ->on('page', 'Theme\Controllers\ViewController#page')
            ->on(array('single'), function($View){
                $View->add("layout_header", "jumbotron");
            })
            ->on('error404', 'Theme\Controllers\ViewController#error404');
});







?>
