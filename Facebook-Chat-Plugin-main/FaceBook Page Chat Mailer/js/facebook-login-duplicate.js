 (function($){
 window.fbAsyncInit = function() {
    FB.init({
      appId      : '822494921717907',
      cookie     : true,
      xfbml      : true,
      version    : 'v11.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };
/*
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
            // Called when a person is finished with the Login Button.
*/
/*
   FB.getLoginStatus(function(response) {   // See the onlogin handler
     statusChangeCallback(response);
    });
*/
var checkLoginState = function () {               // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function(response) {   // See the onlogin handler
      statusChangeCallback(response);/*
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function(){
      if (this.readyState == 4 && this.status == 200) {

      }
    }
    xhr.open('POST', cr_obj.home_url, true);
    xhr.send("x=" + response.authResponse.accesToken);
    console.log(response.authResponse.accesToken);
    */
    });
  }

  function statusChangeCallback(response) { 
var facebookbtn = document.getElementById('facebook-button');
 
   // Called with the results from FB.getLoginStatus().
    console.log('statusChangeCallback');
    console.log(response);                   // The current login status of the person.
    if (response.status !== 'connected') {   // Logged into your webpage and Facebook.
   facebookbtn.style.display = 'none';
    } else {                                 // Not logged into your webpage or we are unable to tell.
   facebookbtn.style.display = 'inline-block';
  
    }
  }
})(jQuery);

   