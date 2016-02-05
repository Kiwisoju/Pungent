<?php
include('header.php');

if($_POST){
        // Setting the $_POST data to $data so as to set the values
        // in the form set to what was previously entered.
        $data = $_POST;
        if(array_key_exists('delete', $data)){
        $table = $data['table'];
        $id['id'] = $data['id'];
          if($databaseQueries->removePun($table, $id)){
            $message = "Pun deleted";
            header('Location: /topic.php?message='.$message);
          }
        }elseif(array_key_exists('edit', $data)){
          
          header('Location: /edit-pun.php?table='.$data['table'].'&id='.$data['id']);
        }else{
        $databaseQueries->addPun($data);}
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
    <div class="container page-content text-center">
        <?php if($_GET['pun']=='yes'):?>
        <div class="popup"><p>Pun post successful!</p> </div>
      <?php elseif($_GET['pun']=='no'): ?>
      <div class="popup"><p>Pun post un-successful</p> </div>
      <?php elseif($_GET['message']): ?>
      <div class="popup"><p><?= $_GET['message']?></p> </div>
      <?php endif; ?>
      <div class="image challenge">
          <h2>Image Challenge #<?=$_GET['image']?></h2>
        
         <a href="?image=<?=$_GET['image']-1?>"><i class="fa fa-chevron-left pull-left fa-2"></i></a>
        <a href="?image=<?=$_GET['image']+1?>"><i class="fa fa-chevron-right pull-right fa-2"></i></a> 
        <img class="grayscale img-responsive" src="<?=$databaseQueries->getChallengeByNumber("image",$_GET['image'])['image'];?>"/>
        <form class="pun-input" method="post">
          <div class="form-group">
              <input type="text" class="form-control text-center" name="pun-image" value="<?= $data['pun-image']?>" placeholder="Post your pun here" required></input>
          </div>
           <input type="submit" class="btn btn-default">
        </form><?php
        $totalPuns = $databaseQueries->totalPuns('image',$_GET['image']);
        if($totalPuns == 0 ): ?>
        <div>
            <p>No one has submitted any puns yet!<br><br>
                <strong>Be the first!</strong>
            </p>
        </div><?php
        else: ?>
        <hr class="hr-fade"><?php
        $databaseQueries->getPunsById($totalPuns,'image',$_GET['image']);
        endif;
include('footer.php');