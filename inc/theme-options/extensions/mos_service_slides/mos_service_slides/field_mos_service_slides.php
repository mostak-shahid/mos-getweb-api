<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Don't duplicate me!
if (!class_exists('ReduxFramework_mos_service_slides')) {

    /**
     * Main ReduxFramework_slides class
     *
     * @since       1.0.0
     */
    class ReduxFramework_mos_service_slides {

        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
          function __construct ( $field = array(), $value = '', $parent ) {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

             $defaults = array(
                'show' => array(
                    'title' => true,
                    'description' => true,
                    'link_title' => false,
                    'link_url' => false,
                    'target' => false,
                ),
                'content_title' => __ ( 'Slide', 'virtue' )
            );

             $this->field = wp_parse_args ( $this->field, $defaults );
			/* translators: %s: slide */
           	echo '<div class="redux-slides-accordion" data-new-content-title="' . esc_attr ( sprintf ( __ ( 'New %s', 'virtue' ), $this->field[ 'content_title' ] ) ) . '">';

            $x = 0;

             $multi = ( isset ( $this->field[ 'multi' ] ) && $this->field[ 'multi' ] ) ? ' multiple="multiple"' : "";

            if ( isset ( $this->value ) && is_array ( $this->value ) && !empty ( $this->value ) ) {

                $slides = $this->value;

                foreach ( $slides as $slide ) {

                    if ( empty ( $slide ) ) {
                        continue;
                    }


                    $defaults = array(
                        'title' => '',
                        
                        'image' => '',
                        'attachment_id' => '',
                        'thumb' => '',
                        'height' => '',
                        'width' => '',

                        'photo' => '',
                        'photo_attachment_id' => '',
                        'photo_thumb' => '',
                        'photo_height' => '',
                        'photo_width' => '',

                        'description' => '',
                        'sort' => '',
                        'link_title' => '',
                        'link_url' => '',
                        'target' => '',
                        'select' => array(),
                    );
                    $slide = wp_parse_args( $slide, $defaults );

                    if ( empty ( $slide[ 'photo_thumb' ] ) && !empty ( $slide[ 'photo_attachment_id' ] ) ) {
                        $pto = wp_get_attachment_image_src ( $slide[ 'photo_attachment_id' ], 'full' );
                        $slide[ 'photo_image' ] = $pto[ 0 ];
                        $slide[ 'photo_width' ] = $pto[ 1 ];
                        $slide[ 'photo_height' ] = $pto[ 2 ];
                    }

                    if ( empty ( $slide[ 'thumb' ] ) && !empty ( $slide[ 'attachment_id' ] ) ) {
                        $img = wp_get_attachment_image_src ( $slide[ 'attachment_id' ], 'full' );
                        $slide[ 'image' ] = $img[ 0 ];
                        $slide[ 'width' ] = $img[ 1 ];
                        $slide[ 'height' ] = $img[ 2 ];
                    }

                    echo '<div class="redux-slides-accordion-group"><fieldset class="redux-field" data-id="' . esc_attr( $this->field[ 'id' ] ) . '"><h3><span class="redux-slides-header">' . esc_html( $slide[ 'title' ] ) . '</span></h3><div>';

                    $hide = '';
                    if ( empty ( $slide[ 'image' ] ) ) {
                        $hide = ' hide';
                    }

                    echo '<div class="screenshot' . esc_attr( $hide ) . '">';
                    echo '<a class="of-uploaded-image" href="' . esc_url( $slide[ 'image' ] ) . '">';
                    echo '<img class="redux-slides-image" id="image_image_id_' . esc_attr( $x ). '" src="' . esc_url( $slide[ 'thumb' ] ) . '" alt="" target="_blank" rel="external" />';
                    echo '</a>';
                    echo '</div>';

                    echo '<div class="redux_slides_add_remove">';

                    echo '<span class="button media_upload_button" id="add_' . esc_attr( $x ) . '">' . esc_html__( 'Upload', 'virtue' ) . '</span>';

                    $hide = '';
                    if ( empty ( $slide[ 'image' ] ) || $slide[ 'image' ] == '' ) {
                        $hide = ' hide';
                    }

                    echo '<span class="button remove-image' . esc_attr( $hide ) . '" id="reset_' . esc_attr( $x ) . '" rel="' . esc_attr( $slide[ 'attachment_id' ] ) . '">' . esc_html__( 'Remove', 'virtue' ) . '</span>';

                    echo '</div>' . "\n";

                    echo '<div class="photo-container">';
                    $phide = '';
                    if ( empty ( $slide[ 'photo' ] ) ) {
                        $phide = ' hide';
                    }
                    echo '<div class="screenshot-photo' . esc_attr( $phide ) . '"><a class="of-uploaded-photo" href="' . esc_attr($slide['photo']) . '" target="_blank"><img class="redux-option-photo" src="' . esc_attr($slide['photo_thumb']) . '"></a></div>';
                    echo '<span class="button photo_upload_button" id="photo_add_' . esc_attr( $x ) . '">Upload</span>'; 
                    echo '<span class="button remove-photo' . esc_attr( $phide ) . '" id="photo_reset_' . esc_attr( $x ) . '">' . esc_html__( 'Remove', 'virtue' ) . '</span>';
                    echo '</div>';

                    echo '<ul id="' . esc_attr( $this->field[ 'id' ] ) . '-ul" class="redux-slides-list">';

                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][title]" value="' . esc_attr($slide['title']) . '" placeholder="'.esc_html__('Title', 'virtue').'" class="full-text slide-title" /></li>';
                    if ( $this->field[ 'show' ][ 'description' ] ) {
                        echo '<li><textarea name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][description]" id="' . esc_attr( $this->field['id'] ) . '-description_' . esc_attr( $x ) . '" placeholder="'.esc_attr__('Description', 'virtue').'" class="large-text" rows="6">' . esc_attr($slide['description']) . '</textarea></li>';
                    }
                    if ( $this->field[ 'show' ][ 'link_title' ] ) {

                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-link_title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][link_title]" value="' . esc_attr($slide['link_title']) . '" placeholder="'.esc_attr__('Read More', 'virtue').'" class="full-text" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'link_url' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-link_url_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][link_url]" value="' . esc_attr($slide['link_url']) . '" class="full-text" placeholder="'.esc_html__('URL', 'virtue').'" /></li>';
                    }
                    
                    if ( $this->field[ 'show' ][ 'target' ] ) {
                        echo '<li><label for="'. esc_attr( $this->field['id'] ) .  '-target_' . esc_attr( $x ) . '" class="icon-link-target">';
                        echo '<input type="checkbox" class="checkbox-slide-target" id="' . esc_attr( $this->field['id'] ) . '-target_' . esc_attr( $x ) . '" value="1" ' . checked(  $slide['target'], '1', false ) . ' name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][target]" />';
                        echo ' '.esc_html__('Open Link in New Tab/Window', 'virtue'). '</label></li>';
                    }

                    echo '<li><input type="hidden" class="slide-sort" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][sort]" id="' . esc_attr( $this->field['id'] ) . '-sort_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['sort'] ) . '" />';

                    
                    echo '<li><input type="hidden" class="upload-id" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][attachment_id]" id="' . esc_attr( $this->field['id'] ) . '-image_id_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['attachment_id'] ) . '" />';
                    echo '<input type="hidden" class="upload-thumbnail" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][thumb]" id="' . esc_attr( $this->field['id'] ) . '-thumb_url_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['thumb'] ) . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][image]" id="' . esc_attr( $this->field['id'] ) . '-image_url_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['image'] ) . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload-height" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][height]" id="' . esc_attr( $this->field['id'] ) . '-image_height_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['height'] ) . '" />';
                    echo '<input type="hidden" class="upload-width" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][width]" id="' . esc_attr( $this->field['id'] ) . '-image_width_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['width'] ) . '" /></li>';


                    echo '<li><input type="hidden" class="photo-id" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][photo_attachment_id]" id="' . esc_attr( $this->field['id'] ) . '-photo_id_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['photo_attachment_id'] ) . '" />';
                    echo '<input type="hidden" class="photo-thumbnail" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][photo_thumb]" id="' . esc_attr( $this->field['id'] ) . '-thumb_url_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['photo_thumb'] ) . '" readonly="readonly" />';
                    echo '<input type="hidden" class="photo" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][photo]" id="' . esc_attr( $this->field['id'] ) . '-photo_url_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['photo'] ) . '" readonly="readonly" />';
                    echo '<input type="hidden" class="photo-height" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][photo_height]" id="' . esc_attr( $this->field['id'] ) . '-photo_height_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['photo_height'] ) . '" />';
                    echo '<input type="hidden" class="photo-width" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][photo_width]" id="' . esc_attr( $this->field['id'] ) . '-photo_width_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['photo_width'] ) . '" /></li>';
                    
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-slides-remove">' . esc_html__('Delete Slide', 'virtue') . '</a></li>';
                    echo '</ul></div></fieldset></div>';
                    $x++;
                
                }
            }

            if ($x == 0) {
                echo '<div class="redux-slides-accordion-group"><fieldset class="redux-field" data-id="'.esc_attr( $this->field['id'] ).'"><h3><span class="redux-slides-header">New Slide</span></h3><div>';

                $hide = ' hide';

                echo '<div class="screenshot' . esc_attr( $hide ) . '">';
                echo '<a class="of-uploaded-image" href="">';
                echo '<img class="redux-slides-image" id="image_image_id_' . esc_attr( $x ) . '" src="" alt="" target="_blank" rel="external" />';
                echo '</a>';
                echo '</div>';

                //Upload controls DIV
                echo '<div class="upload_button_div">';

                //If the user has WP3.5+ show upload/remove button
                echo '<span class="button media_upload_button" id="add_' . esc_attr( $x ) . '">' . esc_html__( 'Upload', 'virtue' ) . '</span>';

                echo '<span class="button remove-image' . esc_attr( $hide ) . '" id="reset_' . esc_attr( $x ) . '" rel="' . esc_attr( $this->parent->args[ 'opt_name' ] ) . '[' . esc_attr( $this->field[ 'id' ] ) . '][attachment_id]">' . esc_html__( 'Remove', 'virtue' ) . '</span>';

                echo '</div>' . "\n";

                echo '<div class="photo-container">';
                $phide = ' hide';

                echo '<div class="screenshot-photo' . esc_attr( $phide ) . '"><a class="of-uploaded-photo" href="' . esc_attr($slide['photo']) . '" target="_blank"><img class="redux-option-photo" src="' . esc_attr($slide['photo_thumb']) . '"></a></div>';
                echo '<span class="button photo_upload_button" id="photo_add_' . esc_attr( $x ) . '">Upload</span>'; 
                echo '<span class="button remove-photo' . esc_attr( $phide ) . '" id="photo_reset_' . esc_attr( $x ) . '">' . esc_html__( 'Remove', 'virtue' ) . '</span>';
                echo '</div>';

                echo '<ul id="' . esc_attr( $this->field['id'] ) . '-ul" class="redux-slides-list">';
                
                $placeholder = (isset($this->field['placeholder']['title'])) ? esc_attr($this->field['placeholder']['title']) : __( 'Title', 'virtue' );
                echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][title]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text slide-title" /></li>';
                
                if ( $this->field[ 'show' ][ 'description' ] ) {
                $placeholder = (isset($this->field['placeholder']['description'])) ? esc_attr($this->field['placeholder']['description']) : __( 'Description', 'virtue' );
                    echo '<li><textarea name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][description]" id="' . esc_attr( $this->field['id'] ) . '-description_' . esc_attr( $x ) . '" placeholder="'.esc_attr( $placeholder ).'" class="large-text" rows="6"></textarea></li>';
                }
                if ( $this->field[ 'show' ][ 'link_title' ] ) {
                    $placeholder = (isset($this->field['placeholder']['link_title'])) ? esc_attr($this->field['placeholder']['link_title']) : __( 'Read More', 'virtue' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-link_title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][link_title]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text" /></li>';
                }
                if ( $this->field[ 'show' ][ 'link_url' ] ) {
                    $placeholder = (isset($this->field['placeholder']['link_url'])) ? esc_attr($this->field['placeholder']['link_url']) : __( 'URL', 'virtue' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-link_url_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][link_url]" value="" class="full-text" placeholder="'.esc_attr( $placeholder ).'" /></li>';
                }

                if ( $this->field[ 'show' ][ 'target' ] ) {
                    echo '<li><label for="'. esc_attr( $this->field['id'] ) .  '-target_' . esc_attr( $x ) . '">';
                    echo '<input type="checkbox" class="checkbox-slide-target" id="' . esc_attr( $this->field['id'] ) . '-target_' . esc_attr( $x ) . '" value="1" ' . checked(  '', '1', false ) . ' name="' . esc_attr( $this->args['opt_name'] ) . '[' . esc_attr( $this->field['id'] ) . '][' . esc_attr( $x ) . '][target]" />';
                    echo ' '.esc_html__('Open Link in New Tab/Window', 'virtue'). '</label></li>';
                }

                echo '<li><input type="hidden" class="slide-sort" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][sort]" id="' . esc_attr( $this->field['id'] ) . '-sort_' . esc_attr( $x ) . '" value="' . esc_attr( $x ) . '" />';

                echo '<li><input type="hidden" class="upload-id" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][attachment_id]" id="' . esc_attr( $this->field['id'] ) . '-image_id_' . esc_attr( $x ) . '" value="" />';
                echo '<input type="hidden" class="upload" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][image]" id="' . esc_attr( $this->field['id'] ) . '-image_url_' . esc_attr( $x ) . '" value="" readonly="readonly" />';
                echo '<input type="hidden" class="upload-height" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][height]" id="' . esc_attr( $this->field['id'] ) . '-image_height_' . esc_attr( $x ) . '" value="" />';
                echo '<input type="hidden" class="upload-width" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][width]" id="' . esc_attr( $this->field['id'] ) . '-image_width_' . esc_attr( $x ) . '" value="" /></li>';


                echo '<li><input type="hidden" class="photo-id" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][photo_attachment_id]" id="' . esc_attr( $this->field['id'] ) . '-photo_id_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['photo_attachment_id'] ) . '" />';
                echo '<input type="hidden" class="photo" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][photo]" id="' . esc_attr( $this->field['id'] ) . '-photo_url_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['photo'] ) . '" readonly="readonly" />';
                echo '<input type="hidden" class="photo-height" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][photo_height]" id="' . esc_attr( $this->field['id'] ) . '-photo_height_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['photo_height'] ) . '" />';
                echo '<input type="hidden" class="photo-width" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][photo_width]" id="' . esc_attr( $this->field['id'] ) . '-photo_width_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['photo_width'] ) . '" /></li>';


                echo '<li><a href="javascript:void(0);" class="button deletion redux-slides-remove">' . esc_html__('Delete Slide', 'virtue') . '</a></li>';
                echo '</ul></div></fieldset></div>';
            }
            /* translators: %s: slide */
            echo '</div><a href="javascript:void(0);" class="button redux-slides-add2 mos_redux-slides-add button-primary" rel-id="' . esc_attr( $this->field[ 'id' ] ) . '-ul" rel-name="' . esc_attr( $this->field[ 'name' ] ) . '[title][]">' . sprintf ( esc_html__( 'Add %s', 'virtue' ), esc_attr( $this->field[ 'content_title' ] ) ) . '</a><br/>';
        }
        public function enqueue () {
            if ( function_exists( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            } else {
                wp_enqueue_script( 'media-upload' );
            }
                
            
            wp_enqueue_style ('redux-field-media-css');
            
            wp_enqueue_style (
                'field_mos_service_slides', 
                plugin_dir_path( MOS_GETWEB_API_FILE ) . '/inc/theme-options/extensions/mos_service_slides/mos_service_slides/field_mos_service_slides.css', 
                array(),
                time (), 
                'all'
            );
            
            wp_enqueue_script(
                'redux-field-media-js',
                ReduxFramework::$_url . 'assets/js/media/media' . Redux_Functions::isMin() . '.js',
                array( 'jquery', 'redux-js' ),
                time(),
                true
            );

            wp_enqueue_script (
                'field_mos_service_slides', 
                //plugin_dir_path( MOS_GETWEB_API_FILE ) . '/inc/theme-options/extensions/mos_service_slides/mos_service_slides/field_mos_service_slides' . Redux_Functions::isMin () . '.js', 
                plugin_dir_path( MOS_GETWEB_API_FILE ) . '/inc/theme-options/extensions/mos_service_slides/mos_service_slides/field_mos_service_slides.js', 
                array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'jquery-ui-sortable', 'redux-field-media-js' ),
                time (), 
                true
            );
        }

    }
}
