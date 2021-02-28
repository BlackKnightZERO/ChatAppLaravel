<template>
    <div class="h-144 w-full">
        <div class="h-full p-2 flex flex-col-reverse overflow-scroll bg-gradient-to-b from-blue-200">
            <div v-for="(msg, index) in messages" :key="index">
                <message-item :messageItem="msg" :authID="authID"></message-item>
            </div>
        </div>
    </div>
</template>

<script>
import messageItem from './messageItem.vue'
export default {
    components: { messageItem },
    props:['messages'],
    data(){
        return {
            authID : '',
        }
    },
    methods:{
            getAuthId(){
                let url = `/getAuthId`;
                axios.get(url)
                       .then(res => {
                           this.authID = res.data;
                       })
                       .catch(err => {
                           console.log(err);
                       }) 
            },
    },

    created(){
        this.getAuthId();
    }
}
</script>