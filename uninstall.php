<?php

//Fired when the plugin is uninstalled.
// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$settingOptions = array( 'sb_api_key', 'sb_business_id', 'sb_display_settings', 'sb_style_settings' ); 
 
// Clear up our settings
foreach ( $settingOptions as $settingName ) {
    delete_option( $settingName );
}