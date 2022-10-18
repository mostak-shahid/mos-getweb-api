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
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/cmb2/extensions/cmb2-conditionals/cmb2-conditionals.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/cmb2/extensions/custom-address/custom-address.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/cmb2/extensions/custom-button/custom-button.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'mos-getweb-api-metaboxes.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'mos-getweb-user-profile-picture.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'mos-getweb-api-admin-pages.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'mos-getweb-api-post-types.php' );

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
//var_dump(mos_get_terms('block_category'));
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
  ?>
    <style type="text/css">
    .attachment-266x266, .thumbnail img {
         width: 100% !important;
         height: auto !important;
    }
    </style>';
    <?php
}
add_action( 'admin_head', 'fix_svg' );

/* AJAX action callback */
add_action( 'wp_ajax_query_read', 'query_read_ajax_callback' );
add_action( 'wp_ajax_nopriv_query_read', 'query_read_ajax_callback' );
/* Ajax Callback */
function query_read_ajax_callback () {
    $id = $_GET['id'];
    global $wpdb; 
    $table_name = $wpdb->prefix.'contact_data';
    //
    $cview = $wpdb->get_var( "SELECT view FROM {$table_name} WHERE ID={$id}" );
    $nview = ($cview)?0:1;
    
    $wpdb->update( 
        $table_name, 
        array( 
            'view' => $nview,   // string
        ), 
        array( 'ID' => $id )
    );
    
    echo $nview;
    //$location = admin_url('/') . 'post.php?post=' . $post_id . '&action=edit';
    //wp_redirect( $location, $status = 302 );
    exit; // required. to end AJAX request.
}
/* AJAX action callback */
add_action( 'wp_ajax_query_delete', 'query_delete_ajax_callback' );
add_action( 'wp_ajax_nopriv_query_delete', 'query_delete_ajax_callback' );
/* Ajax Callback */
function query_delete_ajax_callback () {
    $id = $_GET['id'];
    global $wpdb; 
    $table_name = $wpdb->prefix.'contact_data';
    
    $wpdb->delete($table_name, array( 'ID' => $id ) );
    
    echo 1;
    //$location = admin_url('/') . 'post.php?post=' . $post_id . '&action=edit';
    //wp_redirect( $location, $status = 302 );
    exit; // required. to end AJAX request.
}



/* AJAX action callback */
add_action( 'wp_ajax_view_cv', 'view_cv_ajax_callback' );
add_action( 'wp_ajax_nopriv_view_cv', 'view_cv_ajax_callback' );
/* Ajax Callback */
function view_cv_ajax_callback () {
    $id = $_GET['id'];
    global $wpdb; 
    $table_name = $wpdb->prefix.'apply_data';
    //
    $cview = $wpdb->get_var( "SELECT view FROM {$table_name} WHERE ID={$id}" );
    $nview = ($cview)?0:1;
    
    $wpdb->update( 
        $table_name, 
        array( 
            'view' => $nview,   // string
        ), 
        array( 'ID' => $id )
    );
    
    echo $nview;
    //$location = admin_url('/') . 'post.php?post=' . $post_id . '&action=edit';
    //wp_redirect( $location, $status = 302 );
    exit; // required. to end AJAX request.
}
/* AJAX action callback */
add_action( 'wp_ajax_cv_delete', 'cv_delete_ajax_callback' );
add_action( 'wp_ajax_nopriv_cv_delete', 'cv_delete_ajax_callback' );
/* Ajax Callback */
function cv_delete_ajax_callback () {
    $id = $_GET['id'];
    global $wpdb; 
    $table_name = $wpdb->prefix.'apply_data';
    
    $wpdb->delete($table_name, array( 'ID' => $id ) );
    
    echo 1;
    //$location = admin_url('/') . 'post.php?post=' . $post_id . '&action=edit';
    //wp_redirect( $location, $status = 302 );
    exit; // required. to end AJAX request.
}
add_action( 'admin_enqueue_scripts', 'datatables_enqueue_scripts', 10 );
function datatables_enqueue_scripts() {
    wp_enqueue_style('jquery-datatables-css','//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css');
    wp_enqueue_script('jquery-datatables-js','//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js',array('jquery'));
}

