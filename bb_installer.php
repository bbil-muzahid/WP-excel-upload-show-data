<?php

/* Plugin Name: BB Installer
Plugin URI: http://blubirdinteractive.com/
Description: A plugin to allow users to style multiple pages and select one as home page by WordPress
Author: author
Version: 1.0
Author URI: http://www.blubirdinteractive.com/
*/
define('BBITEMPLATEDIRPATH',get_template_directory().'/');
define('BBIHOMEFILEPATH',get_template_directory().'/front-page.php');
define('BBIPLUGINURL',plugin_dir_url( __FILE__ ));
define('BBIPLUGINPATH',plugin_dir_path( __FILE__ ));
define('BBITABLENAME','bbi_installer');
define('BBITEMPTABLE','bbi_temp');
define('BBIUPLOADDIR','xml_upload');
define('BBISUCCESSDIR','xml_success');
define('BBIERRORDIR','xml_error');
define('BBIFAILEDDIR','xml_FAILED');

//include BBIPLUGINURL.'inc/bbi_backend.php';
//include('inc/bbi_backend.php');

add_action('admin_menu', 'run_bb_installer');
function run_bb_installer(){
    add_menu_page('BB Installer', 'BB Installer', 'manage_options', 'bb-installer', 'bbi_run_plugin','',100);
    add_submenu_page('bb-installer', 'Uploader', 'Uploader', 'manage_options', 'bb-installer' );
    add_submenu_page('bb-installer', 'Installers', 'Installers', 'manage_options', 'installers', 'installers' );
}

// ADDITIONAL FUNCTIONS AND CONFIGURATIONS
//include BBIPLUGINPATH.'config.php';

// CREATE TABLE ON PLUGIN ACTIVATION
//require_once 'templates/content3.php';

function bbi_on_deactivation(){
    global $wpdb;
    removeHomeFile();
    $table = $wpdb->prefix.BBITABLENAME;
    $wpdb->query( "DROP TABLE IF EXISTS `$table`" );
}

function bbi_on_uninstall(){
    //Some stuff
}

//register_activation_hook( __FILE__, 'create_style_table' );
// DELETE TABLE ON UNINSTALLATION
register_deactivation_hook(__FILE__, 'bbi_on_deactivation');
register_uninstall_hook(__FILE__, 'bbi_on_uninstall');
// FIRST STYLE MENU
function bbi_run_plugin($dir){

    include('inc/bbi_backend.php');
    include 'templates/index.php';
}

// SECOND STYLE MENU
function installers(){
    include 'inc/db.php';
    include 'templates/show.php';
}

function bbi_add_styles() {
    wp_enqueue_style( 'sweetalert', plugins_url( '/templates/css/sweetalert.css', __FILE__ ) );
}
add_action('admin_print_styles', 'bbi_add_styles');

function bbi_add_scripts() {   
    wp_enqueue_script( 'sweetalert', plugin_dir_url( __FILE__ ) . 'templates/js/sweetalert.min.js', array('jquery'), '1.0' );
}
add_action('admin_enqueue_scripts', 'bbi_add_scripts');

add_action( 'wp_ajax_save_installer', 'save_installer' );
add_action( 'wp_ajax_nopriv_save_installer', 'save_installer' );
function save_installer(){
    global $wpdb;
    $dataArray = [];
    $table = $wpdb->prefix.BBITABLENAME;
    $columns = $wpdb->get_results('SHOW columns FROM '. $table);

    foreach ($columns as $column) {
        $name = $column->Field;
        $dataArray[$name] = isset($_GET[$name]) && !empty($_GET[$name]) ? $_GET[$name] : '';
    }
    $tableID = $dataArray['id'];
    unset($dataArray['id']);
    if ( $tableID > 0 ) {
        $updated = $wpdb->update( $table, $dataArray,array('id'=>$tableID));
        if ( $updated ) { echo "success"; }
        else { echo 'failed'; }
    } else {
        echo "noTable";
    }
    wp_die();
}


add_action( 'wp_ajax_delete_installer', 'delete_installer' );
add_action( 'wp_ajax_nopriv_delete_installer', 'delete_installer' );
function delete_installer(){
    global $wpdb;
    $table = $wpdb->prefix.BBITABLENAME;

    $tableID = isset($_GET['ID']) && !empty($_GET['ID']) ? $_GET['ID'] : false;
    if ( $tableID ) {
        $deleted = $wpdb->query('DELETE  FROM '.$table.' WHERE id = "'.$tableID.'"');
        if ($deleted) { echo 'success'; }
        else { echo 'failed'; }
    }
    wp_die();
}