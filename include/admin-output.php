<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

    include('settings.php');

    // ============================================================
    // checking if the data exists on the database
    // ============================================================
    global $wpdb;

    // -----------------------------------------------
    // incase this is a regular page or a blog post
    // -----------------------------------------------
    $this_post_id = get_the_ID();

    if( isset($this_post_id) && !empty($this_post_id) ) {
        $seo_info_data = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE page_post_id  = $this_post_id ");
    } // if( !empty($this_post_id) ) {

    // -----------------------------------------------
    // incase this is a category or a tag page
    // -----------------------------------------------
    $categorie_id = $term->term_id;

    if( isset($categorie_id) && !empty($categorie_id) ) {
        $seo_info_data = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE category_tags_id  = $categorie_id ");
        $this_post_id = $categorie_id;

        // creating an hidden input with the page/category id
        echo "<input type='hidden' name='seo_current_category_id' value ='1' />";

        // echo style for the categoy page
        echo "<div class='postbox category_keywords_seo'>";
        echo "<h2 class='hndle'><span>YYDevelopment SEO Data</span></h2>";
        echo  "<div class='inside'>";



    } // if( !empty($this_post_id) ) {


    // creating an hidden input with the page/category id
    echo "<input type='hidden' name='seo_current_post_id' value ='" . $this_post_id . "' />";


?>


