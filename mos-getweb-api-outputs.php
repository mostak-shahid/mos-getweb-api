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
    /*global $wpdb;
    $output = [];
    $term_taxonomies = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy = 'nav_menu'", ARRAY_A );
    foreach($term_taxonomies as $row){
        $terms = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}terms WHERE term_id={$row['term_id']}", ARRAY_A ); 
        foreach($terms as $term) {            
            //$output[$term['term_id']]['name'] = $term['name'];    
            $output[$term['term_id']] = wp_get_nav_menu_items($term['name']);
        }
    }
    return $output;*/
    $menu = wp_nav_menu( array(
        'menu'              => "Primary Menu", // (int|string|WP_Term) Desired menu. Accepts a menu ID, slug, name, or object.
        'menu_class'        => "", // (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
        'menu_id'           => "", // (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.
        'container'         => "", // (string) Whether to wrap the ul, and what to wrap it with. Default 'div'.
        'container_class'   => "", // (string) Class that is applied to the container. Default 'menu-{menu slug}-container'.
        'container_id'      => "", // (string) The ID that is applied to the container.
        'fallback_cb'       => "", // (callable|bool) If the menu doesn't exists, a callback function will fire. Default is 'wp_page_menu'. Set to false for no fallback.
        'before'            => "", // (string) Text before the link markup.
        'after'             => "", // (string) Text after the link markup.
        'link_before'       => "", // (string) Text before the link text.
        'link_after'        => "", // (string) Text after the link text.
        'echo'              => 1, // (bool) Whether to echo the menu or return it. Default true.
        'depth'             => "", // (int) How many levels of the hierarchy are to be included. 0 means all. Default 0.
        'walker'            => "", // (object) Instance of a custom walker class.
        'theme_location'    => "", // (string) Theme location to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
        'items_wrap'        => "", // (string) How the list items should be wrapped. Default is a ul with an id and class. Uses printf() format with numbered placeholders.
        'item_spacing'      => "", // (string) Whether to preserve whitespace within the menu's HTML. Accepts 'preserve' or 'discard'. Default 'preserve'.
    ));
    return wp_nav_menu([
        'menu'              => 'Primary Menu',
        'echo'              => false,
        'walker' => new Mos_Walker_Nav_Menu()
    ]);
}
/**
 * Custom walker class.
 */
class Mos_Walker_Nav_Menu extends Walker_Nav_Menu {
 
    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );
 
        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . ' mos-menues">' . "\n";
    }
 
    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
 
        // Depth-dependent classes.
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
 
        // Passed classes.
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
 
        // Build HTML.
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
 
        // Link attributes.
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
 
        // Build HTML output and pass through the proper filter.
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
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