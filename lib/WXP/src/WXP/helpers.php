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

