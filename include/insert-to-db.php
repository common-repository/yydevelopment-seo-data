<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

if( isset($_POST['yydev_keywords_nonce']) ) {

    if( wp_verify_nonce($_POST['yydev_keywords_nonce'], 'yydev_keywords_action') ) {


        include('settings.php');

        // ====================================================
        // Function that prepare the data to be insert to the database
        // ====================================================

        if( !function_exists('yydev_keywords_implode_prep') ) {

            function yydev_keywords_implode_prep($value) {

                $implode_value = implode("^^", $value);
                return $implode_value;
                
            } // function yydev_keywords_implode_prep($value) {
            
        } // if( !function_exists('yydev_keywords_implode_prep') ) {


        // ====================================================
        // Checking if this is a category/tags post or regular page/post
        // ====================================================

            // incase of a regular post/page
            if(isset($_POST['seo_current_post_id'])) {

                $this_post_id = intval($_POST['seo_current_post_id']);
                $insert_id_to_db_table = "page_post_id";

            } // if(isset($_POST['seo_current_post_id'])) {
            
            // // incase of a category/tag
            if(isset($_POST['seo_current_category_id'])) {
                $insert_id_to_db_table = "category_tags_id";
            } // if(isset($_POST['seo_current_category_id'])) {
                

        // ====================================================
        // Add seo data to the database
        // ====================================================

        if( isset($this_post_id) && !empty($this_post_id)  ) {

                // If there is no error insert the info to the database
                $current_post_id = intval($this_post_id);
                $table_notes = wp_kses_post($_POST['table_notes']);
                $seo_data_date_range = sanitize_text_field($_POST['seo_data_date_range']);
                $changes_date = sanitize_text_field($_POST['seo_data_changes_date']);
                $notes_text_area_direction = sanitize_text_field($_POST['notes-text-area-direction']);
                
                // creating an array with all the info
                $seo_data_keywords = yydev_keywords_implode_prep($_POST['seo_data_keywords']);
                $seo_data_google_montly_search = yydev_keywords_implode_prep($_POST['seo_data_google_montly_search']);
                $seo_data_adwords_competition = yydev_keywords_implode_prep($_POST['seo_data_adwords_competition']);
                $seo_data_all_in_title_amounts = yydev_keywords_implode_prep($_POST['seo_data_all_in_title_amounts']);
                $seo_data_search_console_montly_search = yydev_keywords_implode_prep($_POST['seo_data_search_console_montly_search']);
                $seo_data_search_console_montly_clicks = yydev_keywords_implode_prep($_POST['seo_data_search_console_montly_clicks']);
                $seo_data_keyword_position = yydev_keywords_implode_prep($_POST['seo_data_keyword_position']);
                $seo_data_ctr = yydev_keywords_implode_prep($_POST['seo_data_search_ctr']);
                $seo_data_main_keyword = yydev_keywords_implode_prep($_POST['seo_data_main_keyword_value']);

                // creating some kind of array that will have inside all the keywords data
                $insert_to_db_value = $seo_data_keywords . "###" . $seo_data_google_montly_search . "###" . $seo_data_adwords_competition . "###" . $seo_data_all_in_title_amounts 
                 . "###" . $seo_data_search_console_montly_search . "###" . $seo_data_search_console_montly_clicks . "###" . $seo_data_keyword_position . "###" . $seo_data_ctr . "###" . $seo_data_main_keyword;

                $insert_to_db_value = sanitize_text_field($insert_to_db_value);

                // making sure the data is not empty, so we won't insert empty data to the database. this take in account only keywords
                $check_there_is_data = str_replace(array(",", "###", "^^", "0"), array("", "", "", ""),  $insert_to_db_value);

                // checking if there is any data at all so we know if to change the database
                if( empty($check_there_is_data) && empty($table_notes) && empty($changes_date) ) {
                    $there_is_data_here = 1;
                } // if( empty($check_there_is_data) && empty($table_notes) && empty($changes_date) ) {

                // if the keywords are empty we will clean the keywords database field
                if( empty($check_there_is_data) ) {
                    $insert_to_db_value = '';
                } // if( empty($check_there_is_data) ) {

                // Checking if the data id exists
                global $wpdb;
                $check_database_exists = $wpdb->query("SELECT * FROM " . $table_name . " WHERE {$insert_id_to_db_table} = $current_post_id ");

                // sanitize the data
                $insert_to_db_value = sanitize_text_field($insert_to_db_value);


                if( $check_database_exists == 0 ) {
                    
                    // if the post doesn't exists in the database we will 
                    // make sure there is data and then we will insert it
                    if( !isset($there_is_data_here) ) {

                        // if the data not exists on the database insert new one
                        $wpdb->insert( $table_name,
                            array($insert_id_to_db_table=>$current_post_id,
                            'value'=>$insert_to_db_value,
                            'table_notes'=>$table_notes,
                            'date_range'=>$seo_data_date_range,
                            'date'=>$changes_date,
                            'direction_class'=>$notes_text_area_direction,
                            ), array('%d', '%s', '%s', '%s', '%s', '%s') );

                    } // if( !isset($there_is_data_here) ) {

                } else { // if( $check_database_exists == 0 ) {
                
                    // If the current page data exists in the database we will update it
                    if( !isset($there_is_data_here) ) {

                        $wpdb->update( $table_name,
                        array('value'=>$insert_to_db_value,
                        'table_notes'=>$table_notes,
                        'date_range'=>$seo_data_date_range,
                        'date'=>$changes_date,
                        'direction_class'=>$notes_text_area_direction,
                        ), array($insert_id_to_db_table=>$current_post_id), array('%s', '%s', '%s', '%s', '%s') );

                    } else { // if( !isset($there_is_data_here) ) {
                        
                        // if there are no data at all (in notes and date as well) we will remove the line from the database
                        $wpdb->delete( $table_name, array($insert_id_to_db_table=>$current_post_id) );

                    } // if( !isset($there_is_data_here) ) {

                } // } else { // if($check_database_exists == 0 ) {
            
        } // if( isset($this_post_id) && !empty($this_post_id)  ) {


    } // if( wp_verify_nonce($_POST['yydev_keywords_nonce'], 'yydev_keywords_action') ) {

} // if( isset($_POST['yydev_keywords_nonce']) ) {

?>