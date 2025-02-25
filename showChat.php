<?php
function connectOrDie(){
    $username = "xqb20146"; $password = "heePai0tahpi"; $servername = "devweb2021.cis.strath.ac.uk"; $database = "xqb20146";

    $mysqli = new mysqli($username ,$password,$servername,$database);
    if($mysqli->connect_errno){
        die("Connect failed: %s".$mysqli->connect_error);
    }
    return $mysqli;
}
function getPosts($mysqli, $fromID){
    if ($result = $mysqli->query("SELECT * FROM `chat317` where insertID>=$fromID")) {
        $comments = array();

        while( $row =  $result->fetch_array(MYSQLI_ASSOC) ) {
            $comments[] = $row;
        }
        $result->close();

        return $comments;
    } else {
        die("Query failed: %s ". $mysqli->error);
    }
}

header("Content-Type: text/plain");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past


$mysqli = connectOrDie();
$firstID = isset($_GET["startID"]) ? $mysqli->real_escape_string($_GET["startID"]) : 0;
$lines = getPosts($mysqli, $firstID);
foreach ($lines as $line) {
    echo json_encode( $line ) . "\n" ;
}
?>
