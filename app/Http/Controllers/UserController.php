<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            "name" => $request->input('name'),
            'email' => $request->input("email"),
            'password' => bcrypt($request->input('password'))
        ]);
        return response()->json($user);
    }

    public function login(Request $request){
$user = User::where("email", $request->email)->first();
if (!$user) return response()->json(["message"=>'User Not Found'],404);
if (!Hash::check($request->input('password'),$user->password)) return response()->json(["message"=>'Unauthurized'],401);
// create token

// return response()->json(["user"=>$user,"token"=>$token]);    
}
}
