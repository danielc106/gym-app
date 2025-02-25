<?php
$video = strip_tags(isset($_GET["vid"]) ? $_GET["vid"] : "");

$servername = "devweb2021.cis.strath.ac.uk";
$dbusername = "xqb20146";
$dbpassword = "heePai0tahpi";
$dbname = "xqb20146";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

$sql = "SELECT * FROM videos WHERE id ='$video'";
$result = $conn->query($sql);

