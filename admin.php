<?php 
//Require security helper functions
require_once('authenticator.php');
//Secured content, redirect unauthenticated users
$authenticator = new AuthenticatorHelper();
$authenticator->redirectUnauthenticatedUser();

switch($_GET['action']){
	case'home':
		header('Location: /home.php');
		break;
    case'challenges':
		header('Location: /challenges.php');
		break;
	case'topic':
		header('Location: /topic.php');
		break;
	case'topic-archive':
		header('Location: /topic-archive.php');
		break;
	case'image-page':
		header('Location: /image-page.php');
		break;
	case'image-archive':
		header('Location: /image-archive.php');
		break;
	case'about':
		header('Location: /about.php');
		break;
	case'profile':
		header('Location: /profile.php');
		break;
	case'sitemap':
		header('Location: /sitemap.php');
		break;	
		
    
}

include('header.php');
?>

<!-- html content for admin page -->
 <!-- Page Content -->
    <div class="container page-content text-center">
          <h2>Administration</h2>
          <div class="crud-container">
              <h2 class="pull-left">Users</h2>
              <button type="button" class="btn btn-success pull-right">Add User</button>
              <div class="table-responsive table-container header-dropshadow">
                  
                <h4 class="pull-left">View, Update, Delete</h4>
                <form class="navbar-form pull-right" role="search" id="search-bar">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
                      
                
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td>JohnDoe</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                        <tr>
                            <td>BobParker</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                        <tr>
                            <td>WonderWoman</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                         <tr>
                            <td>PeterParker</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                         <tr>
                            <td>JimmyStewart</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                         <tr>
                            <td>BobHope</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>    
              
          </div>
           <div class="crud-container">
              <h2 class="pull-left">Puns</h2>
              <button type="button" class="btn btn-success pull-right">Add Pun</button>
              <div class="table-responsive table-container header-dropshadow">
                  
                <h4 class="pull-left">View, Update, Delete</h4>
                <form class="navbar-form pull-right" role="search" id="search-bar">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
                      
                
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td>Lorem Ipsum lorem..</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum lorem..</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum lorem..</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                         <tr>
                            <td>Lorem Ipsum lorem..</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                         <tr>
                            <td>Lorem Ipsum lorem..</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                         <tr>
                            <td>Lorem Ipsum lorem..</td>
                            <td><button type="button" class="btn btn-default">Edit</button></td>
                            <td><button type="button" class="btn btn-default">View</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>    
              
          </div>

<?
include('footer.php');
?>