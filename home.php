<?php
// Require security helpers
require_once('authenticator.php');
$authenticator = new AuthenticatorHelper();
$database = new DatabaseHelper();
// Secured content, redirect unauthenticated users
$authenticator->redirectUnauthenticatedUser();
//$db = new DatabaseHelper();
include('header.php');


/** pun of the day
 * Will use the date function to check what the present
 * date is, and pull the row where the date matches.
 * Then return this and echo within the HTML */

?>
<!-- Page Content -->
    <div class="container page-content text-center">
      <?php if($_GET['not-admin']=='yes'):?>
        <div class="popup header-dropshadow"><p>Sorry, you don't have permission to enter that page.</p> </div>
      <?php endif; ?>
      <?php if($_GET['loggedin']=='yes'):?>
        <div class="popup"><p>Succesfully logged in.</p> </div>
      <?php endif; ?>
      <div class="pun-of-the-day">
        <h2>Pun of the day</h2>
        <p><?= $databaseQueries->punOfTheDay();?></p>
      </div>
      <hr class="hr-fade">
      <div class="topic challenge">
        <h2><a href="?topic-challenge3">Topic Challenge #3 <br>Trees</a></h2>
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
        </div>
        <form class="pun-input">
          <div class="form-group">
              <input type="text" class="form-control text-center" placeholder="Post your pun here"></input>
          </div>
           <button type="submit" class="btn btn-default">Submit</button>
        </form>
      </div>
      <hr class="hr-fade">
      <div class="image challenge">
        <h2><a href="?image-challenge3">Image Challenge #3</a></h2>
        <img class="grayscale img-responsive" src="images/image-challenge-2.jpg"/>
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
        </div>
        <form class="pun-input">
          <div class="form-group">
              <input type="text" class="form-control text-center" placeholder="Post your pun here"></input>
          </div>
           <button type="submit" class="btn btn-default">Submit</button>
        </form>
      
      </div>
      <?php
      include('footer.php');
      ?>