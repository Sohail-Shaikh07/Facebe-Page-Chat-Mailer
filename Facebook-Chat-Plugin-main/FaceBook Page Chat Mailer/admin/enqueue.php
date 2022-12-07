<?php
function cr_enqueue_scripts(){

	wp_register_script('cr_main', plugins_url('js/facebook-main.js', CR_FACEBOOK_PLUGIN), ['jquery'], false, true );
	
    wp_register_style('cr_style', plugins_url('css/style.css', CR_FACEBOOK_PLUGIN));
    wp_localize_script('cr_main', 'cr_obj', [
        'ajax_url'      =>  admin_url( 'admin-ajax.php' ),
   ]);

	wp_enqueue_script('cr_main');

   wp_enqueue_style('cr_style');
}