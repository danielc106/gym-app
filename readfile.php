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
</head>
<body>
<div>

    <?php
    $fetchVideos = mysqli_query($con, "SELECT * FROM videos ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($fetchVideos)){
        $location = $row['location'];
        $name = $row['name'];
        $id = $row['id'];
        echo "<div style='float: left; margin-right: 5px;' >
          <video src='".$location."' controls width='1080px' height='720px' ></video>    
          <form name='go_to_video' method='post' action='gotovideo.php'>
            <button type='submit' name='vid' value = '$id'> Go To Video</button>
         
          </form>
          <br>
          <span>".$name."</span>
       </div>";
    }
    ?>

</div>

</body>
</html>
