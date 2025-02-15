<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getCKEditor(){
        return view('userContent');
    }
    public function uploadImage(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('uploads'), $fileName);

            $url = asset('uploads/'.$fileName); 
            return response()->json([
                'url' => $url,
                'fileName' => $fileName,
                'uploaded' => 1
            ]);
        }
    }
    public function submitContent(Request $request){
        $content = $request->content;
        // You can add your additional code here to store content on database.
        // Make sure that you are storing the content as it is without any modification
        return view('showContent',compact('content'));
    }
}
