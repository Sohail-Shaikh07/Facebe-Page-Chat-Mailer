<?php 
function cr_admin_menu(){

		add_menu_page(
	 'FB PAGE CHAT MAILER',
	 'FB PAGE CHAT',
	 'manage_options',
	 'fb-page-chat',
	 'cr_fb_page_display_menu');

}