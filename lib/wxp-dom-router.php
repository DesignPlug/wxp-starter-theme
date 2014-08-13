<?php
/*
Plugin Name: WP Expressive Dom Router
Plugin URI: http://www.designplug.net
Description: Create Cleaner and Scalable views with WXP DomRouter. WXP DomRouter provides an organized way to handle your queries and other business logic, and make variables accessible in wordpress templates. Wordpress body classes provide a ton of information about the current page that WXP DomRouter allows Theme developers make use of for determining what content should be loaded on each page.
Version: 0.1.0
Author: Ric Anthony Lee
Author URI: http://www.facebook.com/theleecode
License: MIT
*/

use WXP\WXP;
use WXP\Bootstrap;


$ds = DIRECTORY_SEPARATOR;

require 'WXP'.$ds.'src'.$ds.'WXP'.$ds.'WXP.php';
require  WXP::DS('WXP/src/WXP/Autoloader.php');
require  WXP::DS('WXP/src/WXP/TemplatePath.php');
require  WXP::DS('WXP/src/WXP/Path.php');
require  WXP::DS('WXP/src/WXP/Bootstrap.php');
require  WXP::DS('WXP/src/WXP/DomRouter.php');
require  WXP::DS('WXP/src/WXP/Options.php');
require  WXP::DS('WXP/src/WXP/Controller.php');
require  WXP::DS('WXP/src/WXP/View.php');
require  WXP::DS('WXP/src/WXP/helpers.php');


/*****************************************************
 * Begin Routing
 *****************************************************/

new Bootstrap;

?>
