<?php

namespace App\Http\Controllers;

use App\Events\Message as MessageEvent;
use App\Models\Message;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SendMessageController extends Controller
{
    /**
     * Send the message to a room.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'room' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:140'],
        ]);

        $chatRoom = ChatRoom::where('room_code', $request->room)->firstOrFail();

        $message = Message::create([
            'chat_room_id' => $chatRoom->id,
            'user_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        MessageEvent::broadcast(
            $request->user(),
            $request->room,
            $request->message,
        );

        return Response::json(['ok' => true]);
    }
}
