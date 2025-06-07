@extends('layouts.app')

@section('contenido')
<div class="flex justify-center min-h-screen bg-gray-100 py-8 px-4">
    <!-- Contenedor principal -->
    <div class="container max-w-205 min-h-305 ">
            <livewire:search-users />
            @if ($posts->count())
                <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Últimas publicaciones</h1>
                <!-- Grilla responsiva - Ocupa todo el ancho -->
                <div class="w-full">
                    @foreach ($posts as $post)
                        <div class="w-full bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 transition-transform duration-300 hover:scale-100 min-h-80 my-5">
                            <!-- Encabezado del post -->
                            <div class="flex items-center px-4 py-2">

                                <img
                                    src="{{ $post->user->imagen ? asset('perfiles').'/'.$post->user->imagen :  asset('img/usuario.svg') }}"
                                    alt="Perfil de {{ $post->user->username }}"
                                    class="w-10 h-10 rounded-full object-cover mr-3"
                                >
                                <span class="font-semibold text-gray-800">{{ $post->user->username }}</span>
                            </div>

                            <!-- Imagen del post con altura máxima -->
                            <a href="{{ route('post.show', ['post' => $post, 'user' => $post->user]) }}" class="flex-shrink-0">
                                <img
                                    src="{{ asset('uploads') . '/' . $post->imagen }}"
                                    alt="Publicación de {{ $post->user->username }}"
                                    class="w-full max-h-[450px] object-cover"
                                >
                            </a>

                            <!-- Likes y comentarios -->
                            <livewire:like-comment-post :post="$post" :key="$post->id"/>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación centrada -->
                <div class="my-10 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @else
                <p class="text-gray-600 uppercase text-sm text-center font-bold mt-10">No hay Publicaciones</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <!-- AlpineJS para las interacciones -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endpush
