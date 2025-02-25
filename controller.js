'use strict';

// Import jquery
var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);

//stops soft keyboard from resizing screen
var meta = document.createElement('meta');
meta.name = 'viewport';
meta.content = 'width=device-width,height='+window.innerHeight+', initial-scale=1.0';
document.getElementsByTagName('head')[0].appendChild(meta);


const model = new Model();
const view = new View();

//Create random 6 digit code on load for if user wants to reset password
let code = Math.floor(100000 + Math.random() * 900000);

// REQUEST PERMISSIONS FOR SERVICE WORKER:

navigator.serviceWorker.register('./firebase-messaging-sw.js')
    .then((registration) => {
        messaging.useServiceWorker(registration);

        // Request permission and get token.....

        messaging
            .requestPermission()
            .then(function () {
                MsgElem.innerHTML = "Notification permission granted."

                // get the token in the form of promise
                return messaging.getToken()
            })
            .then(function (token) {
                // print the token on the HTML page
                TokenElem.innerHTML = "token is : " + token;
            })
            .catch(function (err) {
                ErrElem.innerHTML = ErrElem.innerHTML + "; " + err
            })
    });



// Check if user login is remembered
if (localStorage.getItem("remMe") == "true") {
    view.hidePopup()
    view.showHideNav()
    view.showPosts();
}


// GET USER POSITION AND CREATE MAP WHEN PAGE LOADS:

// Create global variables for user's position (initially Glasgow)

//When first running page this code is loaded before the map (giving correct coords) however when reloaded the opposite
// to stop that from happening, the coords are stored in local storage to then ensure they are loaded in first
let userLatitude = parseFloat(localStorage.getItem("Lat"));
let userLongitude = parseFloat(localStorage.getItem("Long"));

if (localStorage.getItem("Lat") === null) {
    userLatitude = 55.8642
    userLongitude = -4.2518
}

// Use HTML Geolocation API to get user's current position
function getUserPosition() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(setUserPosition);
    }else{
        console.log("Geo location not supported");
    }
}

// Update global variables for user's position
function setUserPosition(position) {
    userLatitude = position.coords.latitude;
    userLongitude = position.coords.longitude;
    localStorage.setItem("Lat" , userLatitude);
    localStorage.setItem("Long" , userLongitude);

}

// Function call gets user's position
getUserPosition()

// Following URL was used for guidance for initMap function:
// https://developers.google.com/maps/documentation/javascript/examples/place-search-pagination#maps_place_search_pagination-javascript
function initMap(position) {
    // Create the map.
    const userPosition = {lat: userLatitude, lng: userLongitude};
    const map = new google.maps.Map(document.getElementById("nearestGymsMap"), {
        center: userPosition,
        zoom: 15,
        mapId: "8d193001f940fde3",
    });
    // Create the places service.
    const service = new google.maps.places.PlacesService(map);
    let getNextPage;

    // Perform a nearby search.
    service.nearbySearch(
        {location: userPosition, radius: 10000, type: "gym"}, // Gyms within a 10,000 metre radius
        (results, status) => {
            if (status !== "OK" || !results) return;
            // Get location of each gym and mark them on map
            for (let i = 0; i < results.length; i++) {
                model.addToNearbyGyms(results[i].name,results[i].vicinity)
                let gymLat = results[i].geometry.location.lat()
                let gymLng = results[i].geometry.location.lng()
                new google.maps.Marker({
                    position: {lat: gymLat, lng: gymLng},
                    map,
                    title: results[i].name,
                })
            }
            let list = document.getElementById("gymList");
            model.getNearbyGyms().forEach((item)=>{
                let li = document.createElement("li");
                li.innerText = item;
                list.appendChild(li);
            })
        }
    );
}



//view.hidePosts()

// HANDLERS:

// Popup Handlers:

// All of them hide nav bar then show popup
view.setUpMapHandler(() => {
    view.showHideNav()
    view.showMapPopup()
    view.hidePosts()
})
view.setUpUploadHandler(() => {
    view.showHideNav()
    view.showUploadPopup()
    view.hidePosts()
    document.getElementById('userUpload').value = localStorage.getItem("username")
})
view.setUpChatRoomHandler(() => {
    view.showHideNav()
    view.showChatRoomPopup()
    view.updateHiddenUsernameInput()
    view.hidePosts()
})
view.setUpSettingsHandler(() => {
    view.showHideNav()
    view.showSettingsPopup()
    view.hidePosts()
})
view.setUpCalorieHandler(() => {
    view.showHideNav()
    view.showCaloriePopup()
    view.hidePosts()
})



// Button Handlers:

