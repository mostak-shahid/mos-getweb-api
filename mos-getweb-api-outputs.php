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
function mos_getweb_api_menu($data) {
    //$current_menu='12';
    //$current_menu='Primary Menu';
    $menu_array = wp_get_nav_menu_items($data->get_param('id'));

    $menu = array();

    function populate_children($menu_array, $menu_item)
    {
        $children = array();
        if (!empty($menu_array)){
            foreach ($menu_array as $k=>$m) {
                if ($m->menu_item_parent == $menu_item->ID) {
                    $children[$m->ID] = array();
                    $children[$m->ID]['ID'] = $m->ID;
                    $children[$m->ID]['title'] = $m->title;
                    $children[$m->ID]['url'] = $m->url;
                    unset($menu_array[$k]);
                    $children[$m->ID]['children'] = populate_children($menu_array, $m);
                }
            }
        };
        return $children;
    }

    foreach ($menu_array as $m) {
        if (empty($m->menu_item_parent)) {
            $menu[$m->ID] = array();
            $menu[$m->ID]['ID'] = $m->ID;
            $menu[$m->ID]['title'] = $m->title;
            $menu[$m->ID]['url'] = $m->url;
            $menu[$m->ID]['children'] = populate_children($menu_array, $m);
        }
    }

    return $menu;

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
    
    
    
	register_rest_route('mos-getweb-api/v1', 'options', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_options',
	]);     
	register_rest_route('mos-getweb-api/v1', 'menus', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_menus',
	]); 
	register_rest_route('mos-getweb-api/v1', 'menu/(?P<id>[0-9]+)', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_menu',
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