add_action('wp_ajax_contact_list', 'contact_list_ajax_endpoint'); //logged in
add_action('wp_ajax_no_priv_contact_list', 'contact_list_ajax_endpoint'); //not logged in
function contact_list_ajax_endpoint(){
    global $wpdb; 
    $response = [];    
    $table_name = $wpdb->prefix.'contact_data';
    $results = $wpdb->get_results( "SELECT * FROM $table_name  ORDER BY ID DESC", OBJECT );
    //Add two properties to our response - 'data' and 'recordsTotal';
    $fake_data =[];
    $n = 0;
    foreach($results as $row) {
        $data = json_decode($row->data, true);
        $fake_data[$n]['ID'] = $n+1;
        
        $str = '';        
        (@$data['name'] && $data['name']!='undefined')?$str .= '<strong>Name: </strong>'.$data['name'].'<br/>':'';
        ($data['email'] && $data['email']!='undefined')?$str .= '<strong>Email: </strong><a href="mailto:' . $data['email'] . '">' . $data['email'] . '</a><br/>':'';
        ($data['phone'] && $data['phone']!='undefined')?$str .= '<strong>Phone: </strong>' . @$data['code'] . ' ' . $data['phone'] . '<br/>':'';
        ($data['interested'] && $data['budget']!='undefined')?$str .= '<strong>Interested In: </strong>' . $data['interested'] . '<br/>':'';
        ($data['budget'] && $data['budget']!='undefined')?$str .= '<strong>Budget: </strong>' . $data['budget'] . '<br/>':'';
        (@$data['company'] && $data['company']!='undefined') ? $str .= '<strong>Company: </strong>' . $data['company'] . '<br/>':'';
        ($data['attachment_url'] && $data['attachment_url']!='undefined')?$str .= '<strong>File: </strong><a href="' . $data['attachment_url'] . '" target="_blank">' . @$data['attachment_url'] . '</a><br/>':'';
        
        $fake_data[$n]['data'] = $str;
        
        // $fake_data[$n]['data'] = '<strong>Name: </strong>'.@$data['name'].'<br/><strong>Email: </strong><a href="mailto:' . $data['email'] . '">' . @$data['email'] . '</a><br/><strong>Phone: </strong>' . @$data['code'] . ' ' . @$data['phone'] . '<br/><strong>Interested In: </strong>' . @$data['interested'] . '<br/><strong>Budget: </strong>' . @$data['budget'] . '<br/><strong>Company: </strong>' . @$data['company'] . '<br/><strong>File: </strong><a href="' . $data['attachment_url'] . '" target="_blank">' . @$data['attachment_url'] . '</a><br/>';
        
        $fake_data[$n]['message'] = $data['message'];
        $fake_data[$n]['source'] = $row->source;
        $fake_data[$n]['time'] = $row->time;
        
        $fake_data[$n]['action'] = '<span>';
        if($data['message']){
        /*
        if ($row->view)
            $fake_data[$n]['action'] .= '<a class="contact_view" data-id="'.$row->ID.'" data-message="'.$data['message'].'" href="#">Mark as Unread</a> | ';
        else 
            $fake_data[$n]['action'] .= '<a class="contact_view" data-id="'.$row->ID.'" data-message="'.$data['message'].'" href="#">View</a> | ';
        */
            $fake_data[$n]['action'] .= '<a class="contact_view" data-id="'.$row->ID.'" data-message="'.$data['message'].'" href="#">View</a> | ';
        }
        $fake_data[$n]['action'] .='<span class="trash"><a class="contact_delete" href="#" data-id="'.$row->ID.'" data-action="delete">Delete</a></span>';
        $fake_data[$n]['action'] .= '</span>';
        $n++;
    }
    $response['data'] = !empty($fake_data) ? $fake_data : []; //array of post objects if we have any, otherwise an empty array        
    $response['recordsTotal'] = !empty($fake_data) ? count($fake_data) : 0; //total number of posts without 
    wp_send_json($response); //json_encodes our $response and sends it back with the appropriate headers
}

