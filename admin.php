<?php 
//Require security helper functions
require_once('authenticator.php');
require_once('database-queries.php');
//Secured content, redirect unauthenticated users
$authenticator = new AuthenticatorHelper();
$databaseQueries = new DatabaseQueries();
if(!($authenticator->isAdmin() )){
    header('Location: /home.php?not-admin=yes');
   
}

switch($_GET['action']){
	case'home':
		header('Location: /home.php');
		break;
    case'challenges':
		header('Location: /challenges.php');
		break;
	case'topic':
		header('Location: /topic.php?topic='.$databaseQueries->getChallenge('topic_challenge')['topic_id']);
		break;
	case'topic-archive':
		header('Location: /topic-archive.php');
		break;
	case'image-page':
		header('Location: /image.php?image='.$databaseQueries->getChallenge('image_challenge')['image_id']);
		break;
	case'image-archive':
		header('Location: /image-archive.php');
		break;
	case'about':
		header('Location: /about.php');
		break;
	case'profile':
		header('Location: /profile.php?username='.$_SESSION['username']);
		break;
	case'sitemap':
		header('Location: /sitemap.php');
		break;	
}
    
if($_POST){
    $data = $_POST;
    if(array_key_exists('edit', $data)){
        header('Location: /edit-pun.php?table='.$data['table'].'&id='.$data['id']);
    }elseif(array_key_exists('username', $data)){
        $databaseQueries->removeUser($data);
    }elseif(array_key_exists('delete', $data)){
        $table = $data['table'];
        $id['id'] = $data['id'];
        if($databaseQueries->removePun($table, $id)){
            $message = "Pun deleted";
            header('Location: /admin.php?message='.$message);
        }
    }
}

include('header.php');
?>

 <!-- Page Content -->
    <div class="container page-content text-center">
        <?php if($_GET['message']): ?>
        <div class="popup"><p><?= $_GET['message']?></p> </div>
        <?php endif; ?>
            <h2>Administration</h2>
              <a class="btn btn-primary btn-lg" href="admin.php?users=yes">Users</a>
              <a class="btn btn-primary btn-lg" href="admin.php?puns=yes">Puns</a>
                <?php 
                if($_GET['puns']){
                    ?>
                    <div class="container">
                        <a class="btn btn-primary btn-lg" href="admin.php?puns=yes&challenge=image">Image</a>
                        <a class="btn btn-primary btn-lg" href="admin.php?puns=yes&challenge=topic">Topic</a>
                    </div>
                    <?php
                    if($_GET['challenge']){
                        $challenge = $_GET['challenge'];
                          ?>
                    <h2><?=$challenge?> Challenge Puns</h2>
                    <?php
                    $totalPuns = $databaseQueries->totalPuns($challenge,$id);
                    $displayPuns = $databaseQueries->getPunsById($totalPuns, $challenge,$id);
                    } 
                }elseif($_GET['users']){
                    $databaseQueries->getAllUsers();
                }?>
    </div>
<?
include('footer.php');
?>