// Back button takes you back to home page and nav bar reappears
view.setUpBackButtonHandler(() => {
    view.showHideNav()
    view.hidePopup()
    getVideos()
})
view.setUpRegisterButtonHandler(() => {
    view.hidePopup()
    view.showRegisterPopup();
})
view.setUpLoginButtonHandler(() => {
    view.hidePopup()
    view.showLoginPopup();
})
view.setUpForgotPasswordButtonHandler(() => {
    view.hidePopup()
    view.showResetPasswordPopup();
})
view.setUpSendEmailButtonHandler(() => {
    view.hidePopup()
})
view.setUpLogoutHandler(() => {
    view.hidePopup()
    view.showLoginPopup()
    localStorage.setItem("remMe", "false")
})


// Calorie counter Handlers
view.ageInput()
view.heightInput()
view.weightInput()
view.genderRadio()
view.activityMenu()
view.calculateHandler(() => {
    let maintenanceCals;

    let w = model.getWeight();
    let h = model.getHeight();
    let a = model.getAge();
    let g = model.getGender();
    let act = model.getActivity();

    if(!(a < 80 && a > 15)){
        document.getElementById("calorieText").textContent = "This only works for ages from 15 to 80 to accurately" +
            " calculate maintenance calories"
    }else if(!(h > 54.6 && h < 272)){
        document.getElementById("calorieText").textContent = "Please enter a realistic weight"
    }
    else if(!(w > 3.9 && w < 635)){
        document.getElementById("calorieText").textContent = "Please enter a realistic height"
    }else{
        maintenanceCals = calcCals(w,h,a,g,act);
        document.getElementById("calorieText").textContent = "Your maintenance calories are: " + maintenanceCals
            + " Kcal. for a bulk a recommended amount of calories are 200 above maintenance: " + (maintenanceCals + 200) +
            " Kcal. for a cut 200 below: " + (maintenanceCals - 200) + " Kcal.";
    }

})

function regUser () {
    let email = $("#registerEmail").val()
    let username = $("#registerUsername").val();
    let password = $("#newPassword").val();
    let confirmPassword = $("#confirmPassword").val();
    if (password == confirmPassword) {
        $.get("users.php", {email: email, username: username, password: password}, function (data) {
            if (data.includes("account successfully created")) {
                localStorage.setItem("username", username)
                enterApp();
            }
            alert(data);
        })
    } else {
        alert("Passwords do not match")
    }
}
function loginUser () {
    let email = $("#email").val();
    let password = $("#password").val();
    $.get("login.php", { email: email, password: password }, function(data){
        alert(data);
        if (data == "login successful") {
            getUser(email)
            view.remMeCheckbox()
            enterApp()
        }
    })
}
function getUser(email) {
    $.get("getUser.php", { email: email }, function(data){
        let user = String(data)
        localStorage.setItem("username", user)
    })
}

let globalEmail = "";

function checkEmail () {
    let email = $("#emailForReset").val();
    $.get("checkEmail.php", { email: email, code: code }, function(data){
        alert(data);
        if (data == "email exists") {
            globalEmail = email;
            view.hidePopup();
            view.showCodePopup();
        }
    })
}
function checkCode () {
    let resetCode = $("#codeForReset").val();
    if (resetCode == code) {
        view.hidePopup();
        view.showNewPassword();
    } else {
        alert("Code is incorrect");
    }
    return false;
}
function updatePass () {
    let newPassword = $("#updatePassword").val();
    let confirmPassword = $("#confirmUpdatePassword").val();
    if (newPassword == confirmPassword) {
        $.get("updatePassword.php", {email: globalEmail, newPassword: newPassword}, function (data) {
            if (data == "Password updated") {
                view.hidePopup();
                view.showLoginPopup();
            }
        })
    } else {
        alert("Passwords don't match")
    }
}
function addMessage () {
    let message = $("#addChat").val();
    let username = localStorage.getItem("username");
    $.get("chatroom.php", { chatUser: username, addChat: message }, function(data){
    })
}
let globalMessages = [];
function getMessages() {
    $.get( "getMessages.php", function(data) {
        let chat = String(data);
        let allMessages = chat.split(";")
        if (allMessages.length - 1 > globalMessages.length) {
            let myDiv = document.getElementById("allMesCon");
            myDiv.scrollTop = myDiv.scrollHeight;
        }
        for (let i = 0; i < allMessages.length; i++) {
            if (globalMessages.includes(allMessages[i]) == false) {
                let newChat = allMessages[i].split(",")
                let user = newChat[0].split(":")[1]
                let userMes = newChat[1].split(":")[1]
                const messageContainer = document.createElement("div");
                messageContainer.setAttribute("id", "mesCon"+i)
                messageContainer.setAttribute("class", "mesCon")
                const message = document.createElement("p");
                message.innerText = user + ": " + userMes;
                document.getElementById("allMesCon").appendChild(messageContainer);
                document.getElementById("mesCon"+i).appendChild(message);
                globalMessages.push(allMessages[i])
            }
        }
    });
}
getMessages();
setInterval(()=>{
    getMessages();
}, 2000)

