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
        <div id="about-container">
          <h2>About</h2>
          <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
          sed diam nonummy nibh euismod tincidunt ut laoreet dolore
          magna aliquam erat volutpat. Ut wisi enim ad minim veniam,
          quis nostrud exerci tation ullamcorper suscipit lobortis nisl
          ut aliquip ex ea commodo consequat. Duis autem vel eum iriure
          dolor in hendrerit in vulputate velit esse molestie consequat,
          vel illum dolore eu feugiat nulla facilisis at vero eros et
          accumsan et iusto odio dignissim qui blandit praesent luptatum
          zzril delenit augue duis dolore te feugait nulla facilisi.
          </p>
        </div>
<?php
include('footer.php');
?>