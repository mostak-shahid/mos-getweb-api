<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Don't duplicate me!
if (!class_exists('ReduxFramework_mos_slides')) {

    /**
     * Main ReduxFramework_slides class
     *
     * @since       1.0.0
     */
    class ReduxFramework_mos_slides {

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
                    'link_title' => true,
                    'link_url' => true,
                    'target' => true,
                ),
                'content_title' => __ ( 'Slide', 'moscanopies' )
            );

             $this->field = wp_parse_args ( $this->field, $defaults );
			/* translators: %s: slide */
           	echo '<div class="redux-slides-accordion" data-new-content-title="' . esc_attr ( sprintf ( __ ( 'New %s', 'moscanopies' ), $this->field[ 'content_title' ] ) ) . '">';

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
                        'description' => '',
                        'sort' => '',
                        'link_title' => '',
                        'image' => '',
                        'target' => '',
                        'link_url' => '',
                        'thumb' => '',
                        'attachment_id' => '',
                        'height' => '',
                        'width' => '',
                        'select' => array(),
                    );
                    $slide = wp_parse_args( $slide, $defaults );

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

                    echo '<span class="button media_upload_button" id="add_' . esc_attr( $x ) . '">' . esc_html__( 'Upload', 'moscanopies' ) . '</span>';

                    $hide = '';
                    if ( empty ( $slide[ 'image' ] ) || $slide[ 'image' ] == '' ) {
                        $hide = ' hide';
                    }

                    echo '<span class="button remove-image' . esc_attr( $hide ) . '" id="reset_' . esc_attr( $x ) . '" rel="' . esc_attr( $slide[ 'attachment_id' ] ) . '">' . esc_html__( 'Remove', 'moscanopies' ) . '</span>';

                    echo '</div>' . "\n";

                    echo '<ul id="' . esc_attr( $this->field[ 'id' ] ) . '-ul" class="redux-slides-list">';

                    $placeholder_title = (isset($this->field['placeholder']['title'])) ? esc_attr($this->field['placeholder']['title']) : __( 'Title', 'moscanopies' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][title]" value="' . esc_attr($slide['title']) . '" placeholder="'.$placeholder_title.'" class="full-text slide-title" /></li>';
                    if ( $this->field[ 'show' ][ 'description' ] ) {
                        $placeholder = (isset($this->field['placeholder']['description'])) ? esc_attr($this->field['placeholder']['description']) : __( 'Description', 'moscanopies' );
                        echo '<li><textarea name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][description]" id="' . esc_attr( $this->field['id'] ) . '-description_' . esc_attr( $x ) . '" placeholder="'.esc_attr( $placeholder ).'" class="large-text" rows="6">' . esc_attr($slide['description']) . '</textarea></li>';
                    }
                    if ( $this->field[ 'show' ][ 'link_title' ] ) {

                        $placeholder = (isset($this->field['placeholder']['link_title'])) ? esc_attr($this->field['placeholder']['link_title']) : __( 'Link Title', 'moscanopies' );
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-link_title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][link_title]" value="' . esc_attr($slide['link_title']) . '" placeholder="'.esc_attr( $placeholder ).'" class="full-text" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'link_url' ] ) {
                        $placeholder = (isset($this->field['placeholder']['link_url'])) ? esc_attr($this->field['placeholder']['link_url']) : __( 'URL', 'moscanopies' );
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-link_url_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][link_url]" value="' . esc_attr($slide['link_url']) . '" class="full-text" placeholder="'.esc_attr( $placeholder ).'" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'target' ] ) {
                        echo '<li><label for="'. esc_attr( $this->field['id'] ) .  '-target_' . esc_attr( $x ) . '" class="icon-link_title-target">';
                        echo '<input type="checkbox" class="checkbox-slide-target" id="' . esc_attr( $this->field['id'] ) . '-target_' . esc_attr( $x ) . '" value="1" ' . checked(  $slide['target'], 1, false ) . ' name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][target]" />';
                        echo ' '.esc_html__('Open Link in New Tab/Window', 'moscanopies'). '</label></li>';
                    }

                    echo '<li><input type="hidden" class="slide-sort" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][sort]" id="' . esc_attr( $this->field['id'] ) . '-sort_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['sort'] ) . '" />';
                    echo '<li><input type="hidden" class="upload-id" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][attachment_id]" id="' . esc_attr( $this->field['id'] ) . '-image_id_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['attachment_id'] ) . '" />';
                    echo '<input type="hidden" class="upload-thumbnail" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][thumb]" id="' . esc_attr( $this->field['id'] ) . '-thumb_url_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['thumb'] ) . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][image]" id="' . esc_attr( $this->field['id'] ) . '-image_url_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['image'] ) . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload-height" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][height]" id="' . esc_attr( $this->field['id'] ) . '-image_height_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['height'] ) . '" />';
                    echo '<input type="hidden" class="upload-width" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][width]" id="' . esc_attr( $this->field['id'] ) . '-image_width_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['width'] ) . '" /></li>';
                    
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-slides-remove">' . esc_html__('Delete Slide', 'moscanopies') . '</a></li>';
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
                echo '<span class="button media_upload_button" id="add_' . esc_attr( $x ) . '">' . esc_html__( 'Upload', 'moscanopies' ) . '</span>';

                echo '<span class="button remove-image' . esc_attr( $hide ) . '" id="reset_' . esc_attr( $x ) . '" rel="' . esc_attr( $this->parent->args[ 'opt_name' ] ) . '[' . esc_attr( $this->field[ 'id' ] ) . '][attachment_id]">' . esc_html__( 'Remove', 'moscanopies' ) . '</span>';

                echo '</div>' . "\n";

                echo '<ul id="' . esc_attr( $this->field['id'] ) . '-ul" class="redux-slides-list">';
                $placeholder = (isset($this->field['placeholder']['title'])) ? esc_attr($this->field['placeholder']['title']) : __( 'Title', 'moscanopies' );
                echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][title]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text slide-title" /></li>';
                if ( $this->field[ 'show' ][ 'description' ] ) {
                    $placeholder = (isset($this->field['placeholder']['description'])) ? esc_attr($this->field['placeholder']['description']) : __( 'Description', 'moscanopies' );
                    echo '<li><textarea name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][description]" id="' . esc_attr( $this->field['id'] ) . '-description_' . esc_attr( $x ) . '" placeholder="'.esc_attr( $placeholder ).'" class="large-text" rows="6"></textarea></li>';
                }
                if ( $this->field[ 'show' ][ 'link_title' ] ) {
                    $placeholder = (isset($this->field['placeholder']['link_title'])) ? esc_attr($this->field['placeholder']['link_title']) : __( 'Link Title', 'moscanopies' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-link_title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][link_title]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text" /></li>';   
                }
                if ( $this->field[ 'show' ][ 'link_url' ] ) {          
                    $placeholder = (isset($this->field['placeholder']['link_url'])) ? esc_attr($this->field['placeholder']['link_url']) : __( 'URL', 'moscanopies' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-link_url_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][link_url]" value="" class="full-text" placeholder="'.esc_attr( $placeholder ).'" /></li>';
                }
                if ( $this->field[ 'show' ][ 'target' ] ) {
                    echo '<li><label for="'. esc_attr( $this->field['id'] ) .  '-target_' . esc_attr( $x ) . '">';
                    echo '<input type="checkbox" class="checkbox-slide-target" id="' . esc_attr( $this->field['id'] ) . '-target_' . esc_attr( $x ) . '" value="1" ' . checked(  $slide['target'], '1', false ) . ' name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][target]" />';
                    echo ' '.esc_html__('Open Link in New Tab/Window', 'moscanopies'). '</label></li>';
                }

                echo '<li><input type="hidden" class="slide-sort" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][sort]" id="' . esc_attr( $this->field['id'] ) . '-sort_' . esc_attr( $x ) . '" value="' . esc_attr( $x ) . '" />';
                echo '<li><input type="hidden" class="upload-id" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][attachment_id]" id="' . esc_attr( $this->field['id'] ) . '-image_id_' . esc_attr( $x ) . '" value="" />';
                echo '<input type="hidden" class="upload" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][image]" id="' . esc_attr( $this->field['id'] ) . '-image_url_' . esc_attr( $x ) . '" value="" readonly="readonly" />';
                echo '<input type="hidden" class="upload-height" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][height]" id="' . esc_attr( $this->field['id'] ) . '-image_height_' . esc_attr( $x ) . '" value="" />';
                echo '<input type="hidden" class="upload-width" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][width]" id="' . esc_attr( $this->field['id'] ) . '-image_width_' . esc_attr( $x ) . '" value="" /></li>';

                echo '<li><a href="javascript:void(0);" class="button deletion redux-slides-remove">' . esc_html__('Delete Slide', 'moscanopies') . '</a></li>';
                echo '</ul></div></fieldset></div>';
            }
            /* translators: %s: slide */
            echo '</div><a href="javascript:void(0);" class="button redux-slides-add2 mos_redux-slides-add button-primary" rel-id="' . esc_attr( $this->field[ 'id' ] ) . '-ul" rel-name="' . esc_attr( $this->field[ 'name' ] ) . '[title][]">' . sprintf ( esc_html__( 'Add %s', 'moscanopies' ), esc_attr( $this->field[ 'content_title' ] ) ) . '</a><br/>';
        }
        public function enqueue () {
            if ( function_exists( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            } else {
                wp_enqueue_script( 'media-upload' );
            }
            wp_enqueue_style ('redux-field-media-css');
            
            wp_enqueue_style (
                'field_mos_slides', 
                plugins_url('/field_mos_slides.css', __FILE__ ), 
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
//wp_enqueue_script( 'codemirror', plugins_url( 'plugins/CodeMirror/lib/codemirror.js', __FILE__ ), array('jquery') );
            wp_enqueue_script (
                'field_mos_slides', 
                plugins_url('/field_mos_slides' . Redux_Functions::isMin () . '.js', __FILE__ ), 
                array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'jquery-ui-sortable', 'redux-field-media-js' ),
                time (), 
                true
            );
        }

    }
}
