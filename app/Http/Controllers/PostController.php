<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }
    //
    public function index(User $user){
        ///esta es la consulta a la base de datos para obtener los posts de los usuarios
        $posts = Post::where('user_id', $user->id)->latest()->paginate(8);
        return view('layouts.dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create ()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required',
        ]);
        /// esta es la forma de crear un post en la base de datos
        Post::create([
            'titulo' => $request->titulo,
            'descripcion' =>  $request->descripcion,
            'imagen' =>  $request->imagen,
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->route('post.index', Auth::user()->username);
    }

    public function show( User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        ///eliminar la imagen
        $image_path = public_path('uploads/' . $post->image);
        if(File::exists($image_path))
        {
            File::delete($image_path);
            //otra forma de usar es unlink
            /*
                unlink($image_path);
            */
        }
        return redirect()->route('post.index', Auth::user()->username);
    }
}
