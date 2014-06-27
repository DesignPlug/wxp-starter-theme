<?php use WXP\DomRouter;


 DomRouter::getInstance()->on('common', 'Theme\Controllers\ViewController#common')
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
                         ->on('error404', 'Theme\Controllers\ViewController#error404');




?>
