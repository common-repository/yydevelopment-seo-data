<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

// ==================================================================
// output the values into the the page or input in the correct way
// allowing to have double and single quotes inside input
// ==================================================================

function yydev_seo_data_html_output($output_code) {

    $output_code = stripslashes_deep($output_code);
    $output_code = esc_html($output_code);
    return $output_code;

} // function yydev_seo_data_html_output($output_code) {

// ==================================================================
// This function will display error message if there was something wrong
// $error_message will be the name of the string we define and if it's exists
// it will echo the message to the page
// if $display_inline is set to 1 it will have style of display: inline
// ==================================================================

function yydev_show_seo_data_submit_form_error_message($error_message, $display_inline = "") {
    
    if($display_inline == 1) {
        $display_inline_echo = "display-inline";
    } // if($display_inline == 1) {
    
    if( isset($error_message) ) {
        ?>
        
        <div class="output-data-error-message <?php echo $display_inline_echo; ?>">
            <?php echo $error_message; ?>
        </div>
        
        <?php
    } // if( isset($error) ) {
    
} // function yydev_show_seo_data_submit_form_error_message($error) {


// ================================================
// Echoing Message if it's exists 
// ================================================

function yydev_echo_seo_data_message_if_exists() {
    
    if(isset($_GET['message'])) {
        echo "<div class='output-messsage'> " . htmlentities($_GET['message']) . " </div>";
    } // if(isset($_GET['message'])) {
    
    if(isset($_GET['error-message'])) {
        echo "<div class='error-messsage'><b>Error:</b> " .  htmlentities($_GET['error-message']) . " </div>";
    } // if(isset($_GET['error-message'])) {

} // function yydev_echo_seo_data_message_if_exists() {


function yydev_echo_seo_data_error_message_if_exists($error) {

    if(isset($error) && !empty($error) ) {
        echo "<div class='error-messsage'><b>Error:</b> " .  htmlentities($error) . " </div>";
    } // if(isset($_GET['error-message'])) {

} // function yydev_echo_seo_data_error_message_if_exists() {
