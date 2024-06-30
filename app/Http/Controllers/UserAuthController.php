<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function register (Request $request){

        $userData=  $request->validate(([
         'name'=> 'required|string'
        ]));

        $user = User::create([
         'name'=>  $userData['name']

     ]);

   return response()->json(['welcom']);

}

}
