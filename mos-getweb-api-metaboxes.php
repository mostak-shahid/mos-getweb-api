<?php
function mosacademy_metaboxes() {
    $prefix = '_mosacademy_';

    $page_settings = new_cmb2_box(array(
        'id' => $prefix . 'page_settings',
        'title' => __('Page Settings', 'cmb2'),
        'object_types' => array('page', 'post'),
    ));   

    $page_settings->add_field( array(
        'name' => 'Hide Page Title',
        'desc' => 'Yes I like to hide page title for this page',
        'id'   => $prefix . 'page_title',
        'type' => 'checkbox',
        //'default' => true,
    ));
    $page_settings->add_field(array(
        'name' => 'Page Title Background Image',
        'desc' => '',
        'id'   => $prefix.'banner_image',        
        'type' => 'file',
        /*'attributes' => array(
            'required'            => false, // Will be required only if visible.
            'data-conditional-id' => $prefix . 'page_title',
        ),*/
    )); 

    $banner_settings = new_cmb2_box(array(
        'id' => $prefix . 'banner_settings',
        'title' => __('Banner Settings', 'cmb2'),
        'object_types' => array('banner'),
    )); 
    $banner_settings->add_field( array(
        'name' => 'Sub Title',
        'type' => 'text',
        'id'   => $prefix.'banner_sub_title',
        'repeatable' => true,
    ));
    $banner_settings->add_field( array(
        'name' => 'Button Title',
        'type' => 'text',
        'id'   => $prefix.'banner_button_title',
    ));
    $banner_settings->add_field( array(
        'name' => 'Button URL',
        'type' => 'text_url',
        'id'   => $prefix.'banner_button_url',
    ));
    $banner_settings->add_field( array(
        'name' => 'Banner Images',
        'desc' => '',
        'id'   => $prefix.'banner_gallery',
        'type' => 'file_list',
        // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
        'query_args' => array( 'type' => 'image' ), // Only images attachment
        // Optional, override default text strings
        /*'text' => array(
            'add_upload_files_text' => 'Replacement', // default: "Add or Upload Files"
            'remove_image_text' => 'Replacement', // default: "Remove Image"
            'file_text' => 'Replacement', // default: "File:"
            'file_download_text' => 'Replacement', // default: "Download"
            'remove_text' => 'Replacement', // default: "Remove"
        ),*/
    ));
    
    $tab_group_details = new_cmb2_box(array(
        'id' => $prefix . 'tab_group_details',
        'title' => __('Multy Tab Details', 'cmb2'),
        'object_types' => array('page'),
        //'show_on'      => array( 'key' => 'page-template', 'value' => 'page-template/lightbox-multy-gallery-page.php' ),        
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true
    )); 
    $tab_group_details->add_field(array(
        'name' => __('Tab Location', 'cmb2'),  
        'id' => $prefix . 'tab_group_location', 
        'type'             => 'select',
        'default'          => 'before',
        'options'          => array(
            'before' => __( 'Before Content', 'cmb2' ),
            'after'   => __( 'After Content', 'cmb2' ),
        ),
    ));

    $tab_group_details_id = $tab_group_details->add_field( array(
        'id'   => $prefix . 'tab_group_details_group',
        'type' => 'group',
    )); 

    $tab_group_details->add_group_field( $tab_group_details_id, array(
        'name' => 'Tab Title',
        'id'   => $prefix . 'tab_group_title_text',
        'type' => 'text',
    ));   

    $tab_group_details->add_group_field( $tab_group_details_id, array(
        'name'    => 'Tab Title Image',
        'desc'    => 'Upload an image or enter an URL.',
        'id'      => $prefix . 'tab_group_title_images',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => false, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Add File' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            //'type' => 'application/pdf', // Make library only display PDFs.
            // Or only allow gif, jpg, or png images
            'type' => array(
             'image/gif',
             'image/jpeg',
             'image/png',
            ),
        ),
        'preview_size' => 'large', // Image size to use when previewing in the admin.
    ));    
    $tab_group_details->add_group_field( $tab_group_details_id, array(
        'name'    => 'Tab Details',
        'desc'    => 'Tab Name, Tab Desccription, Tab Content',
        'id'      => $prefix . 'tab_group_tab_details',
        'type'    => 'text',
        'repeatable' => true,
    ));  

}
add_action('cmb2_admin_init', 'mosacademy_metaboxes');