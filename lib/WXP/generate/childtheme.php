<?php 

    require "includes.php";

    do{
        
        $pass = false;
        
        // >> get name of theme
        fwrite(STDOUT, "Enter Name of Theme: ");

        // << got name 
        $name      = trim(fgets(STDIN));
        
        //create new dir
        $mkdir = false;
        
        // check if name is valid varname
        if(is_valid_varname($name)){
            
            //build theme path
            $themepath = dirname(TPLDIR) .DIRECTORY_SEPARATOR .$name;
            
            //if folder does not exist, as user if they'd like to create the dir
            if(!is_dir($themepath)){
                
                // >> get answer
                fwrite(STDOUT, "Theme directory {$themepath} does not exist; create it y/n?");
                
                $answer = trim(fgets(STDIN));
                if($answer !== "Y" && $answer !== "y"){
                    exit();
                }
                
                $mkdir = true;
            }
            
            $pass = true;
            
        } else {
            echo "Theme name must follow variable naming conventions\n";
        }
        
    }while(!$pass);

    //load build paths
    $build = require BUILDPATH ."childtheme.php";   
    
    generate($themepath, $mkdir, $build);
