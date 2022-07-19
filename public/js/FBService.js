var messaging;
if ('serviceWorker' in navigator) {
    if (!firebase.apps.length) {
        var firebaseConfig = {
            apiKey: "AIzaSyCsyzivLelJuTTP35aLoocq94hNCWwq0ZU",
            authDomain: "johnny-app-9d4c3.firebaseapp.com",
            projectId: "johnny-app-9d4c3",
            storageBucket: "johnny-app-9d4c3.appspot.com",
            messagingSenderId: "26716726425",
            appId: "1:26716726425:web:320a3001ca5663dda74408"
        };
        firebase.initializeApp(firebaseConfig);
        if(firebase.messaging.isSupported()){
            messaging = firebase.messaging();
            messaging.usePublicVapidKey('BBMqaivadfJy3Eo1_2p-iZqck2VG44cT5PMCI5Aa2vvEwQNccRR9AW8a99KkI70dG50FM3A_KVcfwqntsSYJ7lI');
            console.log('Browser Support for Messaging');
            messaging.onMessage((payload) => {
                console.log('Message received. ', payload);
                reload_data();
                // let title = payload['data']['title'];
                // let body = payload['data']['body'];
                // let type = payload['data']['type'];
                // let redirect = 'redirect' in payload['data'] ? payload['data']['redirect'] : '/';
                //
                // $('#toast-title').html(title);
                // $('#toast-message').html(body);
                // $('.toast').attr('data-type', type);
                // $('.toast').attr('data-redirect', redirect);
                // $('.toast').removeClass('d-none');
                // $('.toast').toast('show');
            });

        }else{
            console.log('Your Browser Not Supported Messaging')
        }
    }
    console.log('in sw');
}else {
    console.log('not in sw')
}

navigator.serviceWorker.register('/firebase-messaging-sw.js');