let globalVideos = [];
let globalID = 0;

function getVideos() {
    view.showPosts();
    $.get( "getVideos.php", function(data) {
        let videos = String(data);
        let allVideos = videos.split(";")
        console.log("allVideos: "+allVideos);
        for (var i = 0; i < allVideos.length; i++) {
            if (globalMessages.includes(allVideos[i]) == false) {
                let newVideo = allVideos[i].split(",")
                console.log(newVideo)
                let location = newVideo[0].split(":")[1]
                let name = newVideo[1].split(":")[1]
                let id = newVideo[2].split(":")[1]
                console.log(location)
                console.log(name)
                console.log(id)
                const vidDiv = document.createElement("div");
                vidDiv.setAttribute("style", "float: left; margin-right: 5px;");
                vidDiv.innerHTML = "<div class='nameDiv'><p  class='name'><span>" + name + "</span></p>"
                    + "<div class='video-container'><video src='" + location + "' controls width='1080px' height='720px' ></video></div>"
                    + `<form name='go_to_video' onsubmit='goToVid("` + id + `","` + name + `","` + location + `"); return false;'>`
                    + "<button class='goVidBtn' type='submit'> Comments</button></form><br>"

                document.getElementById("showPosts").appendChild(vidDiv)
                globalMessages.push(allVideos[i])
            }
        }
    })
}

function goToVid(id, name, location) {
    view.showHideNav()
    globalID = id
    let elements = document.getElementById('showPosts');
    elements.style.display = "none";
    document.getElementById("goToPost").style.display = "inline"
    console.log(location)
    const vidPopup = document.createElement("div");
    vidPopup.innerHTML = "<div id='goToVidDiv' style='float: left; margin-right: 5px;'>"+
        "<span>"+name+"</span>"+
        "<div class='video-container'><video src='"+location+"' controls width='1080px' height='720px' ></video></div></div>"+
    document.getElementById("goToPost").appendChild(vidPopup);

    $.get( "getComments.php", { id: id}, function(data) {
        let chat = String(data);
        let allMessages = chat.split(";")

        for (let i = 0; i < allMessages.length; i++) {
                let newChat = allMessages[i].split(",")
                let user = newChat[0].split(":")[1]
                let userMes = newChat[1].split(":")[1]
                const messageContainer = document.createElement("div");
                messageContainer.setAttribute("id", "commentContainer"+i)
                messageContainer.setAttribute("class", "mesCon")
                const message = document.createElement("p");
                message.innerText = user + ": " + userMes;
                document.getElementById("allCommentsContainer").appendChild(messageContainer);
                document.getElementById("commentContainer"+i).appendChild(message);
        }
    })
}

function refreshComments() {
    $.get( "getComments.php", { id: globalID}, function(data) {
        let chat = String(data);
        let allMessages = chat.split(";")

        for (let i = 0; i < allMessages.length; i++) {
            let newChat = allMessages[i].split(",")
            let user = newChat[0].split(":")[1]
            let userMes = newChat[1].split(":")[1]
            const messageContainer = document.createElement("div");
            messageContainer.setAttribute("id", "commentContainer"+i)
            messageContainer.setAttribute("class", "mesCon")
            const message = document.createElement("p");
            message.innerText = user + ": " + userMes;
            document.getElementById("allCommentsContainer").appendChild(messageContainer);
            document.getElementById("commentContainer"+i).appendChild(message);
        }
})
}

function addVidMessage () {
    let message = $("#addCom").val();
    let username = localStorage.getItem("username");
    console.log(username + ": " + message)
    $.get("uploadvideochat.php", { chatUser: username, addChat: message, id: globalID }, function(data){
    alert(data)})
}



function enterApp () {
    localStorage.setItem("username", document.getElementById("registerUsername").value)
    view.hidePopup()
    view.showHideNav()
    view.showPosts();
}



function calcCals(w,h,a,g,act){
    let BMR;
    let maintenanceCals;

    if(g === 'male'){
        BMR = (10*w) + (6.25*h) - (5*a) + 5;
    }else{
        BMR = (10*w) + (6.25*h) - (5*a) - 161;
    }

    if(act === 'none'){
        maintenanceCals = BMR;
    }else if(act === 'little'){
        maintenanceCals = BMR + 45*((22*w)/200);
    }else if(act === 'light'){
        maintenanceCals = BMR + 75*((20*w)/200);
    }else if(act === 'moderate'){
        maintenanceCals = BMR + 115*((18*w)/200);
    }else if(act === 'active'){
        maintenanceCals = BMR + 100*((22.5*w)/200);
    }else if(act === 'activePlus'){
        maintenanceCals = BMR + 135*((24*w)/200);
    }
    return maintenanceCals;
}

document.getElementById('userUpload').value = localStorage.getItem("username")
