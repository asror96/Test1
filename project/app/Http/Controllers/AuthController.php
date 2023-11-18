<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{


    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $data=$this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email'=> 'required|email|unique:users',
        ]);
        $payload=$this->validate($request, [
            'password'=>'required|string',
        ]);

        $data['password']=Hash::make($payload['password']);
        User::create($data);
        return response()->json('Register!',201);
    }

    protected function jwt(User $user)
    {
        $payload = [
            'iss' => "lumen-jwt",
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60 * 60
        ];

        return JWT::encode($payload, env('JWT_SECRET'),'HS256');
    }
    public function login(Request $request){
        $data=$this->validate($request, [
            'email'=> 'required|email',
            'password'=>'required|string'
        ]);

        $user=User::where('email',$data['email'])->first();

        if (!$user) {
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }

        if(Hash::check($data['password'],$user->password)){
            $token=$this->jwt($user);
            $user->remember_token=$token;
            $user->save();
            return response()->json([
                'token' => $token
            ], 200);
        }
        else{
            return response()->json('Incorrect login or password',401);
        }
    }
}
