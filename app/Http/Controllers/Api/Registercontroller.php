<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class Registercontroller extends Controller
{
    public function register(Request $request){
    
        $registerUserData = $request->validate([
            'name'=>'required|string',
            'lastname' =>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8',

        ]);

        $user = User::create([
            'name' => $registerUserData['name'],
            'lastname' => $registerUserData['lastname'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
        ]);
        return response()->json([
            'message' => 'User Created ',
            'data'=>$user
        ]);
    }

}
