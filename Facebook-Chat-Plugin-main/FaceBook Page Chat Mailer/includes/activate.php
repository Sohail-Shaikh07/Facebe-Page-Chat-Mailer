<?php 
function cr_activate_plugin()
{
    global $wpdb;
    
    $createSQL      =   "CREATE TABLE IF NOT EXISTS `". $wpdb->prefix ."fb_pages_info` (
        `ID` BIGINT(20) NOT NULL AUTO_INCREMENT,
        `page_id` VARCHAR(200) NOT NULL,
        `token` VARCHAR(200) NOT NULL,
        `name` VARCHAR(200) NOT NULL,
        `active` BIGINT(20) NOT NULL,
        `email` VARCHAR(200),
        `recent_message_at` MEDIUMBLOB NULL DEFAULT NULL,
        PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB " . $wpdb->get_charset_collate() . ";";
    require_once( ABSPATH . "/wp-admin/includes/upgrade.php" );
    dbDelta( $createSQL );

    wp_schedule_event( time(), 'hourly', 'cr_facebook_get_messages' );
}
?>