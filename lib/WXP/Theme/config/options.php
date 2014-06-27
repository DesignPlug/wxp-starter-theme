<?php

/**
 * Initialize the options before anything else. 
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array(
    'sections'        => array(
      array(
        'id'          => 'header',
        'title'       => 'Header'
      ),
      array(
         'id'         => 'navigation',
         'title'      => 'Navigation'
      ),
      array(
        'id'          => 'footer',
        'title'       => 'Footer'
      ),
      array(
        'id'          => 'social',
        'title'       => 'Social'
      ),
      array(
        'id'          => 'error_404',
        'title'       => '404 Page'
      )
      
    ),
    'settings'        => array(
      array(
        'id'          => 'wxp_company_logo',
        'label'       => 'Company Logo',
        'desc'        => 'A ' .WXP_HEADER_LOGO_DIMEN .'px image of your brand logo, that will show in the header',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header'
      ),
      array(
        'id'          => 'wxp_slider_shortcode',
        'label'       => 'Slider Shortcode',
        'desc'        => 'Slider that will show in the header if your theme supports it',
        'type'        => 'text',
        'section'     => 'header'
      ),
      array(
        'id'          => 'wxp_rnav_support',
        'label'       => 'Use Responsive Drawer Navigation?',
        'type'        => 'checkbox',
        'section'     => 'navigation',
        'choices'     => array(
          array(
              'value'   => 1,
              'label'   => ''
          )
        )  
      ),  
      array(
        'id'          => 'wxp_rnav_position',
        'label'       => 'Responsive Drawer Navigation Position',
        'desc'        => 'Which side of the screen should the Responsive drawer Navigation toggle from?',
        'type'        => 'radio',
        'section'     => 'navigation',
        'choices'     => array(
          array(
              'value'   => 'left',
              'label'   => 'Left'
          ),
          array(
              'value'   => 'right',
              'label'   => 'Right'
          )
        )
      ),
      array(
        'id'          => 'wxp_copyright',
        'label'       => 'Copyright Information',
        'desc'        => 'The copyright information that will appear at the footer of the site',
        'type'        => 'text',
        'std'         => '&copy; ' .date('Y')." ".get_bloginfo('name'),  
        'section'     => 'footer'
      ),
      array(
        'id'         => 'wxp_social_facebook',
        'label'      => 'Facebook URL',
        'type'       => 'text',
        'section'    => 'social',
        'desc'       => 'URL to your facebook account ex: http://www.facebook.com/username'
      ),
      array(
        'id'         => 'wxp_social_twitter',
        'label'      => 'Twitter URL',
        'type'       => 'text',
        'section'    => 'social',
        'desc'       => 'URL to your twitter account ex: http://www.twitter.com/@username'  
      ),
      array(
        'id'         => 'wxp_social_googleplus',
        'label'      => 'Google + URL',
        'type'       => 'text',
        'section'    => 'social',
        'desc'       => 'URL to your google plus account ex: http://www.googleplus.com/username'  
      ),
      array(
        'id'         => 'wxp_social_instagram',
        'label'      => 'Instagram URL',
        'type'       => 'text',
        'section'    => 'social',
        'desc'       => 'URL to your instagram account ex: http://www.instagram.com/@username'  
      ),
      array(
        'id'         => 'wxp_social_pinterest',
        'label'      => 'Pinterest URL',
        'type'       => 'text',
        'section'    => 'social',
        'desc'       => 'URL to your Pinterest account ex: http://www.pinterest.com/username'  
      ),
      array(
        'id'         => 'wxp_social_vimeo',
        'label'      => 'Vimeo URL',
        'type'       => 'text',
        'section'    => 'social',
        'desc'       => 'URL to your Vimeo account ex: http://www.vimeo.com/username'  
      ),
      array(
        'id'         => 'wxp_social_dribbble',
        'label'      => 'Dribbble URL',
        'type'       => 'text',
        'section'    => 'social',
        'desc'       => 'URL to your Dribbble account ex: http://www.dribbble.com/username'  
      ),
      array(
        'id'         => 'wxp_error404_template',
        'label'      => 'Error 404 Page',
        'type'       => 'page_select',
        'section'    => 'error_404',
        'desc'       => 'choose the page you want to use as a 404 error page'  
      )
    )
);
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}