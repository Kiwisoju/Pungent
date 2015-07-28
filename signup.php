<?php

require_once('authenticator.php');
require_once('database-queries.php');
$authenticator = new AuthenticatorHelper();
$database = new DatabaseHelper();
$databaseQueries = new DatabaseQueries();
        
    /* Once POST has been submitted, the info gets sent in an array
    into the database insert method, then the authenticator logs the 
    user in and creates a session followed by a redirect to the home
    page */
    
    if($_POST){
        // Setting the $_POST data to $data so as to set the values
        // in the form set to what was previously entered.
        $data = $_POST;
        $_SESSION['sticky'] = $data['username'];
        if($databaseQueries->addUser($_POST) ){
            // Logs the user in, redirecting to the home page with login success message 
            //$authenticator->login($_POST['username'], $_POST['password']);
            header('Location: /index.php?signup=yes');
        }else{
            echo "Failed to add new user au";
        }
    }
        
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
    <link rel="icon" type="image/png" href="images/favicon.png"/>
    
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- FontAwesome CSS Sheet -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <link href='//fonts.googleapis.com/css?family=Arizonia|Open+Sans' rel='stylesheet' type='text/css'>
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/index-styles.css" rel="stylesheet" type="text/css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div class="container content">
<div class="container page-content text-center" id="landing-page-container">
    <?php if($_GET['message']):?>
        <div class="popup"><p><?= $_GET['message']?></p> </div>
    <?php endif; ?>
            <div class="text-center logo">
                <h1>Pungent</h1>
                <h3>A Socially Moderated Pun Competition</h3>
            </div>    
        <div id="signup-container">
            <form method="post">
                <input type="text" class="form-control input-lg required" name="username" value="<?= $_SESSION['sticky']?>" placeholder="Enter username" required>
                <input type="password" class="form-control input-lg required" name="password"  placeholder="Enter password" required>
                <input type="password" class="form-control input-lg required" name="password-match"  placeholder="Enter same password" required>
                <input type="submit" class="btn btn-md btn-primary btn-lg custom-button">
            </form>
            
<?php
include('footer.php');
?>