<?php
function connectOrDie(){
    $username = "xqb20146"; $password = "heePai0tahpi"; $servername = "devweb2021.cis.strath.ac.uk"; $database = "xqb20146";

    $mysqli = new mysqli($username ,$password,$servername,$database);
    if($mysqli->connect_errno){
        die("Connect failed: %s".$mysqli->connect_error);
    }
    return $mysqli;
}

function addNewPost($mysqli,$post,$postID){
    if ($mysqli->query('INSERT INTO chat317 (`message`, `uid`)VALUES (\''.$post.'\', '.$postID.')'))
        return $postID;
    else
        die("Query failed: %s".$mysqli->error);
}
$mysqli = connectOrDie();
$post     = $mysqli->real_escape_string(urldecode ($_POST["msg"]));
$postID   = $mysqli->real_escape_string(urldecode ($_POST["uid"]));
$id       = addNewPost($mysqli, $post, $postID);
echo "$id";
?>
