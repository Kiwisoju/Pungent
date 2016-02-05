<?php
require_once('database-queries.php');
require_once('upload.php');

$databaseQueries = new DatabaseQueries();
$uploadImage = new UploadHelper();

include('header.php');

if($_POST){
        // Setting the $_POST data to $data for sticky form
        $data = $_POST;
        
        if(array_key_exists('bio', $data)){
          $databaseQueries->addBio($data);}
        elseif(array_key_exists('submit_image', $data)){
          $uploadImage->uploadImage($_FILES);
        }
        elseif(array_key_exists('delete', $data)){
          $table = $data['table'];
          $id['id'] = $data['id'];
          die(var_dump($data));
          
          if($databaseQueries->removePun($table, $id)){
            $message = "Pun deleted";
            header('Location: /home.php?message='.$message);
          }
        }elseif(array_key_exists('edit', $data)){
          header('Location: /edit-pun.php?table='.$data['table'].'&id='.$data['id']);
        }
    }
if($_GET){
  if($_GET['rating'] == 'up'){
    $databaseQueries->ratePun();
  }elseif($_GET['rating'] == 'down'){
    $databaseQueries->ratePun();
  }
}    
?>
 <!-- Page Content -->
    <div class="container page-content text-center"><?php
      // If user isn't logged in, display sign up/login
      if(!$authenticator->isAuthenticated() ): ?>
      <div>
        <p>You are not logged in.</p>
        <a class="btn btn-primary" href="pungent/signup.php">Sign Up</a>
        <a class="btn btn-primary" href="pungent/login.php">Log in</a>
      </div><?php 
      else:  if($_GET['bio'] == 'yes'):?>
        <div class="well pop-up"><p>Biography update successful.</p> </div>
      <?php elseif($_GET['bio'] == 'no'):?>
        <div class="well pop-up"><p>Error updating biography.</p> </div>
        <?php elseif($_GET['message']):?>
        <div class="well pop-up"><p><?=$_GET['message']?></p> </div>
        <?php endif; ?>
        <div id="profile-container">
            <div class="row" id="profile-row">
              <h2 class="pull-left"><?= htmlspecialchars($_GET['username'], ENT_COMPAT,'ISO-8859-1', true)?></h2>
            </div>
          <div class="row" id="image-badge-wrapper">
            <?php if( !(empty($databaseQueries->getImage("username")['image']) )):?>
              <img id="profile-image" class="pull-left" src="<?= $databaseQueries->getImage()['image']?>"></img>
            <?php else: ?>   
            <img id="profile-image" class="pull-left" src="http://placehold.it/200x200"></img>
            <?php endif; ?>
            </div>
             <?php if($_SESSION['username'] == $_GET['username'] || $_SESSION['user']['admin']):?>
             <div class="row">
              <form class="pull-left" method="post" enctype="multipart/form-data">
                    <label class="pull-left" for="fileToUpload">Select image to upload:</label>
                    <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" class="btn btn-primary pull-left" value="Upload Image" name="submit_image">
              </form>
              </div>
          <div class="row">
              <form method="POST" id="bio">
                <textarea class="form-control" rows="5" placeholder="Write your bio here.." name="bio" required><?= htmlspecialchars($databaseQueries->getBio($_GET['username'])['bio'], ENT_COMPAT,'ISO-8859-1', true); ?></textarea>
                <input type="submit" class="btn btn-md btn-primary btn-lg custom-button">
              </form>
          
              <?php elseif(!($_SESSION['username'] == $_GET['username'])): ?>
              <div class="row">
              <p id='bio'><?= htmlspecialchars($databaseQueries->getBio($_GET['username'])['bio'], ENT_COMPAT,'ISO-8859-1', true)?></p>
              <?php endif; ?>  
              </div>
        </div>
        
        <hr class="hr-fade">
        
        <h2>Best Puns</h2>
        
        <?php $databaseQueries->getUserPuns($_GET['username']);
        
              
include('footer.php');
endif;