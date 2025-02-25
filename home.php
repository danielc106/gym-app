<!DOCTYPE html>
<html lang="en">

<head>
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


<!-- REGISTER/LOGIN -->

<!-- Start Screen -->
<div id="start" class="popup">
    <h1>Welcome, please login or register to continue</h1>
    <button class="registerButton">Register</button>
    <button class="loginButton">Login</button>
</div>

<!-- Login Screen (not displaying for now) -->
<div id="login" class="popup" style="display:none">
    <h1>Login<img src="barbellan.png" alt = "" /></h1>
    <!-- Form for user to input account details -->
    <form id="loginForm" onsubmit="if (checkLoginForm() == true) { loginUser(); return false } else { return false }">
        <label for="email"></label>
        <input type="text" id="email" name="email" placeholder="Enter Email"><br><br>
        <label for="password"></label>
        <input type="password" id="password" name="password" placeholder="Enter Password"><br><br>
        <label for="remMe">Remember me</label>
        <input type="checkbox" id="remMe" name="remMe">
        <input type="submit" class="submitForm" id="loginBtn">
    </form>
    <!-- Allow user to register or reset their password instead -->
    <button class="registerButton">Register instead</button>
    <button class="forgotPasswordButton">Forgot my password</button>
</div>


<!-- Registration Screen (not displaying for now) -->
<div id="register" class="popup" style="display:none">
    <h1>Register</h1>
    <p>Create your account to get started:</p>
    <!-- Form for user to create account -->
    <form id="regForm" onsubmit="if (checkRegForm() == true) { regUser(); return false } else { return false }">
        <label for="registerEmail"></label>
        <input type="text" id="registerEmail" name="registerEmail" placeholder="Enter Email" required>
        <label for="registerUsername"></label>
        <input type="text" id="registerUsername" name="registerUsername" placeholder="Enter Username" required>
        <label for="newPassword"></label>
        <input type="password" id="newPassword" name="newPassword" placeholder="Enter Password" required>
        <label for="confirmPassword"></label>
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required><br><br>
        <input type="submit" class="submitForm">
    </form>
    <button class="loginButton">Login instead</button>
</div>


<!-- Forgot Password Screen (not displaying for now) -->
<div id="resetPassword" class="popup" style="display:none">
    <!-- Form that asks user for account email and a reset link will be sent on submit -->
    <form id="resetPasswordForm" onsubmit="checkEmail(); return false">
        <label for="emailForReset"></label>
        <input type="text" id="emailForReset" name="emailForReset" placeholder="Enter Email"><br><br>
        <input type="submit" id="sendEmail" class="submitForm" value="Send Email">
    </form>
    <button class="loginButton">Go back</button>
</div>



<!-- Enter Code Popup (not displaying for now) -->
<div id="codePopup" class="popup" style="display:none">
    <!-- Form that asks user for account email and a reset link will be sent on submit -->
    <form id="enterCodeForm" onsubmit="checkCode(); return false">
        <label for="codeForReset">Code from email</label>
        <input type="text" id="codeForReset" name="codeForReset"><br><br>
        <input type="submit" id="submitCode" class="submitForm" value="Submit Code"/>
    </form>
    <button class="forgotPasswordButton">Go back</button>
</div>


<!-- Create new password (not displaying for now) -->
<div id="newPasswordPopup" class="popup" style="display:none">
    <!-- Form that asks user for account email and a reset link will be sent on submit -->
    <form id="newPasswordForm" onsubmit="if (checkNewPasswordForm() == true) { updatePass(); return false } else { return false }">
        <label for="updatePassword">Enter new password</label>
        <input type="text" id="updatePassword" name="updatePassword"><br><br>
        <label for="confirmUpdatePassword">Confirm new password</label>
        <input type="text" id="confirmUpdatePassword" name="confirmUpdatePassword"><br><br>
        <input type="submit">
    </form>
    <button class="forgotPasswordButton">Go back</button>
</div>



<!-- AFTER USER LOGIN -->

<!-- Posts (Main Page) -->
<div id="title">
   <h2>G3T FIT APP<img src="barbellan.png" alt = "" /> </h2>
    <h3> Posts <button onclick="getVideos()">Refresh</button></h3>

