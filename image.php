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
      <div class="image challenge">
        <h2><a href="?image-challenge3">Image Challenge #3</a></h2>
        <a href="?previousimage"><i class="fa fa-chevron-left pull-left fa-2"></i></a>
        <a href="?anotherimage"><i class="fa fa-chevron-right pull-right fa-2"></i></a>
        <img class="grayscale img-responsive" src="images/image-challenge-2.jpg"/>
                <form class="pun-input">
          <div class="form-group">
              <input type="text" class="form-control text-center" placeholder="Post your pun here"></input>
          </div>
           <button type="submit" class="btn btn-default">Submit</button>
        </form>
        
        <hr class="hr-fade">
        
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
      </div>
<?php
include('footer.php');
?>