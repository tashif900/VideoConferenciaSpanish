<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Jobs\SendMessageJob;
use App\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\MessageResourceCollection;

class MessageController extends Controller
{
    public function startConversation(Request $request)
    {

        // User2 = Instructor
        // User1 = alumno

        $chat = Chat::where('user2_id', $request->instructor)->where('user1_id', auth()->user()->id)->first();

        if ($chat == null) {
            $chat = new Chat;
            $chat->user1_id = auth()->user()->id;
            $chat->user2_id = $request->instructor;
            $chat->status = 1;
            $chat->save();
        }
        $send_ = $this->sendMail($chat, $request->message);

        $this->storeMessage($chat->id, auth()->user()->id,$request->message, $send_);


        return response()->json(true);
    }

    public function sendMail ($chat, $message){
        $msg_mail = Message::where('chat_id',$chat->id)->where('user_id', auth()->id())
            ->where('send_mail','!=' ,null)->get()->last();
        //dd($msg_mail);
        $send_ = false;
        if ($msg_mail != null){
            $fecha_actual = Carbon::now();
            $fecha_msg = Carbon::parse($msg_mail->send_mail)->addMinute(10);

            if ($fecha_actual > $fecha_msg){
                $send_ = true;
            }
        }else{
            $send_ = true;
        }
        if ($send_){
            if (auth()->user()->hasRole('Profesor')) {
                /*$alumno = User::find($chat->user1_id);
                $instructor = User::find($chat->user2_id);*/
                $user_send = User::find($chat->user2_id);
                $user_recieve = User::find($chat->user1_id);
            }else{
                $user_send = User::find($chat->user1_id);
                $user_recieve = User::find($chat->user2_id);
            }

            dispatch(new SendMessageJob($user_send->name, $message, $user_recieve ->email, $user_recieve ->name));
        }
        return $send_;
    }

    public function storeMessage($chat, $user,$msg, $send_)
    {
        $message = new Message;
        $message->chat_id = $chat;
        $message->user_id = $user;
        $message->message = $msg;
        $message->status = 1;
        if ($send_) $message->send_mail = Carbon::now();
        $message->save();
    }

    public function listChats(Request $request)
    {
        if (auth()->user()->hasRole('Profesor')) {
            $chat = Chat::with('user1:id,name,photo')->where('user2_id', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
            $type = 1;
        } else {
            $chat = Chat::with('user2:id,name,photo')->where('user1_id', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
            $type = 2;
        }

        return response()->json(array('chat' => $chat, 'type' => $type));
    }

    public function listMessages(Request $request)
    {
        $messages = Message::where('chat_id', $request->chat)->orderBy('created_at', 'asc')->get();

        return response()->json(new MessageResourceCollection($messages));
    }

    public function newMessage(Request $request)
    {

        $chat = Chat::find($request->chat);

        $send_ = $this->sendMail($chat, $request->message);

        $this->storeMessage($request->chat, auth()->user()->id,$request->message,$send_);

        return response()->json(true);
    }
}
