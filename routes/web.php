<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MessageController;
use Illuminate\Auth\Events\Logout;

Route::get('/', HomeController::class)->name('home');

///Register
Route::get('/register', [RegisterController::class, 'index']) -> name('register');
Route::post('/register', [RegisterController::class, 'store']);

///Login & logout
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
// perfil

Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

//dashboard
Route::get('/{user:username}', [PostController::class, 'index'])->name('post.index');
Route::get('/posts/create}', [PostController::class, 'create'])->name('posts.create');
Route::post('/post', [PostController::class, 'store'])->name('post.store');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('post.show');
Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');

///para los comentarios
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');
Route::delete('/coment/{comentario}', [ComentarioController::class, 'deleteComment'])->name('comentario.delete');

Route::post('/imagenes', [ImageController::class, 'store'])->name('images.store');


/// like a las fotos
Route::post('/post/{post}/likes', [LikeController::class, 'store'])->name('likes.store');
Route::delete('/post/{post}/likes', [LikeController::class, 'destroy'])->name('likes.destroy');



//followers
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');


Route::middleware(['auth'])->group(function () {
    // Rutas de mensajes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Crear conversación con usuario específico
    Route::get('/messages/create/{user}', [MessageController::class, 'create'])->name('messages.create');

    // API para mensajes en tiempo real
    Route::get('/api/messages/{conversation}/new', [MessageController::class, 'getNewMessages'])->name('messages.new');
});
