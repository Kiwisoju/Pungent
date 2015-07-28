<?php
require_once('database-queries.php');
require_once('database.php');

class PunsHelper{
    
    private $db;
    private $dbq; 
    
    public function PunsHelper(){
        $this->db = new DatabaseHelper();
        $this->dbq = new DatabaseQueries();
    }
    
    /**
     * Method to return array of puns
     * @param int $num Number of puns to display
     * @param string $table Table to receive puns from.
     *  Either topic or image
     */
     
    public function getCurrentPuns($num, $table){
        $id = $this->dbq->getChallenge($table.'_challenge')['topic_id'];
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
        //die(var_dump($allIpFromTable));
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