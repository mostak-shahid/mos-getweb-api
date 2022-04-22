<?php
$output = [];
$type = (@$_GET['type'])?$_GET['type']:'post';
$author = (@$_GET['auth'])?$_GET['auth']:'';
$taxonomy = (@$_GET['taxonomy'])?$_GET['taxonomy']:'';
$terms = (@$_GET['terms'])?$_GET['terms']:'';
$order = (@$_GET['order'])?$_GET['order']:'DESC';
$orderby = (@$_GET['orderby'])?$_GET['orderby']:'ID';
$offset = (@$_GET['offset'])?$_GET['offset']:'';
$limit = (@$_GET['limit'])?$_GET['limit']:10;
$return = (@$_GET['return'])?$_GET['return']:'id,title,content';//id, date, modified, slug, link, title, content, excerpt, author, featured_media
$returnmeta = (@$_GET['returnmeta'])?$_GET['returnmeta']:'';

$args = array( 
    'post_type' => $type,
    'author' => $author,
    'order' => $order,
    'offset' => $offset,
    'limit' => $limit,    
);
if ($taxonomy && $terms){
    $args['tax_query']['relation'] = 'AND';
    $taxonomySlice = explode(',',$taxonomy);
    if (sizeof($taxonomySlice)) {
        $n = 0;
        foreach($taxonomySlice as $slice){
            $args['tax_query'][$n]['taxonomy'] = $taxonomy;
            $args['tax_query'][$n]['field'] = 'term_id';
            $args['tax_query'][$n]['terms'] = explode(',',$terms);
            $n++;
        }
    }
}
$query = new WP_Query( $args );
if ( $query->have_posts() ) {
    $n = 0;
    while ( $query->have_posts() ) {
        $query->the_post();
        global $post;
        $postDataSplit = explode(',',$return);
        foreach($postDataSplit as $key) {
            if ($key == 'id') $output['result'][$n]['ID'] = get_the_ID();
            elseif ($key == 'date') $output['result'][$n]['date'] = get_the_date("Y-m-d H:m:i");
            elseif ($key == 'modified') $output['result'][$n]['modified'] = get_the_modified_date("Y-m-d H:m:i");
            elseif ($key == 'slug') $output['result'][$n]['slug'] = $post->post_name;
            elseif ($key == 'link') $output['result'][$n]['link'] = get_the_permalink();
            
            elseif ($key == 'title') $output['result'][$n]['title'] = get_the_title();
            elseif ($key == 'content') $output['result'][$n]['content'] = get_the_content();
            elseif ($key == 'excerpt') $output['result'][$n]['excerpt'] = get_the_excerpt();
            elseif ($key == 'author') {
                $output['result'][$n]['author']['id'] = $post->post_author;
                $output['result'][$n]['author']['name'] = get_the_author();
            }
            elseif ($key == 'featured_media') {                
                $output['result'][$n]['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
                $output['result'][$n]['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
                $output['result'][$n]['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
                $output['result'][$n]['featured_image']['full'] = get_the_post_thumbnail_url($post->ID, 'full');
            }
        }
        $postMetaSpliut = explode(',', $returnmeta); 
        if ($returnmeta && sizeof($postMetaSpliut)) {
            foreach($postMetaSpliut as $metakey) {
                $output['result'][$n]['meta'][trim($metakey)] = get_post_meta($post->ID,trim($metakey), true);
            }
        }
        $output['message'] = 'Success';
        $n++;
    }
    wp_reset_postdata();
} else {
    $output['message'] = 'Sorry no posts found';
}
$output['total_post'] = $query->post_count;
header('Content-type: application/json');
echo json_encode($output);
//echo '<pre>';
//var_dump($query);
//echo '</pre>';