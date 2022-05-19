<?php
/* 
 * Add custom user profile information
 *
 */ 

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

    <h3>Extra profile information</h3>

    <table class="form-table">

        <tr>
            <th><label for="_mos_profile_image">Profile Image</label></th> 
            <td>
                <img src="<?php echo esc_attr( get_the_author_meta( '_mos_profile_image', $user->ID ) ); ?>" style="height:50px;">
                <input type="text" name="_mos_profile_image" id="_mos_profile_image" value="<?php echo esc_attr( get_the_author_meta( '_mos_profile_image', $user->ID ) ); ?>" class="regular-text" /><input type='button' class="button-primary" value="Upload Image" id="uploadimage"/><br />
                <span class="description">Please upload your image for your profile.</span>
            </td>
        </tr>

        <tr>
            <th><label for="_mos_profile_designation">Designation</label></th> 
            <td>
                <input type="text" name="_mos_profile_designation" id="_mos_profile_designation" value="<?php echo esc_attr( get_the_author_meta( '_mos_profile_designation', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>

        <tr>
            <th><label for="_mos_profile_linkedin">Linkedin</label></th> 
            <td>
                <input type="url" name="_mos_profile_linkedin" id="_mos_profile_linkedin" value="<?php echo esc_attr( get_the_author_meta( '_mos_profile_linkedin', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>

    </table>
<?php }

/* 
 * Script for saving profile image
 *
 */

add_action('admin_head','my_profile_upload_js');
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox'); 

function my_profile_upload_js() { ?>
    
    <script type="text/javascript">
        jQuery(document).ready(function() {
        
            jQuery(document).find("input[id^='uploadimage']").on('click', function(){
                //var num = this.id.split('-')[1];
                formfield = jQuery('#_mos_profile_image').attr('name');
                tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
     
                window.send_to_editor = function(html) {
                    imgurl = jQuery(html).attr('src');
                    //jQuery('img',html).attr('src');
                    //console.log(imgurl);
                    jQuery('#_mos_profile_image').val(imgurl);
                    
                    tb_remove();
                }
     
                return false;
            });
        });

    </script>

<?php }



/*
 * Save custom user profile data
 *
 */

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
    update_usermeta( $user_id, '_mos_profile_image', $_POST['_mos_profile_image'] );
    update_usermeta( $user_id, '_mos_profile_designation', $_POST['_mos_profile_designation'] );
    update_usermeta( $user_id, '_mos_profile_linkedin', $_POST['_mos_profile_linkedin'] );
}