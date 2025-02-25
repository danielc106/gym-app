'use strict';

class View {

    // Set up handlers for nav bar buttons:
    setUpMapHandler(handler){
        document.getElementById("map").addEventListener("click", handler)
    }
    setUpUploadHandler(handler){
        document.getElementById("upload").addEventListener("click", handler)
    }
    setUpChatRoomHandler(handler){
        document.getElementById("chatRoom").addEventListener("click", handler)
    }
    setUpSettingsHandler(handler){
        document.getElementById("settings").addEventListener("click", handler)
    }
    setUpCalorieHandler(handler){
        document.getElementById("calorie").addEventListener("click", handler)
    }

    // Set up handlers for other buttons:
    setUpBackButtonHandler(handler) {
        let elements = document.querySelectorAll(".backButton")
        for (let i = 0; i < elements.length; i++) {
            elements[i].addEventListener("click", handler)
        }
    }
    setUpSubmitButtonHandler(handler) {
        let elements = document.querySelectorAll(".submitForm")
        for (let i = 0; i < elements.length; i++) {
            elements[i].addEventListener("click", handler)
        }
    }
    setUpRegisterButtonHandler(handler) {
        let elements = document.querySelectorAll(".registerButton")
        for (let i = 0; i < elements.length; i++) {
            elements[i].addEventListener("click", handler)
        }
    }
    setUpLoginButtonHandler(handler) {
        let elements = document.querySelectorAll(".loginButton")
        for (let i = 0; i < elements.length; i++) {
            elements[i].addEventListener("click", handler)
        }
    }
    setUpForgotPasswordButtonHandler(handler) {
        let elements = document.querySelectorAll(".forgotPasswordButton")
        for (let i = 0; i < elements.length; i++) {
            elements[i].addEventListener("click", handler)
        }
    }
    setUpSendEmailButtonHandler(handler) {
        document.getElementById("sendEmail").addEventListener("click", handler)
    }
    setUpLogoutHandler(handler) {
        document.getElementById("logout").addEventListener("click", handler)
    }
    showInitialPosts(handler){
        document.getElementById("loginBtn").addEventListener('click',handler);
    }
    remMeCheckbox() {
    if (document.getElementById("remMe").checked) {
        localStorage.setItem("remMe", "true");
    } else {
        localStorage.setItem("remMe", "false");
    }
}



    // Show a popup:
    showMapPopup(){
        document.getElementById("mapPopup").style.display = "inline";
    }
    showUploadPopup(){
        document.getElementById("uploadPopup").style.display = "inline";
    }
    showChatRoomPopup(){
        document.getElementById("chatRoomPopup").style.display = "inline";
    }
    showSettingsPopup(){
        document.getElementById("settingsPopup").style.display = "inline";
    }
    showRegisterPopup(){
        document.getElementById("register").style.display = "inline";
    }
    showLoginPopup(){
        document.getElementById("login").style.display = "inline";
    }
    showResetPasswordPopup(){
        document.getElementById("resetPassword").style.display = "inline";
    }
    showCodePopup(){
        document.getElementById("codePopup").style.display = "inline";
    }
    showNewPassword(){
        document.getElementById("newPasswordPopup").style.display = "inline";
    }
    showCaloriePopup(){
        document.getElementById("caloriePopup").style.display = "inline";
    }


    // Hide any of the popups:
    hidePopup(){
        let elements = document.querySelectorAll(".popup")
        for (let i = 0; i < elements.length; i++) {
            elements[i].style.display = "none";
        }
    }

    // Toggle nav bar as visible or not visible
    showHideNav(){
        let x = document.getElementById('nav')
        if (x.style.display === 'none') {
            x.style.display = 'flex';
        } else {
            x.style.display = 'none';
        }
    }
    //hide posts
    hidePosts(){
        let elements = document.getElementById('showPosts');
            elements.style.display = "none";
    }

    showPosts(){
        let elements = document.getElementById('showPosts');
        elements.style.display = 'inline';
        const viewport = document.querySelector('meta[name="viewport"]');

        if ( viewport ) {
            viewport.content = "initial-scale=0.1";
            viewport.content = "width=1200";
        }
    }


    updateHiddenUsernameInput(){
        const chatForm = document.getElementById("chatForm");
        chatForm.querySelector('input[name="chatUser"]').value = localStorage.getItem("username");
    }

    // Handlers for Calorie Counter

    ageInput(){
        let input = document.getElementById("age");
        input.addEventListener("input",()=>{
            model.setAge(input.value);
        });
    }

    heightInput(){
        let input = document.getElementById("height");
        input.addEventListener("input",()=>{
            model.setHeight(input.value);
        });
    }

    weightInput(){
        let input = document.getElementById("weight");
        input.addEventListener("input",()=>{
            model.setWeight(input.value);
        });
    }

    genderRadio() {
        let temp;
        let genderBtn = localStorage.getItem("genderBtn");
        temp = genderBtn;
        if (temp == null) {
            temp = "male";
        }
        let defGenBtn = document.getElementById(temp);
        defGenBtn.checked = true;

        if (defGenBtn.checked) {
            model.setGender(defGenBtn.value);
        }

        const radioBtn = document.calorieForm.gen;
        for (let i = 0; i < radioBtn.length; i++) {
            radioBtn[i].addEventListener("change", () => {
                if (radioBtn[i].checked) {
                    model.setGender(radioBtn.value);
                    genderBtn = radioBtn[i].id;
                    localStorage.setItem("genderBtn", genderBtn);
                }
            });
        }
    }

    activityMenu(){
        let dropMenu = document.getElementById("activity");
        dropMenu.addEventListener('change',() =>{
           model.setActivity(dropMenu.value);
        });
    }

    calculateHandler(handler){
        let calcBtn = document.getElementById("calculate");
        calcBtn.addEventListener("click",handler);
    }

}
