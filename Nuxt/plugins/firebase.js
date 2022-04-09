import firebase from 'firebase'

if (!firebase.apps.length) {
  firebase.initializeApp(
    {
     apiKey: "AIzaSyBK719DKPHu_CtLkEoHQzcpRavVFs-hzcs",
    authDomain: "shareapp-e1a21.firebaseapp.com",
    projectId: "shareapp-e1a21",
    storageBucket: "shareapp-e1a21.appspot.com",
    messagingSenderId: "71160336502",
    appId: "1:71160336502:web:cca45825b29133f36b8f57",
    measurementId: "G-M1XTXDW2R0"
    }
  )
}
  
export default firebase