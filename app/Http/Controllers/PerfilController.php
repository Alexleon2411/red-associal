<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->request->add(['username' => Str::slug($request->username)]);

       $this->validate($request, [
         'username' => ['required', 'unique:users,username,' . Auth::user()->id, 'min:3', 'max:20', 'not_in:twitter,editar-perfil'],
         'email' => ['required', 'unique:users,email,' . Auth::user()->id, 'email', 'max:60'],
       ]);

       if($request->imagen){
             $imagen = $request->file('imagen');
            $nombreImage = Str::uuid() . "." . $imagen->extension();
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);
            $imagenPath = public_path('perfiles') . '/' . $nombreImage;
            $imagenServidor->save($imagenPath);
       }

       // editar contraseNa
       /// guardar cambios

       $usuario = User::find(Auth::user()->id);
        if (!Hash::check($request->password, $usuario->password)) {
            return back()->withErrors(['password' => 'La contraseña actual es incorrecta']);
        }
        if ($request->filled('newpassword')) {
            $usuario->password = $request->newpassword;
        }
       $usuario->username = $request->username;
       $usuario->email = $request->email;
       $usuario->imagen = $nombreImage ??  Auth::user()->imagen ?? '';
       $usuario->save();

       return redirect()->route('post.index', $usuario->username);
    }

}
