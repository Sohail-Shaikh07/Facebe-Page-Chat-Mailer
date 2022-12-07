  window.fbAsyncInit = function() {
    FB.init({
      appId      : '822494921717907',
      cookie     : true,
      xfbml      : true,
      version    : 'v11.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };



  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
            // Called when a person is finished with the Login Button.
   FB.getLoginStatus(function(response) {   // See the onlogin handler
     statusChangeCallback(response);
    });

function checkLoginState(response) {               // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function(response) {   // See the onlogin handler
      statusChangeCallback(response);
      console.log(cr_obj);
      /*
       var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function(){
      if (this.readyState == 4 && this.status == 200) {

      }
    }
    xhr.open('POST', cr_obj.home_url, true);
    xhr.send("x=" + response.authResponse.accessToken);
    console.log(response.authResponse.accesToken);
    */
    });
  }
  function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    var facebookbtn = document.getElementById('facebook-button');
  
    console.log('statusChangeCallback');
    console.log(response);                   // The current login status of the person.
   }
   