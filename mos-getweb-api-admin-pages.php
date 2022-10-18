<?php
function admin_contact_list_page(){
	//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null )
    add_menu_page( 
        __( 'Contact Form Queries', 'textdomain' ),
        'Contact Queries',
        'manage_options',
        'contact-list',
        'contact_list_page',
        'dashicons-book-alt',
        3
    ); 
    add_menu_page( 
        __( 'Application Form Queries', 'textdomain' ),
        'Application Queries',
        'manage_options',
        'application-list',
        'application_list_page',
        'dashicons-book-alt',
        4
    ); 
}
add_action( 'admin_menu', 'admin_contact_list_page' );
function contact_list_page(){
    global $wpdb;    
    $table_name = $wpdb->prefix.'contact_data';
    $results = $wpdb->get_results( "SELECT * FROM $table_name", OBJECT );
	?>
	<div class="wrap">
		<h1>Contact Form Queries</h1>
		
		<table id="contact-list" class="wp-list-table widefat fixed striped table-view-list posts">
		    <thead>
		        <th width="50px">ID</th>
		        <th>Data</th>
		        <th>Source</th>
<!--		        <th class="no-sort">Message</th>-->
		        <th>Date</th>
		        <th class="no-sort">Action</th>
		    </thead>
		    <tbody></tbody>
		</table>
	</div>
	<?php
}
function application_list_page(){
    global $wpdb;    
    $table_name = $wpdb->prefix.'contact_data';
    $results = $wpdb->get_results( "SELECT * FROM $table_name", OBJECT );
	?>
	<div class="wrap">
		<h1>Contact Form Queries</h1>
		
		<table id="application-list" class="wp-list-table widefat fixed striped table-view-list posts">
		    <thead>
                <tr>
                    <th width="50px">ID</th>
                    <th>Job Title</th>
                    <th>Data</th>
    <!--		        <th class="no-sort">Attachment</th>-->
                    <th>Application Date</th>
                    <th>Dead Line</th>
                    <th class="no-sort">Action</th>
		        </tr>
		    </thead>
		    <tbody></tbody>
		    <tfoot>
                <tr>
                    <th width="50px">ID</th>
                    <th class="search-col">Job Title</th>
                    <th class="search-col">Data</th>
    <!--		        <th class="no-sort">Attachment</th>-->
                    <th class="search-col">Application Date</th>
                    <th class="search-col">Dead Line</th>
                    <th class="no-sort">Action</th>
		        </tr>
		    </tfoot>
		</table>
	</div>
	<?php
}