<div class="wordpress-seo-notes-warp ">
        <table id="wordpress-seo-notes" class="wordpress-seo-notes">

        <tr class="table-titles" >
            <th> </th>
            <th class='keyword'> Keyword </th>
            <th> Google Montly Searchs </th>
            <th> Adwords Competition </th>
            <th> All In Title Results </th>
            <th> Search Console <br /> Montly Clicks </th>
            <th> Search Console <br /> Montly Searchs </th>
            <th class='smaller-input'> CTR </th>
            <th class='smaller-input'> Keyword Position </th>
            <th>  </th>
        </tr>


    <?php
    
    // creating empty value so it won't return error if there are no results
    $keywords_table_notes = "";
    $making_sure_array_not_empty = "";
    
    if( count($seo_info_data) > 0 ) {

        // output the data to the page
        foreach($seo_info_data as $seo_info_data_output) {


            $keywords_table_notes = $seo_info_data_output->table_notes;
            $keywords_update_changes_date = $seo_info_data_output->date;
            $keywords_date_range = $seo_info_data_output->date_range;
            $keywords_table_direction_class = $seo_info_data_output->direction_class;
            $all_the_keywords_data = explode("###", $seo_info_data_output->value);

            // create an array that will make sure $all_the_keywords_data is not empty. if it does empty we will create new table
            $making_sure_array_not_empty .= $seo_info_data_output->value;

            // ================================================
            // Recreate an array with the code to output
            // ================================================
            $keyword_seo_data_array['keyword'] = explode("^^", $all_the_keywords_data[0]);
            $keyword_seo_data_array['google_montly_search'] = explode("^^", $all_the_keywords_data[1]);
            $keyword_seo_data_array['adwords_competition'] = explode("^^", $all_the_keywords_data[2]);
            $keyword_seo_data_array['all_in_title'] = explode("^^", $all_the_keywords_data[3]);
            $keyword_seo_data_array['console_montly_search'] = explode("^^", $all_the_keywords_data[4]);
            $keyword_seo_data_array['console_montly_clicks'] = explode("^^", $all_the_keywords_data[5]);
            $keyword_seo_data_array['keyword_position'] = explode("^^", $all_the_keywords_data[6]);
            $keyword_seo_data_array['ctr'] = explode("^^", $all_the_keywords_data[7]);
            $keyword_seo_data_array['main_keyword'] = explode("^^", $all_the_keywords_data[8]);

                $counting_number = 0;
                $keywords_amount = count($keyword_seo_data_array['keyword']);

                while($counting_number <= $keywords_amount-1) {

                    // ================================================
                    // making sure there are no empty lines
                    // ================================================
                    
                    $not_empty_keywords_line = 0;
                    $data_keywords_array = array('keyword', 'google_montly_search', 'adwords_competition', 'all_in_title', 'console_montly_search', 'console_montly_clicks', 'keyword_position', 'ctr', 'main_keyword');
                    foreach($data_keywords_array as $data_keywords_info) {
                        
                        if( !empty($keyword_seo_data_array[$data_keywords_info][$counting_number]) ) {
                            $not_empty_keywords_line = 1;
                        } // if( !empty($keyword_seo_data_array[$data_keywords_info][$counting_number]) ) {

                    } // foreach($data_keywords_array as $data_keywords_info) {

                    // ================================================
                    // output the code if it exists on the database
                    // ================================================

                    if($not_empty_keywords_line == 1) { // checking line is not empty
            ?>

                        <tr class='wordpress-seo-line <?php if(yydev_seo_data_html_output($keyword_seo_data_array['main_keyword'][$counting_number]) == 1) { echo "heightlight-keyword"; } ?>'>        
                            <td class="main-keywords-buttons"><a class='move-keyword-up' href='#'><img  src='<?php echo plugins_url( 'images/move-up.png', dirname(__FILE__) ); ?>' alt='' title='Move Up' /></a><input type='checkbox' name='seo_data_main_keyword[]' class='keywords-checkbox-input' value='1' <?php if(yydev_seo_data_html_output($keyword_seo_data_array['main_keyword'][$counting_number]) == 1) {echo "checked";} ?> /></td>
                            <input type='hidden' name='seo_data_main_keyword_value[]' class='seo_data_main_keyword_value' <?php if(yydev_seo_data_html_output($keyword_seo_data_array['main_keyword'][$counting_number]) == 1) {echo "value='1'";} else {echo "value='0'";} ?> />

                            <td><input type='text' name='seo_data_keywords[]' class='keyword' value='<?php echo yydev_seo_data_html_output($keyword_seo_data_array['keyword'][$counting_number]); ?>' /></td>
                            <td><input type='text' name='seo_data_google_montly_search[]' value='<?php echo yydev_seo_data_html_output($keyword_seo_data_array['google_montly_search'][$counting_number]); ?>' /></td>
                            <td><input type='text' name='seo_data_adwords_competition[]' value='<?php echo yydev_seo_data_html_output($keyword_seo_data_array['adwords_competition'][$counting_number]); ?>' /></td>
                            <td><input type='text' name='seo_data_all_in_title_amounts[]' value='<?php echo yydev_seo_data_html_output($keyword_seo_data_array['all_in_title'][$counting_number]); ?>' /></td>
                            <td><input type='text' name='seo_data_search_console_montly_clicks[]' value='<?php echo yydev_seo_data_html_output($keyword_seo_data_array['console_montly_clicks'][$counting_number]); ?>' /></td>
                            <td><input type='text' name='seo_data_search_console_montly_search[]' value='<?php echo yydev_seo_data_html_output($keyword_seo_data_array['console_montly_search'][$counting_number]); ?>' /></td>
                            <td><input type='text' name='seo_data_search_ctr[]' value='<?php echo yydev_seo_data_html_output($keyword_seo_data_array['ctr'][$counting_number]); ?>' /></td>
                            <td><input type='text' name='seo_data_keyword_position[]' class='smaller-input' value='<?php echo yydev_seo_data_html_output($keyword_seo_data_array['keyword_position'][$counting_number]); ?>' /></td>
                            <td><a class='remove-seo-data-line' href='#'><img  src='<?php echo plugins_url( 'images/remove.png', dirname(__FILE__) ); ?>' alt='' title='Remove Keyword' /></a></td>
                        </tr>

            <?php
                    } // if($not_empty_keywords_line == 1) {

                $counting_number++;
                } // while($counting_number <= $keywords_amount-1) {

            } // foreach($seo_info_data as $seo_info_data_output) {

    } // if( count($seo_info_data) > 0 ) {


    // ================================================
    // Creating the output for the page and for the script
    // ================================================
    $remove_line_icon = plugins_url( 'images/remove.png', dirname(__FILE__) );
    $move_up_icon = plugins_url( 'images/move-up.png', dirname(__FILE__) );

    $another_keyword_line = "";
    $another_keyword_line .= "<tr class='wordpress-seo-line'>";
        $another_keyword_line .= "<td class='main-keywords-buttons'><a class='move-keyword-up' href='#'><img  src='" . $move_up_icon . "' alt='' title='Move Up' /></a>";
        $another_keyword_line .=  "<input type='checkbox' name='seo_data_main_keyword[]' class='keywords-checkbox-input' value='1' />";
        $another_keyword_line .= "</td>";
        $another_keyword_line .= "<input type='hidden' name='seo_data_main_keyword_value[]' class='seo_data_main_keyword_value' value='0' />";

        $another_keyword_line .= "<td><input type='text' name='seo_data_keywords[]' class='keyword' value='' /></td>";
        $another_keyword_line .= "<td><input type='text' name='seo_data_google_montly_search[]' value='' /></td>";
        $another_keyword_line .= "<td><input type='text' name='seo_data_adwords_competition[]' value='' /></td>";
        $another_keyword_line .= "<td><input type='text' name='seo_data_all_in_title_amounts[]' value='' /></td>";
        $another_keyword_line .= "<td><input type='text' name='seo_data_search_console_montly_clicks[]' value='' /></td>";
        $another_keyword_line .= "<td><input type='text' name='seo_data_search_console_montly_search[]' value='' /></td>";
        $another_keyword_line .= "<td><input type='text' name='seo_data_search_ctr[]' value='' /></td>";
        $another_keyword_line .= "<td><input type='text' name='seo_data_keyword_position[]' class='smaller-input' value='' /></td>";
        $another_keyword_line .= "<td><a class='remove-seo-data-line' href='#'><img  src='" . $remove_line_icon . "' alt='' title='Remove Keyword' /></a></td>";
    $another_keyword_line .= "</tr>";


        $making_sure_array_not_empty = str_replace(array(",", "###", "^^"), array("", "", ""),  $making_sure_array_not_empty);

        if( (count($seo_info_data) == 0) || empty($making_sure_array_not_empty) ) {

            // ================================================
            // if the the keywords not exists for this page echo the form
            // ================================================
            echo $another_keyword_line;
            
        } // if( count($seo_info_data) == 0 ) {

    ?>

        </table>

    <br />

    <?php 
        // checking if the table with notes should be visible or not
        $hide_textare_class = "";
        $hide_text_area_button = "hide_textarea_button";
        if( empty($keywords_table_notes) ) {
            $hide_textare_class = "hide_textarea";
            $hide_text_area_button = "";
        } // if( empty($keywords_table_notes) ) {
    ?>

    <div class="add-another-seo-data-div">

        <a href="#" class="add-another-seo-data direction-ltr">+ Add Another Keyword</a>
        
        <div class="add-notes-table-button <?php echo $hide_text_area_button; ?>">
        <a href="#" class="direction-ltr">+ Add Changes Notes</a>
        </div>


        <div class="add-updates-date">
            <label for="seo_data_date_range">Data Date range:</label>

            <select name="seo_data_date_range" id='seo_data_date_range'>
                <option value=""></option>
                <option value="7_days" <?php if($keywords_date_range == '7_days') {echo "selected";} ?> >Last 7 Days</option>
                <option value="28_days" <?php if($keywords_date_range == '28_days') {echo "selected";} ?> >Last 28 Days</option>
                <option value="3_months" <?php if($keywords_date_range == '3_months') {echo "selected";} ?> >Last 3 Months</option>
                <option value="6_months" <?php if($keywords_date_range == '6_months') {echo "selected";} ?> >Last 6 Months</option>
                <option value="12_months" <?php if($keywords_date_range == '12_months') {echo "selected";} ?> >Last 12 Months</option>
                <option value="16_months" <?php if($keywords_date_range == '16_months') {echo "selected";} ?> >Last 16 Months</option>
            </select>

        </div><!--add-updates-date-->


        <div class="add-updates-date">
            <label for="seo_data_changes_date">Date:</label>
            <input type="text" id="seo_data_changes_date" name="seo_data_changes_date" value="<?php if(isset($keywords_update_changes_date)) {echo $keywords_update_changes_date;} ?>" />
        </div><!--add-updates-date-->

    </div><!--add-another-seo-data-div-->

    <br />
