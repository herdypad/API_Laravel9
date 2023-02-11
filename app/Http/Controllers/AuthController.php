<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login','register']]);
    // }


    public function login(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // dd($request->all());

        // // mengabil data user dari API lain ketika berhasil login dari API lain maka akan dibuatkan Token
        // // balikan data user dari API lain disimpan dan variable $post
        // $client = new SoapSikkaModel();
        // $post = $client->login($username, $passsword);

        $post = [
            "username" => "herdy",
            "jabatan" => "pelaksana",
            "alamat" => "Jalan Kenangan",
            "kota" => "Jakarta",
        ];


        // semua data di $post akan dijadiakan


        // koda dibawah ini berhasil generat JWT token dan belum berhasil jika mengunakan data dari $Post

        $credentials = $request->only('email','password');

        // dd($credentials);

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }



    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

}
