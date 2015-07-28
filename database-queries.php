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
			public function addUser($formData){
        // Checking if passwords match, if not set errormessage
        // and redirect back to signup
        //die(var_dump($formData['password']!=$formData['password-match']));
        
        if($formData['password']!=$formData['password-match']){
            $message = "Your passwords do not match";
            
        }else{
		    //Getting the formData ready for insert. Removing matching
		    //password, hashing password and inserting username
		    
		    unset($formData['password-match']);    
        $formData['password']=password_hash($formData['password'], PASSWORD_DEFAULT );
		    
		    // Checking if username already exists, if not then insert to database, otherwise
		    // redirect with error message.
		    $username = $formData['username'];
		    if(!($this->db->queryRow("SELECT `username` FROM `users` Where `username` = '$username'") )){
					//Inserting user to the database and redirecting
					$this->db->insert('users',$formData,"User successfully added");
					$message = "User successfully added";
					exit(header("Location: /index.php?message=".$message));
		    }else{
		    	$message = "User already taken";
		    }
			}
			header( "Location: ?message=".$message );
			}
			
			
			public function getAllUsers(){
				$sql = "SELECT username FROM users";
				if($result = $this->db->queryRows($sql) ){
					//die(var_dump($result));
					$numUsers = count($result);
          for($i = 0; $i < $numUsers; $i++){
            $users = $result[$i];
            //die(var_dump($users['username']));
            echo '<div class="user">
            			<h2>'.$users['username'].'</h2>
            			<div class="row">
            			<a class="btn btn-default btn-lg" href="profile.php?username='.$users['username'].'">Edit/View User Profile</a>
									<form method="POST">
									<input type="hidden" name="username" value="'.$users['username'].'">
									<input type="submit" class="btn btn-danger btn-lg name="delete" value="Delete User">
									</form>
									</div>
            			</div>
            			<hr class="hr-fade">';
			}
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
     * Will delete a user from the database
     */
     
    public function removeUser($user){
     
     if($this->db->remove('users', $user))
       header('Location: /admin.php?message=User Successfully Deleted');
     
    }
    
    /**
     * Method to insert biography to the database
     * @param string $data Text to be inserted into users table
     */
     
    public function addBio($data){
    	$username = $_SESSION['username'];
    	
    	
			if( $this->db->update('users', $data, 'username', $username) ){
			//redirect success
			header('Location: /profile.php?username='.$username.'&bio=yes');
			}else{
				//redirect failure
				header('Location: /profile.php?username='.$username.'&bio=no');
			}
    }
    
    /**
     * Method to return biography from the database
     */
     
    public function getBio($username){
    	$sql = "SELECT `bio` FROM `users` WHERE `username` = '$username'";
          if($result = $this->db->queryRow($sql) ){
          return $result;      
          }
    }
    
    
    
    
    /**
     * Method to add pun to a topic/challenge
     */
    public function addPun($data){
     	$type = ( isset($data['pun-topic']) ) ? 'topic' : 'image';
     	$table = "{$type}_pun_post";
			$data["pun"] = $data["pun-{$type}"];
			$data["{$type}_id"] = $this->getChallenge("{$type}_challenge")["{$type}_id"];
			unset($data["pun-{$type}"]);
    	
			//Setting up the rest of the formData
			// To get the topic-id the pun post was set for..
			$data["username"] = $_SESSION['username'];
			$data["rating"] = 0;
			
			//Inserting data into the database
			if($this->db->insert($table, $data,"Pun succesfully posted") ){
				//Redirect with successmessage
				$section = substr($_SERVER['PHP_SELF'], 1);
				header('Location: /'.$section.'?pun=yes');	
				
			}else{
				return 'failed';
			}
			
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
      * Method to return a specific challenge numebr
      */ 
     
     public function getChallengeByNumber($table,$num){
     	$sql = "SELECT * FROM `{$table}_challenge` WHERE `{$table}_id` = '$num'";
          if($result = $this->db->queryRow($sql) ){
          return $result;     
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
          //die(var_dump($sql));
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
        $path = $image;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
       }
      
      
      /**
       * Method to get image from database based
       * on param of username
       * @param string $username Username to get image from
       */
       
       public function getImage(){
       	$username = $_GET['username'];
       		 // Makes sure that timezone is set to NZ
          $sql = "SELECT `image` FROM `users` WHERE `username` = '$username'";
          if($result = $this->db->queryRow($sql) ){
          return $result;  
       }
       }
      
      /**
       * Takes an image, and converts it to Base_64
       * and uploads the image to the database
       * 
       * @param string $table Table to insert image into
       * @param string $image String containing images filepath
       **/ 
   
   		public function uploadImage($table, $image){
   		$successMessage = "Image has been uploaded";
   		$username = $_SESSION['username'];
	    $data = array();
	    
	    // Converting the image to Base64
	    $data['image'] = $this->convertImage($image);
	    
			$sql = "UPDATE `users` SET `picture` = '".$data['image']."' WHERE `username` = '$username'";
	    // Run the update method to insert the image to the database
	    if($this->db->update($table , $data, 'username' ,$username ) ){
	    return true;
	    }
    
   }
   
   
    /**
     * Under construction function for uploading
     * images specifically for the challenges
     */ 
    public function uploadChallengeImage($table, $image){
    $successMessage = 'Image successfully uploaded';
    // Converting the image to Base64
    $formData['image'] = $this->convertImage($image);
    // Need to get this to query the database and check whether the week has been taken
    // and then if so it will need to increase the week number by 1
    $latestPost = $this->db->queryRow("SELECT `image_id`, `week` FROM `image_challenge` ORDER BY image_id DESC LIMIT 1");
   //die(var_dump($latestPost));
    // Setting the week for the newest post
    $formData['week'] = $latestPost['week'] + 1;
    // Run the insert method to insert the image to the database
     if($this->db->insert($table , $formData, 'username') ){
	    return true;
    }
    
   }
     
    public function displayArchive($table){
    	if($table == 'topic' || $table =='image'){
    		// Get current week
    		date_default_timezone_set("Pacific/Auckland");
        $currentWeek = date('W');
    		// Query to get info from the challenge table
    		$sql = "SELECT `{$table}_id`,`$table` FROM `{$table}_challenge` WHERE week < $currentWeek";
    		//die(var_dump($sql));
    		$sql2 = "SELECT username, {$table}_id, rating FROM {$table}_pun_post ORDER BY rating DESC";
    		// Query both rows and save as variables
    		$challengeDetails = $this->db->queryRows($sql);
    		$winnerDetails = $this->db->queryRows($sql2);
    		// Now match and combine the results to fit, IE. Get rid of the other winnerDetails
    		for ($i=0;$i < count($challengeDetails); $i++){
    			$challengeDetails[$i]['username'] = $winnerDetails[$i]['username'];
    		}
    		if($table == 'topic'){
	    		for ($row = 0; $row < count($challengeDetails); $row++){
	                            echo "<tr>";
	                        
	                            foreach($challengeDetails[$row] as $key => $value)
	                            {
	                                echo "<td>".$value."</td>";
	                            }
	                            echo "</tr>";
	   	}}else{
	   		for ($row = 0; $row < count($challengeDetails); $row++){
	                            echo "<tr>";
	                        
	                               //die(var_dump($challengeDetails[$row]['image']));
	                                echo "<td>".$challengeDetails[$row][$table."_id"]."</td>";
	                                echo "<td><img src=".$challengeDetails[$row]['image']." /></td>";
	                                echo "<td>".$challengeDetails[$row]['username']."</td>";
	                            
	                            echo "</tr>";
	   		
	   		
	   	}
    		
    		
    	}
    	}
	   	else{
    		return 'Table must be either topic or image';
    	}
    	
    }
    
    
}

?>