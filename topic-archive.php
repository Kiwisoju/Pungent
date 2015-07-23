<?php
// Require security helpers
require_once('authenticator.php');
$authenticator = new AuthenticatorHelper();
// Secured content, redirect unauthenticated users
$authenticator->redirectUnauthenticatedUser();
//$db = new DatabaseHelper();
include('header.php');
require_once('database.php');
$databaseQueries = new DatabaseQueries();
$db = new DatabaseHelper();


?>
  <!-- Page Content -->
    <div class="container page-content text-center">
     
        <h2>Topic Challenge Archive</h2>
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
                            <th>Topic</th>
                            <th>Winner / Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Get rows from the Topic-challenge table showing only id and topic
                        // This needs to be joined by some dummy data showing some winners.
                         //$topicChallengeData = $db->queryRow("SELECT `id`, `topic` FROM `topic_challenge`"); 
                       die(var_dump($db->queryRows("SELECT `id`,`topic` FROM `topic_challenge`")));
                        // for ($row = 0; $row < count($topicChallengeData); $row++){
                        //     echo "<tr>";
                        
                        //     foreach($topicChallengeData[$row] as $key => $value)
                        //     {
                        //         echo "<td>".$value."</td>";
                        //     }
                        //     echo "</tr>";
                        // }
                        ?>
                        
                    </tbody>
                </table>
            </div>
<?php
include('footer.php');
?>