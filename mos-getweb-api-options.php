<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "mosacademy_options";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();
    
    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        //'display_name'         => $theme->get( 'Name' ),
        'display_name'         => 'Mos Academy',
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Theme Options', 'redux-framework-demo' ),
        'page_title'           => __( 'Theme Options', 'redux-framework-demo' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null, //number or null 0 te dashboard er upore
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => 'dashicons-smiley', //dash icon or directly image link
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    $args['admin_bar_links'][] = array(
        'id'    => 'redux-docs',
        'href'  => 'http://docs.reduxframework.com/',
        'title' => __( 'Documentation', 'redux-framework-demo' ),
    );

    $args['admin_bar_links'][] = array(
        //'id'    => 'redux-support',
        'href'  => 'https://github.com/ReduxFramework/redux-framework/issues',
        'title' => __( 'Support', 'redux-framework-demo' ),
    );

    $args['admin_bar_links'][] = array(
        'id'    => 'redux-extensions',
        'href'  => 'reduxframework.com/extensions',
        'title' => __( 'Extensions', 'redux-framework-demo' ),
    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://github.com/mostak-shahid/',
        'title' => 'Visit us on GitHub',
        'icon'  => 'el el-github'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/mosacademybd/',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://twitter.com/mostak_shahid',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.linkedin.com/in/mdmostakshahid/',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( __( '', 'redux-framework-demo' ), $v );
    } else {
        $args['intro_text'] = __( '', 'redux-framework-demo' );
    }

    // Add content after the form.
    $args['footer_text'] = __( '', 'redux-framework-demo' );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */




    // -> Add options here

    
    //Logo Settings
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Logo Settings', 'redux-framework-demo' ),
        'id'               => 'logo-settings',
        'desc' => "<div class='redux-info-field'><h3>".__('Welcome to Mos Academy Options', 'redux-framework-demo')."</h3>
        <p>".__('This theme was developed by', 'redux-framework-demo')." <a href=\"https://github.com/mostak-shahid/\" target=\"_blank\">Md. Mostak Shahid</a></p></div>",
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-dashboard',
        'fields'     => array(
            array(
                'id'       => 'logo',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Logo', 'redux-framework-demo' ),
                'compiler' => 'true',
                'subtitle' => __( 'Upload your logo here.', 'redux-framework-demo' ),
                //'default'  => array( 'url' => plugin_dir_path( MOS_GETWEB_API_FILE ).'/images/logo.png' ),
            ),
            array(
                'id'       => 'logo-option',
                'type'     => 'radio',
                'title'    => __( 'Logo option for large devices', 'redux-framework-demo' ),
                'options'  => array(
                    'logo' => 'Logo',
                    'title' => 'Title and Description'
                ),
                'default'  => 'title'
            )
        )
    ) );
    //Contact Info    
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Contact Info', 'redux-framework-demo' ),
        'id'               => 'contact-section',
        'desc'             => '',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-admin-users',
        'fields'     => array(
            array(
                'id'        => 'contact-phone',
                'type'      => 'multi_text',
                'title'     => __( 'Phone', 'redux-framework-demo' ),
                'desc'      => __( '<b>Example:</b> 00 0000 0000', 'redux-framework-demo' ),                
                'validate' => 'no_html',
            ),
            array(
                'id'        => 'contact-fax',
                'type'      => 'multi_text',
                'title'     => __( 'Fax', 'redux-framework-demo' ),
                'desc'      => __( '<b>Example:</b> 00 0000 0000', 'redux-framework-demo' ),                
                'validate' => 'no_html',
            ),
            array(
                'id'        => 'contact-email',
                'type'      => 'multi_text',
                'title'     => __( 'Email', 'redux-framework-demo' ),
                'default'   => '',
                'desc'     => '<b>Example:</b> example@domain.com',
                'validate' => 'no_html',
            ),
            array(
                'id'       => 'contact-hour',
                'type'     => 'multi_text',
                'title'    => __( 'Business Hours', 'redux-framework-demo' ),
                'subtitle'       => __( 'You can use span tag ( &lt;span&gt;&lt;/span&gt; ) here.', 'redux-framework-demo' ),
                'desc'     => __( '<b>Example:</b> 6.30am - 6pm <span>(Mon-Fri)</span>', 'redux-framework-demo' ),
                'validate'     => 'html_custom',
                'allowed_html' => array(
                    'span' => array(
                        'id' => array(),
                        'class' => array()
                    )
                )
            ),
            array(
                'id'          => 'contactAddress',
                'type'        => 'multi_text',
                'title'       => __( 'Contact Address', 'redux-framework-demo' ),           
            ),
            array(
                'id'          => 'contact-social',
                'type'        => 'multi_text',
                //'type'        => 'kad_icons',
                'title'       => __( 'Social Media', 'redux-framework-demo' ),             
            ),
            array(
                'id'          => 'contact-social-links',
                'type'        => 'mos_slides',
                'show' => array(
                    'title' => true,
                    'description' => false,
                    'link_title' => false,
                    'link_url' => true,
                    'target' => false,
                ),
                'title'       => __( 'Social Media', 'redux-framework-demo' ),             
            ),
            array(
                'id'             => 'contact-request-link',
                'type'           => 'text',
                'title'          => __( 'Request a Quote Link', 'redux-framework-demo' ),
            ),
        )
    ) );

    //Page Sections
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Page Sections', 'redux-framework-demo' ),
        'id'               => 'sections',
        'desc'             => '',
        'customizer_width' => '400px',
        'icon'             => 'el el-adjust-alt'
    ) );
    //Header Section 
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Header Section', 'redux-framework-demo' ),
        'id'               => 'header-section',
        'subsection'       => true,
        'desc'             => '',
        'customizer_width' => '450px',
        'icon'             => 'el el-move',
        'fields'     => array(
            array(
                'id'             => 'sections-header-padding',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'all'            => false,
                'units'          => array( 'rem','em', 'px', '%', 'vw', 'vh' ),
                'units_extended' => 'true',
                'output'         => array( '#main-header .content-wrap' ),
                'title'          => __( 'Section Padding', 'redux-framework-demo' ),
            ),
            array(
                'id'             => 'sections-header-margin',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'all'            => false,
                'units'          => array( 'rem','em', 'px', '%', 'vw', 'vh' ),
                'units_extended' => 'true',
                'output'         => array( '#main-header .content-wrap' ),
                'title'          => __( 'Section Margin', 'redux-framework-demo' ),
            ),
            array(
                'id'       => 'sections-header-border',
                'type'     => 'border',
                'title'    => __( 'Header Border', 'redux-framework-demo' ),
                'output'   => array( '#main-header .content-wrap' ),
                'all'      => false,
            ),
            array(
                'id'       => 'sections-header-background',
                'type'     => 'background',                
                'title'    => __( 'Header Background', 'redux-framework-demo' ),
            ),           

        )
    ) );
   
    
    //Footer Section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Footer Section', 'redux-framework-demo' ),
        'id'               => 'sections-footer',
        'subsection'       => true,
        'desc'             => '',
        'customizer_width' => '450px',
        'icon'             => 'el el-move',
        'fields'     => array( 
            array(
                'id'             => 'sections-footer-padding',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'all'            => false,
                'units'          => array( 'rem','em', 'px', '%', 'vw', 'vh' ),
                'units_extended' => 'true',
                'output'         => array( '#footer .content-wrap' ),
                'title'          => __( 'Section Padding', 'redux-framework-demo' ),
            ), 
            array(
                'id'             => 'sections-footer-margin',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'all'            => false,
                'units'          => array( 'rem','em', 'px', '%', 'vw', 'vh' ),
                'units_extended' => 'true',
                'output'         => array( '#footer .content-wrap' ),
                'title'          => __( 'Section Margin', 'redux-framework-demo' ),
            ),        
            array(
                'id'       => 'sections-footer-border',
                'type'     => 'border',
                'title'    => __( 'Section Border', 'redux-framework-demo' ),
                'output'   => array( '#footer .content-wrap' ),
                'all'      => false,
            ),             
            array(
                'id'       => 'sections-footer-content',
                'type'     => 'editor',
                'title'    => __( 'Section Content', 'redux-framework-demo' ),
                'default'  => '<p class="mb-0">We help global brands design <br class="d-none d-xl-inline"/> enabling seamless user experiences <br class="d-none d-xl-inline" /> across all modern platforms and <br className="d-none d-xl-inline"/> devices.</p>',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => false,
                    'textarea_rows' => 5,
                    //'tabindex' => 1,
                    //'editor_css' => '',
                    //'teeny'         => false,
                    //'tinymce' => array(),
                    'quicktags'     => false,
                )
            ),  
            array(
                'id'          => 'sections-footer-career',
                'type'        => 'text',
                'title'       => __( 'Careers URL', 'redux-framework-demo' ),
            ),  
            array(
                'id'       => 'sections-footer-copyright-image',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Copyright Image', 'redux-framework-demo' ),
                'compiler' => 'true',
            ),     
            array(
                'id'       => 'sections-footer-copyright',
                'type'     => 'textarea',
                'title'    => __( 'Copyright Content', 'redux-framework-demo' ),
                'default'  => '',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => true,
                    'textarea_rows' => 5,
                    //'tabindex' => 1,
                    //'editor_css' => '',
                    //'teeny'         => false,
                    //'tinymce' => array(),
                    'quicktags'     => true,
                )
            ),
            array(
                'id'       => 'sections-footer-gallery',
                'type'     => 'gallery',
                'title'    => __( 'Footer Gallery', 'redux-framework-demo' ),
            ),
            array(
                'id'       => 'sections-footer-background',
                'type'     => 'background',                
                'title'    => __( 'Section Background', 'redux-framework-demo' ),
            ),  
        )
    ) );    
    //Page Title Section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Page Title Section', 'redux-framework-demo' ),
        'id'               => 'sections-title',
        'subsection'       => true,
        'desc'             => '',
        'customizer_width' => '450px',
        'icon'             => 'el el-move',
        'fields'     => array(  
            array(
                'id'             => 'sections-title-padding',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'all'            => false,
                'units'          => array( 'rem','em', 'px', '%', 'vw', 'vh' ),
                'units_extended' => 'true',
                'output'         => array( '#page-title .content-wrap' ),
                'title'          => __( 'Section Padding', 'redux-framework-demo' ),
            ), 
            array(
                'id'             => 'sections-title-margin',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'all'            => false,
                'units'          => array( 'rem','em', 'px', '%', 'vw', 'vh' ),
                'units_extended' => 'true',
                'output'         => array( '#page-title .content-wrap' ),
                'title'          => __( 'Section Margin', 'redux-framework-demo' ),
            ),         
            array(
                'id'       => 'sections-title-border',
                'type'     => 'border',
                'title'    => __( 'Section Border', 'redux-framework-demo' ),
                'output'   => array( '#page-title .content-wrap' ),
                'all'      => false,
            ), 
            array(
                'id'       => 'sections-title-tag',
                'type'     => 'button_set',
                'title'    => __( 'Title tag', 'redux-framework-demo' ),
                //Must provide key => value pairs for radio options
                'options'  => array(
                    'h1' => 'H1',
                    'span' => 'Span',
                ),
                'default'  => 'span'
            ),
            array(
                'id'       => 'sections-title-background-solid',
                'type'     => 'background',                
                'title'    => __( 'Page Title Background', 'redux-framework-demo' ),
                //'required' => array( 'sections-title-background-type', '=', '2' ),
            ),
        )
    ) );
    //Breadcrumbs Section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Breadcrumbs Section', 'redux-framework-demo' ),
        'id'               => 'sections-breadcrumbs',
        'subsection'       => true,
        'desc'             => '',
        'customizer_width' => '450px',
        'icon'             => 'el el-move',
        'fields'     => array(
            array(
                'id'             => 'sections-breadcrumbs-padding',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'all'            => false,
                'units'          => array( 'rem','em', 'px', '%', 'vw', 'vh' ),
                'units_extended' => 'true',
                'output'         => array( '#section-breadcrumbs .content-wrap' ),
                'title'          => __( 'Section Padding', 'redux-framework-demo' ),
            ), 
            array(
                'id'             => 'sections-breadcrumbs-margin',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'all'            => false,
                'units'          => array( 'rem','em', 'px', '%', 'vw', 'vh' ),
                'units_extended' => 'true',
                'output'         => array( '#section-breadcrumbs .content-wrap' ),
                'title'          => __( 'Section Margin', 'redux-framework-demo' ),
            ),        
            array(
                'id'       => 'sections-breadcrumbs-border',
                'type'     => 'border',
                'title'    => __( 'Breadcrumbs Section Border', 'redux-framework-demo' ),
                'output'   => array( '#section-breadcrumbs .content-wrap' ),
                'all'      => false,
            ),            
            array(
                'id'       => 'sections-breadcrumbs-option',
                'type'     => 'switch',
                'title'    => __( 'Breadcrumbs', 'redux-framework-demo' ),
                //'options' => array('on', 'off'),
                'default'  => false,
            ),
            array(
                'id'       => 'sections-breadcrumbs-background',
                'type'     => 'background',                
                'title'    => __( 'Breadcrumbs Section Background', 'redux-framework-demo' ),
            ),
        )
    ) );  
    //Baner Section
    /*Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner Section', 'redux-framework-demo' ),
        'id'               => 'sections-banner',
        'subsection'       => true,
        'desc'             => '',
        'customizer_width' => '450px',
        'icon'             => 'el el-move',
        'fields'     => array(  
            array(
                'id'       => 'sections-banner-select',
                'type'     => 'select',
                'title'    => __( 'Choose a Home Image Slider', 'redux-framework-demo' ),
                'subtitle' => __( 'If you don\'t want an image slider on your home page choose none.', 'redux-framework-demo' ),
                //Must provide key => value pairs for select options
                'options'  => array(
                    'banner' => 'Banner',
                    'carousel' => 'Carousel Slider',
                    'shortcode' => 'From Shortcode',
                ),
                'default'  => 'banner'
            ),
            array(
                'id'          => 'sections-banner-details',
                'type'        => 'mos_slides',
                'title'       => __( 'Slider Images', 'redux-framework-demo' ),
                'subtitle'    => __( 'Use large images (Max Width 1920px) for best results.', 'redux-framework-demo' ),              
                'show' => array(
                    'title' => true,
                    'description' => true,
                    'link_title' => true,
                    'link_url' => true,
                    'target' => true,
                ),
                'placeholder' => array(
                    'title'       => __( 'This is a title', 'redux-framework-demo' ),
                    'description' => __( 'Description Here', 'redux-framework-demo' ),
                    'link_title'         => __( 'Link Title', 'redux-framework-demo' ),
                    'url'         => __( 'Give us a link!', 'redux-framework-demo' ),
                ),
                'required' => array( 'sections-banner-select', '!=', 'shortcode' ),
            ),  
            array(
                'id'       => 'sections-banner-type',
                'type'     => 'switch',
                'title'    => __( 'Background Slider', 'redux-framework-demo' ),
                'options' => array('Background', 'Image'),
                'default'  => false,
                'required' => array( 'sections-banner-select', '!=', 'shortcode' ),
            ),          
            array(
                'id'       => 'sections-banner-shortcode',
                'type'     => 'text',
                'title'    => __( 'Shortcode', 'redux-framework-demo' ),
                'subtitle' => __( 'All HTML will be stripped', 'redux-framework-demo' ),
                'validate' => 'no_html',
                'default'  => 'No HTML is allowed in here.',
                'required' => array( 'sections-banner-select', '=', 'shortcode' ),
            ),
            array(
                'id'       => 'sections-banner-title-font',
                'type'     => 'typography',
                'title'    => __( 'Slider Title Font', 'redux-framework-demo' ),
                'subtitle' => __( 'Choose Size and Style for Slider Title.', 'redux-framework-demo' ),
                'google'   => true,
                'output'      => array( '#section-banner .banner-content .banner-title' ),
            ),
            array(
                'id'       => 'sections-banner-description-font',
                'type'     => 'typography',
                'title'    => __( 'Slider Description Font', 'redux-framework-demo' ),
                'subtitle' => __( 'Choose Size and Style for Slider Description.', 'redux-framework-demo' ),
                'google'   => true,
                'output'      => array( '#section-banner .banner-content .banner-desc' ),
            ),
            array(
                'id'       => 'sections-banner-link-title-font',
                'type'     => 'typography',
                'title'    => __( 'Slider Link Title Font', 'redux-framework-demo' ),
                'subtitle' => __( 'Choose Size and Style for Slider Link Title.', 'redux-framework-demo' ),
                'google'   => true,
                'output'      => array( '#section-banner .banner-content .btn-banner' ),
            ),

            array(
                'id'       => 'sections-banner-background-type',
                'type'     => 'button_set',
                'title'    => __( 'Banner Background Type', 'redux-framework-demo' ),
                'options'  => array(
                    '1' => 'Gradient',
                    '2' => 'Solid Color/Image',
                    '3' => 'RGBA Color'
                ),
                'default'  => '2',
            ),

            array(
                'id'     => 'sections-banner-background-start',
                'type'   => 'section',
                'indent' => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'sections-banner-background-gradient',
                'type'     => 'color_gradient',
                'title'    => __( 'Banner Section Background', 'redux-framework-demo' ),
                'validate' => 'color',              
                'required' => array( 'sections-banner-background-type', '=', '1' ),
            ),
            array(
                'id'       => 'sections-banner-background-solid',
                'type'     => 'background',                
                'title'    => __( 'Banner Section Background', 'redux-framework-demo' ),
                'required' => array( 'sections-banner-background-type', '=', '2' ),
            ),
            array(
                'id'       => 'sections-banner-background-rgba',
                'type'     => 'color_rgba',
                'title'    => __( 'Banner Section Background', 'redux-framework-demo' ),
                'validate' => 'colorrgba',
                'required' => array( 'sections-banner-background-type', '=', '3' ),
            ),
            array(
                'id'     => 'sections-banner-background-end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),
        )
    ) );    */
    
	/*
    if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
        $section = array(
            'icon'   => 'el el-list-alt',
            'title'  => __( 'Documentation', 'redux-framework-demo' ),
            'fields' => array(
                array(
                    'id'       => '17',
                    'type'     => 'raw',
                    'markdown' => true,
                    'content_path' => dirname( __FILE__ ) . '/../README.md', // FULL PATH, not relative please
                    //'content' => 'Raw content here',
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }
	*/
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use plugin_dir_path( MOS_GETWEB_API_FILE ) if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'redux-framework-demo' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a mosacademy section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
/*    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }*/

