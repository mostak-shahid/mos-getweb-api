<?php

    /**
     * Class ReduxFramework_mos_group
     */

// Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    if ( ! class_exists( 'ReduxFramework_mos_group' ) ) {
        class ReduxFramework_mos_group {

            /**
             * Field Constructor.
             * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
             *
             * @since ReduxFramework 1.0.1
             */
            function __construct( $field = array(), $value = '', $parent ) {
                $this->parent = $parent;
                $this->field  = $field;
                $this->value  = $value;
            }

            /**
             * Field Render Function.
             * Takes the vars and outputs the HTML for the field in the settings
             *
             * @since ReduxFramework 1.0.1
             */
            function render() {
                $this->_render_combined_field();
                /*if ( ! empty( $this->field['username'] ) && $this->field['username'] === true ) {
                    $this->_render_combined_field();
                } 
                else {
                    $this->_render_single_field();
                }*/
            }

            /**
             * This will render a combined User/Password field
             *
             * @since ReduxFramework 3.0.9
             * @example
             *        <code>
             *        array(
             *        'id'          => 'smtp_account',
             *        'type'        => 'password',
             *        'username'    => true,
             *        'title'       => 'SMTP Account',
             *        'placeholder' => array('username' => 'Username')
             *        )
             *        </code>
             */
            private function _render_combined_field() {


                 /*$defaults = array(
                    'show' => array(
                        'title' => true,
                        'basic_icon' => true,
                        'hover_icon' => true,
                        'link_url' => true,
                        'target' => true,
                    )
                );*/

                $defaults = array(
                    'placeholder' => array(
                        'text_field_1' => __( 'Text Field 1', 'redux-framework' ),
                        'text_field_2' => __( 'Text Field 2', 'redux-framework' ),
                        'text_field_3' => __( 'Text Field 3', 'redux-framework' ),
                        'text_field_4' => __( 'Text Field 4', 'redux-framework' ),
                        'text_field_5' => __( 'Text Field 5', 'redux-framework' ),
                        'text_field_6' => __( 'Text Field 6', 'redux-framework' ),
                        'text_field_7' => __( 'Text Field 7', 'redux-framework' ),
                        'text_field_8' => __( 'Text Field 8', 'redux-framework' ),
                        'text_field_9' => __( 'Text Field 9', 'redux-framework' ),
                        'text_field_10' => __( 'Text Field 10', 'redux-framework' ),
                        'text_field_11' => __( 'Text Field 11', 'redux-framework' ),
                        'text_field_12' => __( 'Text Field 12', 'redux-framework' ),
                        'text_field_13' => __( 'Text Field 13', 'redux-framework' ),
                        'text_field_14' => __( 'Text Field 14', 'redux-framework' ),
                        'text_field_15' => __( 'Text Field 15', 'redux-framework' ),
                        'text_field_16' => __( 'Text Field 16', 'redux-framework' ),
                        'text_field_17' => __( 'Text Field 17', 'redux-framework' ),
                        'text_field_18' => __( 'Text Field 18', 'redux-framework' ),
                        'text_field_19' => __( 'Text Field 19', 'redux-framework' ),
                        'text_field_20' => __( 'Text Field 20', 'redux-framework' )
                    ),
                    'show' => array(
                        'text_field_1' => true,
                        'text_field_2' => false,
                        'text_field_3' => false,
                        'text_field_4' => false,
                        'text_field_5' => false,
                        'text_field_6' => false,
                        'text_field_7' => false,
                        'text_field_8' => false,
                        'text_field_9' => false,
                        'text_field_10' => false,
                        'text_field_11' => false,
                        'text_field_12' => false,
                        'text_field_13' => false,
                        'text_field_14' => false,
                        'text_field_15' => false,
                        'text_field_16' => false,
                        'text_field_17' => false,
                        'text_field_18' => false,
                        'text_field_19' => false,
                        'text_field_20' => false
                    )
                );

                $this->value = wp_parse_args( $this->value, $defaults );

                if ( ! empty( $this->field['placeholder'] ) ) {
                    if ( is_array( $this->field['placeholder'] ) ) {
                        if ( ! empty( $this->field['placeholder']['text_field_1'] ) ) {
                            $this->value['placeholder']['text_field_1'] = $this->field['placeholder']['text_field_1'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_2'] ) ) {
                            $this->value['placeholder']['text_field_2'] = $this->field['placeholder']['text_field_2'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_3'] ) ) {
                            $this->value['placeholder']['text_field_3'] = $this->field['placeholder']['text_field_3'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_4'] ) ) {
                            $this->value['placeholder']['text_field_4'] = $this->field['placeholder']['text_field_4'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_5'] ) ) {
                            $this->value['placeholder']['text_field_5'] = $this->field['placeholder']['text_field_5'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_6'] ) ) {
                            $this->value['placeholder']['text_field_6'] = $this->field['placeholder']['text_field_6'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_7'] ) ) {
                            $this->value['placeholder']['text_field_7'] = $this->field['placeholder']['text_field_7'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_8'] ) ) {
                            $this->value['placeholder']['text_field_8'] = $this->field['placeholder']['text_field_8'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_9'] ) ) {
                            $this->value['placeholder']['text_field_9'] = $this->field['placeholder']['text_field_9'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_10'] ) ) {
                            $this->value['placeholder']['text_field_10'] = $this->field['placeholder']['text_field_10'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_11'] ) ) {
                            $this->value['placeholder']['text_field_11'] = $this->field['placeholder']['text_field_11'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_12'] ) ) {
                            $this->value['placeholder']['text_field_12'] = $this->field['placeholder']['text_field_12'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_13'] ) ) {
                            $this->value['placeholder']['text_field_13'] = $this->field['placeholder']['text_field_13'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_14'] ) ) {
                            $this->value['placeholder']['text_field_14'] = $this->field['placeholder']['text_field_14'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_15'] ) ) {
                            $this->value['placeholder']['text_field_15'] = $this->field['placeholder']['text_field_15'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_16'] ) ) {
                            $this->value['placeholder']['text_field_16'] = $this->field['placeholder']['text_field_16'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_17'] ) ) {
                            $this->value['placeholder']['text_field_17'] = $this->field['placeholder']['text_field_17'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_18'] ) ) {
                            $this->value['placeholder']['text_field_18'] = $this->field['placeholder']['text_field_18'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_19'] ) ) {
                            $this->value['placeholder']['text_field_19'] = $this->field['placeholder']['text_field_19'];
                        }
                        if ( ! empty( $this->field['placeholder']['text_field_20'] ) ) {
                            $this->value['placeholder']['text_field_20'] = $this->field['placeholder']['text_field_20'];
                        }
                    }
                }

                // text_field_11 field
                if ( $this->field[ 'show' ][ 'text_field_1' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_1'] . '" id="' . $this->field['id'] . '[text_field_1]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_1]' . '" value="' . esc_attr( $this->value['text_field_1'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_12 field
                if ( $this->field[ 'show' ][ 'text_field_2' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_2'] . '" id="' . $this->field['id'] . '[text_field_2]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_2]' . '" value="' . esc_attr( $this->value['text_field_2'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_13 field
                if ( $this->field[ 'show' ][ 'text_field_3' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_3'] . '" id="' . $this->field['id'] . '[text_field_3]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_3]' . '" value="' . esc_attr( $this->value['text_field_3'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_14 field
                if ( $this->field[ 'show' ][ 'text_field_4' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_4'] . '" id="' . $this->field['id'] . '[text_field_4]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_4]' . '" value="' . esc_attr( $this->value['text_field_4'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_15 field
                if ( $this->field[ 'show' ][ 'text_field_5' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_5'] . '" id="' . $this->field['id'] . '[text_field_5]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_5]' . '" value="' . esc_attr( $this->value['text_field_5'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_16 field
                if ( $this->field[ 'show' ][ 'text_field_6' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_6'] . '" id="' . $this->field['id'] . '[text_field_6]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_6]' . '" value="' . esc_attr( $this->value['text_field_6'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_17 field
                if ( $this->field[ 'show' ][ 'text_field_7' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_7'] . '" id="' . $this->field['id'] . '[text_field_7]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_7]' . '" value="' . esc_attr( $this->value['text_field_7'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_18 field
                if ( $this->field[ 'show' ][ 'text_field_8' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_8'] . '" id="' . $this->field['id'] . '[text_field_8]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_8]' . '" value="' . esc_attr( $this->value['text_field_8'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_19 field
                if ( $this->field[ 'show' ][ 'text_field_9' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_9'] . '" id="' . $this->field['id'] . '[text_field_9]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_9]' . '" value="' . esc_attr( $this->value['text_field_9'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_20 field
                if ( $this->field[ 'show' ][ 'text_field_10' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_10'] . '" id="' . $this->field['id'] . '[text_field_10]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_10]' . '" value="' . esc_attr( $this->value['text_field_10'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }

                // text_field_11 field
                if ( $this->field[ 'show' ][ 'text_field_11' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_11'] . '" id="' . $this->field['id'] . '[text_field_11]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_11]' . '" value="' . esc_attr( $this->value['text_field_11'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_12 field
                if ( $this->field[ 'show' ][ 'text_field_12' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_12'] . '" id="' . $this->field['id'] . '[text_field_12]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_12]' . '" value="' . esc_attr( $this->value['text_field_12'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_13 field
                if ( $this->field[ 'show' ][ 'text_field_13' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_13'] . '" id="' . $this->field['id'] . '[text_field_13]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_13]' . '" value="' . esc_attr( $this->value['text_field_13'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_14 field
                if ( $this->field[ 'show' ][ 'text_field_14' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_14'] . '" id="' . $this->field['id'] . '[text_field_14]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_14]' . '" value="' . esc_attr( $this->value['text_field_14'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_15 field
                if ( $this->field[ 'show' ][ 'text_field_15' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_15'] . '" id="' . $this->field['id'] . '[text_field_15]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_15]' . '" value="' . esc_attr( $this->value['text_field_15'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_16 field
                if ( $this->field[ 'show' ][ 'text_field_16' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_16'] . '" id="' . $this->field['id'] . '[text_field_16]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_16]' . '" value="' . esc_attr( $this->value['text_field_16'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_17 field
                if ( $this->field[ 'show' ][ 'text_field_17' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_17'] . '" id="' . $this->field['id'] . '[text_field_17]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_17]' . '" value="' . esc_attr( $this->value['text_field_17'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_18 field
                if ( $this->field[ 'show' ][ 'text_field_18' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_18'] . '" id="' . $this->field['id'] . '[text_field_18]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_18]' . '" value="' . esc_attr( $this->value['text_field_18'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_19 field
                if ( $this->field[ 'show' ][ 'text_field_19' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_19'] . '" id="' . $this->field['id'] . '[text_field_19]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_19]' . '" value="' . esc_attr( $this->value['text_field_19'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }
                // text_field_20 field
                if ( $this->field[ 'show' ][ 'text_field_20' ] ) {
                    echo '<input type="text" autocomplete="off" placeholder="' . $this->value['placeholder']['text_field_20'] . '" id="' . $this->field['id'] . '[text_field_20]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text_field_20]' . '" value="' . esc_attr( $this->value['text_field_20'] ) . '" class="' . $this->field['class'] . '" />&nbsp;';
                }

                

                // Password field
                //echo '<input type="password" autocomplete="off" placeholder="' . $this->value['placeholder']['password'] . '" id="' . $this->field['id'] . '[password]" name="' . $this->field['name'] . $this->field['name_suffix'] . '[password]' . '" value="' . esc_attr( $this->value['password'] ) . '" class="' . $this->field['class'] . '" />';
            }

            /**
             * This will render a single Password field
             *
             * @since ReduxFramework 3.0.9
             * @example
             *        <code>
             *        array(
             *        'id'    => 'smtp_password',
             *        'type'  => 'password',
             *        'title' => 'SMTP Password'
             *        )
             *        </code>
             */
            /*private function _render_single_field() {
                echo '<input type="password" id="' . $this->field['id'] . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '" value="' . esc_attr( $this->value ) . '" class="' . $this->field['class'] . '" />';
            }*/
        }
    }