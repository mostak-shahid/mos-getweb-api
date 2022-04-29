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
                $taxonomy = $wpdb->get_var( "SELECT taxonomy FROM {$wpdb->prefix}term_taxonomy WHERE term_id={$catID}" );
                $args['tax_query'][$catID] = array(
                    'taxonomy' => $taxonomy,
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
            $output[$i]['slug'] = get_post_field( 'post_name', get_the_ID() );
            $output[$i]['date'] = get_the_date('Y-m-d H:m:i');
            $output[$i]['modified_date'] = get_the_modified_date('Y-m-d H:m:i');
    
            $output[$i]['author']['id'] = get_the_author_ID();
            $output[$i]['author']['name'] = get_the_author_meta('display_name',get_the_author_ID());
            $output[$i]['author']['slug'] = get_the_author_meta('user_login',get_the_author_ID());
                
            $output[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $output[$i]['featured_image']['medium'] = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $output[$i]['featured_image']['large'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $output[$i]['featured_image']['full'] = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
            $output[$i]['featured_image']['id'] = get_post_thumbnail_id(get_the_ID());     
            $output[$i]['image'] = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
    
            foreach ($columns as $col) {
                $output[$i]['meta'][$col] = get_post_meta(get_the_ID(),$col, true);
            }
    
            $i++;
        endwhile;
    else : 
        $output['status'] = 'Error';
    endif;
    wp_reset_postdata();
	return $output;
}
function mos_getweb_api_data_single( $id ) {    
    global $wpdb;
    //$post_id = $id['id'];
    
    $post_id = (!is_numeric($id['id']))?$wpdb->get_var("SELECT ID FROM {$wpdb->prefix}posts WHERE post_name='{$id['id']}'"):$id['id'];
	$output = [];
    $columns = $wpdb->get_col( $wpdb->prepare("SELECT DISTINCT meta_key FROM {$wpdb->prefix}postmeta WHERE post_id=" . $post_id));
    
    //$id = SELECT ID FROM api_getweb_wp_posts WHERE post_name='hello-world'
    
    $post   = get_post( $post_id );
    if ($post){
        $output['id'] = $post_id;
        $output['title'] = $post->post_title;
        $output['content'] = apply_filters('the_content',$post->post_content);
        $output['excerpt'] = $post->post_excerpt;
        $output['slug'] = $post->post_name;    
        $output['date'] = get_the_date('Y-m-d H:m:i', $post_id);
        $output['modified_date'] = get_the_modified_date('Y-m-d H:m:i', $post_id);

        $output['author']['id'] = $post->post_author;
        $output['author']['name'] = get_the_author_meta('display_name',$post->post_author);
        $output['author']['slug'] = get_the_author_meta('user_login',$post->post_author);

        $output['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post_id, 'thumbnail');
        $output['featured_image']['medium'] = get_the_post_thumbnail_url($post_id, 'medium');
        $output['featured_image']['large'] = get_the_post_thumbnail_url($post_id, 'large');
        $output['featured_image']['full'] = get_the_post_thumbnail_url($post_id, 'full');
        $output['featured_image']['id'] = get_post_thumbnail_id($post_id); 
        $output['image'] = get_the_post_thumbnail_url($post_id, 'full');

        foreach ($columns as $col) {
            $output['meta'][$col] = get_post_meta($post_id,$col, true);
        }
    } else {        
        $output['status'] = 'Error';
    }
    return $output;
}
function mos_getweb_api_data_categories ($data){
    //return $data->get_param('taxonomy');
    return mos_get_terms($data->get_param('taxonomy'));
}
function mos_getweb_api_options (){
    global $mosacademy_options;
    if ($mosacademy_options["sections-footer-gallery"]) {
        $slice = explode(',',$mosacademy_options["sections-footer-gallery"]);
        $mosacademy_options["sections-footer-gallery"] = [];
        foreach($slice as $attachment_id){
            $mosacademy_options["sections-footer-gallery"][$attachment_id] = wp_get_attachment_url( $attachment_id );
        }
    }
    $mosacademy_options['site_title'] = get_bloginfo('name');
    $mosacademy_options['site_description'] = get_bloginfo('description');
    return $mosacademy_options;
}
function mos_getweb_api_menus (){
    global $wpdb;
    $output = [];
    $term_taxonomies = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy = 'nav_menu'", ARRAY_A );
    foreach($term_taxonomies as $row){
        $terms = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}terms WHERE term_id={$row['term_id']}", ARRAY_A ); 
        foreach($terms as $term) {            
            //$output[$term['term_id']]['name'] = $term['name'];    
            $output[$term['term_id']] = wp_get_nav_menu_items($term['name']);
        }
    }
    return $output;
}
/************************************************************************************************/
function mos_getweb_api_banners($data) {
	$output = [];
	$i = 0;
	$args = [
		'post_type' => 'banner',
        'offset' => ($data->get_param('offset'))?$data->get_param('offset'):0,
		'posts_per_page' => ($data->get_param('offset'))?
        (($data->get_param('count'))? $data->get_param('count'):10):
        (($data->get_param('count'))? $data->get_param('count'):-1)
	];
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            $output[$i]['id'] = get_the_ID();
            $output[$i]['title'] = get_the_title();
            $output[$i]['content'] = get_the_content();
            $output[$i]['excerpt'] = get_the_excerpt();
    
            $term_obj_list = get_the_terms( get_the_ID(), 'banner_category' );
            $output[$i]['categories'] = join(', ', wp_list_pluck($term_obj_list, 'name'));
                
            $output[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $output[$i]['featured_image']['medium'] = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $output[$i]['featured_image']['large'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $output[$i]['featured_image']['full'] = get_the_post_thumbnail_url(get_the_ID(), 'full'); 

            $output[$i]['meta']['banner_title'] = get_post_meta(get_the_ID(),'_mosacademy_banner_title', true);
            $output[$i]['meta']['banner_sub_title'] = get_post_meta(get_the_ID(),'_mosacademy_banner_sub_title', true);
            $output[$i]['meta']['banner_button_title'] = get_post_meta(get_the_ID(),'_mosacademy_banner_button_title', true);
            $output[$i]['meta']['banner_button_url'] = get_post_meta(get_the_ID(),'_mosacademy_banner_button_url', true);
            $output[$i]['meta']['banner_gallery'] = get_post_meta(get_the_ID(),'_mosacademy_banner_gallery', true);
    
            $i++;
        endwhile;
    endif;
    wp_reset_postdata();
	return $output;
}
function mos_getweb_api_banners_by_category($data) {
	$output = [];
	$i = 0;
    $catSlice = explode('-',$data->get_param('category'));
	$args = [
		'post_type' => 'banner',
        'offset' => ($data->get_param('offset'))?$data->get_param('offset'):0,
		'posts_per_page' => ($data->get_param('offset'))?
        (($data->get_param('count'))? $data->get_param('count'):10):
        (($data->get_param('count'))? $data->get_param('count'):-1),       
        
        /*'tax_query' => array(
            array(
            'taxonomy' => 'banner_category',
            'field' => 'term_id',
            'terms' => $data->get_param('category')
            )
        )*/
	];
    if ($catSlice && sizeof($catSlice)) {        
        $args['tax_query']['relation'] = 'OR';
        foreach($catSlice as $catID){
            $args['tax_query'][$catID] = array(
                'taxonomy' => 'banner_category',
                'field' => 'term_id',
                'terms' => $catID
            );
        }
    }
    
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();    
            $output[$i]['id'] = get_the_ID();
            $output[$i]['title'] = get_the_title();
            $output[$i]['content'] = get_the_content();
            $output[$i]['excerpt'] = get_the_excerpt();
    
            $term_obj_list = get_the_terms( get_the_ID(), 'banner_category' );
            $output[$i]['categories'] = join(', ', wp_list_pluck($term_obj_list, 'name'));
    
                
            $output[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $output[$i]['featured_image']['medium'] = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $output[$i]['featured_image']['large'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $output[$i]['featured_image']['full'] = get_the_post_thumbnail_url(get_the_ID(), 'full'); 

            $output[$i]['meta']['banner_title'] = get_post_meta(get_the_ID(),'_mosacademy_banner_title', true);
            $output[$i]['meta']['banner_sub_title'] = get_post_meta(get_the_ID(),'_mosacademy_banner_sub_title', true);
            $output[$i]['meta']['banner_button_title'] = get_post_meta(get_the_ID(),'_mosacademy_banner_button_title', true);
            $output[$i]['meta']['banner_button_url'] = get_post_meta(get_the_ID(),'_mosacademy_banner_button_url', true);
            $output[$i]['meta']['banner_gallery'] = get_post_meta(get_the_ID(),'_mosacademy_banner_gallery', true);
    
            $i++;
        endwhile;
    endif;
    wp_reset_postdata();
	return $output;
}
function mos_getweb_api_banner_categories (){
    return mos_get_terms ('banner_category');
}
function mos_getweb_api_banner( $id ) {
    $post   = get_post( $id['id'] );
    $output['id'] = $post->ID;
    $output['title'] = $post->post_title;
    $output['content'] = apply_filters('the_content',$post->post_content);
    $output['excerpt'] = get_the_excerpt();
    $output['slug'] = $post->post_name;
    $output['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
    $output['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
    $output['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
    $output['featured_image']['full'] = get_the_post_thumbnail_url($post->ID, 'full');

    $output['meta']['banner_title'] = get_post_meta($post->ID,'_mosacademy_banner_title', true);
    $output['meta']['banner_sub_title'] = get_post_meta($post->ID,'_mosacademy_banner_sub_title', true);
    $output['meta']['banner_button_title'] = get_post_meta($post->ID,'_mosacademy_banner_button_title', true);
    $output['meta']['banner_button_url'] = get_post_meta($post->ID,'_mosacademy_banner_button_url', true);
    $output['meta']['banner_gallery'] = get_post_meta($post->ID,'_mosacademy_banner_gallery', true);
    return $output;
}
/************************************************************************************************/
function mos_getweb_api_services($data) {
	$output = [];
	$i = 0;
	$args = [
		'post_type' => 'service',
        'offset' => ($data->get_param('offset'))?$data->get_param('offset'):0,
		'posts_per_page' => ($data->get_param('offset'))?
        (($data->get_param('count'))? $data->get_param('count'):10):
        (($data->get_param('count'))? $data->get_param('count'):-1)
	];
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            $output[$i]['id'] = get_the_ID();
            $output[$i]['title'] = get_the_title();
            $output[$i]['content'] = get_the_content();
            $output[$i]['excerpt'] = get_the_excerpt();
    
            $term_obj_list = get_the_terms( get_the_ID(), 'service_category' );
            $output[$i]['categories'] = join(', ', wp_list_pluck($term_obj_list, 'name'));
                
            $output[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $output[$i]['featured_image']['medium'] = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $output[$i]['featured_image']['large'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $output[$i]['featured_image']['full'] = get_the_post_thumbnail_url(get_the_ID(), 'full'); 

            $output[$i]['meta']['service_title'] = get_post_meta(get_the_ID(),'_mosacademy_service_title', true);
    
            $i++;
        endwhile;
    endif;
    wp_reset_postdata();
	return $output;
}
function mos_getweb_api_services_by_category($data) {
	$output = [];
	$i = 0;
    $catSlice = explode('-',$data->get_param('category'));
	$args = [
		'post_type' => 'service',
        'offset' => ($data->get_param('offset'))?$data->get_param('offset'):0,
		'posts_per_page' => ($data->get_param('offset'))?
        (($data->get_param('count'))? $data->get_param('count'):10):
        (($data->get_param('count'))? $data->get_param('count'):-1),       
        
        /*'tax_query' => array(
            array(
            'taxonomy' => 'service_category',
            'field' => 'term_id',
            'terms' => $data->get_param('category')
            )
        )*/
	];
    if ($catSlice && sizeof($catSlice)) {        
        $args['tax_query']['relation'] = 'OR';
        foreach($catSlice as $catID){
            $args['tax_query'][$catID] = array(
                'taxonomy' => 'service_category',
                'field' => 'term_id',
                'terms' => $catID
            );
        }
    }
    
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();    
            $output[$i]['id'] = get_the_ID();
            $output[$i]['title'] = get_the_title();
            $output[$i]['content'] = get_the_content();
            $output[$i]['excerpt'] = get_the_excerpt();
    
            $term_obj_list = get_the_terms( get_the_ID(), 'service_category' );
            $output[$i]['categories'] = join(', ', wp_list_pluck($term_obj_list, 'name'));
    
                
            $output[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $output[$i]['featured_image']['medium'] = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $output[$i]['featured_image']['large'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $output[$i]['featured_image']['full'] = get_the_post_thumbnail_url(get_the_ID(), 'full'); 

            $output[$i]['meta']['service_title'] = get_post_meta(get_the_ID(),'_mosacademy_service_title', true);
    
            $i++;
        endwhile;
    endif;
    wp_reset_postdata();
	return $output;
}
function mos_getweb_api_service_categories (){
    return mos_get_terms ('service_category');
}
function mos_getweb_api_service( $id ) {
    $post   = get_post( $id['id'] );
    $output['id'] = $post->ID;
    $output['title'] = $post->post_title;
    $output['content'] = apply_filters('the_content',$post->post_content);
    $output['excerpt'] = get_the_excerpt();
    $output['slug'] = $post->post_name;
    $output['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
    $output['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
    $output['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
    $output['featured_image']['full'] = get_the_post_thumbnail_url($post->ID, 'full');

    $output['meta']['service_title'] = get_post_meta($post->ID,'_mosacademy_service_title', true);
    return $output;
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

	register_rest_route( 'mos-getweb-api/v1', 'data-single/(?P<id>[a-zA-Z0-9_-]+)', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_data_single',
    ]);
    
	register_rest_route('mos-getweb-api/v1', 'data-taxonomies/(?P<taxonomy>[a-zA-z0-9_-]+)', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_data_categories',
	]);
    
    /****************************************************************/
    
	/*register_rest_route('mos-getweb-api/v1', '/banners(?:/(?P<offset>[0-9]+)(?:/(?P<count>[0-9]+))?)?', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_banners',
	]);
	register_rest_route('mos-getweb-api/v1', 'banners-by-cateory/(?P<category>[a-zA-Z0-9-]+)(?:/(?P<offset>[0-9]+)(?:/(?P<count>[0-9]+))?)?', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_banners_by_category',
	]);
	register_rest_route('mos-getweb-api/v1', 'banner-cateories/', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_banner_categories',
	]);

	register_rest_route( 'mos-getweb-api/v1', 'banner/(?P<id>[0-9]+)', array(
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_banner',
    ));*/
    
    /****************************************************************/
    
	/*register_rest_route('mos-getweb-api/v1', '/services(?:/(?P<offset>[0-9]+)(?:/(?P<count>[0-9]+))?)?', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_services',
	]);
	register_rest_route('mos-getweb-api/v1', 'services-by-cateory/(?P<category>[a-zA-Z0-9-]+)(?:/(?P<offset>[0-9]+)(?:/(?P<count>[0-9]+))?)?', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_services_by_category',
	]);
	register_rest_route('mos-getweb-api/v1', 'service-cateories/', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_service_categories',
	]);

	register_rest_route( 'mos-getweb-api/v1', 'service/(?P<id>[0-9]+)', array(
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_service',
    ) );*/
    
    /****************************************************************/
    
    
    
	register_rest_route('mos-getweb-api/v1', 'options', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_options',
	]);     
	register_rest_route('mos-getweb-api/v1', 'menus', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_menus',
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