<?php
    include('header.php');
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

<div class="container page-content text-center" id="landing-page-container">
    <?php if($_GET['message']):?>
        <div class="well pop-up"><p><?= $_GET['message']?></p> </div>
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
            </form><?php
            include('footer.php');