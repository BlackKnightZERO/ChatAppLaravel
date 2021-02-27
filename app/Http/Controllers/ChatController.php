<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;

class ChatController extends Controller
{
    public function rooms(){
      return ChatRoom::all();
    }

    public function messages(Request $request, $room_id){
      return ChatMessage::where('chat_room_id', $room_id)
                          ->with('user')
                          ->orderBy('created_at', 'DESC')
                          ->get();
    }

    public function newMessage(Request $request, $room_id){
        $newMessage = new ChatMessage;
        $newMessage->user_id = Auth::id();
        $newMessage->chat_room_id = $room_id;
        $newMessage->message = $request->message;
        $newMessage->save();

        broadcast(new NewChatMessage($newMessage))->toOthers();

        return $newMessage;
    }
}
