<?php

$build = require dirname(__FILE__) .DIRECTORY_SEPARATOR .'vendor.php';

$more_paths =  array(
                    "BaseVendor"  => "vendor",
                    "Style"       => "style.css",
                    "Index"       => "index.php",
                    "ScreenShot"  => "screenshot.png"   
                );

 return array_merge($build, $more_paths);


