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
     * @param array $formData Contains the username, passwords
     **/
		public function addUser($formData){
      // Checking if passwords match, if not set errormessage
      // and redirect back to signup
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
			
		/** 
		 * Method to add user to the database
		 * who is logging in with their facebook account
		 * 
		 * @param string $formData Their username
		 * @param string $picture Link to their profile picture
		 **/ 
		 
		public function addFbUser($formData, $picture){
      $username = $formData['name'];
      $sql = "SELECT username FROM users WHERE username = '{$username}'";
      // Checking if there is a match with usernames
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
		
		/**
		 *  Method to Display all users for
		 *  admin privileges
		 **/
		 
		public function getAllUsers(){
		  $sql = "SELECT username FROM users";
			if($result = $this->db->queryRows($sql) ){
				$numUsers = count($result);
        for($i = 0; $i < $numUsers; $i++){
          $users = $result[$i];
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
     * Method to delete a user from the database
     * @param string $user Username
     */
     
    public function removeUser($user){
     
      if($this->db->remove('users', $user))
        header('Location: /admin.php?message=User Successfully Deleted');
    }
    
    /**
     * Method to insert/update biography to the database
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
     * Method to return biography from the database of usernames
     * @param string $username Username
     */
     
    public function getBio($username){
    	$sql = "SELECT `bio` FROM `users` WHERE `username` = '$username'";
      
      if($result = $this->db->queryRow($sql) ){
        return $result;      
      }
    }
    
    /**
     * Method to add pun to a topic/challenge
     * @param string $data Pun to be added
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
       return 'Out of puns';  
      }

    }
     
     /**
      * Method to return a specific challenge number
      * @param string $table Table to pull challenge from
      * @param string $num Number of challenge to pull
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
     * @param string $image Filepath of image
     */
     
    public function convertImage($image){
      $path = $image;
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      return $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
    
    
    /**
     * Method to get image from database based
     * on GET param of username
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
        // Search based on topic first if theres a match, display the winning pun
        $sql = "SELECT `{$table}_id`,`$table` FROM `{$table}_challenge` WHERE week < $currentWeek AND `$table` LIKE '%{$search}%'";
        
        if($result = $this->db->queryRow($sql)){
          $id = $result[$table.'_id'];
          return($this->getPunsById(1, $table, $id));
        }else{
          // Search based on challenge_# next, display the winning pun
          $sql = "SELECT `{$table}_id`,`$table` FROM `{$table}_challenge` WHERE week < $currentWeek AND `{$table}_id` LIKE '%{$search}%'";
          if($result = $this->db->queryRow($sql)){
            $id = $result[$table.'_id'];
            return($this->getPunsById(1, $table, $id));
          }else{
            // Search based on username
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
          }
        }
      }
    }
   
    /**
     * Method to display Archived challenges based
     * on challenge name/table
     * @param string $table Table name
     */ 
    public function displayArchive($table){
    	if($table == 'topic' || $table =='image'){
    		// Get current week
    		date_default_timezone_set("Pacific/Auckland");
        $currentWeek = date('W');
    		// Query to get info from the challenge table
    		$sql = "SELECT `{$table}_id`,`$table` FROM `{$table}_challenge` WHERE week < $currentWeek";
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
            foreach($challengeDetails[$row] as $key => $value){
                echo "<td>".$value."</td>";
            }
            echo "</tr>";
	   	    }
    		  
    		}else{
  	   		for ($row = 0; $row < count($challengeDetails); $row++){
            echo "<tr>";
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
    
    /**
     * Method to get puns based on username
     * @param string $username Username to get puns from
     */ 
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
    
    /**
     * Method to get puns and display puns
     * Optional to provide ID
     * @param int $num Number of puns to display
     * @param string $table Table to get puns from
     * @param num $id Id of pun to grab
     */ 
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
    
    /**
     * Method to return array of puns
     * @param int $num Number of puns to display
     * @param string $table Table to receive puns from.
     *  Either topic or image
     */
     
    public function getCurrentPuns($num, $table){
        $id = $this->getChallenge($table.'_challenge')['topic_id'];
        if($table == 'topic' || $table == 'image'){
        $sql = "SELECT ".$table.", pun, username, rating, date, id
          FROM ".$table."_challenge
          JOIN ".$table."_pun_post ON ".$table."_pun_post.".$table."_id = ".$table."_challenge.".$table."_id 
          WHERE ".$table."_pun_post.".$table."_id = '$id'
          ORDER BY rating DESC";
          
       }else{
            echo 'Table must be either topic or image';
        }
        $errorMessage = 'Error getting puns';
        $this->punTemplate($sql,$table,$num, $errorMessage);
    }
    
    /**
     * Method to update a pun
     * @param string $table Table to update pun from
     * @param string $data New pun text to update
     * @param string $whereVal WHERE Val and Keys to determine where to update pun in table
     */
    public function updatePun($table, $data, $whereVal){
        $table = $table."_pun_post";
        if($this->db->update($table , $data, 'pun', $whereVal  ) ){  
            return true;
        }
    }
    /**
     * Method to return array of puns based on
     * username given. This is primarily to display
     * puns on profile pages.
     * @param string $username Username to get puns from
     */
    
    public function getUserPuns($username){
        $sql = "SELECT username, pun, date, rating, id FROM topic_pun_post
            WHERE username='".$username."'
            UNION ALL
            SELECT username, pun, date, rating, id FROM image_pun_post
            WHERE username='".$username."'
            ORDER BY rating DESC";
        $num = 3;    
        $errorMessage = '<div class="pun-post"><p>This user has no puns<br>They should be punished..</p></div>';

    if($punData = $this->db->queryRows($sql))
        {
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
                <i class="fa fa-thumbs-up fa-2"></i>
                <i class="fa fa-thumbs-down fa-2"></i>
                <span class="rating-number">'.$data["rating"].'</span>
              </div>          
            </div>
            <p class="username pull-right"><a href="/profile.php?username='.$data["username"].'">'.htmlspecialchars($data["username"], ENT_COMPAT,'ISO-8859-1', true).'</a></p>
        </div>';
                
            
            }
        }else{
            echo $errorMessage;
        }

    }
    
    /**
     * Method to receive how many total puns there
     * are in the database based on parameter
     * @param string $table Table to receive puns from.
     * @param id $id Id to get puns from
     */ 
    public function totalPuns($table,$id){
      
        if($table == 'topic' | $table == 'image'){
            if($id){
             $sql = "SELECT pun
              FROM ".$table."_challenge
              JOIN ".$table."_pun_post ON ".$table."_pun_post.".$table."_id = ".$table."_challenge.".$table."_id
              WHERE ".$table."_pun_post.".$table."_id = '$id'";   
            }else{
               $sql = "SELECT pun
              FROM ".$table."_challenge
              JOIN ".$table."_pun_post ON ".$table."_pun_post.".$table."_id = ".$table."_challenge.".$table."_id";   
            }
            
        }else{
            return "Error: table needs to be either topic_challenge or image_challenge";
        }
        
        if($totalPuns = $this->db->queryRows($sql))
        {return $totalPuns = count($totalPuns);
        }else{
            return 'Error getting puns';
        }
       
    }
    
    public function findPunById(){
        
        $table = $_GET['table'];
        $id = $_GET['id'];
        $sql = "SELECT `pun` FROM `{$table}_pun_post` WHERE `id` = '{$id}'";
        return $this->db->queryRow($sql);

    }
    
    public function removePun($table, $whereData){
        
        $table = $table."_pun_post";
       if($this->db->remove($table, $whereData))
       return true;
    }
    
    private function rate($table, $id, $username, $currentRating, $rating){
        if($table == 'topic'){
            $table = 'topic_pun_post';
        }elseif($table == 'image'){
            $table = 'image_pun_post';
        }
        $formData['rating'] = $rating;
        if($formData['rating'] == "up"){
            $formData['rating'] = $currentRating + 1;
             return $this->db->update($table, $formData,'id', $id );
        }
        elseif($formData['rating'] == 'down'){
            
            $formData['rating'] = $currentRating - 1;
               return $this->db->update($table, $formData,'id', $id );
            }
            
        
    }
    
    
    private function setRateIp($table, $id, $username){
       if($table == 'topic')
       {
           $formData['topic_pun_id'] = $id;
       }elseif($table == 'image'){
           $formData['image_pun_id'] = $id;
       }
       
        $formData['username'] = $username;
        $table .= '_rating_ips';
        //die(var_dump($formData));
        
        return $this->db->insert($table, $formData, 'Ip has been set');
    }
    
    private function getRateIps($table, $id, $username){
        $sql = "SELECT * FROM `{$table}_rating_ips` WHERE `{$table}_pun_id` = {$id} AND `username` = '{$username}'";
        //die(var_dump($sql));
        return $this->db->queryRow($sql);
    }
    
    public function ratePun(){
        $username = $_SESSION['username'];
        $table = $_GET['table'];
        $id = $_GET['id'];
        $rating = $_GET['rating'];
        $currentRating = $_GET['currentRating'];
        
        //Check whether IP exists already in the table
        //Getting all ips already stored.
        $allIpFromTable = $this->getRateIps($table, $id, $username);
        if(!isset($allIpFromTable)){
            $this->setRateIp($table, $id, $username);
            if($this->rate($table, $id, $username, $currentRating, $rating)){
                $message = 'Pun has been rated';
                header('Location: ?message='.$message);
                
            };
        }else{
            $message = 'You have already rated this pun';
            header('Location: ?message='.$message);
        }
        
        //if all clear then update the table to include your ip linked
        //with the correct id.
        
        //Then increase the number or decrease the rating on the other table.
    
    }
    
    
    
    /**
     * Method to template out the HTML structure of a pun post
     * @param string $sql SQL query to be made
     * @param string $table Table to query
     * @param int $num Number of puns to display
     * @param string $errorMessage Error message to log
     */
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