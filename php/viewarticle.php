<?php
# Shows all grades a student has earned. Student must be logged in.
include("db.php");
ensure_logged_in();
include("top.php"); ?>

<style>
.indent{
  margin-left: 20px;
  width: 400px;
  word-wrap: break-word;
  background-color: aliceblue;
}
</style>

<h2>Would you like to look up a specific article?</h2>
<form id="view_article" action="viewarticle.php" method="get">
    <fieldset>
        <label>Short Title: </label>
        <input type="text" id="short_title" name="short_title">
        
        <button id="submit" class="button">Search</button>

    </fieldset>
</form>

  <?php 
  $stitle = $_GET['short_title'];
  foreach (get_article($stitle) as $row) { ?>
  <div class="indent">
    <h2><?= $row["title"] ?><br></h2>
    Short title: <?= $row["short_title"] ?><br>
    <?= $row["body"] ?><br>
  </div>
  <?php } ?>

  <h3>Would you like to update <?php echo($stitle) ?>?</h3>
  
  <form id="update_title" action="updatearticle.php" method="post">  
    <fieldset>
      <label>Short Title: </label>
      <input type="text" id="stitle" name="short title" value="<?php echo($stitle) ?>" readonly>
      <br>

      <label>Title: </label>
      <input type="text" id="title" name="title" placeholder="title">
      <br>

      <label>Body:</label><br>
      <textarea id="body" name="body" placeholder="Put your body here!" rows="4" cols="50"></textarea>
      <br>
      <button id="submit" class="button">Update</button>
    </fieldset>
  </form>

<?php include("bottom.php"); ?>
