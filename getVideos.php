<?php
$servername = "devweb2021.cis.strath.ac.uk";
$dbusername = "xqb20146";
$dbpassword = "heePai0tahpi";
$dbname = "xqb20146";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

$sql = "SELECT * FROM videos ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "location:".$row['location'].", name:".$row['name'].", id:".$row['id'].";";
    }
} else {
    echo "0 results";
}
    ?>
