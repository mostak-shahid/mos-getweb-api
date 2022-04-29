<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Don't duplicate me!
if (!class_exists('ReduxFramework_mos_person')) {

    /**
     * Main ReduxFramework_slides class
     *
     * @since       1.0.0
     */
    class ReduxFramework_mos_person {

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
                    'address' => true,
                    'organization' => true,
                    'phone' => true,
                    'email' => true,
                    'facebook' => true,
                    'twitter' => true,
                    'linkedin' => true,
                    'google-plus' => true,
                    'instagram' => true,
                    'youtube' => true,
                ),
                'content_title' => __ ( 'Person', 'mosacademy' )
            );

             $this->field = wp_parse_args ( $this->field, $defaults );
			/* translators: %s: slide */
           	echo '<div class="redux-slides-accordion" data-new-content-title="' . esc_attr ( sprintf ( __ ( 'New %s', 'mosacademy' ), $this->field[ 'content_title' ] ) ) . '">';

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
                        'address' => '',
                        'organization' => '',
                        'phone' => '',
                        'email' => '',
                        'facebook' => '',
                        'twitter' => '',
                        'linkedin' => '',
                        'google-plus' => '',
                        'instagram' => '',
                        'youtube' => '',
                        'image' => '',
                        'thumb' => '',
                        'attachment_id' => '',
                        'height' => '',
                        'width' => '',
                        'sort' => '',
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

                    echo '<span class="button media_upload_button" id="add_' . esc_attr( $x ) . '">' . esc_html__( 'Upload', 'mosacademy' ) . '</span>';

                    $hide = '';
                    if ( empty ( $slide[ 'image' ] ) || $slide[ 'image' ] == '' ) {
                        $hide = ' hide';
                    }

                    echo '<span class="button remove-image' . esc_attr( $hide ) . '" id="reset_' . esc_attr( $x ) . '" rel="' . esc_attr( $slide[ 'attachment_id' ] ) . '">' . esc_html__( 'Remove', 'mosacademy' ) . '</span>';

                    echo '</div>' . "\n";

                    echo '<ul id="' . esc_attr( $this->field[ 'id' ] ) . '-ul" class="redux-slides-list">';

                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][title]" value="' . esc_attr($slide['title']) . '" placeholder="'.esc_html__('Title', 'mosacademy').'" class="full-text slide-title" /></li>';
                    if ( $this->field[ 'show' ][ 'description' ] ) {
                        echo '<li><textarea name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][description]" id="' . esc_attr( $this->field['id'] ) . '-description_' . esc_attr( $x ) . '" placeholder="'.esc_attr__('Description', 'mosacademy').'" class="large-text" rows="6">' . esc_attr($slide['description']) . '</textarea></li>';
                    }
                    if ( $this->field[ 'show' ][ 'address' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-address_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][address]" value="' . esc_attr($slide['address']) . '" placeholder="'.esc_attr__('Address', 'mosacademy').'" class="full-text slide-address" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'organization' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-organization_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][organization]" value="' . esc_attr($slide['organization']) . '" placeholder="'.esc_attr__('Organization', 'mosacademy').'" class="full-text slide-address" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'phone' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-phone_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][phone]" value="' . esc_attr($slide['phone']) . '" placeholder="'.esc_attr__('Phone', 'mosacademy').'" class="full-text slide-phone" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'email' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-email_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][email]" value="' . esc_attr($slide['email']) . '" class="full-text slide-email" placeholder="'.esc_html__('Email', 'mosacademy').'" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'facebook' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-facebook_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][facebook]" value="' . esc_attr($slide['facebook']) . '" class="full-text slide-facebook" placeholder="'.esc_html__('Facebook', 'mosacademy').'" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'twitter' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-twitter_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][twitter]" value="' . esc_attr($slide['twitter']) . '" class="full-text slide-twitter" placeholder="'.esc_html__('Twitter', 'mosacademy').'" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'linkedin' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-linkedin_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][linkedin]" value="' . esc_attr($slide['linkedin']) . '" class="full-text slide-linkedin" placeholder="'.esc_html__('LinkedIn', 'mosacademy').'" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'google-plus' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-google-plus_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][google-plus]" value="' . esc_attr($slide['google-plus']) . '" class="full-text slide-google-plus" placeholder="'.esc_html__('Google Plus', 'mosacademy').'" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'instagram' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-instagram_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][instagram]" value="' . esc_attr($slide['instagram']) . '" class="full-text slide-instagram" placeholder="'.esc_html__('Instagram', 'mosacademy').'" /></li>';
                    }
                    if ( $this->field[ 'show' ][ 'youtube' ] ) {
                        echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-youtube' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][youtube]" value="' . esc_attr($slide['youtube']) . '" class="full-text slide-youtube" placeholder="'.esc_html__('Youtube', 'mosacademy').'" /></li>';
                    }

                    echo '<li><input type="hidden" class="slide-sort" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][sort]" id="' . esc_attr( $this->field['id'] ) . '-sort_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['sort'] ) . '" />';
                    echo '<li><input type="hidden" class="upload-id" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][attachment_id]" id="' . esc_attr( $this->field['id'] ) . '-image_id_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['attachment_id'] ) . '" />';
                    echo '<input type="hidden" class="upload-thumbnail" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][thumb]" id="' . esc_attr( $this->field['id'] ) . '-thumb_url_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['thumb'] ) . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][image]" id="' . esc_attr( $this->field['id'] ) . '-image_url_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['image'] ) . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload-height" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][height]" id="' . esc_attr( $this->field['id'] ) . '-image_height_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['height'] ) . '" />';
                    echo '<input type="hidden" class="upload-width" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][width]" id="' . esc_attr( $this->field['id'] ) . '-image_width_' . esc_attr( $x ) . '" value="' . esc_attr( $slide['width'] ) . '" /></li>';
                    
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-slides-remove">' . esc_html__('Delete Person', 'mosacademy') . '</a></li>';
                    echo '</ul></div></fieldset></div>';
                    $x++;
                
                }
            }

            if ($x == 0) {
                echo '<div class="redux-slides-accordion-group"><fieldset class="redux-field" data-id="'.esc_attr( $this->field['id'] ).'"><h3><span class="redux-slides-header">New Person</span></h3><div>';

                $hide = ' hide';

                echo '<div class="screenshot' . esc_attr( $hide ) . '">';
                echo '<a class="of-uploaded-image" href="">';
                echo '<img class="redux-slides-image" id="image_image_id_' . esc_attr( $x ) . '" src="" alt="" target="_blank" rel="external" />';
                echo '</a>';
                echo '</div>';

                //Upload controls DIV
                echo '<div class="upload_button_div">';

                //If the user has WP3.5+ show upload/remove button
                echo '<span class="button media_upload_button" id="add_' . esc_attr( $x ) . '">' . esc_html__( 'Upload', 'mosacademy' ) . '</span>';

                echo '<span class="button remove-image' . esc_attr( $hide ) . '" id="reset_' . esc_attr( $x ) . '" rel="' . esc_attr( $this->parent->args[ 'opt_name' ] ) . '[' . esc_attr( $this->field[ 'id' ] ) . '][attachment_id]">' . esc_html__( 'Remove', 'mosacademy' ) . '</span>';

                echo '</div>' . "\n";

                echo '<ul id="' . esc_attr( $this->field['id'] ) . '-ul" class="redux-slides-list">';
                $placeholder = (isset($this->field['placeholder']['title'])) ? esc_attr($this->field['placeholder']['title']) : __( 'Title', 'mosacademy' );
                echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-title_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][title]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text slide-title" /></li>';
                if ( $this->field[ 'show' ][ 'description' ] ) {
                    $placeholder = (isset($this->field['placeholder']['description'])) ? esc_attr($this->field['placeholder']['description']) : __( 'Description', 'mosacademy' );
                    echo '<li><textarea name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][description]" id="' . esc_attr( $this->field['id'] ) . '-description_' . esc_attr( $x ) . '" placeholder="'.esc_attr( $placeholder ).'" class="large-text" rows="6"></textarea></li>';
                }
                if ( $this->field[ 'show' ][ 'address' ] ) {
                    $placeholder = (isset($this->field['placeholder']['address'])) ? esc_attr($this->field['placeholder']['address']) : __( 'Address', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-address_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][address]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text slide-address" /></li>';   
                }
                if ( $this->field[ 'show' ][ 'organization' ] ) {
                    $placeholder = (isset($this->field['placeholder']['organization'])) ? esc_attr($this->field['placeholder']['organization']) : __( 'Organization', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-organization_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][organization]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text slide-organization" /></li>';   
                }
                if ( $this->field[ 'show' ][ 'phone' ] ) {
                    $placeholder = (isset($this->field['placeholder']['phone'])) ? esc_attr($this->field['placeholder']['phone']) : __( 'Phone', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-phone_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][phone]" value="" placeholder="'.esc_attr( $placeholder ).'" class="full-text slide-phone" /></li>';   
                }
                if ( $this->field[ 'show' ][ 'email' ] ) {             
                    $placeholder = (isset($this->field['placeholder']['email'])) ? esc_attr($this->field['placeholder']['email']) : __( 'Email', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-email_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][email]" value="" class="full-text slide-email" placeholder="'.esc_attr( $placeholder ).'" /></li>';
                }
                if ( $this->field[ 'show' ][ 'facebook' ] ) {             
                    $placeholder = (isset($this->field['placeholder']['facebook'])) ? esc_attr($this->field['placeholder']['facebook']) : __( 'Facebook', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-facebook_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][facebook]" value="" class="full-text slide-facebook" placeholder="'.esc_attr( $placeholder ).'" /></li>';
                }
                if ( $this->field[ 'show' ][ 'twitter' ] ) {             
                    $placeholder = (isset($this->field['placeholder']['twitter'])) ? esc_attr($this->field['placeholder']['twitter']) : __( 'Twitter', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-twitter_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][twitter]" value="" class="full-text slide-twitter" placeholder="'.esc_attr( $placeholder ).'" /></li>';
                }
                if ( $this->field[ 'show' ][ 'linkedin' ] ) {             
                    $placeholder = (isset($this->field['placeholder']['linkedin'])) ? esc_attr($this->field['placeholder']['linkedin']) : __( 'LinkedIn', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-linkedin_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][linkedin]" value="" class="full-text slide-linkedin" placeholder="'.esc_attr( $placeholder ).'" /></li>';
                }
                if ( $this->field[ 'show' ][ 'google-plus' ] ) {             
                    $placeholder = (isset($this->field['placeholder']['google-plus'])) ? esc_attr($this->field['placeholder']['google-plus']) : __( 'Google Plus', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-google-plus_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][google-plus]" value="" class="full-text slide-google-plus" placeholder="'.esc_attr( $placeholder ).'" /></li>';
                }
                if ( $this->field[ 'show' ][ 'instagram' ] ) {             
                    $placeholder = (isset($this->field['placeholder']['instagram'])) ? esc_attr($this->field['placeholder']['instagram']) : __( 'Instagram', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-instagram_' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][instagram]" value="" class="full-text slide-instagram" placeholder="'.esc_attr( $placeholder ).'" /></li>';
                }
                if ( $this->field[ 'show' ][ 'youtube' ] ) {             
                    $placeholder = (isset($this->field['placeholder']['youtube'])) ? esc_attr($this->field['placeholder']['youtube']) : __( 'Youtube', 'mosacademy' );
                    echo '<li><input type="text" id="' . esc_attr( $this->field['id'] ) . '-youtube' . esc_attr( $x ) . '" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][youtube]" value="" class="full-text slide-youtube" placeholder="'.esc_attr( $placeholder ).'" /></li>';
                }

                echo '<li><input type="hidden" class="slide-sort" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][sort]" id="' . esc_attr( $this->field['id'] ) . '-sort_' . esc_attr( $x ) . '" value="' . esc_attr( $x ) . '" />';
                echo '<li><input type="hidden" class="upload-id" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][attachment_id]" id="' . esc_attr( $this->field['id'] ) . '-image_id_' . esc_attr( $x ) . '" value="" />';
                echo '<input type="hidden" class="upload" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][url]" id="' . esc_attr( $this->field['id'] ) . '-image_url_' . esc_attr( $x ) . '" value="" readonly="readonly" />';
                echo '<input type="hidden" class="upload-height" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][height]" id="' . esc_attr( $this->field['id'] ) . '-image_height_' . esc_attr( $x ) . '" value="" />';
                echo '<input type="hidden" class="upload-width" name="' . esc_attr( $this->field['name'] ) . '[' . esc_attr( $x ) . '][width]" id="' . esc_attr( $this->field['id'] ) . '-image_width_' . esc_attr( $x ) . '" value="" /></li>';

                echo '<li><a href="javascript:void(0);" class="button deletion redux-slides-remove">' . esc_html__('Delete Person', 'mosacademy') . '</a></li>';
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
                'field_mos_person', 
                get_template_directory_uri() . '/inc/theme-options/extensions/mos_person/mos_person/field_mos_person.css', 
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
                'field_mos_person', 
                get_template_directory_uri() . '/inc/theme-options/extensions/mos_person/mos_person/field_mos_person' . Redux_Functions::isMin () . '.js', 
                array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'jquery-ui-sortable', 'redux-field-media-js' ),
                time (), 
                true
            );
        }

    }
}
