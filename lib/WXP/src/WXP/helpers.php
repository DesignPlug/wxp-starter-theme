<?php

function view_var($var){
    return \WXP\View::getInstance()->get($var);
}

function __var($name){
    echo view_var($name);
}

function wxp_get_view($path, $name = null, $param = array()){
    \WXP\WXP::get_view($path, $name, $param);
}

function wxp_global_view(){
    return view_var("wxp_global_view");
}

function wxp_reset_render_path(){
    view_var("wxp_global_view")->set_render_path(view_var("wxp_default_render_path"));
}

function wxp_include_view($path){
    WXP::include_view($path);
}

