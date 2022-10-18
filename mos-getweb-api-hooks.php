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

add_filter('manage_block_posts_columns', function($columns) {
    
//    var_dump($columns);
//    unset($columns['date']);
    $column['title'] = 'Title';
    $column['block_category'] = 'Categories';
    $column['date'] = 'Date';

    return $column;
	//return array_merge($columns, ['block_category' => __('Categories', 'textdomain')]);
});
 
add_action('manage_block_posts_custom_column', function($column_key, $post_id) {
	if ($column_key == 'block_category') {
		$terms_string = '';        
        $term_obj_list = get_the_terms( $post_id, 'block_category' );
        $terms_string = ($term_obj_list)?join(', ', wp_list_pluck($term_obj_list, 'name')):'';
        
        echo $terms_string;
	}
}, 10, 2);

add_filter('manage_job_posts_columns', function($columns) {
    
//    var_dump($columns);
//    unset($columns['date']);
    $column['title'] = 'Title';
    $column['job_category'] = 'Categories';
    $column['date'] = 'Date';

    return $column;
	//return array_merge($columns, ['job_category' => __('Categories', 'textdomain')]);
});
 
add_action('manage_job_posts_custom_column', function($column_key, $post_id) {
	if ($column_key == 'job_category') {
		$terms_string = '';        
        $term_obj_list = get_the_terms( $post_id, 'job_category' );
        $terms_string = ($term_obj_list)?join(', ', wp_list_pluck($term_obj_list, 'name')):'';
        
        echo $terms_string;
	}
}, 10, 2);



add_filter('manage_project_posts_columns', function($columns) {
    
//    var_dump($columns);
//    unset($columns['date']);
    $column['title'] = 'Title';
    $column['project_category'] = 'Categories';
    $column['project_tag'] = 'Tags';
    $column['date'] = 'Date';

    return $column;
	//return array_merge($columns, ['project_category' => __('Categories', 'textdomain')]);
});
 
add_action('manage_project_posts_custom_column', function($column_key, $post_id) {
	if ($column_key == 'project_category') {
		$terms_string = '';        
        $term_obj_list = get_the_terms( $post_id, 'project_category' );
        $terms_string = ($term_obj_list)?join(', ', wp_list_pluck($term_obj_list, 'name')):'';        
        echo $terms_string;
	}
	if ($column_key == 'project_tag') {
		$terms_string = '';        
        $term_obj_list = get_the_terms( $post_id, 'project_tag' );
        $terms_string = ($term_obj_list)?join(', ', wp_list_pluck($term_obj_list, 'name')):'';        
        echo $terms_string;
	}
}, 10, 2);

add_filter('manage_industry_posts_columns', function($columns) {
    
//    var_dump($columns);
//    unset($columns['date']);
    $column['title'] = 'Title';
    $column['industry_category'] = 'Categories';
    $column['date'] = 'Date';

    return $column;
	//return array_merge($columns, ['industry_category' => __('Categories', 'textdomain')]);
});
 
add_action('manage_industry_posts_custom_column', function($column_key, $post_id) {
	if ($column_key == 'industry_category') {
		$terms_string = '';        
        $term_obj_list = get_the_terms( $post_id, 'industry_category' );
        $terms_string = ($term_obj_list)?join(', ', wp_list_pluck($term_obj_list, 'name')):'';
        
        echo $terms_string;
	}
}, 10, 2);