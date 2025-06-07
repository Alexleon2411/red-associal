<?php

// namespace App\Http\Controllers\Api;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Controller;



// class AuthController extends Controller
// {
//     public function register(Request $request)
//     {
//         $validated = $request->validate([
//             'name' => ['required', 'string', 'max:255'],
//             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//             'password' => ['required', 'confirmed', Rules\Password::defaults()],
//         ]);

//         $user = User::create([
//             'name' => $validated['name'],
//             'email' => $validated['email'],
//             'password' => Hash::make($validated['password']),
//         ]);

//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'message' => 'Usuario creado',
//             'access_token' => $token,
//             'token_type' => 'Bearer',
//         ], 201);
//     dd('post and register');
//     }

//     public function login(Request $request)
//     {
//         $validated = $request->validate([
//             'email' => ['required', 'email'],
//             'password' => ['required'],
//         ]);

//         if (!Auth::attempt($validated)) {
//             return response()->json(['message' => 'Credenciales inválidas'], 401);
//         }

//         $user = $request->user();
//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'access_token' => $token,
//             'token_type' => 'Bearer',
//         ]);
//     }

//     public function profile(Request $request)
//     {
//         return response()->json($request->user());
//     }

//     public function logout(Request $request)
//     {
//         $request->user()->currentAccessToken()->delete();
//         return response()->json(['message' => 'Sesión cerrada']);
//     }
// }
