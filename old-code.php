<?php
function mos_getweb_api_data_list($data) {
    global $wpdb;
	$output = [];
    $columns = $wpdb->get_col( $wpdb->prepare("SELECT DISTINCT meta_key FROM {$wpdb->prefix}postmeta"));
	$i = 0;
	$args = [
		'post_type' => $data->get_param('type'),
        'offset' => ($data->get_param('offset'))?$data->get_param('offset'):0,
		'posts_per_page' => ($data->get_param('offset'))?
        (($data->get_param('count'))? $data->get_param('count'):10):
        (($data->get_param('count'))? $data->get_param('count'):-1)
	];
    if ($data->get_param('taxonomy')) {        
        $catSlice = explode('-',$data->get_param('taxonomy'));
        
        if ($catSlice && sizeof($catSlice)) {        
            $args['tax_query']['relation'] = 'OR';
            foreach($catSlice as $catID){
                $args['tax_query'][$catID] = array(
                    'taxonomy' => $data->get_param('type') . '_category',
                    'field' => 'term_id',
                    'terms' => $catID
                );
            }
        }
    }
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            $output[$i]['id'] = get_the_ID();
            $output[$i]['title'] = get_the_title();
            $output[$i]['content'] = get_the_content();
            $output[$i]['excerpt'] = get_the_excerpt();
                
            $output[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $output[$i]['featured_image']['medium'] = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $output[$i]['featured_image']['large'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $output[$i]['featured_image']['full'] = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
    
            foreach ($columns as $col) {
                $output[$i]['meta'][$col] = get_post_meta(get_the_ID(),$col, true);
            }
    
            $i++;
        endwhile;
        
        //$output['columns'] = $columns;
        $output['status'] = 'Success';
    else : 
        $output['status'] = 'Error';
    endif;
    wp_reset_postdata();
	return $output;
}
function mos_getweb_api_data_single( $data ) {
    global $wpdb;
	$output = [];
    $columns = $wpdb->get_col( $wpdb->prepare("SELECT DISTINCT meta_key FROM {$wpdb->prefix}postmeta WHERE post_id=" . $data->get_param('id')));
    
    $post   = get_post( $data->get_param('id') );

    $output['id'] = $post->ID;
    $output['title'] = $post->post_title;
    $output['content'] = apply_filters('the_content',$post->post_content);
    $output['excerpt'] = get_the_excerpt();
    $output['slug'] = $post->post_name;
    $output['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
    $output['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
    $output['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
    $output['featured_image']['full'] = get_the_post_thumbnail_url($post->ID, 'full');
    
    foreach ($columns as $col) {
        $output['meta'][$col] = get_post_meta($post->ID,$col, true);
    }
    
    return $columns;
}
function mos_getweb_api_data_categories ($data){
    //return $data->get_param('taxonomy');
    return mos_get_terms($data->get_param('taxonomy'));
}
/************************************************************************************************/

function mos_getweb_api_page_list (){
    return get_pages();
}
function mos_getweb_api_posts() {
	$args = [
		'numberposts' => 99999,
		'post_type' => 'post'
	];

	$posts = get_posts($args);

	$output = [];
	$i = 0;

	foreach($posts as $post) {
		$output[$i]['id'] = $post->ID;
		$output[$i]['title'] = $post->post_title;
		$output[$i]['content'] = $post->post_content;
		$output[$i]['slug'] = $post->post_name;
		$output[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
		$output[$i]['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
		$output[$i]['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
		$i++;
	}

	return $output;
}
function mos_getweb_api_post( $id ) {
	$post   = get_post( $id['id'] );
	$output['id'] = $post->ID;
	$output['title'] = $post->post_title;
	$output['content'] = $post->post_content;
	$output['slug'] = $post->post_name;
	$output['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
	$output['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
	$output['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
    
    $output['meta']['page_group_details_group'] = get_post_meta($post->ID,'_mosacademy_page_group_details_group', true);
	return $output;
}
// Used in this video https://www.youtube.com/watch?v=76sJL9fd12Y
function mos_getweb_api_products() {
	$args = [
		'numberposts' => -1,
		'post_type' => 'products'
	];

	$posts = get_posts($args);

	$output = [];
	$i = 0;

	foreach($posts as $post) {
		$output[$i]['id'] = $post->ID;
		$output[$i]['title'] = $post->post_title;
        $output[$i]['slug'] = $post->post_name;
        $output[$i]['price'] = get_field('price', $post->ID);
        $output[$i]['delivery'] = get_field('delivery', $post->ID);
		$i++;
	}

	return $output;
}

add_action('rest_api_init', function() {
    //https://developer.wordpress.org/reference/functions/register_rest_route/
    
	register_rest_route('mos-getweb-api/v1', '/data-list/(?P<type>[a-zA-z0-9_]+)/(?P<taxonomy>[0-9-]+)(?:/(?P<offset>[0-9]+)(?:/(?P<count>[0-9]+))?)?', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_data_list',
	]);

	register_rest_route( 'mos-getweb-api/v1', 'data-single/(?P<id>[0-9]+)', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_data_single',
    ]);
    
	register_rest_route('mos-getweb-api/v1', 'data-taxonomies/(?P<taxonomy>[a-zA-z0-9_-]+)', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_data_categories',
	]);
    
    
    
	register_rest_route('mos-getweb-api/v1', 'page-list', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_page_list',
	]);
    
	register_rest_route('mos-getweb-api/v1', 'posts', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_posts',
	]);

	register_rest_route( 'mos-getweb-api/v1', 'post/(?P<id>[0-9]+)(?:/(?P<return>[a-zA-z0-9,]+))?', array(
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_post',
    ) );
    
    // Used in this video: https://www.youtube.com/watch?v=76sJL9fd12Y	
    register_rest_route('mos-getweb-api/v1', 'products', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_products',
	]);
});