</div>
<div id="showPosts"></div>
<div id="vidChat"></div>
<div id="posts">

</div>

<!-- Go to post --->
<div id="goToPost" class="popup" style="display:none">

    <div id="allCommentsContainer"></div>
    <form id="comForm" onsubmit="addVidMessage(); return false;">
        <label for="addCom">Add chat:</label>
        <input type="text" id="addCom" name="addCom"><br><br>
        <input type="submit">
    </form>
    <button class="backButton" onclick="let elements = document.getElementById('showPosts'); elements.style.display = 'inline'; document.getElementById('goToVidDiv').remove(); document.getElementById('allCommentsContainer').innerHTML=''">Back</button>
    <button onclick="document.getElementById('allCommentsContainer').innerHTML = ''; refreshComments()">Refresh</button>

</div>

<!-- Map Popup -->
<div id="mapPopup" class="popup" style="display:none">
    <button class="backButton">Back</button>
    <h1 class="header">Your Nearest Gyms <img src="barbellan.png" alt = "" /> </h1>
    <div id="nearestGymsMap" style="width:100%; height:25em; display: flex;" ></div>
    <ul id="gymList" class="gymList"> </ul>
</div>


<!-- Upload Popup -->
<div id="uploadPopup" class="popup" style="display:none">
    <h1 class="header">Upload video here <img src="barbellan.png" alt = "" /></h1>
    <!-- Form for the user to create a post -->
    <form method="post" action="upload.php" enctype='multipart/form-data'>
        <input type='file' name='file' />
        <br><input type="text" name="description" placeholder="Add Description">
        <input type="hidden" id="userUpload" name="userUpload" value="" />
        <br><input type='submit' value='Upload' name='but_upload'>
    </form>

    <button class="backButton">Back</button>
</div>


<!-- Chat Room Popup -->
<div id="chatRoomPopup" class="popup" style="display:none">
    <h1 class="header">Chat with others here <img src="barbellan.png" alt = "" /></h1>
    <div id="allMesCon"></div>
    <!-- Form to allow user to add to chat log -->
    <form id="chatForm" onsubmit="if (checkChatForm() == true) { addMessage(); return false } else { return false }">
        <label for="addChat">Add chat:</label>
        <input type="text" id="addChat" name="addChat"><br><br>

        <!-- invisible input of username so others know who wrote the message -->
        <input type="hidden" id="chatUser" name="chatUser" value="">

        <input type="submit">
    </form>
    <button class="backButton">Back</button>
</div>

<div id="settingsPopup" class="popup" style="display:none">
    <h1>Logout <img src="barbellan.png" alt = "" /> </h1>
    <button class="logout" id="logout">Logout</button>
    <button class="backButton">Back</button>
</div>

<div id="settingsPopup" class="popup" style="display:none">
    <button id="logout">Logout</button>
</div>
<!-- Calorie popup -->
<div id="caloriePopup" class="popup" style="display:none">
    <h1 class="header">Estimate Maintenance Calories <img src="barbellan.png" alt = "" /></h1>
    <form name="calorieForm" id="calorieForm">
        <form name="genderForm">
            <p>Select gender</p>
            <label class="gender">
                <input type="radio" id="male" name="gen" value="male"> Male
                <span class="checkmark"></span>
            </label>
            <label class="gender">
                <input type="radio" id="female" name="gen" value="female"> Female
                <span class="checkmark"></span>
            </label><br><br>
        </form>
        <label for="age"></label>
        <input type="number" id="age" name="age" placeholder="Enter age" min="18" class="inputCalBox" required><br><br>
        <label for="height"></label>
        <input type="number" id="height" name="height" placeholder="Enter Height (cm)" class="inputCalBox" required><br><br>
        <label for="weight"></label>
        <input type="number" id="weight" name="weight" placeholder="Enter Weight (Kg)" class="inputCalBox" required><br><br>
        <label for="activity">Activity level:</label><br><br>
        <select name="activity" id="activity"  class="dropDown">
            <option value="none">Basal Metabolic Rate (Absolute no activity)</option>
            <option value="little">Little to none</option>
            <option value="light">light: 1-3 times/week</option>
            <option value="moderate">moderate: 4-5 times/week</option>
            <option value="active">Active: daily or intense 3-4 times/week</option>
            <option value="activePlus">Very Active: intense exercise 6-7 times/week</option>
        </select><br><br>
    </form>
    <button class="calculate" id="calculate">calculate calories</button>
    <p class="text" id="calorieText""></p>
    <button class="backButton">Back</button>
