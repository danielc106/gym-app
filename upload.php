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

if(isset($_POST['but_upload'])){
    $maxsize = 5242880; // 5MB
    if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ''){
        $name = $_FILES['file']['name'];
        $target_dir = "videos/";
        $target_file = $target_dir . $_FILES["file"]["name"];
        $description = $_POST['description'];
        $username = $_POST['userUpload'];
        $description = $username . " - " . $description;
        $name = $description;

        // Select file type
        $extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Valid file extensions
        $extensions_arr = array("mp4","avi","3gp","mov","mpeg");

        // Check extension
        if( in_array($extension,$extensions_arr) ){

            // Check file size
            if(($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0)) {
                $_SESSION['message'] = "File too large. File must be less than 5MB.";
            }else{
                // Upload
                if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
                    // Insert record
                    $query = "INSERT INTO videos(name,location) VALUES('".$name."','".$target_file."')";

                    mysqli_query($con,$query);
                    $_SESSION['message'] = "Upload successfully.";


                    $fetchVideos = mysqli_query($con, "SELECT * FROM videos WHERE name = '$name'");
                    $row = mysqli_fetch_assoc($fetchVideos);
                    $chatid = "chatroom";
                    $chatid .= $row['id'];

                    $sql = "CREATE TABLE `$chatid`(
                        messageID int NOT NULL AUTO_INCREMENT, 
                        Username VARCHAR(255) NOT NULL,
                        Message VARCHAR(255) NOT NULL,
                        PRIMARY KEY (messageID)
                    )";

                    if ($con->query($sql) === TRUE) {
                        echo "Table created successfully";
                    } else {
                        echo "Error creating table: " . $con->error;
                    }

                }
            }

        }else{
            $_SESSION['message'] = "Invalid file extension.";
        }
    }else{
        $_SESSION['message'] = "Please select a file.";
    }
    header('location: home.php');
    exit;
}
?>
    <!doctype html>
    <html>
    <head>
        <title>Upload and Store video to MySQL Database with PHP</title>
    </head>
    <body>

    <!-- Upload response -->
<?php
if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
    </body>
</html>
