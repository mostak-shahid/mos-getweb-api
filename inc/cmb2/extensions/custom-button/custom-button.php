<?php
/**
 * Returns options markup for a state select field.
 * @param  mixed $value Selected/saved state
 * @return string       html string containing all state options
 */

/**
 * Render Button Field
 */
function cmb2_render_button_field_callback( $field, $value, $object_id, $object_type, $field_type ) {

	// make sure we specify each part of the value we need.
	$value = wp_parse_args( $value, array(
		'title' => '',
		'url' => '',
	) );

	?>
	<div><p><label for="<?php echo $field_type->_id( '_title' ); ?>">Title</label></p>
		<?php echo $field_type->input( array(
			'name'  => $field_type->_name( '[title]' ),
			'id'    => $field_type->_id( '_title' ),
			'value' => $value['title'],
			'desc'  => '',
		) ); ?>
	</div>
	<div><p><label for="<?php echo $field_type->_id( '_url' ); ?>'">URL</label></p>
		<?php echo $field_type->input( array(
			'name'  => $field_type->_name( '[url]' ),
			'id'    => $field_type->_id( '_url' ),
			'value' => $value['url'],
			'desc'  => '',
		) ); ?>
	</div>
	<br class="clear">
	<?php
	echo $field_type->_desc( true );

}
add_filter( 'cmb2_render_button', 'cmb2_render_button_field_callback', 10, 5 );