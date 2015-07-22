<?php
// Require security helpers
require_once('authenticator.php');
require_once('database-queries.php');
$authenticator = new AuthenticatorHelper();
// Secured content, redirect unauthenticated users
$authenticator->redirectUnauthenticatedUser();
//$db = new DatabaseHelper();
$databaseQueries = new DatabaseQueries();
include('header.php');

if($_POST){
        // Setting the $_POST data to $data so as to set the values
        // in the form set to what was previously entered.
        
        $data = $_POST; 
        $databaseQueries->addBio($data);
    }

?>
 <!-- Page Content -->
    <div class="container page-content text-center">
    <?php if($_GET['bio']=='yes'):?>
        <div class="popup"><p>Biography update successful.</p> </div>
      <?php elseif($_GET['bio']=='no'):?>
        <div class="popup"><p>Error updating biography.</p> </div>
        <?php endif; ?>
        <div id="profile-container">
            <div class="row" id="profile-row">
              <h2 class="pull-left"><?=$_GET['username']?></h2>
            </div>
          <div class="row" id="image-badge-wrapper">
              <img id="profile-image" class="pull-left" src="http://placehold.it/200x200"></img>
              <div class="pull-right header-dropshadow" id="badges-container">
                  <h3>Badges</h3>
                  <img src="http://placehold.it/50x50"></img>
                  <img src="http://placehold.it/50x50"></img>
                  <img src="http://placehold.it/50x50"></img>
              </div>
            </div>
          <?php if($_SESSION['username'] == $_GET['username']):?>
              <form method="POST" id="bio">
                <textarea class="form-control" rows="5" placeholder="Write your bio here.." name="bio" value="<?=$data['bio']?>" required></textarea>
                <input type="submit" class="btn btn-md btn-primary btn-lg custom-button">
              </form>
              <?php else: ?>
              <p id='bio'><?= 'the bio from the database' ?></p>
              <?php endif; ?>   
        </div>
        
        <hr class="hr-fade">
        
        <h2>Best Puns</h2>
        
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
            <div id="clear-floats"></div>
        </div>
<?php
include('footer.php');
?>