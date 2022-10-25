# Mos Getweb API
## Base plugin for getweb website

### Functions are used
- Create Table on Plugin Activation
- Add editor button
- Rest API  
---
**Create Table on Plugin Activation**
```
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
register_activation_hook( __FILE__, 'create_necessary_contact_table' );
```