<?php
// Require security helpers
require_once('authenticator.php');
require_once('puns.php');
$authenticator = new AuthenticatorHelper();
$database = new DatabaseHelper();
$puns = new PunsHelper();
// Secured content, redirect unauthenticated users
$authenticator->redirectUnauthenticatedUser();
//$db = new DatabaseHelper();
include('header.php');

if($_GET['table']=='topic')
$table = $_GET['table'];
elseif($_GET['table']=='image')
$table = $_GET['table'];

$whereVal = $puns->findPunById()['pun'];
if(array_key_exists( 'pun', $_POST)){
    $data = $_POST;
     if($puns->updatePun($table, $data, $whereVal)){
         $message = 'Pun successfully updated';
         header("Location: /home.php?message=".$message);
     }
}
?>
<div class="container page-content text-center">
    <div class="row">
<form class="pun-input" method="post">
          <div class="form-group">
              <input type="text" class="form-control text-center" name="pun" value="<?=$puns->findPunById()['pun']?>" placeholder="Post your pun here" required></input>
          </div>
           <input type="submit" class="btn btn-default">
        </form>
        </div>
</div>
<?php
include('footer.php');
?>