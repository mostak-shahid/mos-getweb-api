<?php
/**
 * Plugin Name:       Mos Getweb API
 * Plugin URI:        http://www.mdmostakshahid.com/mos-getweb-api/
 * Description:       This plugin will all the necessary API for Getweb React Applications.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Md. Mostak Shahid
 * Author URI:        http://www.mdmostakshahid.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       mos-getweb-api
 * Domain Path:       /languages
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define MOS_PLUGIN_FILE.
if ( ! defined( 'MOS_GETWEB_API_FILE' ) ) {
	define( 'MOS_GETWEB_API_FILE', __FILE__ );
}
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/aq_resizer.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/cmb2/init.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/cmb2/extensions/custom-address/custom-address.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/cmb2/extensions/custom-button/custom-button.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'mos-getweb-api-metaboxes.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'mos-getweb-user-profile-picture.php' );

require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/theme-options/ReduxCore/framework.php'); 
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/theme-options/loader.php');
//require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/theme-options/sample/sample-config.php');
// require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/theme-options/sample/theme-options.php');
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'mos-getweb-api-options.php');
Redux::init( 'mosacademy_options' );

require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'mos-getweb-api-outputs.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'mos-getweb-api-hooks.php' );
//require_once('inc/metabox/custom-cmb2-fields.php'); 
//require_once('inc/metabox/extensions/cmb-field-sorter/cmb-field-sorter.php');
//require_once('inc/metabox/extensions/cmb2-conditionals/cmb2-conditionals.php');
function mos_getweb_api_add_page($page_slug, $page_title, $page_content, $page_template) {
    $page = get_page_by_path( $page_slug , OBJECT );
    //var_dump($page);
    if(!$page){
        $page_details = array(
            'post_title' => $page_title,
            'post_name' => $page_slug,
            'post_date' => gmdate("Y-m-d h:i:s"),
            'post_content' => $page_content,
            'post_status' => 'publish',
            'post_type' => 'page',
        );
        $page_id = wp_insert_post( $page_details );
        add_post_meta( $page_id, '_wp_page_template', $page_template );
    }
}
//mos_getweb_api_add_page('mos-getweb-api', 'API Page', '', '');
//mos_getweb_api_add_page('mos-getweb-api-single', 'API Single Page', '', '');

add_filter( 'page_template', 'mos_getweb_api_page_template' );
function mos_getweb_api_page_template( $page_template ) {
	if ( is_page( 'mos-getweb-api' ) ) {
		$page_template = dirname( __FILE__ ) . '/page-api.php';
	}
	else if ( is_page( 'mos-getweb-api-single' ) ) {
		$page_template = dirname( __FILE__ ) . '/page-api_single.php';
	}
	return $page_template;
}

function get_post_id_by_slug($slug) {
	$post = get_page_by_path($slug);
	if ($post) {
		return $post->ID;
	} else {
		return null;
	}
}



function mos_get_terms ($taxonomy = 'category') {
    global $wpdb;
    $output = array();
    $all_taxonomies = $wpdb->get_results( "SELECT {$wpdb->prefix}term_taxonomy.term_id, {$wpdb->prefix}term_taxonomy.taxonomy, {$wpdb->prefix}terms.name, {$wpdb->prefix}terms.slug, {$wpdb->prefix}term_taxonomy.description, {$wpdb->prefix}term_taxonomy.parent, {$wpdb->prefix}term_taxonomy.count, {$wpdb->prefix}terms.term_group FROM {$wpdb->prefix}term_taxonomy INNER JOIN {$wpdb->prefix}terms ON {$wpdb->prefix}term_taxonomy.term_id={$wpdb->prefix}terms.term_id", ARRAY_A);

    foreach ($all_taxonomies as $key => $value) {
        if ($value["taxonomy"] == $taxonomy) {
            $output[] = $value;
        }
    }
    return $output;
}

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

  global $wp_version;
  if ( $wp_version !== '4.7.1' ) {
     return $data;
  }

  $filetype = wp_check_filetype( $filename, $mimes );

  return [
      'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  ];

}, 10, 4 );

function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
  echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );


if (!function_exists('create_necessary_contact_table')){
    function create_necessary_contact_table() {
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $charset_collate = $wpdb->get_charset_collate();        
        $table_name = $wpdb->prefix.'contact_data';
        $sql = "CREATE TABLE $table_name (
            ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, 
            source varchar(255) DEFAULT '' NOT NULL,
            view tinyint(1) NOT NULL,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            data text NOT NULL,                      
            PRIMARY KEY  (ID)
        ) $charset_collate;";
        dbDelta( $sql );        
    }
}
//add_action('init', 'create_necessary_mos_order_table');
register_activation_hook( __FILE__, 'create_necessary_contact_table' );

if (!function_exists('create_necessary_apply_table')){
    function create_necessary_apply_table() {
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $charset_collate = $wpdb->get_charset_collate();        
        $table_name = $wpdb->prefix.'apply_data';
        $sql = "CREATE TABLE $table_name (
            ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, 
            job_id bigint(20) NOT NULL,
            email varchar(255) DEFAULT '' NOT NULL,
            view int(1) NOT NULL,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,   
            data text NOT NULL,                 
            PRIMARY KEY  (ID)
        ) $charset_collate;";
        dbDelta( $sql );        
    }
}
//add_action('init', 'create_necessary_mos_order_table');
register_activation_hook( __FILE__, 'create_necessary_apply_table' );

