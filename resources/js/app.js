import './bootstrap';

// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyAwNSxErKd2HREvuV457gSj_wW-3Q8H4V0",
    authDomain: "web-push-notification-80eda.firebaseapp.com",
    projectId: "web-push-notification-80eda",
    storageBucket: "web-push-notification-80eda.appspot.com",
    messagingSenderId: "525921119835",
    appId: "1:525921119835:web:5b59e6e3eccd6a9b8d597e"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

onMessage(messaging, (payload) => {
    console.log('Message received. ', payload);
    alert(payload.notification.body);
});

getToken(messaging, { vapidKey: 'BIB8s5jzKfGBLsfXq59El4x-E5ffXa1K_auTrOIPKTQxBNqpdjjz0OR8hSGe-TQDC3y8RBxjksVDZSNS14IPMfU' }).then((currentToken) => {
    if (currentToken) {
        localStorage.setItem('web_token', currentToken);
    } else {
        // Show permission request UI
        requestPermision();
        console.log('No registration token available. Request permission to generate one.');
    }
}).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    // ...
});

function requestPermision() {
    Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {
            console.log('Notification permission granted.');
            // TODO(developer): Retrieve a registration token for use with FCM.
            // ...
        } else {
            alert('Silakan aktifkan untuk mendapatkan notifikasi waktu presensi');
        }
    });
}

