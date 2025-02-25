
<?php
$servername = "devweb2021.cis.strath.ac.uk";
$dbusername = "xqb20146";
$dbpassword = "heePai0tahpi";
$dbname = "xqb20146";

$con = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!doctype html>
<html>
<head>
    <title>Upload and Store video to MySQL Database with PHP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel ="apple-touch-icon" sizes="128x128" href="barbellap.png">
    <link rel ="icon" sizes="192x192" href="barbellan.png">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>screen.orientation.lock("portrait")</script>
</head>
<body>
<div>

    <?php
    $video = $_POST['vid'];
    $fetchVideos = mysqli_query($con, "SELECT * FROM videos WHERE id ='$video'");
    while($row = mysqli_fetch_assoc($fetchVideos)){
        $location = $row['location'];
        $name = $row['name'];
        $id = $row['id'];
        session_start();
        $_SESSION['vidid'] = $id;
        echo "<div style='float: left; margin-right: 5px;'>
          <video src='".$location."' controls width=100% height=100% ></video>    
          <br>
          <span>".$name."</span>
       </div>";
    }
    ?>

</div>


<br><div id="comments">
    <?php
    $chatroom = "chatroom";
    $chatroom .= $id;
    $sql = "SELECT * FROM `$chatroom`";
    $result = $con->query($sql);

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
</div>

<div id="allMesCon"></div>
<!-- Form to allow user to add to chat log -->

<form id="videochatForm" action='uploadvideochat.php' method="post" onsubmit="addVidMessage(); return false">
    <label for="addChat">Add chat:</label>
    <input type="text" id="addChat" name="addChat"><br><br>
    <!-- invisible input of username so others know who wrote the message -->
    <input type="hidden" id="chatUser" name="chatUser" value="">
    <input type="submit">
</form>

</div>

</body>
</html>
