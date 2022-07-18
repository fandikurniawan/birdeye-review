<?php
/*
Plugin Name: BirdEye - Sitetrustee
Plugin URI: https://sitetrustee.com/birdeye-plugin
Description: Plugin to display reviews from BirdEye.
Version: 1.0
Author: Fandi Kurniawan
Author URI: https://sitetrustee.com/
License: GPLv2 or later
Text Domain: sitetrustee
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'SB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


require_once( SB_PLUGIN_DIR . 'includes/sb-functions.php' );
require_once( SB_PLUGIN_DIR . 'admin/sb-settings-page.php' );
require_once( SB_PLUGIN_DIR . 'includes/sb-shortcode.php' );