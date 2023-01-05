<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Str;

class AuthController extends Controller
{
   
   private $apiToken;

   public function __construct(){
        $this->apiToken = uniqid(base64_encode(Str::random(40)));
   }


   public function login(Request $req){
        $data = $req->only("email","password");
        if(Auth::attempt($data)){
            $success['token'] = $this->apiToken;
            $success['name'] = Auth::user()->name;
            $success['msg'] = "login successfully done";
            $success['status'] = true;
            return response()->json($success, 200);
        }
        else{
            return response()->json(["status"=>false,"msg"=> "email and password is incorrect"]);
        }
   }
   public function register(Request $req){
        $req->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);

        $user->save();

        return response()->json([
            'status'=>'success',
            'data' => $user
        ]);
   }
}