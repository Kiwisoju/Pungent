<?php
include('header.php');

$authenticator->redirectUnauthenticatedUser();

if($_GET['table']=='topic')
$table = $_GET['table'];
elseif($_GET['table']=='image')
$table = $_GET['table'];

$whereVal = $databaseQueries->findPunById()['pun'];
if(array_key_exists( 'pun', $_POST)){
    $data = $_POST;
     if($databaseQueries->updatePun($table, $data, $whereVal)){
         $message = 'Pun successfully updated';
         header("Location: pungent/index.php?message=".$message);
     }
}
?>
<div class="container page-content text-center">
    <div class="row">
<form class="pun-input" method="post">
          <div class="form-group">
              <input type="text" class="form-control text-center" name="pun" value="<?=$databaseQueries->findPunById()['pun']?>" placeholder="Post your pun here" required></input>
          </div>
           <input type="submit" class="btn btn-default">
        </form>
        </div>
</div>
<?php
include('footer.php');
?>