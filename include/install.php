<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); // Require to use dbDelta
include('settings.php'); // Load the files to get the databse info

// ==============================================================
// install the plugin for the first time
// ==============================================================

// Making sure the table we want to create don't exists
if( $wpdb->get_var("SHOW TABLES LIKE '{$table_name}' ") != $table_name ) {
    
    $sql = "CREATE TABLE " . $table_name . "( 
        id INTEGER(11) UNSIGNED AUTO_INCREMENT,
        page_post_id INTEGER(11),
        category_tags_id INTEGER(11),
        value TEXT,
        table_notes TEXT,
        date TEXT,
        date_range TEXT,
        direction_class VARCHAR (500),
        PRIMARY KEY (id) 
    ) $charset_collate;";
    
    dbDelta($sql);
    
}  // if( $wpdb->get_var("SHOW TABLES LIKE '{$table_name}' ") != $table_name ) {


// if the plugin change version and require to add database fields
if( isset($yydev_database_update ) ) {

        // ============================================================
        // Dealing with the plugin database updates for new versions
        // ============================================================

        // creating an array with all the columns from the database
        $existing_columns = $wpdb->get_col("DESC {$table_name}", 0);

        
        if($existing_columns) {

                // -------------------------------------------------------------
                // update the database for plugin version 1.1
                // -------------------------------------------------------------

                $new_db_column = 'date';
                if( !in_array($new_db_column, $existing_columns) ) {
                    // create the date column on the database
                    $wpdb->query("ALTER TABLE $table_name ADD $new_db_column TEXT NOT NULL");
                } // if( in_array($new_db_column, $existing_columns) ) {

                // -------------------------------------------------------------
                // update the database for plugin version 1.1.4
                // -------------------------------------------------------------

                $new_db_column = 'direction_class';
                if( !in_array($new_db_column, $existing_columns) ) {
                    // create the date column on the database
                    $wpdb->query("ALTER TABLE $table_name ADD $new_db_column VARCHAR (500) NOT NULL");
                } // if( !in_array($new_db_column, $existing_columns) ) {

                // -------------------------------------------------------------
                // update the database for plugin version 1.1
                // -------------------------------------------------------------

                $new_db_column = 'date_range';
                if( !in_array($new_db_column, $existing_columns) ) {
                    // create the date column on the database
                    $wpdb->query("ALTER TABLE $table_name ADD $new_db_column TEXT NOT NULL");
                } // if( in_array($new_db_column, $existing_columns) ) {

                // -------------------------------------------------------------
                // update the database for plugin version 1.3.0
                // -------------------------------------------------------------

                $new_db_column = 'category_tags_id';
                if( !in_array($new_db_column, $existing_columns) ) {
                    // create the date column on the database
                    $wpdb->query("ALTER TABLE $table_name ADD $new_db_column INTEGER(11) NOT NULL AFTER page_post_id");
                } // if( !in_array($new_db_column, $existing_columns) ) {

        } // if($existing_columns) {

} // if( isset($yydev_database_update ) ) {