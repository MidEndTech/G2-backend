<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class Logincontroller extends Controller
{
    public function login(Request $request){
        $UserData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);
        $user = User::where('email',$UserData['email'])->first();
        if(!$user || !Hash::check($UserData['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'data' => $user
        ]);
    }
}





















// public function login(Request $request){
//     $loginUserData = $request->validate([
//         'email'=>'required|string|email',
//         'password'=>'required|min:8'
//     ]);
//     $user = User::where('email',$loginUserData['email'])->first();
//     if(!$user || !Hash::check($loginUserData['password'],$user->password)){
//         return response()->json([
//             'message' => 'Invalid Credentials'
//         ],401);
//     }
//     $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
//     return response()->json([
//         'access_token' => $token,
//     ]);
// }
