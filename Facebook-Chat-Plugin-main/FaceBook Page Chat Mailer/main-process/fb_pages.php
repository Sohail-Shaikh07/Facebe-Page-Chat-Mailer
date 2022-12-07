<?php
//require_once './php-graph-sdk-5.x/src/Facebook/autoload.php';

function get_all_fb_pages(){
$fb = new Facebook\Facebook([
  'app_id' => FACEBOOK_APP_ID,
  'app_secret' => FACEBOOK_APP_SECRET,
  'default_graph_version' => GRAPH_VERSION
  ]);

	$token = get_option( 'long_lived_user_token' );
try {
  // Returns a `FacebookFacebookResponse` object
  $response = $fb->get(
    'me/accounts?fields=access_token,name',
    $token
  );
} catch(FacebookExceptionsFacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(FacebookExceptionsFacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$graphNode = $response->getGraphEdge();
global $wpdb;
$current_user = wp_get_current_user();
$email = $current_user->user_email;
$table = $wpdb->prefix.'fb_pages_info';
$delete = $wpdb->query("TRUNCATE TABLE {$table}");
foreach($graphNode as $graph){
	$table = $wpdb->prefix.'fb_pages_info';
    $data = array('page_id' => $graph['id'], 'token' => $graph['access_token'],'name' => $graph['name'], 'active' => 0, 'email' => $email );
     $wpdb->insert($table,$data);
//$my_id = $wpdb->insert_id;
}
//do_action('get_messages');
}