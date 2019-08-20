require("./bootstrap");
window.Vue = require("vue");
import Vue from "vue";
import VueChatScroll from "vue-chat-scroll";
import chatvue from "./components/Vuemessage.vue";
// import Echo from 'laravel-echo';
// import Axios from 'axios';
Vue.use(VueChatScroll);

Vue.component("message", chatvue);

Vue.component("chat-box", require("./components/Vuemessage.vue"));

const app = new Vue({
    el: "#app",
    data: {
        message: "",
        chat: {
            message: [],
            user: [],
            color: [],
            time: []
        },
        typing: "",
        numberOfUser: 0
    },

    watch: {
        message() {
            window.Echo.private("chat").whisper("typing", {
                name: this.message
            });
        }
    },
    methods: {
        send() {
            //chat blade의 key.enter = 'send' 함수
            if (this.message.length != 0) {
                this.chat.message.push(this.message);
                this.chat.color.push("success");
                this.chat.user.push("you");
                this.chat.time.push(this.getTime());
                axios
                    .post("/messageSend", {
                        // send -> messageSend post request//
                        message: this.message
                    })
                    .then(response => {
                        console.log(response);
                        this.message = "";
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        getTime() {
            let time = new Date();
            return (
                // time.getFullYear() +
                // "年" +
                time.getMonth() +
                "月" +
                time.getDate() +
                "日" +
                time.getHours() +
                "時" +
                time.getMinutes() +
                "秒"
            );
        }
    },
    mounted() {
        window.Echo.private("chat")
            .listen("ChatEvent", e => {
                this.chat.message.push(e.message);
                this.chat.user.push(e.user);
                this.chat.color.push("warning");
                this.chat.time.push(this.getTime());
                console.log(e);
            })
            .listenForWhisper("typing", e => {
                if (e.name != "") {
                    this.typing = "タイピング中...";
                } else {
                    this.typing = "";
                }
            });
        window.Echo.join("chat")
            .here(users => {
                this.numberOfUser = users.length;
            })
            .joining(users => {
                this.numberOfUser += 1;
            })
            .leaving(users => {
                this.numberOfUser -= 1;
            });
    }
});
