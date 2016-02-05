<?php
include('header.php');
?>
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
        <hr class="hr-fade">
        <!-- Sign up button -->
        <div id="signup-container">
            <a href="signup.php" class="btn btn-md btn-primary btn-lg custom-button">Sign Up</a>
        </div>
    </div>
    <!-- /.container -->