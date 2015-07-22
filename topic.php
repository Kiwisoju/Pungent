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
      <div class="topic challenge">
       <h2><a href="?topic_challenge3">Topic Challenge #<?=$databaseQueries->getChallenge("topic_challenge")['topic_id'] ?><br><?= $databaseQueries->getChallenge("topic_challenge")['topic']?></a></h2>
        <a href="?previoustopic"><i class="fa fa-chevron-left pull-left fa-2"></i></a>
        <a href="?anothertopic"><i class="fa fa-chevron-right pull-right fa-2"></i></a>
        <form class="pun-input" method="post">
          <div class="form-group">
              <input type="text" class="form-control text-center" name="pun-topic" value="<?= $data['pun-topic']?>" placeholder="Post your pun here" required></input>
          </div>
           <input type="submit" class="btn btn-default">
        </form>
        
        <hr class="hr-fade">
        
         <?php
         $totalPuns = $displayPuns->totalPuns('topic');
         $displayPuns->getPuns($totalPuns,'topic');

include('footer.php');
?>