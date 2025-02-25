<?php

$email = strip_tags(isset($_GET["email"]) ? $_GET["email"] : "");




$servername = "devweb2021.cis.strath.ac.uk";
$dbusername = "xqb20146";
$dbpassword = "heePai0tahpi";
$dbname = "xqb20146";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if($conn -> connect_error){
    die("Connection Failed: ".$conn->connect_error);
}

$sql = "SELECT * FROM Users WHERE Email = '$email'";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo $row["Username"];
}
