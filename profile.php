<?php
// Require security helpers
require_once('authenticator.php');
$authenticator = new AuthenticatorHelper();
// Secured content, redirect unauthenticated users
$authenticator->redirectUnauthenticatedUser();
//$db = new DatabaseHelper();
include('header.php');
?>
 <!-- Page Content -->
    <div class="container page-content text-center">
        <div id="profile-container">
            <div class="row" id="profile-row">
              <h2 class="pull-left">Username</h2>
              <div class="pull-right header-dropshadow" id="badges-container">
                  <h3>Badges</h3>
                  <img src="http://placehold.it/50x50"></img>
                  <img src="http://placehold.it/50x50"></img>
                  <img src="http://placehold.it/50x50"></img>
              </div>
          </div>
          <div class="row">
              <img id="profile-image" class="pull-left" src="http://placehold.it/200x200"></img>
              <p class="" id="bio">Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
              sed diam nonummy nibh euismod tincidunt ut laoreet dolore
              magna aliquam erat volutpat. Ut wisi enim ad minim veniam,
              quis nostrud exerci tation ullamcorper suscipit lobortis nisl
              ut aliquip ex ea commodo consequat. Duis autem vel eum iriure
              dolor in hendrerit in vulputate velit esse molestie consequat,
              vel illum dolore eu feugiat nulla facilisis.
              </p>
          </div>
        </div>
        
        <hr class="hr-fade">
        
        <h2>Best Puns</h2>
        
        <div class="pun-post">
            <p class="pun-date pull-left">26/06/2015</p>
            <div class="pun-inner row">
              <p class="pun-text pull-left col-xs-9 text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              <div class="rating-group">
                <a href="#"><i class="fa fa-thumbs-up fa-2"></i></a>
                <a href="#"><i class="fa fa-thumbs-down fa-2"></i></a>
                <a href="#" class="rating-number">+31</a>
              </div>          
            </div>
            <p class="username pull-right"><a href="?username-profile">Username</a></p>
        </div>
         <div class="pun-post">
            <p class="pun-date pull-left">26/06/2015</p>
            <div class="pun-inner row">
              <p class="pun-text pull-left col-xs-9 text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              <div class="rating-group">
                <a href="#"><i class="fa fa-thumbs-up fa-2"></i></a>
                <a href="#"><i class="fa fa-thumbs-down fa-2"></i></a>
                <a href="#" class="rating-number">+31</a>
              </div>          
            </div>
            <p class="username pull-right"><a href="?username-profile">Username</a></p>
        </div>
         <div class="pun-post">
            <p class="pun-date pull-left">26/06/2015</p>
            <div class="pun-inner row">
              <p class="pun-text pull-left col-xs-9 text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              <div class="rating-group">
                <a href="#"><i class="fa fa-thumbs-up fa-2"></i></a>
                <a href="#"><i class="fa fa-thumbs-down fa-2"></i></a>
                <a href="#" class="rating-number">+31</a>
              </div>          
            </div>
            <p class="username pull-right"><a href="?username-profile">Username</a></p>
            <div id="clear-floats"></div>
        </div>
<?php
include('footer.php');
?>