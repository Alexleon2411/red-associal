<div>
     <!-- Likes y comentarios -->
    <div class="px-4 py-2">
        <div class="flex align-middle text-center ">
            <div class="mt-3">
                <button wire:click="like">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="{{$isLiked? 'red' : 'currentColor'}}" d="m12 21.35l-1.45-1.32C5.4 15.36 2 12.27 2 8.5C2 5.41 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.08C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.41 22 8.5c0 3.77-3.4 6.86-8.55 11.53z"/></svg>
                </button>
            </div>
            <form action="{{route('post.show', ['post' => $post, 'user' => $post->user]) }}">
                <button class="mt-3 text-red-500 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 17 24"><path fill="currentColor" d="M19 5.5a4.5 4.5 0 1 1-9 0a4.5 4.5 0 0 1 9 0m-4-2a.5.5 0 0 0-1 0V5h-1.5a.5.5 0 0 0 0 1H14v1.5a.5.5 0 0 0 1 0V6h1.5a.5.5 0 0 0 0-1H15zm-.5 7.5c1.33 0 2.55-.472 3.5-1.257v2.533c0 1.418-1.164 2.566-2.6 2.566h-4.59l-4.011 2.961a1.01 1.01 0 0 1-1.4-.199a.98.98 0 0 1-.199-.59v-2.172h-.6c-1.436 0-2.6-1.149-2.6-2.566v-6.71C2 4.149 3.164 3 4.6 3h5a5.5 5.5 0 0 0 4.9 8"/></svg>
                </button>
            </form>
            <button class="text-red-500 focus:outline-none ">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 32 32"><path fill="currentColor" d="M27.71 4.29a1 1 0 0 0-1.05-.23l-22 8a1 1 0 0 0 0 1.87l8.59 3.43L19.59 11L21 12.41l-6.37 6.37l3.44 8.59A1 1 0 0 0 19 28a1 1 0 0 0 .92-.66l8-22a1 1 0 0 0-.21-1.05"/></svg>
            </button>
        </div>
        <span class="text-sm text-gray-600 ml-2">{{$likes}} Me gusta</span>

        <p class="mt-2 text-sm">
            <span class="font-semibold">{{ $post->user->username }}</span>
            {{ $post->descripcion }}
        </p>
    </div>
    <div class="mb-6 mx-2">
        {{-- Mostrar último comentario si existe --}}
        @if($ultimoComentario)
            <div class="bg-gray-50 p-4 rounded-lg mb-4 mx-2">
                <div class="flex justify-between items-start">
                    <div>
                        <a href="{{ route('post.index', $ultimoComentario->user) }}"
                        class="font-bold text-gray-800 hover:text-gray-600">
                        {{ $ultimoComentario->user->username }}
                        <span class="font-normal">{{ $ultimoComentario->comentario }}</span>
                        </a>
                        <p class="text-gray-500 text-xs mt-1">
                            {{ $ultimoComentario->created_at->diffForHumans() }}
                        </p>
                    </div>

                    @if($ultimoComentario->user_id === auth()->id())
                        <button wire:click="eliminarComentario({{ $ultimoComentario->id }})"
                                class="text-red-500 hover:text-red-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif
                </div>

                @if($post->comentarios->count() > 1)
                    <a href="{{ route('post.show', ['post' => $post, 'user' => $post->user]) }}"
                    class="text-blue-500 hover:text-blue-700 text-sm inline-block mt-2">
                    Ver los {{ $post->comentarios->count() - 1 }} comentarios anteriores
                    </a>
                @endif
            </div>
        @endif

        {{-- Formulario para nuevo comentario --}}
        <div class="relative" x-data="{ showButton: false }">
            <textarea
                wire:model="comentario"
                class="w-full border-b border-gray-300 rounded-lg px-2 focus:border-blue-500 focus:ring focus:ring-blue-200 transition"
                placeholder="Escribe un comentario..."
                rows="2"
                x-on:input="showButton = $event.target.value.trim() !== ''">
            </textarea>

            <div class="absolute right-2 bottom-5" x-show="showButton">
                <button wire:click="crearComentario"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-2 rounded-lg text-sm font-medium transition-colors">
                    Publicar
                </button>
            </div>
        </div>

        @error('comentario')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
