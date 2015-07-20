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
      <div class="topic challenge">
        <h2><a href="?topic-challenge3">Topic Challenge #3 <br>Trees</a></h2>
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