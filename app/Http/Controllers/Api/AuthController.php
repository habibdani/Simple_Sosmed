<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Posting;

use Illuminate\Support\Facades\DB as FacadesDB;

class AuthController extends Controller
{
    //Register
    public function register(Request $request){

        //validation

        //save new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => hash::make($request->password)
        ]);

        return response()->json([
            'status'=> true,
            'message' => 'Registrasi Berhasil.'
        ], 201);
    }

    public function login(Request $request){
        //validasi

        //cek username dan password
        if(!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            return response()->json([
                'status' => false,
                'message' => 'Username atau Password invalid'
            ], 400);
        }

        $token = Auth::user()->createToken('authToken')->accessToken;

        return response()->json([
            'status' => true,
            'message' => 'Login success',
            'user' => Auth::user(),
            'token' => $token
        ], 200);
    }

    public function profile(Request $request){

        $getdatapsoting = FacadesDB::connection('DB')
        ->select("SELECT * FROM postings WHERE user_id = {$request['id']}");

        return response()->json([
            'status' => true,
            'message' => 'Berhasil cek profile pengguna.',
            'user' => Auth::user(),
            'data' => $getdatapsoting
        ], 200);
    }

    public function serach(Request $request){

        $getdatausers= FacadesDB::connection('DB')
        ->select("SELECT * FROM users WHERE name like '%{$request['id']}%'");
        
        $getdatapsoting = FacadesDB::connection('DB')
        ->select("SELECT * FROM postings WHERE user_id = {$getdatausers['id']}");

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data pengguna.',
            'user' => Auth::user(),
            'data' => $getdatapsoting
        ], 200);
    }

    public function logout(Request $request){
        $token = $request->user()->token();

        $token->revoke();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil logout.'
        ], 200);
    }
}
