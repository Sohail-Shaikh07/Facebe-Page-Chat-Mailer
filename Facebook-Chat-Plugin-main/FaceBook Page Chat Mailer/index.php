<?php
/**
 * Plugin Name:       Facebook Chat Mailer
 * Description:       Sends a Email whenever your Facebook Page gets a message
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Aman Khan
 * Author URI:        https://www.upwork.com/freelancers/~014023f820b4940974
 */
define('CR_FACEBOOK_PLUGIN', __FILE__);
define('FACEBOOK_APP_ID', '822494921717907');
define('FACEBOOK_APP_SECRET', '6c7310e1227834599e481a309a6b4eb7');
define('GRAPH_VERSION', 'v11.0');


//Includes
include('includes/activate.php');
include('admin/menu-page.php');
include('admin/menu-setting.php');
include('admin/enqueue.php');
include('main-process/save-facebook-response.php');
include('main-process/fb_pages.php');
include('php-graph-sdk-5.x/src/Facebook/autoload.php');
include('main-process/cr_facebook_get_messages.php');

//Actions
register_activation_hook( __FILE__, 'cr_activate_plugin');
register_deactivation_hook( __FILE__, 'cr_deactivate_plugin' );
add_action( 'admin_menu', 'cr_admin_menu' );
add_action('admin_enqueue_scripts', 'cr_enqueue_scripts', 100);
add_action('wp_ajax_save_facebook_response', 'save_facebook_response');
add_action('save_facebook_pages_response', 'get_all_fb_pages');
add_action('cr_facebook_get_messages', 'cr_facebook_get_messages');
add_action('wp_loaded', 'cr_facebook_get_messages');

add_filter( 'wp_mail_content_type',function(){
    return "text/html";
} );