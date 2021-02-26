<template>
    <div class="relative h-10 m-1">
        <div style="border-top: 1px solid #e6e6e6" class="grid grid-cols-6">
            <input 
                type="text"
                v-model="message"
                @keyup.enter="sendMessage"
                placeholder="Say something..."
                class="col-span-5 border-none focus:outline-none focus:ring focus:border-blue-300 p-1"
            >
            <button 
                @click="sendMessage"
                class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white"    
            >
                Send
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props:['room'],

    data(){
        return{
            message: '',
        }
    },
    methods:{
        sendMessage(){
            if(this.message == ''){
                return;
            }

            let postData = {
                message : this.message,
            };

            let url = `/chat/rooms/${this.room.id}/messages`;

            axios.post(url, postData)
                 .then((res)=> {
                     if(res.status == 201){
                         this.message = '';
                         this.$emit('messageSent');
                     }
                 })
                 .catch((err)=>{
                     console.log(err);
                 });
        }
    },
}
</script>