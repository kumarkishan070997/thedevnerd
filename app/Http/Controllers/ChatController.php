<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;

class ChatController extends Controller
{
    public function __construct(){
        $this->api = 'https://api.openai.com/v1/chat/completions';
    }
    public function show(){
        return view('chat');
    }
    public function send(Request $request){
        $sid = config('app.twilio_sid');
        $auth_token = config('app.twilio_auth_token');
        $twilio = new Client($sid,$auth_token);
        $message = $twilio->messages->create("whatsapp:+917978688223", // to
        array(
          "from" => "whatsapp:+918895830119",
          "body" => $request->input('query')
        ));
        return $message;
    }
}
