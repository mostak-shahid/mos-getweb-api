<?php
/*
add_action( 'admin_init', 'my_admin_init' );
function my_admin_init() {
    add_filter( 'manage_edit-technology_columns', 'my_new_custom_post_column');
    add_action( 'manage_technology_custom_column', 'technology_catagory_tax_column_info', 10, 2);
}

function my_new_custom_post_column( $column ) {
    $column['technology_catagory'] = 'Categories';

    return $column;
}

function technology_catagory_tax_column_info( $column_name, $post_id ) {
        $taxonomy = $column_name;
        $post_type = get_post_type($post_id);
        $terms = get_the_terms($post_id, $taxonomy);

        if (!empty($terms) ) {
            foreach ( $terms as $term )
            $post_terms[] ="<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " .esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
            echo join('', $post_terms ) . 'xx';
        }else echo '<i>No Categories Set. </i>';
}
*/


add_filter('manage_technology_posts_columns', function($columns) {
    
//    var_dump($columns);
//    unset($columns['date']);
    $column['title'] = 'Title';
    $column['technology_catagory'] = 'Categories';
    $column['date'] = 'Date';

    return $column;
	//return array_merge($columns, ['technology_catagory' => __('Categories', 'textdomain')]);
});
 
add_action('manage_technology_posts_custom_column', function($column_key, $post_id) {
	if ($column_key == 'technology_catagory') {
		$terms_string = '';        
        $term_obj_list = get_the_terms( $post_id, 'technology_catagory' );
        $terms_string = ($term_obj_list)?join(', ', wp_list_pluck($term_obj_list, 'name')):'';
        
        echo $terms_string;
	}
}, 10, 2);