add_action('wp_ajax_application_list', 'application_list_ajax_endpoint'); //logged in
add_action('wp_ajax_no_priv_application_list', 'application_list_ajax_endpoint'); //not logged in
function application_list_ajax_endpoint(){
    global $wpdb; 
    $response = [];    
    $table_name = $wpdb->prefix.'apply_data';
    $results = $wpdb->get_results( "SELECT * FROM $table_name  ORDER BY ID DESC", OBJECT );
    //Add two properties to our response - 'data' and 'recordsTotal';
    $fake_data =[];
    $n = 0;
    foreach($results as $row) {
        $data = json_decode($row->data, true);
        $fake_data[$n]['ID'] = $n+1;
        $fake_data[$n]['job_title'] = '<a href="'.admin_url('post.php?post='.$row->job_id.'&action=edit&classic-editor').'" target="_blank">'.get_the_title($row->job_id).'</a>';
        $fake_data[$n]['job_deadline'] = get_post_meta($row->job_id, '_mosacademy_job_application_deadline', true);
        
        $str = '';
        (@$data['first_name'])?$str .= '<strong>Name: </strong>'.$data['first_name'].' '.$data['last_name'].'<br/>':'';
        (@$data['email'])?$str .= '<strong>Email: </strong><a href="mailto:' . $data['email'] . '">' . $data['email'] . '</a><br/>':'';
        (@$data['phone'])?$str .= '<strong>Phone: </strong>' . $data['code'] . ' ' . $data['phone'] . '<br/><strong>':'';
        (@$data['country'])?$str .= '<strong>Country: </strong>' . $data['country'] . '<br/>':'';
        $fake_data[$n]['data'] = $str;
        
        //$fake_data[$n]['data'] = '<strong>Name: </strong>'.$data['first_name'].' '.$data['last_name'].'<br/><strong>Email: </strong><a href="mailto:' . $data['email'] . '">' . $data['email'] . '</a><br/><strong>Phone: </strong>' . $data['code'] . ' ' . $data['phone'] . '<br/><strong>Country: </strong>' . $data['country'] . '<br/>';
        
        $fake_data[$n]['attachment'] = '<a href="'.$data['attachment_url'].'"  target="_blank">PDF</a>';
        $fake_data[$n]['time'] = $row->time;
        /*if ($row->view)
            $fake_data[$n]['action'] = '<a class="view_cv" data-url="'.$data['attachment_url'].'" data-id="'.$row->ID.'" href="#">Mark as unread</a> | ';
        else 
            $fake_data[$n]['action'] = '<a class="view_cv" data-url="'.$data['attachment_url'].'" data-id="'.$row->ID.'" href="#">View CV</a> | ';*/
        
        $fake_data[$n]['action'] = '<a href="'.$data['attachment_url'].'" target="_blank" data-url="'.$data['attachment_url'].'" data-id="'.$row->ID.'" href="#">View CV</a> | ';
        $fake_data[$n]['action'] .='<span class="trash"><a class="delete_cv" href="#" data-id="'.$row->ID.'" data-action="delete">Delete</a></span>';
        $n++;
    }
    $response['data'] = !empty($fake_data) ? $fake_data : []; //array of post objects if we have any, otherwise an empty array        
    $response['recordsTotal'] = !empty($fake_data) ? count($fake_data) : 0; //total number of posts without 
    wp_send_json($response); //json_encodes our $response and sends it back with the appropriate headers
}
function datatables_script() {
  ?>
<style>

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal .modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.modal .close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.modal .close:hover,
.modal .close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-text">Loading...</div>
            
        </div>

    </div>
    <script>
// Get the modal
var modal = document.getElementById("myModal");
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
    jQuery(document).ready(function($){
        $('#application-list tfoot th.search-col').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });
        var cl = $('#contact-list').DataTable({    
            ajax: {
                url: "admin-ajax.php?action=contact_list",
                cache:false,
            },
            columns: [
                { data: 'ID' },        
                { data: 'data' },        
                { data: 'source' },        
                { data: 'time' },        
                { data: 'action' },        
            ],
            pageLength: 25,                  
            "columnDefs": [
                {
                    "targets": 'no-sort',
                    "orderable": false,
                },
                { 
                    "width": "20px", 
                    "targets": 0 
                },
                { 
                    "searchable": false, 
                    "targets": 3
                }
            ]
        }); //.DataTable()
        var al = $('#application-list').DataTable({    
            ajax: {
                url: "admin-ajax.php?action=application_list",
                cache:false,
            },
            columns: [
                { data: 'ID' },        
                { data: 'job_title' },        
                { data: 'data' },             
//                { data: 'attachment' },             
                { data: 'time' },        
                { data: 'job_deadline' },        
                { data: 'action' },        
            ],
            pageLength: 25,           
            "columnDefs": [
                {
                    "targets": 'no-sort',
                    "orderable": false,
                },
                { 
                    "width": "20px", 
                    "targets": 0 
                }
            ],
            initComplete: function () {
                // Apply the search
                this.api()
                    .columns()
                    .every(function () {
                        var that = this;

                        $('input', this.footer()).on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        });
                    });
            },
        }); //.DataTable()
        $('body').on('click', '.close', function (e){
            $('#myModal').hide();
        })
        $('body').on('click', '.contact_view', function (e){
            e.preventDefault();  
            let ths = $(this);
            let message = $(this).data('message');
            let id = $(this).data('id');            
            $('#myModal').find('.modal-text').html(message);
            $('#myModal').show();
            
            /*$.ajax({
                url: 'admin-ajax.php', // or example_ajax_obj.ajaxurl if using on frontend
                type:"GET",
                dataType:"json",
                data: {
                    'action': 'query_read',
                    'id' : id,
                },
                success: function(result){
                    if(result) {
                        //ths.html('Mark as Unread');
                        $('#myModal').show();
                    }
                    //else ths.html('View');
                    
                    console.log(result);
                    // $('.track-output').html(result);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });*/
        })
        $('body').on('click', '.contact_delete', function (e){
            e.preventDefault();  
            let ths = $(this);
            let id = $(this).data('id');            
            $.ajax({
                url: 'admin-ajax.php', // or example_ajax_obj.ajaxurl if using on frontend
                type:"GET",
                dataType:"json",
                data: {
                    'action': 'query_delete',
                    'id' : id,
                },
                success: function(result){ 
                    console.log(result);
                    //ths.closest('tr').remove();
                    
                    cl.row( ths.parents('tr') ).remove().draw();
                    //console.log(result);
                    // $('.track-output').html(result);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });
        })
        $('body').on('click', '.view_cv', function (e){
            e.preventDefault();  
            let ths = $(this);            
            let url = $(this).data('url');            
            let id = $(this).data('id');            
            $('#myModal').find('.modal-text').html('<iframe src="'+url+'" style="border:none; width: 100%; min-height: calc(100vh - 200px)" title="Iframe Example"></iframe>');
            $('#myModal').show();
            /*$.ajax({
                url: 'admin-ajax.php', // or example_ajax_obj.ajaxurl if using on frontend
                type:"GET",
                dataType:"json",
                data: {
                    'action': 'view_cv',
                    'id' : id,
                },
                success: function(result){ 
                    if(result) {
                        ths.html('Mark as Unread');
                        $('#myModal').show();
                    }
                    else ths.html('View CV');
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });*/
        })
        $('body').on('click', '.delete_cv', function (e){
            e.preventDefault();  
            let ths = $(this);            
            let id = $(this).data('id');  
            $.ajax({
                url: 'admin-ajax.php', // or example_ajax_obj.ajaxurl if using on frontend
                type:"GET",
                dataType:"json",
                data: {
                    'action': 'cv_delete',
                    'id' : id,
                },
                success: function(result){ 
                    console.log(result);
                    //ths.closest('tr').remove();
                    
                    al.row( ths.parents('tr') ).remove().draw();
                    //console.log(result);
                    // $('.track-output').html(result);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });
        })
    });
    </script>';
    <?php
}
add_action( 'admin_footer', 'datatables_script' );

add_action('admin_head', 'mos_custom_css');

function mos_custom_css() {
    ?>
    <style>
        .select2-container .select2-selection--single {
            min-width: 200px;
        } 
    </style>
  <?php
}