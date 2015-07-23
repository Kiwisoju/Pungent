<?php
require_once('authenticator.php');

/**
 * Helper class containing various database methods
 */
class DatabaseHelper{
  public $mysqli;
  private $query;
  
  /**
   * Constructor method that initialise database connection
   * TODO Set up an error alternative.
   */
  function DatabaseHelper(){
    // Open connect to database
   $this->mysqli = $this->connect();
    
  } 
  
  /**
   * Select the database and connect to it using given parameters
   * 
   * @return resource $mysql Successfully connected MySQL database resource 
   */
  private function connect(){
    // Connect and select database
    # @TODO Replace error message with redirect + log + email notification 
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "Ch4ng3m3#";
    $database = "Pungent";
    $dbport = 3306;

    
    if(!$password)
      throw new Exception('No password set for database');
    
    // Create connection
    $mysqli = new mysqli($servername, $username, $password, $database, $dbport);
    
     // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } 
    // "Connected successfully (".$mysqli->host_info.")";
                
  
    
    return $mysqli;
  }
  
  /**
   * Inserts a single row of data into database based on parameters 
   * given and if data consists of password, will hash the password 
   * prior to entry.
   * 
   * To Add:
   * redirect user on success/failure with message/error 
   * in URL parameter
   *    
   * @param string $table Name of table to insert new row into
   * @param array $formData Array of data to insert into new row of table
   * @param string $successMessage Message attached to success URL
   * 
   * @TODO Replace switch with default of 'manage-'.$table, if $redirect param not supplied
   */
   public function insert($table, $formData, $successMessage) {
    $helperVars = $this->preparedStatementHelper($formData);
    
    $sql = "INSERT INTO `{$table}` ({$helperVars['keysStr']}) VALUES ({$helperVars['valuesStr']})";
      
    return $this->runPreparedStatement($sql, $helperVars['bindParamArgs']);
   }

  /**
   * Enables updates to specific data regarding in the database for a given 
   * table
   * 
   * @param string $table Name of table to update row in
   * @param array $formData Array of data to insert into specified row
   * @param string $whereKey Key to insert
   * @param string $whereValue Value to insert
   * 
   * @TODO Write update method
   */
  public function update($table, $formData, $whereKey, $whereValue){ 
    $helperVars = $this->preparedStatementHelper($formData);
    
    // Add type of whereValue to typesStr and push to end of array
    $helperVars['bindParamArgs'][0] .= $this->getFieldTypeInitial($whereValue);
    array_push($helperVars['bindParamArgs'], $whereValue);
    
    $sql = "UPDATE `{$table}` SET {$helperVars['keyValStr']} WHERE {$whereKey} = ?";
    
    return $this->runPreparedStatement($sql, $helperVars['bindParamArgs']);
  }

  /**
   * Removes a row of a given table based on the given parameters
   * 
   * @param string $table Name of table to remove row from
   * 
   * @TODO Write remove method
   */
  public function remove($table, $whereData){
    $helperVars = $this->preparedStatementHelper($whereData, 'delete');
    
    $sql = "DELETE FROM `{$table}` WHERE {$helperVars['keyValStr']}";

    return $this->runPreparedStatement($sql, $helperVars['bindParamArgs']);
  }
  
  /*
  // idea output for a delete thing
  Only show this is users post...
  <div>
  <form action="./post/delete" method="post">
    <input type="hidden" name="id" value="233"  />
    <button type="submit">Delete</button>
  </form>
  </div>
  
  
  function deletePun($formData) {
    // get user name from session and put in var
    $formData['username'] = $usernameVar;
    
    you should call die and test  sql looks something like this for debugging
    DELETE FROM `topic_pun_post` WHERE id = ? AND username = ?
    
    // check this works, sql could fail if already removed or invalid username
    $this->db->remove('pun', $formData);
  }
  */
  
  
  /**
   * Fetches a single row from a table specified in the given SQL
   * 
   * @param string $sql SQL to run against connected database
   * @return array $row Row matched by the given SQL statement
   */
  public function queryRow($sql = '') {
   
   if( !isset($this->query) ){
    
    $result = $this->mysqli->query($sql);
    while($row = $result->fetch_assoc() )
      return $row; 
    }

  }
  
  # @TODO Document DatabaseHelper->queryRows()
  public function queryRows($sql = ''){
    
    $result = $this->mysqli->query($sql);
    $rows = array();
    while($row = $result->fetch_assoc()){
        $rows[] = $row;
    }
    return $rows;
 }
 
 
 /**
  * Method to return array
  */ 
 private function preparedStatementHelper($formData, $queryType=null){
    $valuesStr = $typesStr = '';
    $keyValDelimiter = '= ?, ';
    
    foreach($formData as $key => $value){
      $values[] = $value;
      $keys[] = $key;
      
      // Dynamically create the param and type placeholders for a statement
      $valuesStr .= "?, ";
      $typesStr .= $this->getFieldTypeInitial($value);
    }
   
    // Remove last comma and space from string
    $valuesStr = substr($valuesStr, 0, -2);
    
    $bindParamArgs = $values;
    array_unshift($bindParamArgs, $typesStr);
    
    if (isset($queryType) && $queryType == 'delete') {
      $keyValDelimiter = '= ? AND ';
    }
    
    return array(
      'keysStr' => implode(',',$keys),
      'keyValStr' => implode($keyValDelimiter, $keys) . '= ?',
      'valuesStr' => $valuesStr,
      'typesStr' => $typesStr,
      'bindParamArgs' => $bindParamArgs
    );
 }

  private function getFieldTypeInitial($type) {
    return substr(gettype($type), 0, 1);
  }
/**
 * Method to create and run prepared statement
 * @param string $sql Prepared sql statement
 */ 
 private function runPreparedStatement($sql, $bindParamArgs){
    $refBindParamArgs = array();
   
    // call_user_func_array expects array values to be references. Loop through 
    // and reference each arg var
    for($i = 0; $i < count($bindParamArgs); $i++) {
      $refBindParamArgs[] = &$bindParamArgs[$i];
    }
    
    if (!$stmt = $this->mysqli->prepare($sql)) {
      // @todo log here
      echo $this->mysqli->error;
      exit();
    }
    
    if (!call_user_func_array(array($stmt, 'bind_param'), $refBindParamArgs)) {
       // @todo log here
      echo $this->mysqli->error;
      exit();
    }
    
    if (!$stmt->execute()) {
      return "Error: {$sql}<br>{$conn->error}"; 
    } 
      
    return true;
 } 
  
}
