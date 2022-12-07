
    window.fbAsyncInit = function() {
    FB.init({
      appId            : '822494921717907',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v11.0'
    });
  };
jQuery(document).ready(function() {
  jQuery.ajaxSetup({ cache: true });
  jQuery.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
    FB.init({
      appId: '822494921717907',
      version: 'v11.0' 
    });     
     
  jQuery('.fb-login-custom-button').on('click', function(){
FB.login(function(response) {
  console.log(response);
    if (response.authResponse) {
  var form = {
              action:'save_facebook_response',
              response:response.authResponse.accessToken,
              }
                jQuery.post( cr_obj.ajax_url, form, function(data){

           } );
     console.log('Welcome! Fetching your information.... ');
     FB.api('/me', function(response) {
       console.log('Good to see you, ' + response.authResponse + '.');
     });
    } else {
     console.log('User cancelled login or did not fully authorize.');
    }
}, {scope:'public_profile, email, pages_messaging, pages_show_list,pages_messaging,pages_read_engagement'});
 
  });

jQuery('#facebook-btn').innerHTML = "<fb:login-button class='fb-login-button' scope='public_profile, email, pages_messaging, pages_show_list,pages_messaging,pages_read_engagement' onlogin='checkLoginState()'></fb:login-button>";

});
});
