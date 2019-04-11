<template>
    <div>
        <small class="badge float-left" :class="badgeClass">{{user}}</small>
        <li class="list-group-item" :class="className"><slot></slot></li>
        <mark class="badge float-right" id="time">{{time}}</mark>
    </div>
</template>

<script>
    export default {
        name:'message',
        props:[
            'color',
            'user',
            'time'
        ],
        computed:{
            className(){
                return 'list-group-item-'+this.color;
            },
            badgeClass(){
                return 'badge-'+this.color;
            }
        },
        mounted() {
            // console.log('Component mounted.');
        }
    }
</script>
<style>
    mark{
        background-color:#45b4e61a;
    }
    #time{
        font-size:9px;
        color:black;
    }
</style>