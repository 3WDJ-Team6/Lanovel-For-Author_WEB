
<template>
  <div>
    <!-- <small class="badge float-left" id="usernickname">私</small> -->
    <li class="list-group-item list-group-item-success" :class="usernn" id="chatContent2">
      <slot></slot>
    </li>
    <mark class="badge float-right" id="time">{{time}}</mark>
  </div>
</template>

<script>
export default {
  //   data() {
  //     return {
  //       text: "",
  //       messages: []
  //     };
  //   },
  //   computed: {
  //     contentExists() {
  //       return this.text.length > 0;
  //     }
  //   },

  name: "message",
  props: ["color", "user", "time"],
  computed: {
    usernn() {
      return this.user;
    },
    // methods: {
    //   postMessage() {
    //     axios.post("/messageSend", { message: this.text }).then(({ data }) => {
    //       this.messages.push(data);
    //       this.text = "";
    //     });
    //   }
    // },
    badgeClass() {
      return "badge-" + this.color;
    }
  },
  mounted() {
    // console.log('Component mounted.');
  },

  // Fixed New chat Vue
  created() {
    axios.get("/getChat").then(({ data }) => {
      this.messages = data;
      console.log("data : " + data);
    });
    // Registered client on public channel to listen to MessageSent event
    Echo.channel("chat").listen("chatEvent", ({ message }) => {
      this.messages.push(message);
    });
  } // end of new Chat
};
</script>
<style>
mark {
  background-color: #45b4e61a;
}

.list-group-item-success:not(.you) {
  background-color: white;
  padding-left: 5px;
  margin-left: 5px;
}

.you {
  background-color: #b3e8ca;
  padding-left: 5px;
  margin-left: 5px;
}
#time {
  font-size: 10px;
  color: rgba(0, 0, 0, 0.5);
}

#chatcontent2 {
  background-color: #b3e8ca;
  padding-left: 5px;
  margin-left: 5px;
}

#usernickname {
  left: 0px;
}
</style>