<?php
    // checking if the table should be rtl or ltr
    if( isset($keywords_table_direction_class) && !empty($keywords_table_direction_class) ) {

        // setting the direction class from the database
        $table_direction_class = $keywords_table_direction_class;

    } else { // if( isset($keywords_table_direction_class) && !empty($keywords_table_direction_class) ) {

        // setting the direction class from the theme direction
        if( is_rtl() ) {
            $table_direction_class = "direction-rtl";
        } else { // if( is_rtl() ) {
            $table_direction_class = "direction-ltr";
        } // } else { // if( is_rtl() ) {

    } // } else { // if( isset($keywords_table_direction_class) && !empty($keywords_table_direction_class) ) {

?>
    <div class="add-table-notes <?php echo $hide_textare_class; ?>">

        <div class="textarea-buttons">
            <a class='table-line-separator' href='#'><img  src='<?php echo plugins_url( 'images/separator.png', dirname(__FILE__) ); ?>' alt='' title='Change Text Direction' /></a>
            <a class='table-text-derction' href='#'><img  src='<?php echo plugins_url( 'images/text-direction.png', dirname(__FILE__) ); ?>' alt='' title='Change Text Direction' /></a>
        </div><!--textarea-buttons-->

        <textarea cols="150" rows="8" class="table_notes <?php echo esc_attr($table_direction_class); ?>" name="table_notes" ><?php echo yydev_seo_data_html_output( esc_textarea($keywords_table_notes) ); ?></textarea>
        <a class='remove-table-notes' href='#'><img  src='<?php echo plugins_url( 'images/remove.png', dirname(__FILE__) ); ?>' alt='' title='Remove Notes' /></a>
        <input type="hidden" class="notes-text-area-direction" name="notes-text-area-direction" value="<?php echo esc_attr($table_direction_class); ?>" />
    </div><!--add-table-notes-->

</div><!--wordpress-seo-notes-warp-->

<?php

if( isset($categorie_id) && !empty($categorie_id) ) {

    // // close style for the categoy page
    echo "</div><!--postbox-->";
    echo "</div><!--inside-->";

} // if( isset($categorie_id) && !empty($categorie_id) ) {

?>
<?php 
    // creating nonce to make sure the form was submitted correctly from the right page
    wp_nonce_field( 'yydev_keywords_action', 'yydev_keywords_nonce' ); 
?>