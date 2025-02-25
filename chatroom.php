<?php
$username = strip_tags(isset($_GET["chatUser"]) ? $_GET["chatUser"] : "");
$message = strip_tags(isset($_GET["addChat"]) ? $_GET["addChat"] : "");

$servername = "devweb2021.cis.strath.ac.uk";
$dbusername = "xqb20146";
$dbpassword = "heePai0tahpi";
$dbname = "xqb20146";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


if($conn -> connect_error){
die("Connection Failed: ".$conn->connect_error);
}

$sql = "INSERT INTO `Chatroom` (`user`, `message`) VALUES ('$username', '$message')";

if($conn->query($sql) === TRUE) {
echo "success";
} else{
die("Error");
}

?>
