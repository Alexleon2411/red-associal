<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeCommentPost extends Component
{
    public $post;
    public $isLiked;
    public $likes;
    public $comentario = '';
    public $ultimoComentario;

    public function mount($post)
    {
        $this->post = $post;
        $this->isLiked = $post->checkLike(Auth::user());
        $this->likes = $post->likes->count();
        $this->ultimoComentario = $this->post->comentarios()
            ->with('user')
            ->latest()
            ->first();
    }

    public function like()
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        if($this->isLiked) {
            $this->post->likes()->where('user_id', Auth::id())->delete();
            $this->isLiked = false;
            $this->likes--;
        } else {
            $this->post->likes()->create([
                'user_id' => Auth::id()
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function crearComentario()
    {
        $this->validate([
            'comentario' => 'required|max:255'
        ]);

        $nuevoComentario = Comentario::create([
            'user_id' => Auth::id(),
            'post_id' => $this->post->id,
            'comentario' => $this->comentario
        ]);

        // Actualizar el último comentario
        $this->ultimoComentario = $nuevoComentario;
        $this->comentario = ''; // Limpiar el textarea
    }

    public function eliminarComentario($comentarioId)
    {
        $comentario = Comentario::findOrFail($comentarioId);

        if($comentario->user_id === Auth::id()) {
            $comentario->delete();
            $this->ultimoComentario = $this->post->comentarios()
                ->with('user')
                ->latest()
                ->first();
        }
    }

    public function render()
    {
        return view('livewire.like-comment-post');
    }
}
