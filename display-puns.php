<?php
require_once('database-queries.php');
require_once('database.php');
class DisplayPuns{
    
    private $db;
    
    public function DisplayPuns(){
        $this->db = new DatabaseHelper();
    }
    
    /**
     * Method to return array of puns
     * @param int $num Number of puns to display
     * @param string $table Table to receive puns from.
     *  Either topic or image
     */
     
    public function getPuns($num, $table){
        //$challengeTable = $table.'_challenge';
        //$punTable = $table.'_pun_post';
        if($table == 'topic' || $table == 'image'){
        $sql = "SELECT ".$table.", pun, username, rating, date
  FROM ".$table."_challenge
  JOIN ".$table."_pun_post ON ".$table."_pun_post.".$table."_id = ".$table."_challenge.".$table."_id 
  ORDER BY rating DESC";
       }else{
            echo 'Table must be either topic or image';
        }
  
        if($punData = $this->db->queryRows($sql))
        {
           
            // Now iterate over this data based on $num and output the HTML template
            for($i = 0; $i < $num; $i++){
            $data = $punData[$i];    
          
               echo '<div class="pun-post">
             <p class="pun-date pull-left">'.substr($data["date"], 0, 10).'</p>
            <div class="pun-inner row">
              <p class="pun-text pull-left col-xs-9 text-left">'.$data["pun"].'</p>
              <div class="rating-group">
                <a href="#"><i class="fa fa-thumbs-up fa-2"></i></a>
                <a href="#"><i class="fa fa-thumbs-down fa-2"></i></a>
                <a href="#" class="rating-number">'.$data["rating"].'</a>
              </div>          
            </div>
            <p class="username pull-right"><a href="/profile.php?username='.$data["username"].'">'.$data["username"].'</a></p>
        </div>';
                
            
            }
        }else{
            return 'Error getting puns';
        }
    }
    
    /**
     * Method to receive how many total puns there
     * are in the database.
     */ 
    public function totalPuns($table){
        
        if($table == 'topic' | $table == 'image'){
            $sql = "SELECT pun
  FROM ".$table."_challenge
  JOIN ".$table."_pun_post ON ".$table."_pun_post.".$table."_id = ".$table."_challenge.".$table."_id ";
        }else{
            return "Error: table needs to be either topic_challenge or image_challenge";
        }
        if($totalPuns = $this->db->queryRows($sql))
        {return $totalPuns = count($totalPuns);
        }else{
            return 'Error getting puns';
        }
       
    }
}

?>