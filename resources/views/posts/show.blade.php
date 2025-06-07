@extends('layouts.app')

@section('titulo')
    {{$post->titulo}}
@endsection

@section('contenido')
    <div class="container mx-auto md:flex">
        <div class="md:w-1/2">
            <img src="{{asset('uploads') . '/' . $post->imagen}}" alt="imagen de post {{$post->titulo}}">
            <div class="flex justify-between items-start">
                <div>
                    <div class="p-3 ">
                        @auth
                        <livewire:like-post :post="$post"/>

                        @endauth
                    </div>
                    <div>
                        <p class="font-bold"> {{$post->user->username}}</p>
                        <p class="text-sm text-gray-500">{{$post->created_at->diffForHumans()}}</p>
                        <p class="mt-5">{{$post->descripcion}}</p>
                    </div>
                </div>
                <div class="justify-end">
                    @auth
                        @if ($post->user_id === auth()->user()->id)

                            <form action="{{route('post.destroy', $post)}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button
                                    type="submit"
                                    class=" p-2 rounded text-white font-bold mt-4 cursor-pointer flex items-center gap-2"
                                >
                                    <!-- Icono SVG de papelera -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd" clip-rule="evenodd"><path fill="#020202" d="M22.049 7.077a4 4 0 0 1-1.001 0c-.851-.09-1.822-.31-2.573-.38a62 62 0 0 0-4.764-.3c-1.612-.03-3.203 0-4.765.11l-4.614.31a.31.31 0 0 0 .12-.26c.12 0 .12-.5.14-.56q.113-.321.32-.591a1 1 0 0 1 .46-.34q1.186-.38 2.413-.591a26.5 26.5 0 0 1 3.734-.35c1.436-.1 2.877-.1 4.314 0c.947.055 1.887.21 2.802.46a.59.59 0 0 1 .35.37q.126.393.171.801a.36.36 0 0 0 .39.29a.34.34 0 0 0 .29-.39a3.8 3.8 0 0 0-.23-1.151a1.23 1.23 0 0 0-.73-.68a14.2 14.2 0 0 0-3.003-.701s-.58-1.512-.59-1.522A3.8 3.8 0 0 0 14.21.411a2.64 2.64 0 0 0-1.651-.4a5.1 5.1 0 0 0-1.522.36c-.507.221-.95.565-1.291 1a7.6 7.6 0 0 0-.66 1.843c-.281 0-.581.08-.862.14a15.3 15.3 0 0 0-3.143 1a1.85 1.85 0 0 0-.64.491c-.224.3-.388.64-.48 1.001q-.092.346-.14.7a.38.38 0 0 0 .09.281l.07.02c-3.544.25-2.273.831-2.003.821q.339-.02.67-.08h6.337c1.301 0 2.623-.06 3.954-.07h2.642c1.001 0 1.892 0 2.823.06c.741 0 1.722.19 2.573.24c.399.048.802.048 1.2 0a.34.34 0 0 0 .281-.39a.35.35 0 0 0-.41-.35m-11.59-5.065a2.5 2.5 0 0 1 .77-.47c.46-.188.946-.303 1.442-.341a1.63 1.63 0 0 1 1 .15c.344.198.649.456.901.76c.05.07.27.591.441.942a30 30 0 0 0-3.544-.04c-.48 0-.97 0-1.48.07c.23-.37.38-1.011.47-1.071m10.19 6.646a.31.31 0 0 0-.43 0a.32.32 0 0 0 0 .38v.37a39 39 0 0 1-.571 4.765c-.34 2.062-.751 4.164-1.061 5.235c-.14.491-.24 1.001-.41 1.482c-.092.28-.227.544-.401.78c-.41.492-.975.827-1.602.952a9 9 0 0 1-3.153.21c-1.421-.15-3.003 0-4.434-.19a4.7 4.7 0 0 1-1.602-.52a1.83 1.83 0 0 1-.64-.842a8 8 0 0 1-.591-1.882c-.15-.83-.33-1.871-.51-3.002c-.42-2.663-.861-5.706-1.062-7.007a.36.36 0 0 0-.39-.3a.35.35 0 0 0-.29.39c.16 1.321.51 4.364.86 7.007c.14 1.13.28 2.192.411 3.003a9.3 9.3 0 0 0 .61 2.162a2.93 2.93 0 0 0 1.022 1.381a5.6 5.6 0 0 0 2.002.68c1.461.25 3.003.07 4.494.23a10 10 0 0 0 3.593-.27a4 4 0 0 0 2.183-1.41c.22-.339.392-.706.51-1.092c.16-.5.25-1 .38-1.551a71 71 0 0 0 1.112-7.538c.124-.996.175-2 .15-3.003a.8.8 0 0 0-.18-.42"/><path fill="#0c6fff" d="M9.256 16.156c.14.841.31 1.582.42 2.112c.07.34.121.591.141.711c.06.3.32.26.51.17a.23.23 0 0 0 .16-.1v-.79c0-.541 0-1.302-.11-2.153c0-.46-.09-.94-.16-1.421c0-.24-.06-.48-.11-.71c-.2-1.122-.46-2.143-.61-2.814a.303.303 0 1 0-.6.08c0 .681 0 1.742.11 2.873c0 .24 0 .47.07.711c.03.39.1.87.18 1.331m5.585 2.813a.34.34 0 0 0 .34-.34c.05-.61.22-1.542.33-2.563c.07-.56.13-1.15.15-1.711c.06-1.352 0-2.523 0-2.913a.31.31 0 0 0-.508-.247a.3.3 0 0 0-.102.207c-.06.35-.29 1.32-.46 2.502c-.05.34-.08.71-.11 1.071c-.03.36 0 .73 0 1.091c0 1.001 0 1.952.08 2.563a.34.34 0 0 0 .28.34"/></g></svg>
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5">
                @auth
                    <p class="text-xl font-bold text-center mb-4">Agregar un Bueno Comentario</p>
                    @if(session('mensaje'))
                        <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                            {{session('mensaje')}}
                        </div>
                    @endif
                    <form action="{{route('comentarios.store', ['post' => $post, 'user' => $user])}}" method="POST">
                        @csrf
                        <div  class="mb-5">
                            <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">Comentario</label>
                            <textarea  id="comentario" name="comentario" placeholder="comentario de la publicacion" class="border p-3 w-full rounded-lg @error('comentario') border-red-500
                            @enderror"></textarea>
                            @error('comentario')
                                <p class="text-bold text-red-600">{{$message}} </p>
                            @enderror
                        </div>
                        <input type="submit" value="Agregar comentario" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
                    </form>
                @endauth
                <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios->sortByDesc('created_at') as $comentario)
                        <div class="p-5 border-gray-400 border-b md:flex md:justify-between items-start">
                            <div>
                                <a href="{{route('post.index', $comentario->user)}}" class="font-bold">{{$comentario->user->username}}</a>
                                <p class=" ">{{$comentario->comentario}}</p>
                                <p class="text-gray-600 align-middle text-sm">{{$comentario->created_at->diffForHumans()}}</p>
                            </div>
                            <div>
                                @if ($comentario->user_id === auth()->user()->id)

                                    <form action="{{route('comentario.delete', $comentario)}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit"
                                                class="text-red-500 hover:text-red-700 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                     <p class="p-10 text-center"> No hay Comentarios aun </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
