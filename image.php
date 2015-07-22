<?php
// Require security helpers
require_once('authenticator.php');
require_once('display-puns.php');
$authenticator = new AuthenticatorHelper();
$displayPuns = new DisplayPuns();
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
         <h2><a href="?image-challenge3">Image Challenge #<?= $databaseQueries->getChallenge("image_challenge")['image_id']?></a></h2>
        
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
        
         <?php
         $totalPuns = $displayPuns->totalPuns('image');
         $displayPuns->getPuns($totalPuns,'image');

include('footer.php');
?>