</div>




<!-- Navigation bar: -->
<div id="nav" style="display:none">
    <div id="map" style="flex-grow: 1">Map</div>
    <div id="upload" style="flex-grow: 1">Upload</div>
    <div id="chatRoom" style="flex-grow: 1">Chat</div>
    <div id="calorie" style="flex-grow: 1">Calories</div>
    <div id="settings" style="flex-grow: 1">Logout</div>
</div>




<!-- Load MVC -->
<script src="model.js"></script>
<script src="view.js"></script>
<script src="controller.js"></script>


<!-- Load Map -->
<script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFreTEyyBBRaiJ2WeAoZ2XBJE7Kbb5FsE&callback=initMap&libraries=places&v=weekly"
></script>


<!-- Form Validation -->
<script>
    function checkRegForm(){
        let email = document.forms["regForm"]["registerEmail"];
        let username = document.forms["regForm"]["registerUsername"];
        let password = document.forms["regForm"]["newPassword"];
        let confirmPassword = document.forms["regForm"]["confirmPassword"];
        let errs = "";

        email.style.background = "white";
        username.style.background = "white";
        password.style.background = "white";
        confirmPassword.style.background = "white";

        if ( (email.value==null) || (email.value=="")) {
            errs += "   * Email must not be empty\n";
            email.style.background = "pink";
        }

        if ( (username.value==null) || (username.value=="")) {
            errs += "   * Username must not be empty\n";
            username.style.background = "pink";
        }

        if ( (password.value==null) || (password.value=="")) {
            errs += "   * Password must not be empty\n";
            password.style.background = "pink";
        }

        if ( (confirmPassword.value==null) || (confirmPassword.value=="")) {
            errs += "   * Confirm Password must not be empty\n";
            confirmPassword.style.background = "pink";
        }

        if (errs!=""){
            alert("Sorry the following need corrected:\n"+errs);
            return false;
        } else {
            return true;
        }
    }

    function checkLoginForm() {
        let email = document.forms["loginForm"]["email"];
        let password = document.forms["loginForm"]["password"];
        let errs = "";

        email.style.background = "white";
        password.style.background = "white";

        if ((email.value == null) || (email.value == "")) {
            errs += "   * Email must not be empty\n";
            email.style.background = "pink";
        }

        if ((password.value == null) || (password.value == "")) {
            errs += "   * Password must not be empty\n";
            password.style.background = "pink";
        }

        if (errs != "") {
            alert("Sorry the following need corrected:\n" + errs);
            return false;
        } else {
            return true;
        }
    }

    function checkChatForm() {
        let chat = document.getElementById("addChat");
        let errs = "";

        chat.style.background = "white";

        if ((chat.value == null) || (chat.value == "")) {
            errs += "   * Message must not be empty\n";
            chat.style.background = "pink";
        }

        if ((chat.value.includes(",")) || (chat.value.includes(";")) || (chat.value.includes(":"))) {
            errs += "   * Message must not contain commas, colons or semi colons\n";
            chat.style.background = "pink";
        }

        if (errs != "") {
            alert("Sorry the following need corrected:\n" + errs);
            return false;
        } else {
            return true;
        }
    }

    function checkNewPasswordForm() {
        let updatePassword = document.getElementById("updatePassword");
        let confirmUpdatePassword = document.getElementById("confirmUpdatePassword");
        let errs = "";

        updatePassword.style.background = "white";
        confirmUpdatePassword.style.background = "white";

        if ((updatePassword.value == null) || (updatePassword.value == "")) {
            errs += "   * New password must not be empty\n";
            updatePassword.style.background = "pink";
        }

        if ((confirmUpdatePassword.value == null) || (confirmUpdatePassword.value == "")) {
            errs += "   * Confirm new password must not be empty\n";
            confirmUpdatePassword.style.background = "pink";
        }

        if (errs != "") {
            alert("Sorry the following need corrected:\n" + errs);
            return false;
        } else {
            return true;
        }
    }

</script>




</body>
</html>
