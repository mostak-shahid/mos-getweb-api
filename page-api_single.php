<?php
$output = [];
$id=(@$_GET['id'])?$_GET['id']:1;
$return = (@$_GET['return'])?$_GET['return']:'id,title,content';//id, date, modified, slug, link, title, content, excerpt, author, featured_media
$returnmeta = (@$_GET['returnmeta'])?$_GET['returnmeta']:'';

$post   = get_post( $id );
if ( $post ) {
    $postDataSplit = explode(',',$return);
    foreach($postDataSplit as $key) {
        if ($key == 'id') $output['result']['ID'] = $post->ID;
        elseif ($key == 'date') $output['result']['date'] = $post->post_date;
        elseif ($key == 'modified') $output['result']['modified'] = $post->post_modified;
        elseif ($key == 'slug') $output['result']['slug'] = $post->post_name;
        elseif ($key == 'link') $output['result']['link'] = get_the_permalink($post->ID);

        elseif ($key == 'title') $output['result']['title'] = $post->post_title;
        elseif ($key == 'content') $output['result']['content'] = $post->post_content;
        elseif ($key == 'excerpt') $output['result']['excerpt'] = $post->post_excerpt;
        elseif ($key == 'author') {
            $output['result']['author']['id'] = $post->post_author;
            $output['result']['author']['name'] = get_author_name($post->post_author);
        }
        elseif ($key == 'featured_media') {                
            $output['result']['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
            $output['result']['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
            $output['result']['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
            $output['result']['featured_image']['full'] = get_the_post_thumbnail_url($post->ID, 'full');
        }
    }
    $postMetaSpliut = explode(',', $returnmeta); 
    if ($returnmeta && sizeof($postMetaSpliut)) {
        foreach($postMetaSpliut as $metakey) {
            $output['result']['meta'][trim($metakey)] = get_post_meta($post->ID,trim($metakey), true);
        }
    }
    $output['message'] = 'Success';    
} else {
    $output['message'] = 'Sorry no posts found';
}
header('Content-type: application/json');
echo json_encode($output);
//echo '<pre>';
//var_dump($post);
//echo '</pre>';