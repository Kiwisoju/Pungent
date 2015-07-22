<?php
require_once('database.php');

class DatabaseQueries{
    
private $db;    

    //instantiates a connection to the database
    public function DatabaseQueries(){
    $this->db = new DatabaseHelper();    
        
    }
    
    /**
     * Method to create a user
     * First queries the database to check whether
     * a user already exists with the same username.
     * Also checks whether each field has been filled, 
     * and also whether the two passwords match.
     * Then drops the matching password and hashes the other 
     * before inserting it into the database. Then it calls
     * upon the insert() method to insert the data into
     * the database.
     * @param array $formData Contains the username, passwords
     **/
     
     public function addUser(){
      
     // Creating an empty array to store error messages.
        $errorMessage = [];
        // Checking if username has been filled
        if(empty($_POST['username']) ){
            $errorMessage[] = "Please enter a username";
            print_r($errorMessage);
        
        // Checking if password has been filled
        }elseif(empty($_POST['password']) ){
            $errorMessage[] = "Please enter a password";
           print_r($errorMessage);
        
        // Checking if same password has been filled
        }elseif(empty($_POST['password-match']) ){
            $errorMessage[] = "Please enter your matching password";
          print_r($errorMessage);
        // Checking if passwords match
        }elseif(!($_POST['password'] === $_POST['password-match']) ){
            $errorMessage[] = "Your passwords do not match";
            print_r($errorMessage);
        }
        $username = $_POST['username'];
    if(!($this->db->queryRow("SELECT `username` FROM `users` Where `username` = '$username'") )){
     // Unsetting the matching password so as to not insert it into the
    // database.
    unset($_POST['password-match']);    
    
    // Hash the password first. Need to remove this from the insert function
    
    // Inserting user to the database
    $this->db->insert('users',$_POST,"Successfully added new user");
    }else{
     print("User already taken");
    }    
    
    }
      
      /**
       * Method to get all user properties
       * 
       */ 
      public function getUser(){
          $username = $_SESSION['username'];
          $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
          if($result = $this->db->queryRow($sql) ){
          return $result;      
          }
      }
      
     /**
      * Method to edit user properties.
      * Properties being bio and profile picture.
      * First needs to read/get all properties
      * then allow for edits.
      */ 
     public function editUser(){
      
     }
    
    
    /**
     * Will delete a user from the database
     */
     
    public function deleteUser(){
     
     
    }
    
    /**
     * Method to insert biography to the database
     */
     
    public function addBio(){
     
    }
    
    /**
     * Method to return biography from the database
     */
     
    public function readBio(){
     
    }
    
    
    
    
    /**
     * Method to add pun to a topic/challenge
     */
    public function addPun($data){
     	$type = ( isset($data['pun-topic']) ) ? 'topic' : 'image';
     	$table = "{$type}_pun_post";
			$data["pun"] = $data["pun-{$type}"];
			$data["{$type}_id"] = $this->getChallenge("{$type}_challenge")['id'];
			unset($data["pun-{$type}"]);
    	
			//Setting up the rest of the formData
			// To get the topic-id the pun post was set for..
			$data["username"] = $_SESSION['username'];
			$data["rating"] = 0;
			//Inserting data into the database
			$this->db->insert($table, $data,"Pun succesfully posted");
			//Redirect with successmessage
			$section = substr($_SERVER['PHP_SELF'], 1);
			header('Location: /'.$section.'?pun=yes');
    }
    
    /**
     * Method to edit/update pun
     */
     
    public function editPun(){
     
     
    }
    
    /**
     * Method to delete pun from database
     * Need to think about what parameters will be
     * needed. Table name? and pun post? Wait until
     * I've figured how to add and display puns first.
     */
    public function deletePun(){
     
     
    }
    
    /**
     * Method to read from the database and display
     * the number of puns needed.
     * @param int $n Number of puns needed
     **/
     
    public function displayPuns($n){
     
    }
    /**
     * Method to return the pun-of-the-day depending
     * on the current date
     **/
     public function punOfTheDay(){
         // Makes sure that timezone is set to NZ
         date_default_timezone_set("Pacific/Auckland");
         // Getting current date for sql query
         $currentDate = date('Y-m-d');
         $sql = "SELECT `pun_of_the_day` FROM `pun_of_the_day` WHERE `date` = '$currentDate'";
         if($result = $this->db->queryRow($sql) ){
         return $result['pun_of_the_day'];
             
         }else{
             
         }
     
     }
     
     
     /**
      * Method to return all related info for current
      * challenge based on the parameter. Either from
      * topic or image tables.
      * @param string $table Name of the table to query
      *
      */
      
      public function getChallenge($table){
          // Makes sure that timezone is set to NZ
          date_default_timezone_set("Pacific/Auckland");
          $currentWeek = date('W');
          $sql = "SELECT * FROM `$table` WHERE `week` = '$currentWeek'";
          if($result = $this->db->queryRow($sql) ){
          return $result;      
          }
      }
      
      /**
      * Method to return all related info for 
      * challenge based on the parameter. Either
      * topic or image.
      * @param string $table Name of the table to query
      *
      */
      
      public function getAllFromChallenge($table){
          // Makes sure that timezone is set to NZ
          if($result = $this->db->getAllByTableName($table) ){
          return $result;      
          }
      }
      
      /**
       * Converts images into base_64
       */
       public function convertImage($image){
        $path = 'images/'.$image.'';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
       }
      
      
      /**
       * Takes an image, and converts it to Base_64
       * and uploads the image to the database
       * 
       * @param string $table Table to insert image into
       * @param string $image String containing images filepath
       **/ 
   public function uploadImage($table, $image){
    $successMessage = 'Image successfully uploaded';
    // Converting the image to Base64
    $formData['image'] = $this->convertImage($image);
    // Need to get this to query the database and check whether the week has been taken
    // and then if so it will need to increase the week number by 1
    $latestPost = $this->db->queryRow("SELECT `id`, `week` FROM `image_challenge` ORDER BY id DESC LIMIT 1");
   
    // Setting the week for the newest post
    $formData['week'] = $latestPost['week'] + 1;
    // Run the insert method to insert the image to the database
    if($this->db->insert("image_challenge", $formData, $successMessage) ){
    return $successMessage;
    }
    
   }
    
    /**
     * Method for converting uploaded image into Base_64 before
     * inserting into the database.
     */ 
    
     
    
    
    
}

?>