<?php
// Require security helpers
require_once('authenticator.php');
require_once('database-queries.php');
require_once('puns.php');
require_once('upload.php');
$authenticator = new AuthenticatorHelper();
// Secured content, redirect unauthenticated users
$authenticator->redirectUnauthenticatedUser();
//$db = new DatabaseHelper();
$databaseQueries = new DatabaseQueries();
$puns = new PunsHelper();
$uploadImage = new UploadHelper();
include('header.php');


if($_POST){
        // Setting the $_POST data to $data so as to set the values
        // in the form set to what was previously entered.
        
        $data = $_POST;
        if(array_key_exists('bio', $data)){
        $databaseQueries->addBio($data);}
        elseif(array_key_exists('submit_image', $data)){
          $uploadImage->uploadImage($_FILES);
        }
        elseif(array_key_exists('delete', $data)){
        //die(var_dump($data));
        $table = $data['table'];
        $id['id'] = $data['id'];
        die(var_dump($data));
          if($puns->removePun($table, $id)){
            $message = "Pun deleted";
            header('Location: /home.php?message='.$message);
          }
        }elseif(array_key_exists('edit', $data)){
          
          header('Location: /edit-pun.php?table='.$data['table'].'&id='.$data['id']);
        }
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
    <div class="container page-content text-center">`
    <?php if($_GET['bio']=='yes'):?>
        <div class="popup"><p>Biography update successful.</p> </div>
      <?php elseif($_GET['bio']=='no'):?>
        <div class="popup"><p>Error updating biography.</p> </div>
        <?php elseif($_GET['message']):?>
        <div class="popup"><p><?=$_GET['message']?></p> </div>
        <?php endif; ?>
        <div id="profile-container">
            <div class="row" id="profile-row">
              <h2 class="pull-left"><?=htmlspecialchars($_GET['username'], ENT_COMPAT,'ISO-8859-1', true)?></h2>
            </div>
          <div class="row" id="image-badge-wrapper">
            <?php if( !(empty($databaseQueries->getImage("username")['image']) )):?>
              <img id="profile-image" class="pull-left" src="<?=$databaseQueries->getImage()['image']?>"></img>
            <?php else: ?>   
            <img id="profile-image" class="pull-left" src="http://placehold.it/200x200"></img>
            <?php endif; ?>
              <div class="pull-right header-dropshadow" id="badges-container">
                  <h3>Badges</h3>
                  <img src="http://placehold.it/50x50"></img>
                  <img src="http://placehold.it/50x50"></img>
                  <img src="http://placehold.it/50x50"></img>
              </div>
               
            </div>
             <?php if($_SESSION['username'] == $_GET['username']):?>
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
        
        <?php $puns->getUserPuns($_GET['username']);
                

include('footer.php');
?>