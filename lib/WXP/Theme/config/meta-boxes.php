<?php

/**
 * Initialize the meta boxes. 
 */
add_action( 'admin_init', 'wxp_meta_boxes' );

function wxp_meta_boxes() {

  $my_meta_box = array(
    'id'        => 'wxp_layout_options',
    'title'     => 'Page Layout Options',
    'desc'      => '',
    'pages'     => array( 'post', 'page' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(
      array(
        'id'          => 'wxp_layout_header_subtitle',
        'label'       => 'Page Sub Heading',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text'
      ),
      array(
        'id'          => 'wxp_layout_header',
        'label'       => 'Page Header Style',
        'desc'        => '',
        'std'         => 'post',
        'type'        => 'select',
        'choices'     => array(
            array(
                'label' => 'Default',
                'value' => 'post'
            ),
            array(
                'label' => 'Jumbotron',
                'value' => 'jumbotron'
            ),
            array(
                'label' => 'Slider',
                'value' => 'slider'
            )
        )
      ),
      array(
        'id'          => 'wxp_layout_header_slider_shortcode',
        'label'       => 'Slider Shortcode',
        'desc'        => 'Paste the slider\'s shortcode here (only used on slider header style)',
        'std'         => '',
        'type'        => 'text'
      )  
    )
  );
  
  ot_register_meta_box( $my_meta_box );

}