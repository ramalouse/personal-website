<?php
//session_save_path("/var/www/html/stepp/grades/sessions/");
if (!isset($_SESSION)) { session_start(); }

# Returns TRUE if given password is correct password for this user name.
function is_password_correct($name, $password) {
  $db = new PDO("mysql:host=localhost;dbname=wiki", "root", "");
  $name = $db->quote($name);
  $rows = $db->query("SELECT password FROM users WHERE name = $name");
  if ($rows) {
    foreach ($rows as $row) {
      $correct_password = $row["password"];
      return $password === $correct_password;
    }
  } else {
    return FALSE;   # user not found
  }
}

function user_exist($name) { //done dont even think about touch
  $db = new PDO("mysql:host=localhost;dbname=wiki", "root", "");
  $name = $db->quote($name);
  $rows = $db->query("SELECT name FROM users WHERE name = $name");
  if ($rows) {
    foreach ($rows as $row) {
      $user = $row["password"];
      return $user !== $name; #user found
    }
  } else {
    return FALSE; #user not found
  }
}

function register($name, $password) { //done do not touch
  $db = mysqli_connect("localhost", "root", "", "wiki");
  $query = "INSERT INTO users VALUES ('$name', '$password')";
  if (!mysqli_query($db, $query)) {
    die('Error '.mysqli_error($db));
  } 
}

function post_article($stitle, $title, $body) { //done do not touch
  $db = mysqli_connect("localhost", "root", "", "wiki");
  $query = "INSERT INTO articles VALUES ('$stitle', '$title', '$body')";
  if (empty($stitle) || empty($title) || empty($body)) { //this took me WAY too long to figure out. Okay? A simple if statement. Way too long. I am actually ashamed of myself.
    redirect("writearticle.php", "Please provide a short title, title, and body.");
  } elseif (!mysqli_query($db, $query)) {
    return redirect("writearticle.php", "Article with short title $stitle already exists!");
    // die('Error '.mysqli_error($db));
  } else {
    redirect ("viewarticle.php?short_title=$stitle", "Article Posted!");
    exit();
  }
}

function get_articles() {
  $db = mysqli_connect("localhost", "root", "", "wiki");
  // $query = "SELECT * FROM articles";
  return $db->query("SELECT * FROM articles");
}

function get_article($stitle) {
  $db = mysqli_connect("localhost", "root", "", "wiki");
  // $query = "SELECT * FROM articles";
  return $db->query("SELECT * FROM articles WHERE short_title = '{$stitle}'");
}

function update_title($stitle, $title) {
  $db = mysqli_connect("localhost", "root", "", "wiki");
  if (empty($title)){
    redirect("viewarticle.php?short_title=$stitle", "Please provide title text");
  } else{
    $db->query("UPDATE articles SET title = '$title' WHERE short_title = '$stitle'");
    redirect("viewarticle.php?short_title=$stitle", "Succesfully updated title!");
  }
}

function update_body($stitle, $body) {
  $db = mysqli_connect("localhost", "root", "", "wiki");
  if (empty($body)){
    redirect("viewarticle.php?short_title=$stitle", "Please provide title text");
  } else{
    $db->query("UPDATE articles SET body = '$body' WHERE short_title = '$stitle'");
    redirect("viewarticle.php?short_title=$stitle", "Succesfully updated body!");
  }
}

function update_article($stitle, $title, $body) {
  $db = mysqli_connect("localhost", "root", "", "wiki");
  if (empty($body) && empty($title)){
    redirect("viewarticle.php?short_title=$stitle", "Please provide title/body text");
  } else{
    $db->query("UPDATE articles SET title = '$title' WHERE short_title = '$stitle'");
    $db->query("UPDATE articles SET body = '$body' WHERE short_title = '$stitle'");
    redirect("viewarticle.php?short_title=$stitle", "Succesfully updated title and body!");
  }
}

# Redirects current page to login.php if user is not logged in.
function ensure_logged_in() {
  if (!isset($_SESSION["name"])) {
    redirect("user.php", "You must log in before you can view that page.");
  }
}

# Redirects current page to the given URL and optionally sets flash message.
function redirect($url, $flash_message = NULL) {
  if ($flash_message) {
    $_SESSION["flash"] = $flash_message;
  }
  # session_write_close();
  header("Location: $url");
  die;
}
?>
