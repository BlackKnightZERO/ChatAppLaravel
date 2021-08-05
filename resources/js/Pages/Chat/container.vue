<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <chat-room-selection 
                    v-if="currentRoom.id"
                    :rooms="chatRooms"
                    :currentRoom="currentRoom"
                    v-on:roomChanged="setRoom($event)"
                ></chat-room-selection>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <message-container :messages="messages" />
                    <input-message :room="currentRoom" v-on:messageSent="getMessages()" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import messageContainer from './messageContainer.vue'
    import inputMessage from './inputMessage.vue'
    import ChatRoomSelection from './chatRoomSelection.vue'
    export default {
        components: {
            AppLayout,
            messageContainer,
            inputMessage,
            ChatRoomSelection
        },
        data() {
            return {
                chatRooms : [],
                currentRoom : [],
                messages : [],
            }
        },
        watch:{
            currentRoom(val, oldVal){
                if(oldVal.id){
                    this.disconnect(oldVal);
                }
                this.connect();
            }
        },
        methods:{
            getRooms(){
                let url = `/chat/rooms`;
                axios.get(url)
                       .then(res => {
                           this.chatRooms = res.data;
                            this.setRoom(res.data[0]);
                       })
                       .catch(err => {
                           console.log(err);
                       }) 
            },
            setRoom(room){
                this.currentRoom = room;
                // this.getMessages();
            },
            getMessages(){
                let url = `/chat/rooms/${this.currentRoom.id}/messages`;
                axios.get(url)
                       .then(res => {
                           this.messages = res.data;
                       })
                       .catch(err => {
                           console.log(err);
                       }) 
            },
            connect(){
                if(this.currentRoom.id){
                    let vm = this;
                    this.getMessages();
                    let channel = `chat.${this.currentRoom.id}`;
                    window.Echo.private(channel).listen('NewChatMessage', e => {
                        vm.getMessages();
                        console.log('listening');
                    });
                }
            },
            disconnect(room){
                let leaveFrom = `chat.${room.id}`;
                window.Echo.leave(leaveFrom);
            },
        },
        created(){
            this.getRooms();
        }
    }
</script>