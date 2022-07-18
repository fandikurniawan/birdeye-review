<?php

function get_reviews($type, $atts = array()) {

    $index = (isset( $atts['index'] ) ) ? $atts['index'] : 0;
    $count = (isset( $atts['count'] ) ) ? $atts['count'] : 10;

    $api_key = get_option( 'birdeye-api-key' );
    $business_id = get_option( 'birdeye-business-id' );

    if ($type == 'listing') {
        $url = "https://api.birdeye.com/resources/v1/review/businessId/$business_id?sindex=$index&count=$count&api_key=$api_key";
    } elseif ($type == 'summary') {
        $url = "https://api.birdeye.com/resources/v1/review/businessid/$business_id/summary?api_key=$api_key";
    } else {
        return false;
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    if ($type == 'listing') {
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');

    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Accept: application/json"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

$atts = array();
$reviews = get_reviews('listing',$atts);
$reviews = json_decode($reviews, true);

/*
echo "<pre>";
print_r($reviews);
echo "<p>--------</p>";
//print_r($summary);
echo "</pre>"; */

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( STB_PLUGIN_DIR . 'includes/class-wp-list-table.php' );
}

class Review_List extends WP_List_Table {

    /** Class constructor */
    public function __construct() {
    
    parent::__construct( [
    'singular' => __( 'Review', 'stb' ), //singular name of the listed records
    'plural' => __( 'Reviews', 'stb' ), //plural name of the listed records
    'ajax' => false //should this table support ajax?
    
    ] );
    
}
/*
public static function get_reviews( $per_page = 5, $page_number = 1 ) {

    global $wpdb;
    
    $sql = "SELECT * FROM {$wpdb->prefix}customers";
    
    if ( ! empty( $_REQUEST['orderby'] ) ) {
    $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
    $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
    }
    
    $sql .= " LIMIT $per_page";
    
    $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
    
    $result = $wpdb->get_results( $sql, 'ARRAY_A' );
    
    return $result;
    }

*/