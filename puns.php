<?php
if($_POST){
  // Setting the $_POST data to $data so as to set the values
  // in the form set to what was previously entered.
  $data = $_POST;
  if(array_key_exists('delete', $data)){
    $table = $data['table'];
    $id['id'] = $data['id'];
    if($databaseQueries->removePun($table, $id)){
      $message = "Pun deleted";
      header('Location: ?message='.$message);
    }
  }elseif(array_key_exists('edit', $data)){
    
    header('Location: /edit-pun.php?table='.$data['table'].'&id='.$data['id']);
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