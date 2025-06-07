<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    //
    public function index(){
        return view('auth.register');
    }
    public function store(Request $request){
        // dd($request);

        // modifiar el request
        $request->request->add(['username' => Str::slug($request->username)]);
        /// validation
        $validated = $request->validate([
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6',
        ]);
        // dd('Creando usuario');
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        // autenticar el usuario
        Auth::guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // redireccionar al usuario
        return redirect()->route('login');
    }
}
