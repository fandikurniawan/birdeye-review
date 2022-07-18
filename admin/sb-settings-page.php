<?php

add_action('admin_menu', 'sb_birdeye_admin_menu');
add_action('admin_init', 'register_sb_key_info' );
add_action( 'admin_enqueue_scripts', 'sb_enqueue_color_picker' );

function sb_birdeye_admin_menu() {
    add_menu_page( 'Birdeye', 'Birdeye Reviews', 'manage_options', 'sb-birdeye', 'sb_birdeye_admin_settings' );
    add_submenu_page( 'sb-birdeye', 'Settings - Birdeye', 'Settings', 'manage_options', 'sb-birdeye', 'sb_birdeye_admin_settings' );
    //add_submenu_page( 'sb-birdeye', 'Reviews - Birdeye', 'Reviews', 'manage_options', 'sb-birdeye-reviews', 'sb_birdeye_admin_reviews' );    
}

function sb_birdeye_admin_settings() {
   require_once( plugin_dir_path( __FILE__ ).'sb-birdeye-admin-settings.php' );
}

function sb_birdeye_admin_reviews() {
    require_once( plugin_dir_path( __FILE__ ).'sb-birdeye-admin-reviews.php' );
}


function register_sb_key_info() {  
    if( false === get_option( 'sb_api_key' ) ) {
        add_option( 'sb_api_key' , '' , '' , 'yes');
        add_option( 'sb_business_id' , '' , '' , 'yes');
        add_option( 'sb_display_settings' , '' , '' , 'yes');
        add_option( 'sb_style_settings' , '' , '' , 'yes');
    }

    register_setting( 'sb_key_settings', 'sb_api_key' );
    register_setting( 'sb_key_settings', 'sb_business_id' ); 
    register_setting( 'sb_display_settings', 'sb_display_settings', 'sb_array_validate'); 
    register_setting( 'sb_style_settings', 'sb_style_settings'); 
} 


function sb_array_validate($input) {
    return array_map('wp_filter_nohtml_kses', (array)$input);
}

function sb_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'sb-colorpicker-script', plugins_url('js/sb-colorpicker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}