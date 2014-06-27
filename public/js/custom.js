/*==========================================
 * 
 /*========================================
 * Use this script to fire all actions that
 * are common to each page.
 */

(function($) {

    /*=====================================
     * Sidr Responsive Drawer Nav Toggle
     *====================================*/

     if(wxp_local.rnav_support){
         
        $("a.sidr-toggle")
        .sidr({
            name   : "sidr",
            side   : wxp_local.rnav_position,
            source : "#sidr-content"
        })
        .click(function(){
            $.sidr('toggle');
        });

        $(window).resize(function(){
            $.sidr('close');
        });

        $('html').click(function(e){
           if(!$("#sidr").is(e.target)){
               $.sidr('close');
           } 
        });
        
    }

    /*=======================================
     * Twitter Bootstrap Dropdown menu
     *======================================*/

    $('.navtop .dropdown-toggle').dropdown();

})( jQuery );