<?php

function call_api($api_key, $api_bid){
       
    if (empty( $api_key )) return false;

    $ch = curl_init();

    //load https://api.birdeye.com/resources/v1/reports/smb?api_key=$api_key&bid=$api_bid
    //get reviews https://api.birdeye.com/resources/v1/review/businessId/755009344_1?sindex=0&count=25&api_key=92bcd6e0-c102-43fd-8a67-1a7be5258451

    //curl_setopt($ch, CURLOPT_URL, "https://api.birdeye.com/resources/v1/review/businessId/165150087556338?sindex=10&count=5&api_key=nMUg7aVoM2g4iZzk8soPm6Q48U6w6uBJ");
    curl_setopt($ch, CURLOPT_URL, "https://api.birdeye.com/resources/v1/reports/smb?api_key=$api_key&bid=$api_bid");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Accept: application/json"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response);    
}

//$sb_load = call_api($api_key, $api_bid);

//Date differrence
function sb_date_diff($refdate){

$curdate = date('Y-m-d H:i:s');
$now = new DateTime($curdate);
$ref = new DateTime($refdate);
$diff = $now->diff($ref);

return $diff;

}


function get_reviews($type, $atts = array()) {

    

    $index = (isset( $atts['index'] ) ) ? $atts['index'] : 0;
    $count = (isset( $atts['count'] ) ) ? $atts['count'] : 25;

    $api_key = get_option( 'sb_api_key' );
    $business_id = get_option( 'sb_business_id' );

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

function get_business() {

    $api_key = get_option( 'sb_api_key' );
    $business_id = get_option( 'sb_business_id' );

    $url = "https://api.birdeye.com/resources/v1/business/$business_id?api_key=$api_key";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Accept: application/json"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;   
}

function get_review_summary(){

    $api_key = get_option( 'sb_api_key' );
    $business_id = get_option( 'sb_business_id' );

    $ch = curl_init();
    $url = "https://api.birdeye.com/resources/v1/review/businessid/$business_id/summary?api_key=$api_key";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Accept: application/json"
    ));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;    
}

//Generate custom styles
function sb_custom_style($arr_styles){
    global $arr_style_settings;
    
}