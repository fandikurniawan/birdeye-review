<?php

require_once( SB_PLUGIN_DIR . 'includes/sb-public.php' );

add_shortcode( 'stbirdeye_reviews' , 'load_reviews');

function load_reviews(){
    global $arr_style_settings; 
    
    wp_enqueue_style( 'sb-custom-style' );
    wp_enqueue_script( 'sb-custom-script' );
    

    $atts = array();
    $reviews = get_reviews('listing',$atts);
    $reviews = json_decode($reviews);

    ob_start();
    
    $arr_style_settings = get_option('sb_style_settings');
    
    $bgcolor = '';
    if( !empty($arr_style_settings['bgcolor_container']) ){
        $bgcolor .='style="background-color:'.$arr_style_settings['bgcolor_container'].';"';
    }

    echo '<div class="sb-main-container" '.$bgcolor.'>';

        $arr_display_settings = get_option('sb_display_settings');        
        $display_business_summary = $arr_display_settings['summary_information'];

        if( $display_business_summary  == 'show' ){

            $review_summary = get_review_summary();        
            $business_info['summary'] = json_decode($review_summary);
            
            $business_information = get_business();        
            $business_info['information'] = json_decode($business_information);

            display_summary_info($business_info);
        }

        echo '<div id="sb-result" class="sb-result">';

        $display_output = $arr_display_settings['review_layout'];

        if( $display_output == 'tabs'){            
            display_tabs($reviews);
        }else{
            display_list($reviews);
        }
    
        echo '</div> </div>';

    return ob_get_clean();
}

function display_list($arr_reviews){    
    global $arr_style_settings;
    $bgcolor = '';
    if( !empty($arr_style_settings['bgcolor_review']) ){
        $bgcolor .='style="background-color:'.$arr_style_settings['bgcolor_review'].';"';
    }

    if (!$arr_reviews) {
        echo '<div class="sb-plugin-error">An error occurred while getting a review.</div>';
        return '';
    } else {
        echo '<div class="sb-list" '.$bgcolor.'>';
        foreach ($arr_reviews as $review) {
            ?>
            <div class="sb-review-container">

                    <div class="sb-review-header">
                        <div class="sb-avatar" class="alignright">
                            <img src="<?php echo $review->reviewer->thumbnailUrl; ?>" alt="Review Avatar">
                        </div>
                        <div class="sb-reviewer">
                            <h4>
                                <?php

                                if (!empty($review->reviewer->nickName)) {
                                    echo $review->reviewer->nickName;
                                } elseif (!empty($review->reviewer->firstname)) {
                                    echo $review->reviewer->firstname . ' ' . $review->reviewer->lastname;
                                } else {
                                    echo 'Anonymous';
                                }

                                ?>
                            </h4>
                            <?php 
                                printf('<span class="sb-review-date">%s</span>', $review->reviewDate); 
                            ?>
                        </div>
                    </div>
                    <div class="sb-review-body">
                        <div class="sb-rating" itemtype="http://schema.org/AggregateRating" itemscope itemprop="aggregateRating">                            
                            <meta itemprop="ratingValue" content="<?php echo $review->rating; ?>">
                            <span class="sb-rating-stars">
                                <?php

                                
                                if ( $review->rating > 0 ){
                                    $star_symbol = '&#9733;';
                                }else{
                                    $star_symbol = '&#9734;';
                                    $review->rating = 5;
                                }
                                
                                foreach (range(1, $review->rating) as $star) {
                                    echo '<span class="sb-star">'.$star_symbol.'</span>';  
                                }

                                ?>
                            </span>

                            <span class="sb-review-source"> on <?php echo $review->sourceType; ?></span>

                        </div>
                        <div class="sb-review-comments">
                            <p>
                                <?php echo $review->comments; ?>
                            </p>
                            <!-- <a href="<?php echo $review->uniqueReviewUrl; ?>"> Read More... </a> -->
                        </div>
                    </div>
               
            </div>
            <?php
        }
        echo '</div>';
    } 

}

