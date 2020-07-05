<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 400);
        }
        // $request['password'] = Hash::make($request['password']);
        $request['password'] = bcrypt($request->password);


        $user = User::create($request->toArray());

        $accessToken = $user->createToken('authToken')->accessToken;

        $response = ['user' => $user, 'access_token' => $accessToken];

        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['name' => auth()->user()->name, 'token' => $accessToken]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response()->json($response, 200);
    }

    public function tryEmail()
    {
        //     $to_name = 'Abdulla';
        //     $to_email = 'abdovitch896@gmail.com';
        //     $data = array('name'=>'Ogbonna Vitalis(sender_name)', 'body' => 'A test mail');
        //     Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
        //         $message->to($to_email, $to_name)
        //         ->subject('Laravel Test Mail');
        //         $message->from('yodawy.new.task@gmail.com','Test Mail');
        //     });
        $data = array('name' => "Virat Gandhi");

        Mail::send(['text' => 'emails.mail'], $data, function ($message) {
            $message->to('abdovitch896@gmail.com', 'Tutorials Point')->subject('Laravel Basic Testing Mail');
            $message->from('yodawy.new.task@gmail.com', 'Virat Gandhi');
        });
        return response(['send' => 'sended']);
    }
}
