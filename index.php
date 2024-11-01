<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/*
Plugin Name: YYDevelopment - SEO Keywords Data
Plugin URI:  https://www.yydevelopment.com/yydevelopment-wordpress-plugins/
Description: Simple plugin that allow you to save keyword data to wordpress posts and pages
Version:     1.6.0
Author:      YYDevelopment
Author URI:  https://www.yydevelopment.com/
*/

include_once('include/settings.php');
require_once('include/functions.php');

$yydev_keyword_data_plugin_version = '1.5.0'; // plugin version
$yydev_keyword_data_slug_name = 'yydev_keywords_seo_version'; // the name we save on the wp_options database

// ================================================
// Creating Database when the plugin is activated
// ================================================

function yydev_create_notes_seo_database() {
    
    require_once('include/install.php');
        
} // function yydev_create_notes_seo_database() {

register_activation_hook(__FILE__, 'yydev_create_notes_seo_database');  // run on plugin update

// ================================================
// update the database on plugin update
// ================================================

// loading the plugin version from the database
$db_plugin_version = get_option($yydev_keyword_data_slug_name);

// checking if the plugin version exists on the dabase
// and checking if the database version equal to the plugin version $yydev_keyword_data_plugin_version
if( empty($db_plugin_version) || ($yydev_keyword_data_plugin_version != $db_plugin_version) ) {

    // update the plugin database if it's required
    $yydev_database_update = 1;
    require_once('include/install.php');

    // update the plugin version in the database
    update_option($yydev_keyword_data_slug_name, $yydev_keyword_data_plugin_version);

} // if( empty($db_plugin_version) || ($yydev_keyword_data_plugin_version != $db_plugin_version) ) {

// add_action('plugins_loaded', 'my_awesome_plugin_check_version');

// ================================================
// display the plugin we have create on the wordpress
// post blog and pages
// ================================================

// function that will output the code to the page
function yydev_output_wordpress_seo_plugin($term) {

    include('include/style.php');
    include('include/admin-output.php');
    include('include/script.php');

} // function yydev_output_wordpress_seo_plugin() {


function yydev_wpdocs_register_meta_boxes() {
    add_meta_box( 'wordpress_seo_notes', 'YYDevelopment SEO Data', 'yydev_output_wordpress_seo_plugin');
} // function yydev_wpdocs_register_meta_boxes() {

add_action( 'add_meta_boxes', 'yydev_wpdocs_register_meta_boxes' );

// ================================================
// function that will insert the code to the datbase
// once the post or page is updated
// ================================================

function yydev_insert_seo_data_to_database() {

        include('include/insert-to-db.php');

} // function yydev_insert_seo_data_to_database() {

add_action('pre_post_update', 'yydev_insert_seo_data_to_database');

 // ================================================
// Dealing with categories and tags
// ================================================

// Add the field to the Edit Category pages
// add_action( 'edit_category_form', 'yydev_output_wordpress_seo_plugin', 10, 2 );
add_action( 'category_edit_form', 'yydev_output_wordpress_seo_plugin', 10, 2 );

// Save data when the user edit the category
add_action( 'edited_category', 'yydev_insert_seo_data_to_database', 10, 2 );


// Add the field to the Edit Tags pages
add_action( 'edit_tag_form', 'yydev_output_wordpress_seo_plugin', 10, 2 );

// Save data when the user edit the category
add_action( 'edited_post_tag', 'yydev_insert_seo_data_to_database', 10, 2 );

// ================================================
// Add donate page to the plugin menu info
// ================================================

add_filter( 'plugin_action_links', function($actions, $plugin_file) {

	static $plugin;

    if (!isset($plugin)) { $plugin = plugin_basename(__FILE__); }
    
	if ($plugin == $plugin_file) {

            $admin_page_url = esc_url( menu_page_url( 'yydevelopment-seo-data', false ) );
            $donate = array('donate' => '<a target="_blank" href="https://www.yydevelopment.com/coffee-break/?plugin=yydevelopment-seo-data">Donate</a>');
		
            $actions = array_merge($donate, $actions);
        
    } // if ($plugin == $plugin_file) {
		
    return $actions;

}, 10, 5 );

// ================================================
// including admin notices flie
// ================================================

if( is_admin() ) {
	include_once('notices.php');
} // if( is_admin() ) {