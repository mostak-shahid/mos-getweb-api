<?php
function mos_getweb_api_banners($data) {
	$outout = [];
	$i = 0;
	$args = [
		//'posts_per_page' => $count,
		'post_type' => 'banner',
        //'óffset' => $offset
	];
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            $outout[$i]['id'] = get_the_ID();
            $outout[$i]['title'] = get_the_title();
            $outout[$i]['content'] = get_the_content();
            $outout[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $outout[$i]['featured_image']['medium'] = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $outout[$i]['featured_image']['large'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $i++;
        endwhile;
    endif;
    wp_reset_postdata();

	return $data;
}
function mos_getweb_api_banners_by_category($category) {
	$data = [];
	$i = 0;
	$args = [
		'posts_per_page' => -1,
		'post_type' => 'banner'
	];
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            $data[$i]['id'] = get_the_ID();
            $data[$i]['title'] = get_the_title();
            $data[$i]['content'] = get_the_content();
            $data[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
            $data[$i]['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
            $data[$i]['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
            $i++;
        endwhile;
    endif;
    wp_reset_postdata();

	return $data;
}
function mos_getweb_api_posts() {
	$args = [
		'numberposts' => 99999,
		'post_type' => 'post'
	];

	$posts = get_posts($args);

	$data = [];
	$i = 0;

	foreach($posts as $post) {
		$data[$i]['id'] = $post->ID;
		$data[$i]['title'] = $post->post_title;
		$data[$i]['content'] = $post->post_content;
		$data[$i]['slug'] = $post->post_name;
		$data[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
		$data[$i]['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
		$data[$i]['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
		$i++;
	}

	return $data;
}
function mos_getweb_api_post( $slug ) {
	$args = [
		'name' => $slug['slug'],
		'post_type' => 'post'
	];

	$post = get_posts($args);


	$data['id'] = $post[0]->ID;
	$data['title'] = $post[0]->post_title;
	$data['content'] = $post[0]->post_content;
	$data['slug'] = $post[0]->post_name;
	$data['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post[0]->ID, 'thumbnail');
	$data['featured_image']['medium'] = get_the_post_thumbnail_url($post[0]->ID, 'medium');
	$data['featured_image']['large'] = get_the_post_thumbnail_url($post[0]->ID, 'large');

	return $data;
}
// Used in this video https://www.youtube.com/watch?v=76sJL9fd12Y
function mos_getweb_api_products() {
	$args = [
		'numberposts' => -1,
		'post_type' => 'products'
	];

	$posts = get_posts($args);

	$data = [];
	$i = 0;

	foreach($posts as $post) {
		$data[$i]['id'] = $post->ID;
		$data[$i]['title'] = $post->post_title;
        $data[$i]['slug'] = $post->post_name;
        $data[$i]['price'] = get_field('price', $post->ID);
        $data[$i]['delivery'] = get_field('delivery', $post->ID);
		$i++;
	}

	return $data;
}

add_action('rest_api_init', function() {
    //https://developer.wordpress.org/reference/functions/register_rest_route/
	register_rest_route('mos-getweb-api/v1', '/banners/offset=(?P<offset>[0-9]+)/count=(?P<count>[0-9]+)', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_banners',
	]);
	register_rest_route('mos-getweb-api/v1', 'banners/(?P<category>[a-zA-Z0-9-]+)', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_banners_by_category',
	]);
    
	register_rest_route('mos-getweb-api/v1', 'posts', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_posts',
	]);

	register_rest_route( 'mos-getweb-api/v1', 'posts/(?P<slug>[a-zA-Z0-9-]+)', array(
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_post',
    ) );
    
    // Used in this video: https://www.youtube.com/watch?v=76sJL9fd12Y	
    register_rest_route('mos-getweb-api/v1', 'products', [
		'methods' => 'GET',
		'callback' => 'mos_getweb_api_products',
	]);
});