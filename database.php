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
    $valuesStr = "";
    $typesStr = "";
    $bindParamArgs = array();
    
    foreach($formData as $key => $value){
      $values[] = $value;
      $keys[] = $key;
    }
    
    if (count($values) != count($keys)) {
      // error here
    } 
    
    // Dynamically create the param and type placeholders for statement
    foreach ($values as $value) {
      $valuesStr .= "?, ";
      $typesStr .= substr(gettype($value), 0, 1);
    }
    
    // Remove last comma and space from string
    $valuesStr = substr($valuesStr, 0, -2);
    
    // call_user_func_array expects array values to be references, add the types ref
    $bindParamArgs[] = &$typesStr;
    // Then loop through and reference each value var
    for($i = 0; $i < count($values); $i++) {
      $bindParamArgs[] = &$values[$i];
    }
    
    $sql = "INSERT INTO `$table` (".implode(',',$keys).") Values ($valuesStr)";
      
    if (!$stmt = $this->mysqli->prepare($sql)) {
      // @todo log here
      echo $this->mysqli->error;
      exit();
    }
    
    if (!call_user_func_array(array($stmt, 'bind_param'), $bindParamArgs)) {
       // @todo log here
      echo $this->mysqli->error;
      exit();
    }
    
    if ($stmt->execute()) {
      return $successMessage;
    } else {
      return "Error: " . $sql . "<br>" . $conn->error;
    }
    
  }
  
  
  
  private function preparedStatement($sql){
     $valuesStr = "";
    $typesStr = "";
    $bindParamArgs = array();
    
    foreach($formData as $key => $value){
      $values[] = $value;
      $keys[] = $key;
    }
    
    if (count($values) != count($keys)) {
      // error here
    } 
    
    // Dynamically create the param and type placeholders for statement
    foreach ($values as $value) {
      $valuesStr .= "?, ";
      $typesStr .= substr(gettype($value), 0, 1);
    }
    
    // Remove last comma and space from string
    $valuesStr = substr($valuesStr, 0, -2);
    
    // call_user_func_array expects array values to be references, add the types ref
    $bindParamArgs[] = &$typesStr;
    // Then loop through and reference each value var
    for($i = 0; $i < count($values); $i++) {
      $bindParamArgs[] = &$values[$i];
    }
    
    
      
    if (!$stmt = $this->mysqli->prepare($sql)) {
      // @todo log here
      echo $this->mysqli->error;
      exit();
    }
    
    if (!call_user_func_array(array($stmt, 'bind_param'), $bindParamArgs)) {
       // @todo log here
      echo $this->mysqli->error;
      exit();
    }
    
    if ($stmt->execute()) {
      return $successMessage;
    } else {
      return "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  
  
  /**
   * Enables updates to specific data regarding in the database for a given 
   * table
   * 
   * @param string $table Name of table to update row in
   * @param array $formData Array of data to insert into specified row
   * @param string $sql Sql to update table, needs to specify which row
   * 
   * @TODO Write update method
   */
  public function update($table, $formData, $sql){
    
    foreach($formData as $key => $value){
      $values[] = $value;
      $keys[] = $key;
    }
    

    if ($this->mysqli->query($sql) === TRUE) {
        return true;
    }else{
        return "Error: " . $sql . "<br>" . $conn->error;
    }
    
    
  }





  /**
   * Removes a row of a given table based on the given parameters
   * 
   * @param string $table Name of table to remove row from
   * @param int $id ID of row to remove from table
   * 
   * @TODO Write remove method
   */
  public function remove($table, $id){}
  
  
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
}
