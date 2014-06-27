<?php namespace WXP;

class Options {
    
    function get($option_id, $default = null){
        if(function_exists("ot_get_option")){
            return ot_get_option($option_id, $default);
        } else {
            $option = get_option($option_id);
            if($option){
                return $option;
            } else {
                return $default;
            }
        }
    }
    
    
}
