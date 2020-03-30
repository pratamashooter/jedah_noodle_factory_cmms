<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Message;
use App\Activitylog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MessageManagement extends Controller
{
    // Show Message Nav
    public function ShowMessageNav()
    {
        $id = Auth::id();
        $messages = Message::orderBy('id', 'DESC')->where('id_user', '!=', $id)->take(3)->get();
        return view('message_management.message_nav', compact('messages'));
    }

    // Show Message List
    public function ShowMessageList()
    {
    	$messages = Message::orderBy('id', 'DESC')->get();
    	return view('message_management.message_list', compact('messages'));
    }

    // Send Message
    public function SendMessage(Request $request)
    {
    	$message = new Message;
        $message->id_user = $request->id_user;
        $message->avatar = $request->avatar;
    	$message->name = $request->name;
        $message->message = $request->message;
        $message->remember_token = Str::random(40);
        $message->save();

        echo "success";
    }

}
