<?php 
if (isset($_GET['form-sent'])) {
    $all_pages = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}fb_pages_info"); 
         foreach ($all_pages as $page) {
            $email = $_GET['email-'.$page->page_id];
            if (isset($_GET["checkbox-".$page->page_id])) {
                $active = 1;
            }
            else {
                $active = 0;
            }
        $updated = $wpdb->update($wpdb->prefix.'fb_pages_info', ['email' => $email, 'active' => $active], ['page_id' => $page->page_id]);
         }
header('Location:'.get_dashboard_url(get_current_user_id(), 'admin.php?page=fb-page-chat'));

}


function cr_fb_page_display_menu(){
      global $wpdb;
	?> <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <div style="width:100%;text-align: center;padding: 20px 0px;background-color: darkblue;;" >
        <h1 style="color: white;font-size: 3em;" >Settings</h1>
    </div>
    <form action="?page=fb-page-chat" >
        <input type="hidden" name="page" value="fb-page-chat" >
        <input type="hidden" name="form-sent" value="true" >
    <div class="cr-setting-fields" >
        <div class="cr-settings-heading" >
            <div><h2>Name</h2></div>
            <div><h2>Active</h2></div>
            <div><h2>Email</h2></div>
        </div>
           <div class="cr_main_settings_div" style="width:100%" >
        <?php $all_pages = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}fb_pages_info"); 
         foreach ($all_pages as $page) {

            $checked = $page->active == 1? 'checked' : '';
            echo "<div class='cr_page_info_div' >";
            echo "<div><h2>". $page->name ."</h2></div>";
            echo "<div><input type='checkbox' ".$checked." name=checkbox-".$page->page_id." /> </div>";
            echo "<div>";
            echo "<input style='width:90%;' type='email' name=email-".$page->page_id." value=".$page->email." /> </div>";
            echo "</div>";
         }
        ?>
           
           </div>
           <div class="centered" style="text-align: center;" >
           <input class="blue button" type="submit" value="Save Option">
              <button class="fb-login-custom-button blue button " >
        Login
    </button>
   </div>
    </div>
</form>
 
 
    <div style="display:none;"
    class="fb-login-button"
    data-max-rows="1"
    data-size="large"
    data-button-type="continue_with"
    data-use-continue-as="true"
    ></div>
<div id="facebook-btn" >

</div>
	<?php
}