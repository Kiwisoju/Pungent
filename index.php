<?php
session_start();
include('header.php');
include('puns.php');
include('pun-spider.php');
?>
<!-- Page Content -->
    <div class="container page-content text-center">
      <?php if($_GET['not-admin']=='yes'):?>
        <div class="well pop-up"><p>Sorry, you don't have permission to enter that page.</p> </div>
      <?php elseif($_GET['message']):?>
        <div class="well pop-up"><p><?= $_GET['message']?></p> </div>
      <?php elseif($_GET['pun']=='yes'):?>
        <div class="well pop-up"><p>Pun post successful!</p> </div>
      <?php elseif($_GET['pun']=='no'): ?>
        <div class="well pop-up"><p>Pun post un-successful</p> </div>
      <?php endif; ?>
      <div class="pun-of-the-day">
        <h2>Pun of the day</h2>
        <p><?= crawl_page("http://www.punoftheday.com/");?></p>
      </div>
      <hr class="hr-fade">
      <div class="topic challenge">
        <h2><a href="admin.php?action=topic">Topic Challenge #<?=$databaseQueries->getChallenge("topic_challenge")['topic_id'] ?><br><?= $databaseQueries->getChallenge("topic_challenge")['topic']?></a></h2>
        <?php $databaseQueries->getCurrentPuns(3, 'topic');?>
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
        <img class="grayscale img-responsive" src="<?=$databaseQueries->getChallenge("image_challenge")['image']?>"/>
      <?php $databaseQueries->getCurrentPuns(3, 'image');?>
        <form class="pun-input" method="post">
          <div class="form-group">
              <input type="text" class="form-control text-center" name="pun-image" value="<?= $data['pun-image']?>" placeholder="Post your pun here" required></input>
          </div>
           <input type="submit" class="btn btn-default">
        </form>  
      
      </div>
      <?php
      include('footer.php');
      ?>