<?php
function mosacademy_metaboxes() {
    $prefix = '_mosacademy_';

    $banner_settings = new_cmb2_box(array(
        'id' => $prefix . 'banner_settings',
        'title' => __('Banner Settings', 'cmb2'),
        'object_types' => array('banner'),
    )); 
    $banner_settings->add_field( array(
        'name' => 'Title',
        'type'    => 'wysiwyg',
        'id'   => $prefix.'banner_title',        
        'options' => array(
            'wpautop' => true, // use wpautop?
            'media_buttons' => false, // show insert/upload button(s)
            //'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
            'textarea_rows' => get_option('default_post_edit_rows', 3), // rows="..."
            //'tabindex' => '',
            //'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
            ///'editor_class' => '', // add extra class(es) to the editor textarea
            //'teeny' => false, // output the minimal editor config used in Press This
            //'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
            'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
            'quicktags' => false // load Quicktags, can be used to pass settings directly to Quicktags using an array()
        ),
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

    $project_settings = new_cmb2_box(array(
        'id' => $prefix . 'project_settings',
        'title' => __('Project Settings', 'cmb2'),
        'object_types' => array('project'),
    ));
    $project_settings->add_field( array(
        'name' => 'Project URL',
        'type' => 'text_url',
        'id'   => $prefix.'project_url',
    ));

    $testimonial_settings = new_cmb2_box(array(
        'id' => $prefix . 'testimonial_settings',
        'title' => __('Testimonial Settings', 'cmb2'),
        'object_types' => array('testimonial'),
    ));
    $testimonial_settings->add_field( array(
        'name' => 'Company Logo',
        'id'   => $prefix.'testimonial_company_logo',
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
    $testimonial_settings->add_field( array(
        'name' => 'Name',
        'type' => 'text',
        'id'   => $prefix.'testimonial_name',
    ));
    $testimonial_settings->add_field( array(
        'name' => 'Designation',
        'type' => 'text',
        'id'   => $prefix.'testimonial_designation',
    ));
    
    $page_group_details = new_cmb2_box(array(
        'id' => $prefix . 'page_group_details',
        'title' => __('Page Details', 'cmb2'),
        'object_types' => array('page'),
        //'show_on'      => array( 'key' => 'page-template', 'value' => 'page-template/lightbox-multy-gallery-page.php' ),        
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true
    )); 
    /*$page_group_details->add_field(array(
        'name' => __('Tab Location', 'cmb2'),  
        'id' => $prefix . 'page_group_location', 
        'type'             => 'select',
        'default'          => 'before',
        'options'          => array(
            'before' => __( 'Before Content', 'cmb2' ),
            'after'   => __( 'After Content', 'cmb2' ),
        ),
    ));*/

    $page_group_details_id = $page_group_details->add_field( array(
        'id'   => $prefix . 'page_group_details_group',
        'type' => 'group',
        // 'repeatable'  => false, // use false if you want non-repeatable group
        'options'     => array(
            'group_title'       => __( 'Section {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'        => __( 'Add Another Section', 'cmb2' ),
            'remove_button'     => __( 'Remove Section', 'cmb2' ),
            'sortable'          => true,
            // 'closed'         => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    )); 

    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Section Title',
        'id'   => $prefix . 'page_group_title_text',
        'type'    => 'wysiwyg', 
        'options' => array(
            'wpautop' => true, // use wpautop?
            'media_buttons' => false, // show insert/upload button(s)
            //'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
            'textarea_rows' => get_option('default_post_edit_rows', 3), // rows="..."
            //'tabindex' => '',
            //'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
            ///'editor_class' => '', // add extra class(es) to the editor textarea
            //'teeny' => false, // output the minimal editor config used in Press This
            //'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
            'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
            'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
        ),
    ));
    
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name'    => 'Section Sub titles',
        'id'      => $prefix . 'page_group_sub_titles',
        'type'    => 'text',
        'repeatable' => true,
    ));

    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Section Description',
        'id'   => $prefix . 'page_group_title_description',
        'type'    => 'wysiwyg', 
        'options' => array(
            'wpautop' => true, // use wpautop?
            'media_buttons' => false, // show insert/upload button(s)
            //'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
            'textarea_rows' => get_option('default_post_edit_rows', 6), // rows="..."
            //'tabindex' => '',
            //'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
            ///'editor_class' => '', // add extra class(es) to the editor textarea
            //'teeny' => false, // output the minimal editor config used in Press This
            //'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
            'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
            'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
        ),
    )); 

    $page_group_details->add_group_field( $page_group_details_id, array(
        'name'    => 'Section Background Image',
        'desc'    => 'Upload an image or enter an URL.',
        'id'      => $prefix . 'page_group_background_image',
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
    
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Section Component Name',
        'type' => 'text',
        'id'   => $prefix.'page_group_component_name',
    ));
    
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Section Class',
        'type' => 'text',
        'id'   => $prefix.'page_group_css',
    ));
    
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Section Button Text',
        'type' => 'text',
        'id'   => $prefix.'page_group_button_title',
    ));
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Section Button URL',
        'type' => 'text_url',
        'id'   => $prefix.'page_group_button_url',
    ));

}
add_action('cmb2_admin_init', 'mosacademy_metaboxes');