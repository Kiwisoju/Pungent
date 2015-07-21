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
        <div id="about-container">
          <h2>About</h2>
          <p>Pungent is a socially moderated pun competition.<br><br><br> What does that
          mean? <br><br>It means that each week there will be a topic and image based
          challenge for all users to post their puns. These will be rated
          by your fellow punters and at the end of each week a winner will emerge!<br><br>
          That's about it..
          
          </p>
        </div>
<?php
include('footer.php');
?>