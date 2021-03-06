<?php
require_once('database.php');
require_once('database-queries.php');
class UploadHelper{

private $db;
private $dbq;

public function UploadHelper(){
    $this->db = new DatabaseHelper();
    $this->dbq = new DatabaseQueries();
}

/**
 * Method to upload an image to the users table
 * in the database.
 * 
 */
public function uploadImage(){
    $upload = 1;
    $targetFile =  basename($_FILES["fileToUpload"]["name"]);
    $tmpFile = $_FILES['fileToUpload']['tmp_name'];
    $imageFileType = pathinfo($targetFile,PATHINFO_EXTENSION);
    //start  by limiting the size 
    if ($_FILES["fileToUpload"]["size"] > 500000) {
    $upload = 0;
    $message =  "Sorry, your file is too large.";
    header('Location: '. $_SERVER['HTTP_REFERER'].'&message='.$message);
    }
    //then checking the type
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check == false) {
        $upload = 0;
        $message =  "File is not an image.";
        header('Location: '. $_SERVER['HTTP_REFERER'].'&message='.$message);
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $upload = 0;
        $message = "Sorry, only JPG, JPEG, & PNG files are allowed.";
        header('Location: '. $_SERVER['HTTP_REFERER'].'&message='.$message);
    }

    // Upload image, takes care of Base64 conversion then uploads
    // to the database.
    if($upload){
    
        if ($this->dbq->uploadImage('users',$tmpFile)) {
            $message = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            header('Location: '. $_SERVER['HTTP_REFERER'].'&message='.$message);
        } else {
            $message = "Sorry, there was an error uploading your file.";
            header('Location: '. $_SERVER['HTTP_REFERER'].'&message='.$message);
            
        }
    }else{
        return;
    
    }
}


}


?>