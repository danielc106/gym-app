importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-messaging.js');
//Initialise Firebase
const firebaseConfig = {
    apiKey: "AIzaSyDPt6QhosrkJjTjhjxYtQk1jCo5kVepiMI",
    authDomain: "assignment-b0841.firebaseapp.com",
    projectId: "assignment-b0841",
    storageBucket: "assignment-b0841.appspot.com",
    messagingSenderId: "641954284229",
    appId: "1:641954284229:web:c98dd4a03899b36d9526ac",
    measurementId: "G-TFJPHVD3YV"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
// Customize notification here
    const payloadData = JSON.parse(payload.data.notification);
    const notificationTitle = payloadData.title;
    const notificationOptions = {
        body: payloadData.body,
        icon: 'mark.png'
    };
    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});
