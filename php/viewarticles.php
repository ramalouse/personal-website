<?php
# Shows all grades a student has earned. Student must be logged in.
include("db.php");
ensure_logged_in();
include("top.php"); ?>

<h2>Would you like to look up a specific article?</h2>
<form id="view_article" action="viewarticle.php" method="get">
    <fieldset>
        <label>Short Title: </label>
        <input type="text" id="short_title" name="short_title">
        
        <button id="submit" class="button">Search</button>
    </fieldset>
</form>

<h2>Articles for <?= $_SESSION["name"] ?> to read:</h2>

  <?php 
  foreach (get_articles() as $row) { ?>
  <div class="indent">
    <h2><?= $row["title"] ?><br></h2>
    <h3><?= $row["short_title"] ?><br></h3>
    <p><?= $row["body"] ?><br></p>
  </div>
  <?php } ?>

<?php include("bottom.php"); ?>
