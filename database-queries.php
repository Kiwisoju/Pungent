<?php
require_once('database.php');
require_once('puns.php');

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
		    if(!($this->db->queryRow("SELECT `username` FROM `users` WHERE `username` = '$username'") )){
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
			
			public function addFbUser($formData, $picture){
			 $username = $formData['name'];
			 $sql = "SELECT username FROM users WHERE username = '{$username}'";
			 //$sql = "SELECT username FROM users WHERE username = 'test'";
			 
			 //die(var_dump($username));
			 //die(var_dump($sql));
			 //$result = $this->db->queryRow($sql);
			 //die(var_dump(!isset($result)));
		    if(!($this->db->queryRow($sql) )){
					//Inserting user to the database and redirecting
					$fbUser['username'] = $formData['name'];
					$this->db->insert('users',$fbUser,"User successfully added");
					$message = "User successfully added"; 
		    }
					else{
					$_SESSION['loggedIn'] = true;
					$_SESSION['username'] = $username;
					
		   $this->uploadImage('users',$picture);
		   $message = "Welcome {$username}";
					exit(header("Location: /home.php?message=".$message));
					}
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
    /**
     * Method to search database based on table
     * and search/keyword supplied by user.
     * @param string $table Table to search
     * @param string $search Search/keyword to query
     **/ 
   public function searchArchive($table, $search){
     if($table == 'topic' || $table =='image'){
    		// Get current week
    		date_default_timezone_set("Pacific/Auckland");
        $currentWeek = date('W');
    		// Search based on topic first if theres a match, display the winning
    		// pun
    		$sql = "SELECT `{$table}_id`,`$table` FROM `{$table}_challenge` WHERE week < $currentWeek AND `$table` LIKE '%{$search}%'";
    		if($result = $this->db->queryRow($sql)){
    		  $id = $result[$table.'_id'];
    		  return($this->getPunsById(1, $table, $id));
    		}else{
    		  // Search based on challenge_# next, display the winning pun, for
      		// the challenge number it's based on
      		$sql = "SELECT `{$table}_id`,`$table` FROM `{$table}_challenge` WHERE week < $currentWeek AND `{$table}_id` LIKE '%{$search}%'";
      		if($result = $this->db->queryRow($sql)){
      		  $id = $result[$table.'_id'];
      		  return($this->getPunsById(1, $table, $id));
    		  
    		}else{
    		  $sql = "SELECT {$table}, pun, username, rating, date, id 
    		          FROM {$table}_challenge 
    		          JOIN {$table}_pun_post ON {$table}_pun_post.{$table}_id = {$table}_challenge.{$table}_id 
    		          WHERE week < 31 AND username LIKE '%{$search}%' 
    		          ORDER BY rating DESC";
      		if($result = $this->db->queryRow($sql)){
      		  $id = $result[$table.'_id'];
      		  return($this->getPunsById(1, $table, $id));
    		  }else
    		  $message = 'No results found';
    		  header('Location: /'.$table.'-archive.php?message='.$message);
    		}}
    		
    		// Search based on username. Return all puns where username has the highest
    		// rating..
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
    
    public function getPunsByUsername($num, $table, $username){
      if($table == 'topic' || $table == 'image'){
            if($id){
                $sql = "SELECT ".$table.", pun, username, rating, date, id
                FROM ".$table."_challenge
                JOIN ".$table."_pun_post ON ".$table."_pun_post.".$table."_id = ".$table."_challenge.".$table."_id 
                WHERE username = $username
                ORDER BY rating DESC"; 
            }else{
                $sql = "SELECT ".$table.", pun, username, rating, date, id
                FROM ".$table."_challenge
                JOIN ".$table."_pun_post ON ".$table."_pun_post.".$table."_id = ".$table."_challenge.".$table."_id 
                ORDER BY rating DESC";
            }
        
       }else{
            echo 'Table must be either topic or image';
        }
        
        $errorMessage = 'Error getting puns';
  $this->punTemplate($sql,$table,$num, $errorMessage);
    }
    
    public function getPunsById($num,$table,$id=null){
        if($table == 'topic' || $table == 'image'){
            if($id){
                $sql = "SELECT ".$table.", pun, username, rating, date, id
                FROM ".$table."_challenge
                JOIN ".$table."_pun_post ON ".$table."_pun_post.".$table."_id = ".$table."_challenge.".$table."_id 
                WHERE {$table}_challenge.{$table}_id = $id
                ORDER BY rating DESC";
          
            }else{
                $sql = "SELECT ".$table.", pun, username, rating, date, id
                FROM ".$table."_challenge
                JOIN ".$table."_pun_post ON ".$table."_pun_post.".$table."_id = ".$table."_challenge.".$table."_id 
                ORDER BY rating DESC";
            }
        
       }else{
            echo 'Table must be either topic or image';
        }
        
        $errorMessage = 'Error getting puns';
  $this->punTemplate($sql,$table,$num, $errorMessage);
   
    }
    
    private function punTemplate($sql, $table, $num, $errorMessage){
        if($punData = $this->db->queryRows($sql)){
          //If there are less than 3 items in the array, change
           // $num to be the same as the length of the array.
           if(count($punData) < $num){
               $num = count($punData);
           }
            // Now iterate over this data based on $num and output the HTML template
            for($i = 0; $i < $num; $i++){
            $data = $punData[$i];    
          
               echo '<div class="pun-post">
             <p class="pun-date pull-left">'.substr($data["date"], 0, 10).'</p>
            <div class="pun-inner row">
              <p class="pun-text pull-left col-xs-9 text-left">'.htmlspecialchars($data["pun"], ENT_COMPAT,'ISO-8859-1', true).'</p>
              <div class="rating-group">
              <form method="get">
                <a href="?table='.$table.'&id='.$data['id'].'&rating=up&currentRating='.$data['rating'].'"><i class="fa fa-thumbs-up fa-2"></i></a>
                <a href="?table='.$table.'&id='.$data['id'].'&rating=down&currentRating='.$data['rating'].'"><i class="fa fa-thumbs-down fa-2"></i></a>
                <span class="rating-number">'.$data["rating"].'</span>
                </form>
              </div>          
            </div>
            <p class="username pull-right"><a href="/profile.php?username='.$data["username"].'">'.htmlspecialchars($data["username"], ENT_COMPAT,'ISO-8859-1', true).'</a></p>
            ';if($_SESSION["username"] == $data["username"] || $_SESSION['user']["admin"] == true){
                echo'
            <form method="POST">
            <input type="submit" class="btn btn-danger" name="delete" value="delete">
            <input type="submit" class="btn btn-default" name="edit" value="edit">
            <input type="hidden" name="id" value="'.($data['id']).'">
            <input type="hidden" name="table" value="'.($table).'">
            </form>';}
            echo'</div>';
            $data['table'] = $table;    
            $_SESSION['punData'] = $data;
           
            }
        }else{
            return $errorMessage;
        }
    }
}

?>