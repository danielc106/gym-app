
<?php

$email = strip_tags(isset($_GET["email"]) ? $_GET["email"] : "");
$username = strip_tags(isset($_GET["username"]) ? $_GET["username"] : "");
$password = strip_tags(isset($_GET["password"]) ? $_GET["password"] : "");




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

if($result->num_rows > 0) {
    die("Email already exists");
}

$sql2 = "SELECT * FROM Users WHERE Username = '$username'";
$result2 = $conn->query($sql2);

if($result2->num_rows > 0) {
    die("Username already exists");
}

$sql3 = "INSERT INTO `Users` (`email`, `username`, `password`) VALUES ('$email', '$username', '$password')";

if($conn->query($sql3) === TRUE) {
    echo "account successfully created";
} else{
    die("Error on Insert".$conn->error);
}

?>
