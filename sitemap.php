<?php
// Require security helpers
require_once('authenticator.php');
$authenticator = new AuthenticatorHelper();
// Secured content, redirect unauthenticated users
$authenticator->redirectUnauthenticatedUser();
//$db = new DatabaseHelper();
include('header.php');
?>
 <!-- Page Content -->
    <div class="container page-content text-center">
        <h2>Sitemap</h2>
            <div>
              <ul>
                  <li><a href="landing-page.html">Landing page</a></li>
                  <li><a href="index.html">Home Page</a></li>
                  <li><a href="challenges.html">Challenges</a></li>
                  <li><a href="topic.html">Topic</a></li>
                  <li><a href="topic-archive.html">Topic-Archive</a></li>
                  <li><a href="image.html">Image</a></li>
                  <li><a href="image-archive.html">Image-Archive</a></li>
                  <li><a href="about.html">About</a></li>
                  <li><a href="profile.html">Profile</a></li>
                  <li><a href="administration.html">Administration</a></li>
                </ul>
<?php
include('footer.php');
?>