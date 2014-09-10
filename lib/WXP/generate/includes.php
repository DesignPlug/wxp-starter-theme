<?php 

use WXP\WXP;
use WXP\Generator\Generator;

$ds  = DIRECTORY_SEPARATOR;
$dir =  dirname(dirname(__FILE__));

/*************************************************
 * WXP DIRECTORY
 ************************************************/

define("WXPDIR", "{$dir}{$ds}src{$ds}WXP{$ds}");

/*************************************************
 * INCLUDES
 ************************************************/

require WXPDIR ."WXP.php";
require WXPDIR .WXP::DS("Generator/Generator.php");

/*************************************************
 * CONSTANTS
 ************************************************/

define("TPLDIR",    WXP::DS(dirname(dirname($dir))));
define("BUILDPATH", WXPDIR .WXP::DS("/Generator/paths/") );
define("TPLCONTENTSPATH", WXPDIR .WXP::DS("/Generator/templates/") );

/**
 * generates vendor or child theme starter directories
 * 
 * @param string $root_path
 * @param array $build
 * @param callable $callbacks
 */


function generate($root_path, $mkdir = false, $build, $callbacks = array()){
    $g = new Generator($root_path, $mkdir);
    return $g->build($build, $callbacks);
}

/**
 * checks if is $varname is valid variable name. 
 * 
 * @param string $varname
 * @return boolean returns true if valid, false if not
 */

function is_valid_varname($varname){
    if(!preg_match('/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/',$varname)){
       return false;
    }
    return true;
}

/**
 * 
 * 
 */

function parse_template_vars($path, $param){
    if($content = get_template_contents($path)){
        foreach($param as $k => $v){
            $content = preg_replace("/{([\s]*".$k."[\s]*)}/", $v, $content);
        }
        return $content;
    }
}

/**
 * 
 */

function get_template_contents($template, $ext = "tpl"){
    $tpl = pathinfo($template);
    if(!@$tpl["extension"]) return false;
    $tpl = $tpl["filename"].".".$tpl["extension"];
    return @file_get_contents(TPLCONTENTSPATH .$tpl .".".$ext);
}
