window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo";
window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    // host: 'http://127.0.0.1:6001',
    host: window.location.hostname + ':6001'
});

// redis채널설정
window.Echo.channel('share-event')
    .listen('ShareEvent', (data) => {
        console.log(data);
        window.data = data;
        $(".textarea").html(window.data.content);
    });

// Event
window.Echo.channel('chat')
    .listen('ChatEvent', (data) => {
        console.log(data.nickName);
        console.log(data.message);
        // $(document).on( "", ".list-group" )
        $(".list-group").append(
            "<div><small id='usernickname' font-size='10px' class='badge float-left'>" + data.nickName + "</small> <li id='chatContent' class='list-group-item list-group-item-success chat__message-body'>" + data.message +
            "</li> <mark id='time' class='badge float-right chat__message-time'>今</mark></div>");
        console.warn(data);
        console.log('Listen');

    });


// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: "ebbebf6fd111ee412754",
//     cluster: "ap3",
//     encrypted: true
// });


// 접속정보
// window.Echo = new Echo({
//     broadcaster: 'socket.io',
//     host: 'http://localhost:6001',
// });
