<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller{
    //use HasApiTokens;
    public function login(Request $request){
        try{
            if(Auth::attempt($request->only('email', 'password'))){
            /**  @var User $user */
                $user = Auth::user(); 
                $token = $user->createToken('Access Token')->accessToken;
                return response([
                    'message'=>'success',
                    'user'=>$user,
                    'token'=>$token,
                    'status'=>200
                ]);;
            }

            return response([
                'message'=>'Invalid username or password',
                'status'=>401
            ]);

        }catch(\Exception $ex){
            return response([
                'message'=>$ex->getMessage(),
                'status'=>400
            ]);
        }

    }

    public function user(){
        //echo "Fuck it.";
        return Auth::user();
    }

    public function register(RegisterRequest $request){
      try{
            $user = User::create([
                'firstname'=>$request->input('firstname'),
                'lastname'=>$request->input('lastname'),
                'email'=>$request->input('email'),
                'password'=>Hash::make($request->input('password'))
            ]);

            return $user;
        }catch(\Exception $x){
            return response([
                'message'=> $x->getMessage(),
                'status'=>400
            ]);
        }

    }

}