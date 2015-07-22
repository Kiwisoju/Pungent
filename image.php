<?php
// Require security helpers
require_once('authenticator.php');
$authenticator = new AuthenticatorHelper();
// Secured content, redirect unauthenticated users
$authenticator->redirectUnauthenticatedUser();
//$db = new DatabaseHelper();
include('header.php');

if($_POST){
        // Setting the $_POST data to $data so as to set the values
        // in the form set to what was previously entered.
        $data = $_POST; 
        $databaseQueries->addPun($data);
    }
?>
 <!-- Page Content -->
    <div class="container page-content text-center">
        <?php if($_GET['pun']=='yes'):?>
        <div class="popup"><p>Pun post successful!</p> </div>
      <?php elseif($_GET['pun']=='no'): ?>
      <div class="popup"><p>Pun post un-successful</p> </div>
      <?php endif; ?>
      <div class="image challenge">
         <h2><a href="?image-challenge3">Image Challenge #<?= $databaseQueries->getChallenge("image_challenge")['id']?></a></h2>
        
        <a href="?previousimage"><i class="fa fa-chevron-left pull-left fa-2"></i></a>
        <a href="?anotherimage"><i class="fa fa-chevron-right pull-right fa-2"></i></a>
        <img class="grayscale img-responsive" src="<?=$databaseQueries->getChallenge("image_challenge")['image'];?>"/>
        <form class="pun-input" method="post">
          <div class="form-group">
              <input type="text" class="form-control text-center" name="pun-image" value="<?= $data['pun-image']?>" placeholder="Post your pun here" required></input>
          </div>
           <input type="submit" class="btn btn-default">
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