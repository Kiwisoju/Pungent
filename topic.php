<?php
// Require security helpers
require_once('authenticator.php');
require_once('puns.php');
$authenticator = new AuthenticatorHelper();
$puns = new PunsHelper();
// Secured content, redirect unauthenticated users
$authenticator->redirectUnauthenticatedUser();
//$db = new DatabaseHelper();
include('header.php');

if($_POST){
        // Setting the $_POST data to $data so as to set the values
        // in the form set to what was previously entered.
        $data = $_POST;
        if(array_key_exists('delete', $data)){
        //die(var_dump($data));
        $table = $data['table'];
        $id['id'] = $data['id'];
          if($puns->removePun($table, $id)){
            $message = "Pun deleted";
            header('Location: /home.php?message='.$message);
          }
        }elseif(array_key_exists('edit', $data)){
          
          header('Location: /edit-pun.php?table='.$data['table'].'&id='.$data['id']);
        }else{
        $databaseQueries->addPun($data);}
    }
    if($_GET){
  if($_GET['rating'] == 'up')
  {
    
  $puns->ratePun();
  }elseif($_GET['rating'] == 'down'){
     $puns->ratePun();
  }
}    
?>
 <!-- Page Content -->
    <div class="container page-content text-center">
        <?php if($_GET['pun']=='yes'):?>
        <div class="popup"><p>Pun post successful!</p> </div>
      <?php elseif($_GET['pun']=='no'): ?>
      <div class="popup"><p>Pun post un-successful</p> </div>
      <?php elseif($_GET['message']): ?>
      <div class="popup"><p><?= $_GET['message']?></p> </div>
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
         $totalPuns = $puns->totalPuns('topic');
         $puns->getPuns($totalPuns,'topic');

include('footer.php');
?>