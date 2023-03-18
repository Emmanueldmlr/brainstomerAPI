<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function loginOrRegister(Request $request){
       return $this->userService->registerOrLogin($request);
    }

    public function logout(){
        try {
            Auth::user()->currentAccessToken()->delete();
            $data = [
                'status' => true,
                'message' => 'Logout Successful'
            ];
            return response($data, 200)->withCookie(cookie('token', '', 0));
        } catch (\Exception $exception) {
            $data = [
                'status' => false,
                'error' => 'Action Could not be Performed'
            ];
            return response($data, 500);
        }
    }

    public function withdraw(Request $request){
        return $this->userService->withdraw($request);
    }
}
