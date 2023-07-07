<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Asesor;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;
            $name = $user->name;
            $id_user = $user->id;
            $role_id = $user->role_id;

            $asesor = Asesor::where('user_id', $id_user)->first();

            return response()->json([
                'token' => $token,
                'name' => $name,
                'id_user' => $id_user,
                'role_id' => $role_id,
                'asesor' => $asesor

            ]);
        } else {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }
    }
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1
        ]);
        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'user' => $user,
        ], 201);
    }

    // public function registerAsesor(Request $request)
    // {
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role_id' => 2
    //     ]);

    //     $asesor = Asesor::create([

    //     ]);
    //     return response()->json([
    //         'message' => 'Usuario creado exitosamente.',
    //         'user' => $user,
    //     ], 201);
    // }
}
