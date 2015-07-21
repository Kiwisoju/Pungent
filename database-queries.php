<?php
require_once('database.php');

class DatabaseQueries{
    
private $db;    

    //instantiates a connection to the database
    public function DatabaseQueries(){
    $this->db = new DatabaseHelper();    
        
    }
    
    /**
     * Method to return the pun-of-the-day depending
     * on the current date
     **/
     public function punOfTheDay(){
     $currentDate = date('Y-m-d');
     $sql = "SELECT `pun-of-the-day` FROM `Pun-of-the-day` WHERE `date` = '$currentDate'";
     if($result = $this->db->queryRow($sql) ){
     return $result['pun-of-the-day'];
         
     }else{
         
     }
     
     }
     
     
     /**
      * Method to return the the pun challenge
      * depending on the current date
      */
      
      
    
    
    
    
}

?>