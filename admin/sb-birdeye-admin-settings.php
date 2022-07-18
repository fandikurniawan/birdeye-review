<?php

if (!current_user_can('manage_options'))
wp_die(__("You don't have access to this page"));  

if( !empty($_POST) ) {
    switch( $_POST['option_page'] ){
        case 'sb_key_settings':
            update_option( 'sb_api_key', sanitize_text_field( $_POST['sb_api_key'] ) );
            update_option( 'sb_business_id', sanitize_text_field( $_POST['sb_business_id'] ) );          
        break;    

        case 'sb_display_settings':
            $arr_sb_display_settings = array_map( 'sanitize_text_field', $_POST['sb_display_settings'] );
            update_option( 'sb_display_settings', $arr_sb_display_settings );   
        break;

        case 'sb_style_settings':
            $arr_sb_style_settings = array_map( 'sanitize_hex_color', $_POST['sb_style_settings'] );
            update_option( 'sb_style_settings', $arr_sb_style_settings );   
        break;        

        default:
    }
}

?>
<div class="wrap">
<div class="sb-settings-box">
    <div class="sb-settings-box-header"><h2>Birdeye WP Settings</h2></div>
    <div class="sb-settings-box-fields">

        <form action="options.php?page=sb-birdeye" method="post" name="sb-settings-form">
        <?php settings_fields( 'sb_key_settings' ); ?>
        <?php do_settings_sections( 'sb_key_settings' ); ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="sb_api_key">API KEY: </label>
                    </th>                        
                    <td>
                        <input type="text" name="sb_api_key" id="sb_api_key" size="45" value="<?php echo get_option( 'sb_api_key' ); ?>" >                        
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="sb_business_id">Business ID: </label>
                    </th>                        
                    <td>
                        <input type="text" id="sb_business_id" name="sb_business_id" size="45" value="<?php echo get_option( 'sb_business_id' ) ?>"> 
                    </td>
                </tr>                    
            </tbody>
        </table>                                               
                                        
        <p>
            <?php  submit_button('Save Settings') ?>
        </p>
                                            
            
        </form>


    </div>

</div>
<hr/>
<div class="sb-display-box">
        <h2>Display Settings</h2>
        <form action="options.php?page=sb-birdeye" method="post" name="sb-display-settings-form">
        <?php settings_fields( 'sb_display_settings' ); ?>
        <?php 
            do_settings_sections( 'sb_display_settings' ); 
            $arr_display_settings = get_option('sb_display_settings');
        ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="sb_display_settings[summary_information]">Summary Information </label>
                    </th>                        
                    <td>
                        <input type="radio" name="sb_display_settings[summary_information]" value="show" <?php checked('show', $arr_display_settings['summary_information']); ?> /> Show &nbsp;
                        <input type="radio" name="sb_display_settings[summary_information]" value="hide" <?php checked('hide', $arr_display_settings['summary_information']); ?> /> Hide
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="sb_display_settings[review_layout]">Review Layout </label>
                    </th>                        
                    <td>
                    <input type="radio" name="sb_display_settings[review_layout]" value="list" <?php checked('list', $arr_display_settings['review_layout']); ?> /> List &nbsp;
                        <input type="radio" name="sb_display_settings[review_layout]" value="tabs" <?php checked('tabs', $arr_display_settings['review_layout']); ?> /> Tabs                        
                    </td>
                </tr>                    
            </tbody>
        </table>                                               
                                        
        <p>
            <?php  submit_button('Save Display Settings') ?>
        </p>
                                            
            
        </form>        
</div>

<hr/>
<div class="sb-display-box">
        <h2>Style Settings</h2>
        <form action="options.php?page=sb-birdeye" method="post" name="sb-display-settings-form">
        <?php settings_fields( 'sb_style_settings' ); ?>
        <?php 
            do_settings_sections( 'sb_style_settings' ); 
            $arr_style_settings = get_option('sb_style_settings');
        ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="sb_api_key">Main Container Background Color</label>
                    </th>                        
                    <td>
                    <input type="text" name="sb_style_settings[bgcolor_container]" value="<?php echo $arr_style_settings['bgcolor_container']; ?>" class="sb-bg-color" data-default-color="#f4f4f4" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="sb_style_settings[bgcolor_summary]">Summary Information Background Color</label>
                    </th>                        
                    <td>
                        <input type="text" name="sb_style_settings[bgcolor_summary]" value="<?php echo $arr_style_settings['bgcolor_summary']; ?>" class="sb-bg-color" data-default-color="#fefefe" />
                    </td>
                </tr>     
                <tr>
                    <th scope="row">
                        <label for="sb_style_settings[bgcolor_review]">Review Container Background Color</label>
                    </th>                        
                    <td>
                        <input type="text" name="sb_style_settings[bgcolor_review]" value="<?php echo $arr_style_settings['bgcolor_review']; ?>" class="sb-bg-color" data-default-color="#fefefe" />
                    </td>
                </tr>                                
            </tbody>
        </table>                                               
                                        
        <p>
            <?php  submit_button('Save Style Settings') ?>
        </p>
                                            
            
        </form>        
</div>

</div> 