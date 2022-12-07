<?php 
function cr_deactivate_plugin()
{
    	wp_clear_scheduled_hook( 'cr_facebook_get_messages' );
}
}