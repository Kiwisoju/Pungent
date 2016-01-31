<?php
ob_start();
require_once('authenticator.php');
require_once('database-queries.php');
$authenticator = new AuthenticatorHelper();
$database = new DatabaseHelper();
$databaseQueries = new DatabaseQueries();
// Abstracting the custom stylesheets.
$url = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/') + 1);
$stylesheet = substr($url, 0, -4);

?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="A Socially Moderated Pun Competition">
  <meta name="author" content="Glenn Forrest">

  <title>Pungent</title>
 
  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
  <link rel="manifest" href="images/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
  
  <!-- Bootstrap Core CSS -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  
  <!-- FontAwesome CSS Sheet -->
  <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

  <!-- Custom CSS -->
  <link href='//fonts.googleapis.com/css?family=Arizonia|Open+Sans' rel='stylesheet' type='text/css'>
  <link href="css/main.css" rel="stylesheet" type="text/css">
  <link href="css/<?=$stylesheet?>-styles.css" rel="stylesheet" type="text/css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body>
  <div class="container content">
    <?php if(!($authenticator->isAuthenticated()) ): ?>
     <!-- Landing page content -->
      <div class="container page-content text-center" id="landing-page-container">
              <div class="text-center logo">
                  <h1>Pungent</h1>
                  <h3>A Socially Moderated Pun Competition</h3>
              </div>    
          <div id="signin-container">
              <form method="POST" id="signinForm">
                  <label for="username" class="sr-only">Username</label>
                  <input type="text" id="username" class="form-control input-lg required" value="<?= $_SESSION['sticky']?>" name="login[username]" data-validate="regex(abc,Must contain abc)" placeholder="Username">
                  <label for="password" class="sr-only">Password</label>
                  <input type="password" id="password" class="form-control input-lg required" name="login[password]" placeholder="Password">
                  <input type="submit" class="btn btn-md btn-primary btn-lg custom-button" name="signin" value="Sign In">
              </form>
          </div>
          
          <!-- Facebook log in button -->
              <div id="fb-container">
                <a class="btn btn-md btn-primary btn-lg" href="<?=$loginUrl ?>">Sign in with FaceBook</a>
              </div>
              <hr class="hr-fade">
              
              <!-- Sign up button -->
              <div id="signup-container">
                  <a href="signup.php" class="btn btn-md btn-primary btn-lg custom-button">Sign Up</a>
              </div>
  
      </div>
      <!-- /.container -->
  	<?php else: ?>
  	
        <!-- Navigation -->
    <nav class="navbar header header-dropshadow" id="nav" role="navigation">
  
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="text-center logo">
                  <h1><a href="admin.php?action=home">Pungent</a></h1>
                  <h3>A Socially Moderated Pun Competition</h3>
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
  
              <hr class="left hr-fade">
                  <ul class="nav navbar-nav">
                    <li><a href="admin.php?action=challenges"  aria-haspopup="true"><span>Challenges</span></a>
                			<ul class="dropdown navbar-nav nav">
                				<li><a href="admin.php?action=topic" aria-haspopup="true"><span>Topic</span></a>
                				<ul class="dropdown navbar-nav nav">
                            <li id="third-dropdown"><a href="admin.php?action=topic-archive">Archive</a></li>
                          </ul>
                        </li>
                        <li><a href="admin.php?action=image-page" aria-haspopup="true"><span>Image</span></a>
                          <ul class="dropdown navbar-nav nav">
                            <li id="third-dropdown"><a href="admin.php?action=image-archive">Archive</a></li>
                          </ul>
                        </li>
                      </ul>
                		</li>
                		<li><a href="admin.php?action=about">About</a></li>
                    <li><a href="admin.php?action=profile" aria-haspopup="true"><span>Profile</span></a>
                      <ul class="dropdown navbar-nav nav">
                        <li><a href="?logout=yes">Logout</a></li>
                      </ul>
                    </li>
                    <?php if($authenticator->isAdmin() ): ?><li><a href="admin.php?action=admin">Admin</a></li><?php endif;?>
                  </ul>
              <hr class="right hr-fade">
      </nav>
    </div>
  	<?php endif;?>