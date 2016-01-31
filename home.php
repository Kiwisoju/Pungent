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
        if(array_key_exists('delete', $data)){
        //die(var_dump($data));
        $table = $data['table'];
        $id['id'] = $data['id'];
          if($databaseQueries->removePun($table, $id)){
            $message = "Pun deleted";
            header('Location: /home.php?message='.$message);
          }
        }elseif(array_key_exists('edit', $data)){
          
          header('Location: /pungent/edit-pun.php?table='.$data['table'].'&id='.$data['id']);
        }else{
        $databaseQueries->addPun($data);}
    }
if($_GET){
  if($_GET['rating'] == 'up')
  {
    
  $databaseQueries->ratePun();
  }elseif($_GET['rating'] == 'down'){
     $databaseQueries->ratePun();
  }
}    
/** pun of the day
 * Will use the date function to check what the present
 * date is, and pull the row where the date matches.
 * Then return this and echo within the HTML */

?>
<!-- Page Content -->
    <div class="container page-content text-center">
      <?php if($_GET['not-admin']=='yes'):?>
        <div class="popup"><p>Sorry, you don't have permission to enter that page.</p> </div>
      <?php elseif($_GET['message']):?>
        <div class="popup"><p><?= $_GET['message']?></p> </div>
      <?php elseif($_GET['pun']=='yes'):?>
        <div class="popup"><p>Pun post successful!</p> </div>
      <?php elseif($_GET['pun']=='no'): ?>
        <div class="popup"><p>Pun post un-successful</p> </div>
      <?php endif; ?>
      <div class="pun-of-the-day">
        <h2>Pun of the day</h2>
        <p><?= $databaseQueries->punOfTheDay();?></p>
      </div>
      <hr class="hr-fade">
      <div class="topic challenge">
        <h2><a href="admin.php?action=topic">Topic Challenge #<?=$databaseQueries->getChallenge("topic_challenge")['topic_id'] ?><br><?= $databaseQueries->getChallenge("topic_challenge")['topic']?></a></h2>
        <?php $databaseQueries->getCurrentPuns(3, 'topic');?>
        <form class="pun-input" method="post">
          <div class="form-group">
              <input type="text" class="form-control text-center" name="pun-topic" value="<?= $data['pun-topic']?>" placeholder="Post your pun here" required></input>
          </div>
           <input type="submit" class="btn btn-default">
        </form>
      </div>
      <hr class="hr-fade">
      <div class="image challenge">
        <h2><a href="admin.php?action=image-page">Image Challenge #<?= $databaseQueries->getChallenge("image_challenge")['image_id']?></a></h2>
        <img class="grayscale img-responsive" src="<?=$databaseQueries->getChallenge("image_challenge")['image']?>"/>
      <?php $databaseQueries->getCurrentPuns(3, 'image');?>
        <form class="pun-input" method="post">
          <div class="form-group">
              <input type="text" class="form-control text-center" name="pun-image" value="<?= $data['pun-image']?>" placeholder="Post your pun here" required></input>
          </div>
           <input type="submit" class="btn btn-default">
        </form>  
      
      </div>
      <?php
      include('footer.php');
      ?>