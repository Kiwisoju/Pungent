<?php
session_start();
require_once('database.php');

/**
* Authentication Helper Class
* @TODO Document Authenticator Class and Method
*/

class AuthenticatorHelper{

private $db;

/**
 * Constructor method which instantiates an instance of DatabaseHelper to 
 * allow for queries/methods to connect to the database and creates a session
 * if a user has logged in.
 * 
 **/
	function AuthenticatorHelper(){
		$this->db = new DatabaseHelper();

		if($_POST['login']){
			$username = $_POST['login']['username'];
			$password = $_POST['login']['password'];

			if($user = $this->login($username, $password) ){
				// $user being a user database row
				$_SESSION['user'] = $user;
			}else{
				//user and password failed
				$this->logout();
			}
		}

		if($_GET['logout']) 
			$this->logout();
	}
/**
 * User login system checks user input against database
 * Verifies the password and 
 * @param string $username Username as supplied by user through form input
 * @param string $password Password as supplied by user through form input
 **/
 
	public function login($username, $password){
		//Build query to find all users
		$sql = "SELECT * FROM users WHERE username = '$username'";
		
		//Run query to find specific user and check password matches hashed password
		if($result = $this->db->queryRow($sql) ){
			if(password_verify($password, $result['password'])){
				$_SESSION['username'] = $username;
				$_SESSION['loggedIn'] = true;
				
			}else{
				$message = "Password and username don't match";
				header('Location: /index.php?message='.$message);
			}
	}

	return $result;
	}

/**
 * User logout system, destroys session and redirects to home page
 * 
 **/
	public function logout(){
		session_destroy();
		header('Location: index.php');
	}


/**
 * Checks authentication of user
 **/
	public function isAuthenticated(){
		return $_SESSION['loggedIn'];
	}
	
/** 
 * Checks if user is authenticated as admin
 * 
 * */
	public function isAdmin(){
		
		$username = $_SESSION['username']; 
		//Build query check admin of current user
		$sql = "SELECT admin FROM users WHERE username = '$username'";
		//Run query to find specific user and return admin boolean
		$result = $this->db->queryRow($sql);
		//Return the result, will be either true or false
		return $result['admin'];
	}
	
/**
 * Redirects unauthenticated users via logout method
 **/
	function redirectUnauthenticatedUser(){
		if(!$this->isAuthenticated())
			$this->logout();
	}

}
?>