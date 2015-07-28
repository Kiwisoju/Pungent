<?php
require_once('authenticator.php');

session_start();
require_once __DIR__ . '/vendor/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '469336573246700',
  'app_secret' => '32c46b4268b6f882db3a6f2d1cdf3211',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://pungent-clone-kiwisoju.c9.io/fb-callback.php', $permissions);








include('header.php');
$authenticator = new AuthenticatorHelper();
if($authenticator->isAuthenticated()){
$message = "Welcome ".$_SESSION['username'];
header('Location: /home.php?message='.$message);
}?>

<?php if($_GET['message']):?>
        <div class="popup"><p><?= $_GET['message']?></p> </div>
<?php endif; 

include('footer.php');

?>