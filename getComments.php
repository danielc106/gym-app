<?php
$id = strip_tags(isset($_GET["id"]) ? $_GET["id"] : "");

$servername = "devweb2021.cis.strath.ac.uk";
$dbusername = "xqb20146";
$dbpassword = "heePai0tahpi";
$dbname = "xqb20146";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

$chatroom = "chatroom";
$chatroom .= $id;
$sql = "SELECT * FROM `$chatroom`";
$result = $conn->query($sql);

$messages = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "user:" . $row["Username"]. ", message:" . $row["Message"] . ";";
    }
} else {
    echo "0 results";
}

$result->close();
?>
