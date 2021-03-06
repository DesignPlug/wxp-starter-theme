<?php

/**********************************************
* {frameworkfn} uses options tree framework to
*  generate meta-boxes and theme options. {frameworkfn}
*  will check your config folder for meta-boxes.php 
*  and include it if it exists. To remove {frameworkfn}'s
*  default meta options add this line of code in
*  functions.php

add_filter("{framework}.{framework_theme}.include_meta_boxes", "__return_false");

* this will prevent {frameworkfn} from including default 
* meta-boxes
***********************************************/


/** uncomment and modify to create your own metaboxes

add_action( 'admin_init', 'custom_meta_boxes' );

function custom_meta_boxes() {

  $my_meta_box = array(
    'id'        => 'wxp_layout_options',
    'title'     => 'Page Layout Options',
    'desc'      => '',
    'pages'     => array( 'post', 'page' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(
      array(
        'id'          => 'wxp_page_subheading',
        'label'       => 'Page Sub Heading',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text'
      ),
      array(
        'id'          => 'wxp_page_header_style',
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
        'id'          => 'wxp_page_slider_shortcode',
        'label'       => 'Slider Shortcode',
        'desc'        => 'Paste the slider\'s shortcode here (only used on slider header style)',
        'std'         => '',
        'type'        => 'text'
      )  
    )
  );
  
  ot_register_meta_box( $my_meta_box );

}

*/