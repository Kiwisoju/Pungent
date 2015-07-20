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
     
        <h2>Image Challenge Archive</h2>
            <form class="navbar-form" role="search" id="search-bar">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Challenge Number</th>
                            <th>Image</th>
                            <th>Winner / Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><img src="http://placehold.it/250x150"></img></td>
                            <td>johncarter</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><img src="http://placehold.it/250x150"></img></td>
                            <td>peterparker</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><img src="http://placehold.it/250x150"></img></td>
                            <td>johnrambo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
<?php
include('footer.php');
?>