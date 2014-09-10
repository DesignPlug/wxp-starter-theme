<?php

/***************************************************
* This file exists so that Wordpress knows {themename}
* is a theme. We don't use it by default. If you want 
* to use it, just add this line of code to config/dom-routes.php

$router->on(“common”, function(){
	wxp_reset_render_path();
});

This will force Wordpress to revert back to it's default template
hierarchy. Don't Worry, you can still make use of {framework} functions
for dry Wordpress templating.

****************************************************/