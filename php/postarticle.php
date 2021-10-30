<?php
# The make article form submits to here.
include("db.php");
$stitle = $_REQUEST["short_title"];
$title = $_REQUEST["title"];
$body = $_REQUEST["body"];
post_article($stitle, $title, $body);
?>
