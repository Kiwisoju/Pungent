<?php
require_once('authenticator.php');
include('header.php');
$authenticator = new AuthenticatorHelper();
if($authenticator->isAuthenticated()){
$message = "Welcome";
header('Location: /home.php?message='.$message);
}?>

<?php if($_GET['message']):?>
        <div class="popup"><p><?= $_GET['message']?></p> </div>
<?php endif; 

include('footer.php');

?>