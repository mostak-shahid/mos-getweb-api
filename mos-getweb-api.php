<?php
/**
 * Plugin Name:       Mos Getweb API
 * Plugin URI:        http://www.mdmostakshahid.com/mos-getweb-api/
 * Description:       This plugin will all the necessary API for Getweb React Applications.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
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
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'inc/cmb2/init.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'mos-getweb-api-metaboxes.php' );
require_once ( plugin_dir_path( MOS_GETWEB_API_FILE ) . 'mos-getweb-api-outputs.php' );
//require_once('inc/metabox/custom-cmb2-fields.php'); 
//require_once('inc/metabox/extensions/cmb-field-sorter/cmb-field-sorter.php');
//require_once('inc/metabox/extensions/cmb2-conditionals/cmb2-conditionals.php');