function display_tabs($arr_reviews){
    global $arr_style_settings;
    $bgcolor = '';
    if( !empty($arr_style_settings['bgcolor_review']) ){
        $bgcolor .='style="background-color:'.$arr_style_settings['bgcolor_review'].';"';
    }

    if (!$arr_reviews) {
        echo '<div class="sb-plugin-error">An error occurred while getting a review.</div>';
        return '';
    } else {

        echo '<div class="sb-tabs">';

        foreach($arr_reviews as $arr_source){
            $source_type = $arr_source->sourceType;
            $arr_tab_reviews[$source_type][] = $arr_source;
            $list_keys[] = $source_type; 
        }
            $list_tab_keys = array_unique($list_keys);

        
        $sbx = 1;
        foreach ($arr_tab_reviews as $tab_reviews => $source_reviews){
           // echo '<div class="sb-tab sb-tab-selected">'.$tab_reviews.'</div>';
            ?>

            <input id="sb-tab-<?php echo $sbx;?>" type="radio" name="grp" checked />
            <label for="sb-tab-<?php echo $sbx;?>"><?php echo $tab_reviews;?> </php></label>
            <div class="sb-tab-content" <?php echo $bgcolor;?>>
                <?php
                    foreach ($source_reviews as $review) {
                    ?>
                    <div class="sb-review-container">

                            <div class="sb-review-header">
                                <div class="sb-avatar" class="alignright">
                                    <img src="<?php echo $review->reviewer->thumbnailUrl; ?>" alt="Review Avatar">
                                </div>
                                <div class="sb-reviewer">
                                    <h4>
                                        <?php

                                        if (!empty($review->reviewer->nickName)) {
                                            echo $review->reviewer->nickName;
                                        } elseif (!empty($review->reviewer->firstname)) {
                                            echo $review->reviewer->firstname . ' ' . $review->reviewer->lastname;
                                        } else {
                                            echo 'Anonymous';
                                        }

                                        ?>
                                    </h4>
                                    <?php 
                                        printf('<span class="sb-review-date">%s</span>', $review->reviewDate); 
                                    ?>
                                </div>
                            </div>
                            <div class="sb-review-body">
                                <div class="sb-rating" itemtype="http://schema.org/AggregateRating" itemscope itemprop="aggregateRating">                            
                                    <meta itemprop="ratingValue" content="<?php echo $review->rating; ?>">
                                    <span class="sb-rating-stars">
                                        <?php

                                        
                                        if ( $review->rating > 0 ){
                                            $star_symbol = '&#9733;';
                                        }else{
                                            $star_symbol = '&#9734;';
                                            $review->rating = 5;
                                        }
                                        
                                        foreach (range(1, $review->rating) as $star) {
                                            echo '<span class="sb-star">'.$star_symbol.'</span>';  
                                        }

                                        ?>
                                    </span>

                                    <span class="sb-review-source"> on <?php echo $review->sourceType; ?></span>

                                </div>
                                <div class="sb-review-comments">
                                    <p>
                                        <?php echo $review->comments; ?>
                                    </p>
                                    <!-- <a href="<?php echo $review->uniqueReviewUrl; ?>"> Read More... </a> -->
                                </div>
                            </div>
                    
                    </div>
                    <?php
                }
                ?>
            </div>            

            <?php
            
            $sbx++;
        }
            
        ?>

      
        <?php
        echo '</div>';

    }
}

function display_summary_info($arr_info){
    global $arr_style_settings;
    $bgcolor = '';
    if( !empty($arr_style_settings['bgcolor_summary']) ){
        $bgcolor .='style="background-color:'.$arr_style_settings['bgcolor_summary'].';"';
    }

    if (!$arr_info['information']) {
        echo '<div class="sb-summary"><div class="sb-plugin-error">An error occurred while getting a review.</div></div>';
        return '';
    } else {
?>

        <div class="sb-summary" <?php echo $bgcolor;?>>
            <div class="sb-summary-cols sb-summary-logo">                
                <img src="<?php echo $arr_info['information']->logoUrl; ?>" alt="<?php echo $arr_info['information']->name; ?> Logo" title="<?php echo $arr_info['information']->name; ?>">
                <!-- <a href="#" class="sb-button-primary">WRITE A REVIEW</a> -->
            </div>

            <div class="sb-summary-cols sb-summary-ratings">

                <?php 
                    $x = 0;
                    $review_count = $arr_info['summary']->reviewCount;

                    foreach( array_reverse($arr_info['summary']->ratings) as $ratings){
                        ?>
                            <div class="sb-ratings">

                                <?php
                                if( $ratings->rating > 0 ){
                                    $xindex = 5 - $x;
                                    
                                    $width_num = 100 * ($ratings->reviewCount / $review_count);
                                ?>
                                    <div class="sb-premeter"><?php echo $xindex; ?>&#9734; </div>   
                                    <div class="sb-ratings-meter">                                                     
                                        <span class="sb-meter" style="width: <?php echo $width_num;?>%"></span>                            
                                    </div>
                                    <div class="sb-postmeter"><?php echo $ratings->reviewCount;?></div>
                                <?php                
                                }else{
                                    echo '<div class="sb-norating">'.$ratings->reviewCount.' review has no rating </div>';
                                }    

                        ?>  
                            </div>
                        <?php
                        $x++;
                    } 
                ?>
            </div>

            <div class="sb-summary-cols sb-summary-company">
                <div class="sb-avg-rating"><h3><?php echo number_format((float)$arr_info['summary']->avgRating, 1, '.', '');  ?></h3></div>
                <div class="sb-rating-stars">
                    <?php
                                                                
                        if ( $arr_info['summary']->avgRating > 0 ){
                            $star_symbol = '&#9733;';
                        }else{
                            $star_symbol = '&#9734;';
                            $arr_info['summary']->avgRating = 5;
                        }

                        foreach (range(1, $arr_info['summary']->avgRating ) as $star) {
                            echo '<span class="sb-star">'.$star_symbol.'</span>';  
                        }

                    ?>                
                </div>
                <p class="aligncenter">
                    <a href="#sb-result"><small><?php echo $arr_info['summary']->reviewCount; ?> reviews</small></a>
                </p>           
            </div>
        </div>

    
    <?php
    }
}

