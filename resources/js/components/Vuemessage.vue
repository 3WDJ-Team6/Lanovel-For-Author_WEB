<template>
  <div>
    <small class="badge float-left" id="usernickname">{{user}}</small>
    <li class="list-group-item list-group-item-success" :class="usernn" id="chatContent2">
      <slot></slot>
    </li>
    <mark class="badge float-right" id="time">{{time}}</mark>
  </div>
</template>

<script>
export default {
  name: "message",
  props: ["color", "user", "time"],
  computed: {
    usernn() {
      return this.user;
    },
    badgeClass() {
      return "badge-" + this.color;
    }
  },
  mounted() {
    // console.log('Component mounted.');
  }
};
</script>
<style>
mark {
  background-color: #45b4e61a;
}
.list-group-item-success:not(.you) {
  width: 90%;
  float: left;
}
.you {
  width: 90%;
  float: right;
}
#time {
  font-size: 9px;
  color: black;
}
#chatcontent2 {
  width: 90%;
  float: left;
}
#usernickname {
  left: 0px;
}
</style>
