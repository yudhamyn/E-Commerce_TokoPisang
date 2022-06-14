<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        
        $user = auth()->user();

        if($user->level_id == 1)
        {

            $user_data = User::whereHas('chat', function($query) use ($user){
                $query->where('receiver_id',$user->id);
            });

            if($user_data->count())
            {

                $data = [];
                foreach($user_data->get() as $key){
                    $last_message = ChatMessage::whereHas('chat',function($query) use ($user,$key){
                        $query->where([
                            'sender_id' => $user->id,
                            'receiver_id' => $key->id
                        ]);
                    })->orderBy('id','desc')->limit(1)->first();
                    $data[] = [
                        'receiver_id' => $key->id,
                        'name' => $key->name,
                        'last_message' => $last_message? [
                            'sender' => $last_message->sender_id == $user->id? true : false,
                            'created_at' => (date('d') == date('d',strtotime($last_message->created_at))? date('H:i', strtotime($last_message->created_at)) : date('d M Y', strtotime($last_message->created_at))),
                            'message' => $last_message->message
                        ] : null
                    ];
                }

                $result['status'] = true;
                $result['message'] = "OK";
                $result['data'] = $data;
                return response($result);

            }

            $result['status'] = false;
            $result['message'] = "Belum ada chat disini";
            return response($result);

        }else{

            $admin = User::where(['level_id' => 1]);

            if($admin->count())
            {

                $data = [];
                foreach($admin->get() as $key){
                    $last_message = ChatMessage::whereHas('chat',function($query) use ($user,$key){
                        $query->where([
                            'sender_id' => $user->id,
                            'receiver_id' => $key->id
                        ]);
                    })->orderBy('id','desc')->limit(1)->first();
                    $data[] = [
                        'receiver_id' => $key->id,
                        'name' => $key->name,
                        'last_message' => $last_message? [
                            'sender' => $last_message->sender_id == $user->id? true : false,
                            'created_at' => (date('d') == date('d',strtotime($last_message->created_at))? date('H:i', strtotime($last_message->created_at)) : date('d M Y', strtotime($last_message->created_at))),
                            'message' => $last_message->message
                        ] : null
                    ];
                }
    
                $result['status'] = true;
                $result['message'] = "OK";
                $result['data'] = $data;
                return response($result);
    
            }
    
            $result['status'] = false;
            $result['message'] = "Belum ada chat disini";
            return response($result);

        }

    }

    public function message(Request $request)
    {

        $user = auth()->user();

        $request->validate([
            'receiver' => 'exists:App\Models\User,id'
        ]);

        $messages = ChatMessage::whereHas('chat', function($query) use ($user,$request){
            $query->where([
                'sender_id' => $user->id,
                'receiver_id' => $request->receiver
            ]);
        });
        if($messages->count() == 0)
        {
            $result['status'] = false;
            $result['message'] = "Belum ada pesan disini";
            return response($result);
        }

        $data = [];
        foreach($messages->orderBy('id','asc')->get() as $key){
            $data[] = [
                'sender' => ($key->sender_id != $user->id? false : true),
                'message' => $key->message,
                'created_at' => (date('d') == date('d',strtotime($key->created_at))? date('H:i', strtotime($key->created_at)) : date('d M Y', strtotime($key->created_at)))
            ];
        }

        $result['status'] = true;
        $result['message'] = "OK";
        $result['data'] = $data;
        return response($result);

    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            // 'token' => 'required_unless:receiver_id,null|exists:App\Models\Chat,token',
            'receiver' => 'required|exists:App\Models\User,id',
            'message' => 'required|string'
        ]);


        // if(!empty($request->token))
        // {

        //     $cek_chat = Chat::where(['token' => $request->token,'sender_id' => $user->id])->first();
        //     if(!$cek_chat)
        //     {

        //         $result['status'] = false;
        //         $result['message'] = "Gagal saat memuat data";
        //         return response($result);

        //     }

        //     $msg_create = ChatMessage::create([
        //         'chat_token' => $cek_chat->token,
        //         'sender_id' => $user->id,
        //         'message' => $request->message
        //     ]);

        //     if($msg_create)
        //     {

        //         $result['status'] = true;
        //         $result['message'] = "Berhasil mengirim pesan";
        //         $result['data'] = $msg_create;
        //         return response($result);

        //     }

        //     $result['status'] = false;
        //     $result['message'] = "Gagal mengirim pesan";
        //     return response($result);

        // }

        $chat = Chat::where(['sender_id' => $user->id,'receiver_id' => $request->receiver])->first();
        if(!$chat)
        {

            $chat_token = Str::random(18);

            $create_chat = Chat::insert([
                [
                    'token' => $chat_token,
                    'sender_id' => $user->id,
                    'receiver_id' => $request->receiver,
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'token' => $chat_token,
                    'sender_id' => $request->receiver,
                    'receiver_id' => $user->id,
                    'created_at' => date('Y-m-d H:i:s'),
                ],
            ]);

            if($create_chat)
            {

                $msg_create = ChatMessage::create([
                    'chat_token' => $chat_token,
                    'sender_id' => $user->id,
                    'message' => $request->message
                ]);
    
                if($msg_create)
                {
    
                    $result['status'] = true;
                    $result['message'] = "Berhasil mengirim pesan";
                    $result['data'] = [
                        'sender' => ($msg_create->sender_id != $user->id? false : true),
                        'message' => $msg_create->message,
                        'created_at' => (date('d') == date('d',strtotime($msg_create->created_at))? date('H:i', strtotime($msg_create->created_at)) : date('d M Y', strtotime($msg_create->created_at)))
                    ];
                    return response($result);
    
                }
    
                $result['status'] = false;
                $result['message'] = "Gagal mengirim pesan";
                return response($result);

            }

            $result['status'] = false;
            $result['message'] = "Gagal mengirim pesan";
            return response($result);

        }

        $msg_create = ChatMessage::create([
            'chat_token' => $chat->token,
            'sender_id' => $user->id,
            'message' => $request->message
        ]);

        if($msg_create)
        {

            $result['status'] = true;
            $result['message'] = "Berhasil mengirim pesan";
            $result['data'] = [
                'sender' => ($msg_create->sender_id != $user->id? false : true),
                'message' => $msg_create->message,
                'created_at' => (date('d') == date('d',strtotime($msg_create->created_at))? date('H:i', strtotime($msg_create->created_at)) : date('d M Y', strtotime($msg_create->created_at)))
            ];
            return response($result);

        }

        $result['status'] = false;
        $result['message'] = "Gagal mengirim pesan";
        return response($result);

    }
}
