<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailService;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $uniqueEmail = Validator::make($request->all(), [
            'email' => 'unique:users',
        ]);
        if ($uniqueEmail->fails()) {
            return response(['errors' => $uniqueEmail->errors()->all()], 409);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'birthDate' => 'required'
        ]);
        $ValidEmail = filter_var($request['email'], FILTER_VALIDATE_EMAIL);
        if ($validator->fails() || !$ValidEmail) {
            return response(['errors' => $validator->errors()->all()], 400);
        }

        $hashed_random_password = Str::random(8);
        $request['password'] = bcrypt($hashed_random_password);
        $request['password_confirmation'] = $request['password'];
        $request['birthDate'] = date_create($request->birthDate)->format('Y-m-d H:i:s');

        $user = User::create($request->toArray());
        $this->SendMail($request['name'], $request['email'], $hashed_random_password);

        // return response()->json(["msg" => "Check your email to sign in"], 200);
        //for test
        return response()->json(["msg" => "Check your email to sign in", 'password' => $hashed_random_password], 200);
        
    }

    public function login(Request $request)
    {
        try {
            $loginData = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);
            
        } catch (\Exception $e) {
            return response(['message' => 'Invalid Credentials'], 401);
        }
        
        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials'], 401);
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

    private function SendMail($name, $email, $password)
    {
        $details = [
            'title' => 'Sign up on News app',
            'body' => 'body',
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];
        \Mail::to($email)->send(new MailService($details));

        return response(['send' => 'sended']);
    }
}
