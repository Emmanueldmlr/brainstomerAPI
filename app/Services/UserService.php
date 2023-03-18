<?php

namespace App\Services;

use App\Exceptions\Common\ValidationException;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserService
{
    public function registerOrLogin (Request $request){
        $validator = InputValidator::registerValidation($request->all());
        if ($validator->fails()) {
            throw new ValidationException('Ensure All fields are well filled', $validator->errors()->all());
        }
        $user = User::where('address', $request->address)->first();
        if($user){
            if(Auth::loginUsingId($user->id)){
                $access_token = Auth::user()->createToken('userToken');
                $data = [
                    'status' => true,
                    'message' => 'Login Successful',
                    'token' => $access_token->plainTextToken,
                    'user' => Auth::user(),
                ];
                return response($data, 200)->withCookie(cookie('token', $access_token->plainTextToken, 2147483647));
            }
        }
        else{
            $userInstance = new User();
            $newUser = $userInstance->create($request);
            if(Auth::loginUsingId($newUser->id)){
                $access_token = Auth::user()->createToken('userToken');
                $data = [
                    'status' => true,
                    'message' => 'Login Successful',
                    'token' => $access_token->plainTextToken,
                    'user' => Auth::user(),
                ];
                return response($data, 200)->withCookie(cookie('token', $access_token->plainTextToken, 2147483647));
            }
        }
    }

    public function withdraw(Request $request){
       $user = User::where('address', Auth::user()->address)->first();
       if($user->wallet < $request->amount){
           $data = [
               'status' => false,
               'error' => 'Insufficient Balance'
           ];
           return response($data, 403);
       }
       else{
           $withdrawalInstance = new Withdrawal();
           $user->wallet = $user->wallet - $request->amount;
           $user->save();
           $withdrawalInstance->create($request);
           $data = [
               'status' => true,
               'error' => 'Withdrawal Successfully Made'
           ];
           return response($data, 200);
       }
    }
}
