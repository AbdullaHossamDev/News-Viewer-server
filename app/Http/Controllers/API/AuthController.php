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

    public function register($request)
    {
        $validator = Validator::make($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'birthDate' => 'required'
        ]);
        $ValidEmail = filter_var($request['email'], FILTER_VALIDATE_EMAIL);
        if ($validator->fails() || !$ValidEmail) {
            return ['errors' => $validator->errors()->all()];
        }

        $hashed_random_password = Str::random(8);
        $request['password'] = bcrypt($hashed_random_password);
        $request['password_confirmation'] = $request['password'];
        $request['birthDate'] = date_create($request['birthDate'])->format('Y-m-d H:i:s');

        $user = User::create($request);
        $this->SendMail($request['name'], $request['email'], $hashed_random_password);

        return ["msg" => "Check your email to sign in"];
    }


    public function login($request)
    {
        $validator = Validator::make($request, [
            'email' => 'email|required',
            'password' => 'required'
        ]);
        $ValidEmail = filter_var($request['email'], FILTER_VALIDATE_EMAIL);
        if ($validator->fails() || !$ValidEmail) {
            return ['errors' => $validator->errors()->all()];
        }

        if (!auth()->attempt($request)) {
            return ['errors' => ['Invalid Credentials']];
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return ['name' => auth()->user()->name, 'token' => $accessToken];
    }


    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return ['msg' => 'You have been successfully logged out!'];;
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
