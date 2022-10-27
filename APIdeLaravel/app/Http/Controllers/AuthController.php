<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Models\Token;


class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        if (Auth::attempt($request->only('email','password'))) {
            return response()->json([
                'message'=>'usuario creado',
                'token'=>$request->user()->createToken($request->email)->plainTextToken,
            ]);
        }
        
    }

    public function login(LoginRequest $request){
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message'=> 'datos incorrectos',
                'success'=> false
            ],200);
        }

        $userToken = Token::where('name',$request->email)->first();
        $user = User::where('email',$request->email)->first();
        if ($userToken) {
            $userToken->delete();
        }

        return response()->json([
            'success' => true,
            'token' => $request->user()->createToken($request->email)->plainTextToken,
            'id' => $user->id,
            'nombre' => $user->name,
        ]);
    }

    public function logout(Request $request){
        //$request->user()->currentAccessToken()->delete();
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'cerrando sesion de usuario..',
        ],410);
    }
    
}

