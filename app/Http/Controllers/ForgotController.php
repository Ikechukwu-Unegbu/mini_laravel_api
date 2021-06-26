<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\User;



class ForgotController extends Controller
{
    public function forgot(ForgotRequest $request){
        
        $email = $request->input('email');

        if(User::where('email', $email)->doesntExist()){
            return response([
                'message'=>'User doesnt exist!',
                'status'=>404
            ]);
        }
        $token = str::random(10);

        DB::table('pasword_resets')->insert([
            'email'=>$email,
            'token'=>$token
        ]);
    }
}
