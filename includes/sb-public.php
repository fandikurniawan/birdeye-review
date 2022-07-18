<?php

function set_enqueue() {
	
    wp_register_style( 'sb-custom-style', plugin_dir_url( __DIR__ ) . 'css/sb-public.css', array(), '1.0.0', 'all' );
    wp_register_script( 'sb-custom-script', plugin_dir_url( __DIR__ ) . 'js/sb-public.js', array(), '1.0.0', true );

}

add_action( 'wp_enqueue_scripts', 'set_enqueue' );

