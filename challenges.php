<?php
include('header.php');

if($_POST){
        // Setting the $_POST data to $data so as to set the values
        // in the form set to what was previously entered.
        $data = $_POST; 
        $databaseQueries->addPun($data);
    }
?>
<!-- Page Content -->
<div class="container page-content text-center">
    <?php if($_GET['pun']=='yes'):?>
    <div class="popup"><p>Pun post successful!</p> </div>
    <?php elseif($_GET['pun']=='no'): ?>
    <div class="popup"><p>Pun post un-successful</p> </div>
    <?php endif; ?>
    <div class="topic challenge">
        <h2><a href="admin.php?action=topic">Topic Challenge #<?=$databaseQueries->getChallenge("topic_challenge")['topic_id'] ?><br><?= $databaseQueries->getChallenge("topic_challenge")['topic']?></a></h2>
        <form class="pun-input" method="post">
            <div class="form-group">
                <input type="text" class="form-control text-center" name="pun-topic" value="<?= $data['pun-topic']?>" placeholder="Post your pun here" required></input>
            </div>
            <input type="submit" class="btn btn-default">
        </form>
    </div>
    <hr class="hr-fade">
    <div class="image challenge">
        <h2><a href="admin.php?action=image-page">Image Challenge #<?= $databaseQueries->getChallenge("image_challenge")['image_id']?></a></h2>
        <img class="grayscale img-responsive" src="<?=$databaseQueries->getChallenge("image_challenge")['image'];?>"/>
        <form class="pun-input" method="post">
            <div class="form-group">
                <input type="text" class="form-control text-center" name="pun-image" value="<?= $data['pun-image']?>" placeholder="Post your pun here" required></input>
            </div>
            <input type="submit" class="btn btn-default">
        </form>  
    </div>
   
<?php
include('footer.php');