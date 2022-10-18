<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Don't duplicate me!
if (!class_exists('ReduxFramework_mos_font')) {

    /**
     * Main ReduxFramework_slides class
     *
     * @since       1.0.0
     */
    class ReduxFramework_mos_font {

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
                    'url-eot' => true,
                    'url-woff' => true,
                    'url-woff2' => true,
                    'url-ttf' => true,
                    'url-svg' => true,
                    'weight' => true,
                    'style' => true,
                ),
                'content_title' => __ ( 'Slide', 'mosacademy' )
            );

             $this->field = wp_parse_args ( $this->field, $defaults );
			/* translators: %s: slide */
           	echo '<div class="redux-slides-accordion" data-new-content-title="New Font">';

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
                        'url-eot' => '',
                        'url-woff' => '',
                        'url-woff2' => '',
                        'url-ttf' => '',
                        'url-svg' => '',
                        'weight' => '',
                        'style' => '',
                        'sort' => '',
                        'select' => array(),
                    );
                    $slide = wp_parse_args( $slide, $defaults );

                    echo '<div class="redux-slides-accordion-group"><fieldset class="redux-field" data-id="' . esc_attr( $this->field[ 'id' ] ) . '"><h3><span class="redux-slides-header">' . esc_html( $slide[ 'title' ] ) . '</span></h3><div>';

                    

                    echo '<ul id="' . esc_attr( $this->field[ 'id' ] ) . '-ul" class="redux-slides-list">';

                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][title]" value="' . esc_attr($slide['title']) . '" placeholder="'.esc_html__('Title', 'mosacademy').'" class="full-text slide-title" /></li>';                    

                    
                    if ( $this->field[ 'show' ][ 'url-eot' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-url-eot' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url-eot]" value="' . esc_attr($slide['url-eot']) . '" placeholder="'.esc_attr__('Eot Link', 'mosacademy').'" class="full-text" /></li>';
                    }
                    
                    if ( $this->field[ 'show' ][ 'url-woff' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-url-woff_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url-woff]" value="' . esc_attr($slide['url-woff']) . '" placeholder="'.esc_attr__('Woff Link', 'mosacademy').'" class="full-text" /></li>';
                    }
                    
                    if ( $this->field[ 'show' ][ 'url-woff2' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-url-woff2_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url-woff2]" value="' . esc_attr($slide['url-woff2']) . '" placeholder="'.esc_attr__('Woff2 Link', 'mosacademy').'" class="full-text" /></li>';
                    }
                    
                    if ( $this->field[ 'show' ][ 'url-ttf' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-url-ttf_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url-ttf]" value="' . esc_attr($slide['url-ttf']) . '" placeholder="'.esc_attr__('Ttf Link', 'mosacademy').'" class="full-text" /></li>';
                    }
                    
                    if ( $this->field[ 'show' ][ 'url-svg' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-url-svg_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url-svg]" value="' . esc_attr($slide['url-svg']) . '" placeholder="'.esc_attr__('Ttf Link', 'mosacademy').'" class="full-text" /></li>';
                    }
                    
                    if ( $this->field[ 'show' ][ 'weight' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-weight_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][weight]" value="' . esc_attr($slide['weight']) . '" placeholder="'.esc_attr__('Weight', 'mosacademy').'" class="full-text" /></li>';
                    }
                    
                    if ( $this->field[ 'show' ][ 'style' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-style' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][style]" value="' . esc_attr($slide['style']) . '" placeholder="'.esc_attr__('Style', 'mosacademy').'" class="full-text" /></li>';
                    }

                    echo '<li><input type="hidden" class="slide-sort" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][sort]" id="' . esc_attr( $this->field['id'] ) . '-sort_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['sort'] ) . '" />';
                    echo '<li><input type="hidden" class="upload-id" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][attachment_id]" id="' . esc_attr( $this->field['id'] ) . '-image_id_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['attachment_id'] ) . '" />';
                    echo '<input type="hidden" class="upload-thumbnail" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][thumb]" id="' . esc_attr( $this->field['id'] ) . '-thumb_url_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['thumb'] ) . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][image]" id="' . esc_attr( $this->field['id'] ) . '-image_url_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['image'] ) . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload-height" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][height]" id="' . esc_attr( $this->field['id'] ) . '-image_height_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['height'] ) . '" />';
                    echo '<input type="hidden" class="upload-width" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][width]" id="' . esc_attr( $this->field['id'] ) . '-image_width_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['width'] ) . '" /></li>';
                    
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-slides-remove">' . esc_html__('Delete Slide', 'mosacademy') . '</a></li>';
                    echo '</ul></div></fieldset></div>';
                    $x++;
                
                }
            }

            if ($x == 0) {
                echo '<div class="redux-slides-accordion-group"><fieldset class="redux-field" data-id="'.esc_attr( $this->field['id'] ).'"><h3><span class="redux-slides-header">New Font</span></h3><div>';

                $hide = ' hide';

                echo '<ul id="' . esc_attr( $this->field['id'] ) . '-ul" class="redux-slides-list">';
                $placeholder = (isset($this->field['placeholder']['title'])) ? esc_attr($this->field['placeholder']['title']) : __( 'Title', 'mosacademy' );
                echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][title]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text slide-title" /></li>';

                if ( $this->field[ 'show' ][ 'url-eot' ] ) {
                    $placeholder = (isset($this->field['placeholder']['url-eot'])) ? esc_attr($this->field['placeholder']['url-eot']) : __( 'Eot Link', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-url-eot_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url-eot]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text" /></li>';   
                }
                if ( $this->field[ 'show' ][ 'url-woff' ] ) {
                    $placeholder = (isset($this->field['placeholder']['url-woff'])) ? esc_attr($this->field['placeholder']['url-woff']) : __( 'Woff Link', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-url-woff_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url-woff]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text" /></li>';   
                }
                if ( $this->field[ 'show' ][ 'url-woff2' ] ) {
                    $placeholder = (isset($this->field['placeholder']['url-woff2'])) ? esc_attr($this->field['placeholder']['url-woff2']) : __( 'Woff2 Link', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-url-woff2_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url-woff2]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text" /></li>';   
                }
                if ( $this->field[ 'show' ][ 'url-ttf' ] ) {
                    $placeholder = (isset($this->field['placeholder']['url-ttf'])) ? esc_attr($this->field['placeholder']['url-ttf']) : __( 'Ttf Link', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-url-ttf_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url-ttf]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text" /></li>';   
                }
                if ( $this->field[ 'show' ][ 'url-svg' ] ) {
                    $placeholder = (isset($this->field['placeholder']['url-svg'])) ? esc_attr($this->field['placeholder']['url-svg']) : __( 'Svg Link', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-url-svg_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url-svg]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text" /></li>';   
                }
                if ( $this->field[ 'show' ][ 'weight' ] ) {
                    $placeholder = (isset($this->field['placeholder']['weight'])) ? esc_attr($this->field['placeholder']['weight']) : __( 'Weight', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-weight_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][weight]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text" /></li>';   
                }
                if ( $this->field[ 'show' ][ 'style' ] ) {
                    $placeholder = (isset($this->field['placeholder']['style'])) ? esc_attr($this->field['placeholder']['style']) : __( 'Style', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-style_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][style]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text" /></li>';   
                }

                echo '<li><input type="hidden" class="slide-sort" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][sort]" id="' . esc_attr( $this->field['id'] ) . '-sort_' . esc_attr( $x ) . '" value="' . esc_attr( $x ) . '" />';
                echo '<li><input type="hidden" class="upload-id" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][attachment_id]" id="' . esc_attr( $this->field['id'] ) . '-image_id_' . esc_attr( $x ) . '" value="" />';
                echo '<input type="hidden" class="upload" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url]" id="' . esc_attr( $this->field['id'] ) . '-image_url_' . esc_attr( $x ) . '" value="" readonly="readonly" />';
                echo '<input type="hidden" class="upload-height" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][height]" id="' . esc_attr( $this->field['id'] ) . '-image_height_' . esc_attr( $x ) . '" value="" />';
                echo '<input type="hidden" class="upload-width" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][width]" id="' . esc_attr( $this->field['id'] ) . '-image_width_' . esc_attr( $x ) . '" value="" /></li>';

                echo '<li><a href="javascript:void(0);" class="button deletion redux-slides-remove">' . esc_html__('Delete Slide', 'mosacademy') . '</a></li>';
                echo '</ul></div></fieldset></div>';
            }
            /* translators: %s: slide */
            echo '</div><a href="javascript:void(0);" class="button redux-slides-add2 mos_redux-slides-add button-primary" rel-id="' . esc_attr( $this->field[ 'id' ] ) . '-ul" rel-name="' . esc_attr( $this->field[ 'name' ] ) . '[title][]">' . sprintf ( esc_html__( 'Add %s', 'mosacademy' ), esc_attr( $this->field[ 'content_title' ] ) ) . '</a><br/>';
        }
        public function enqueue () {
            if ( function_exists( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            } else {
                wp_enqueue_script( 'media-upload' );
            }
                
            
            wp_enqueue_style ('redux-field-media-css');
            
            wp_enqueue_style (
                'field_mos_font', 
                plugin_dir_path( MOS_GETWEB_API_FILE ) . '/inc/theme-options/extensions/mos_font/mos_font/field_mos_font.css', 
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
                'field_mos_font', 
                plugin_dir_path( MOS_GETWEB_API_FILE ) . '/inc/theme-options/extensions/mos_font/mos_font/field_mos_font' . Redux_Functions::isMin () . '.js', 
                array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'jquery-ui-sortable', 'redux-field-media-js' ),
                time (), 
                true
            );
        }

    }
}
