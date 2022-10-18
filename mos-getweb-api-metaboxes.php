<?php
function mosacademy_metaboxes() {
    $optionCat = ['post'=>'Blogs', 'testimonial'=>'Testimonials'];
    $blockCategories = mos_get_terms('block_category');
    //var_dump($blockCategories);
    foreach($blockCategories as $cat){
        $optionCat[$cat['term_id']] = $cat['name'];
    }
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
            'wpautop' => false, // use wpautop?
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
        'name' => 'Project Follow Link',
        'type' => 'text_url',
        'id'   => $prefix.'project_follow_link',
        'default' => 'https://www.facebook.com/getwebinc'
    ));
    $project_settings->add_field( array(
        'name' => 'Project Tool',
        'id'   => $prefix.'project_tool',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Add Project Tool Logo' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array( 'type' => 'image' ),
        /*'query_args' => array(
            //'type' => 'application/pdf', // Make library only display PDFs.
            // Or only allow gif, jpg, or png images
            'type' => array(
             'image/gif',
             'image/jpeg',
             'image/png',
            ),
        ),*/
        'preview_size' => 'large', // Image size to use when previewing in the admin.
    ));
    $project_settings->add_field( array(
        'name' => 'Project Gallery',
        'desc' => '',
        'id'   => $prefix.'project_gallery',
        'type' => 'file_list',
        'preview_size' => array( 'large' ), // Default: array( 50, 50 )
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
    $project_settings->add_field( array(
        'name' => 'Project Likes',
        'type' => 'text',
        'id'   => $prefix.'project_like',
        'repeatable' => true,
    ));
    /*$project_settings->add_field( array(
        'name' => 'Project views',
        'type' => 'text',
        'id'   => $prefix.'project_view',
        'repeatable' => true,
    ));*/
    $project_settings->add_field( array(
        'name' => 'Project views count',
        'type' => 'text',
        'id'   => $prefix.'project_view_count',
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
            'url' => true, // Hide the text input for the url
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
    
    $page_banner_details = new_cmb2_box(array(
        'id' => $prefix . 'page_banner_details',
        'title' => __('Banner Details', 'cmb2'),
        'object_types' => array('page'),
        //'show_on'      => array( 'key' => 'page-template', 'value' => 'page-template/lightbox-multy-gallery-page.php' ),        
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true
    )); 
    $page_banner_details->add_field( array(
        'name' => 'Tagline',
        'type' => 'text',
        'id'   => $prefix.'page_banner_tagline',
    ));
    $page_banner_details->add_field( array(
        'name' => 'Title',
        'type'    => 'wysiwyg', 
        'options' => array(
            'wpautop' => false, // use wpautop?
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
        'id'   => $prefix.'page_banner_title',
    ));
    $page_banner_details->add_field( array(
        'name' => 'Intro',
        'type' => 'textarea',
        'id'   => $prefix.'page_banner_intro',
    ));
    $page_banner_details->add_field( array(
        'name' => 'Feature Image',
        'id'   => $prefix.'page_banner_feature_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Add Feature Image' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            //'type' => 'application/pdf', // Make library only display PDFs.
            // Or only allow gif, jpg, or png images
            'type' => array('image'),
        ),
        'preview_size' => 'large', // Image size to use when previewing in the admin.
    ));
    $page_banner_details->add_field( array(
        'name' => 'Button',
        'type' => 'button',
        'id'   => $prefix.'page_banner_button',
    ));
    $page_banner_details->add_field( array(
        'name' => 'Background Image',
        'id'   => $prefix.'page_banner_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Add Background Image' // Change upload button text. Default: "Add or Upload File"
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
    
    $page_banner_details->add_field( array(
        'name' => 'Banner Images',
        'desc' => '',
        'id'   => $prefix.'page_banner_image_gallery',
        'type' => 'file_list',
        'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
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
    
    $page_banner_details->add_field(array(
        'name' => 'Link to',
        'type' => 'button',
        'id'   => $prefix.'page_banner_button_2',
    ));
    $page_banner_details->add_field( array(
        'name' => 'Hide Banner',
        'desc' => 'Yes I like to hide banner for this page',
        'id'   => $prefix.'banner_hide',
        'type' => 'checkbox',
    ));
    /*************************************************************/
    
    $page_group_details = new_cmb2_box(array(
        'id' => $prefix . 'page_group_details',
        'title' => __('Page Details', 'cmb2'),
        'object_types' => array('page', 'post'),
        //'show_on'      => array( 'key' => 'page-template', 'value' => 'page-template/lightbox-multy-gallery-page.php' ),        
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true
    )); 
    $page_group_details_id = $page_group_details->add_field( array(
        'id'   => $prefix . 'page_group_details_group',
        'type' => 'group',
        'repeatable'  => true, // use false if you want non-repeatable group
        'options'     => array(
            'group_title'       => __( 'Section {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'        => __( 'Add Another Section', 'cmb2' ),
            'remove_button'     => __( 'Remove Section', 'cmb2' ),
            'sortable'          => true,
            'closed'         => true, // true to have the groups closed by default
            'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    )); 
    /*$page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Section Title',
        'id'   => $prefix . 'page_group_title_text',
        'type'    => 'wysiwyg', 
        'options' => array(
            'wpautop' => false, // use wpautop?
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
    )); */   
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
            'wpautop' => false, // use wpautop?
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
    /*$page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Section Description',
        'id'   => $prefix . 'page_group_title_description',
        'type'    => 'textarea', 
    ));*/  
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Section Button One',
        'type' => 'button',
        'id'   => $prefix.'page_group_button',
    ));
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Section Button Two',
        'type' => 'button',
        'id'   => $prefix.'page_group_button_2',
    ));
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name'    => 'Section Background Image',
        'desc'    => 'Upload an image or enter an URL.',
        'id'      => $prefix . 'page_group_background_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Add Background Image' // Change upload button text. Default: "Add or Upload File"
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
        'name'    => 'Section Feature Image',
        'desc'    => 'Upload an image or enter an URL.',
        'id'      => $prefix . 'page_group_freature_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Add Feature Image' // Change upload button text. Default: "Add or Upload File"
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
        'preview_size' => 'medium', // Image size to use when previewing in the admin.
    ));     
    
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name'             => 'Section Content Width',
        'id'               => $prefix . 'page_group_content_width',
        'type'             => 'select',
        'default'          => 'container-lg',
        'options'          => array(
            'container-lg' => __( 'Boxed', 'cmb2' ),
            'container-fluid full-width'   => __( 'Full Width', 'cmb2' ),
        ),
    ));
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name'             => 'Section Content Layout',
        'id'               => $prefix . 'page_group_content_layout',
        'type'             => 'select',
        'default'          => 'con-top',
        'options'          => array(
            'con-top' => __( 'Default', 'cmb2' ),
            'con-left'   => __( 'Left aligned Content', 'cmb2' ),
            'con-right'   => __( 'Right aligned Content', 'cmb2' ),
            'con-bottom'   => __( 'Bottom aligned Content', 'cmb2' ),
        ),
    ));
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Section Class',
        'type' => 'text',
        'id'   => $prefix.'page_group_css',
    ));
	$page_group_details->add_group_field( $page_group_details_id, array(
		'name' => 'Custom Component',
		'id'   => $prefix.'conditional_checkbox',
        'desc' => 'Yes, I like to add custom component',
		'type' => 'checkbox',
	));
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Component Name',
        'type' => 'text',
        'id'   => $prefix.'page_group_component_name',
		'attributes' => array(
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $page_group_details_id, $prefix.'conditional_checkbox' ) ),
			'data-conditional-value' => 'on',
		),
    )); 
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Component Data',
        'type' => 'text',
        'id'   => $prefix.'page_group_component_data',
		'attributes' => array(
			'required'               => false, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $page_group_details_id, $prefix.'conditional_checkbox' ) ),
			'data-conditional-value' => 'on',
		),
    ));   	
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name'             => 'Component Set',
        'id'               => $prefix.'page_group_components',
        'type'             => 'pw_select',
        'show_option_none' => true,
        'options'          => $optionCat,
		'attributes' => array(
			//'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $page_group_details_id, $prefix.'conditional_checkbox' ) ),
			'data-conditional-value' => 'off',
		),
    ));
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Components Count',
        'type' => 'text',
        'id'   => $prefix.'page_group_component_count_total',
		'attributes' => array(
			//'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $page_group_details_id, $prefix.'conditional_checkbox' ) ),
			'data-conditional-value' => 'off',
		),
    ));  
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name'             => 'Component Layout',
        'desc'             => 'Select an option',
        'id'               => $prefix.'page_group_component_layout',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => array(
            'block' => __( 'Block', 'cmb2' ),
            'slider'   => __( 'Slider', 'cmb2' ),
            'accordion'     => __( 'Accordion', 'cmb2' ),
            'tab'     => __( 'Tab', 'cmb2' ),
        ),
		'attributes' => array(
			//'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $page_group_details_id, $prefix.'conditional_checkbox' ) ),
			'data-conditional-value' => 'off',
		),
    ));
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name' => 'Components Columns Count',
        'type' => 'select',
        'id'   => $prefix.'page_group_component_count_col',
        'options'          => array(
			'col-12'								=> __( 'Single Column', 'cmb2' ),
			'col-sm-6'								=> __( '2 Columns', 'cmb2' ),
			'col-lg-4 col-sm-6'						=> __( '3 Columns', 'cmb2' ),
			'col-lg-3 col-sm-6'						=> __( '4 Columns', 'cmb2' ),
			'col-lg-2 col-sm-4 col-lg-one-fifth'	=> __( '5 Columns', 'cmb2' ),
			'col-lg-2 col-sm-4 col-6'				=> __( '6 Columns', 'cmb2' ),
        ),		
		'attributes' => array(
			//'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $page_group_details_id, $prefix.'conditional_checkbox' ) ),
			'data-conditional-value' => 'off',
		),
    ));
    $page_group_details->add_group_field( $page_group_details_id, array(
        'name'             => 'Unit Template',
        'desc'             => 'Select an option',
        'id'               => $prefix.'page_group_component_template',
        'type'             => 'select',
        'options'          => array(
            'template-1' => __( 'Gradient BG', 'cmb2' ),
            'template-2'   => __( 'Basic Template', 'cmb2' ),
            'template-3'     => __( 'Green Title border', 'cmb2' ),
            'template-4'     => __( 'With Counter', 'cmb2' ),
            'template-5'     => __( 'Basic Text Centered', 'cmb2' ),
            'template-6'     => __( 'With Arrow', 'cmb2' ),
        ),
		'attributes' => array(
			//'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $page_group_details_id, $prefix.'conditional_checkbox' ) ),
			'data-conditional-value' => 'off',
		),
    ));
    
    $block_settings = new_cmb2_box(array(
        'id' => $prefix . 'block_settings',
        'title' => __('Block Details', 'cmb2'),
        'object_types' => array('block'),
        //'show_on'      => array( 'key' => 'page-template', 'value' => 'page-template/lightbox-multy-gallery-page.php' ),        
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true
    )); 
    $block_settings->add_field( array(
        'name' => 'Block URL',
        'type' => 'button',
        'id'   => $prefix.'blobk_url',
    ));
    $block_settings->add_field( array(
        'name' => 'Block Custom HTML',
        'type' => 'textarea_code',
        'id'   => $prefix.'custom_html',
    ));
    /*$block_settings->add_field( array(
        'name'    => 'Icon Image',
        'desc'    => 'Upload an image or enter an URL.',
        'id'      => $prefix . 'blobk_icon_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Add Icon Image' // Change upload button text. Default: "Add or Upload File"
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
        //'preview_size' => 'small', // Image size to use when previewing in the admin.
    )); 
    $block_settings->add_field( array(
        'name'    => 'Hover Image',
        'desc'    => 'Upload an image or enter an URL.',
        'id'      => $prefix . 'blobk_hover_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Add Icon Image' // Change upload button text. Default: "Add or Upload File"
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
        //'preview_size' => 'small', // Image size to use when previewing in the admin.
    )); */
    
    $job_settings = new_cmb2_box(array(
        'id' => $prefix . 'job_settings',
        'title' => __('Job Details', 'cmb2'),
        'object_types' => array('job'),
        //'show_on'      => array( 'key' => 'page-template', 'value' => 'page-template/lightbox-multy-gallery-page.php' ),        
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true
    )); 
    $job_settings->add_field( array(
        'name' => 'Employment Basis',
        'type' => 'text',
        'id'   => $prefix.'job_employment_basis',
    ));
    $job_settings->add_field( array(
        'name' => 'Vacancy',
        'type' => 'text',
        'id'   => $prefix.'job_vacancy',
    ));
    $job_settings->add_field( array(
        'name' => 'Employment Status',
        'type' => 'text',
        'id'   => $prefix.'job_employment_status',
    ));
    $job_settings->add_field( array(
        'name' => 'Experience',
        'type' => 'text',
        'id'   => $prefix.'job_experience',
    ));
    $job_settings->add_field( array(
        'name' => 'Gender',
        'type' => 'text',
        'id'   => $prefix.'job_gender',
    ));
    $job_settings->add_field( array(
        'name' => 'Age',
        'type' => 'text',
        'id'   => $prefix.'job_age',
    ));
    $job_settings->add_field( array(
        'name' => 'Job Location',
        'type' => 'text',
        'id'   => $prefix.'job_location',
    ));
    $job_settings->add_field( array(
        'name' => 'Salary',
        'type' => 'text',
        'id'   => $prefix.'job_salary',
    ));
    $job_settings->add_field( array(
        'name' => 'Application Deadline',
        'type' => 'text_date',
        'id'   => $prefix.'job_application_deadline',
        'date_format' => 'd-m-Y',
    ));

}
add_action('cmb2_admin_init', 'mosacademy_metaboxes');