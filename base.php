<?php use WXP\WXP;

    /**********************************************************************
     * The Body/base Header
     *********************************************************************/

    get_template_part('views/base/header'); 

    do_action('get_header'); 
      
    /**********************************************************************
     * Choose the layout header
     *********************************************************************/

    get_template_part("views/base/layouts/parts/header", view_var("layout_header"));

    /**********************************************************************
     * Choose the template layout/columns
     *********************************************************************/
    
    get_template_part("views/base/layouts/column", view_var("layout"));

    /**********************************************************************
     * get the layout footer
     *********************************************************************/            

    get_template_part("views/base/layouts/parts/footer", view_var("layout_footer"));

    
    /**********************************************************************
     * The Body/base Footer
     *********************************************************************/    
    
    get_template_part('views/base/footer'); 
 ?>

