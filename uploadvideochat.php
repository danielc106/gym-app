<?php
$username = strip_tags(isset($_GET["chatUser"]) ? $_GET["chatUser"] : "");
$message = strip_tags(isset($_GET["addChat"]) ? $_GET["addChat"] : "");
$id = strip_tags(isset($_GET["id"]) ? $_GET["id"] : "");


$servername = "devweb2021.cis.strath.ac.uk";
$dbusername = "xqb20146";
$dbpassword = "heePai0tahpi";
$dbname = "xqb20146";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


if($conn -> connect_error){
    die("Connection Failed: ".$conn->connect_error);
}
session_start();
$chatroom = "chatroom";
$chatroom .= $id;


$sql = "INSERT INTO `$chatroom` (`Username`, `Message`) VALUES ('$username', '$message')";

if($conn->query($sql) === TRUE) {
    echo "success";
} else{
    die("Error");
}

?>
