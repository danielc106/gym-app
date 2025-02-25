<?php

$newPassword = strip_tags(isset($_GET["newPassword"]) ? $_GET["newPassword"] : "");
$email = strip_tags(isset($_GET["email"]) ? $_GET["email"] : "");




$servername = "devweb2021.cis.strath.ac.uk";
$dbusername = "xqb20146";
$dbpassword = "heePai0tahpi";
$dbname = "xqb20146";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


if($conn -> connect_error){
    die("Connection Failed: ".$conn->connect_error);
}

$sql = "UPDATE Users SET Password='$newPassword' WHERE Email='$email'";


if($conn->query($sql) === TRUE) {
    echo "Password updated";
} else{
    echo "$conn->error";
}

?>
