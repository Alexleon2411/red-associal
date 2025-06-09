@extends('layouts.app')

@section('titulo')
   <span class="text-bold text-red-800">{{$user->username}}</span>
@endsection

@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center">
            {{-- <div class="w-8/12 lg:w-6/12 ">
                <img src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg') }}" alt="foto de perfil"  class=" rounded-full border-2 border-white shadow-lg">
            </div> --}}
            <header class="flex items-center gap-4">
                <img
                src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg') }}"
                alt="Foto de perfil"
                class="w-20 h-20 rounded-full object-cover"
                />
                <div class="flex flex-col gap-1">
                    <div class="flex ml-3">
                        <h2 class="text-lg font-semibold">{{ $user->username }} </h2>
                         @if (auth()->check() && $user->id === auth()->user()->id)
                            <a
                                href="{{route('perfil.index')}}"
                                class="text-gray-500 hover:text-blue-700 ml-3"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M6 7a5 5 0 1 1 10 0A5 5 0 0 1 6 7m5-3a3 3 0 1 0 0 6a3 3 0 0 0 0-6M4.413 17.601c-.323.41-.413.72-.413.899c0 .118.035.232.205.384c.197.176.55.37 1.11.543c1.12.346 2.756.521 4.706.563a1 1 0 1 1-.042 2c-1.997-.043-3.86-.221-5.254-.652c-.696-.216-1.354-.517-1.852-.962C2.347 19.906 2 19.274 2 18.5c0-.787.358-1.523.844-2.139c.494-.625 1.177-1.2 1.978-1.69C6.425 13.695 8.605 13 11 13q.671 0 1.316.07a1 1 0 0 1-.211 1.989Q11.564 15 11 15c-2.023 0-3.843.59-5.136 1.379c-.647.394-1.135.822-1.45 1.222Zm16.8-3.567a2.5 2.5 0 0 0-3.536 0l-3.418 3.417a1.5 1.5 0 0 0-.424.849l-.33 2.308a1 1 0 0 0 1.133 1.133l2.308-.33a1.5 1.5 0 0 0 .849-.424l3.417-3.418a2.5 2.5 0 0 0 0-3.535Zm-2.122 1.414a.5.5 0 0 1 .707.707l-3.3 3.3l-.825.118l.118-.825z"/></g></svg>
                            </a>
                        @endif
                    </div>
                <div class="flex  gap-2">
                    @auth
                        @if($user->id !== auth()->user()->id)
                            @if ($user->siguiendo2(auth()->user()))

                            <form  method="POST" action="{{route('users.unfollow', $user)}}">
                                @method('DELETE')
                                @csrf
                                <input type="submit" value="Dejar de Seguir" class="bg-indigo-500 hover:bg-indigo-700 text-white transition-colors cursor-pointer border px-3 py-1 rounded text-sm">

                            </form>
                            @else
                            <form  method="POST" action="{{route('users.follow', $user)}}">
                                @csrf
                                <input type="submit" value="Seguir" class=" bg-rose-500 hover:bg-pink-800 text-white  transition-colors cursor-pointer border px-3 py-1 rounded text-sm">
                            </form>

                            @endif
                        @endif
                    @endauth
                    @if ($user->id !== auth()->user()->id)
                        <a
                            href="{{ route('messages.create', $user) }}"
                            class="bg-white border px-3 py-1 rounded text-sm">
                            Enviar Mensaje
                        </a>
                    @else
                    {{-- para el propio perfil personal --}}
                    <a href="{{route('perfil.index')}}" class="bg-white border px-3 py-1 rounded text-sm">Editar perfil</a>

                          <a
                            href="{{ route('messages.create', $user) }}"
                            class="bg-white border px-3 py-1 rounded text-sm">
                            Enviar Mensaje
                        </a>
                    @endif

                    {{-- <button class="bg-white border px-3 py-1 rounded text-sm">Ver archivo</button> --}}
                </div>
                </div>
            </header>
            <section class="mt-4 text-sm">
                <p><strong>{{$user->name}}</strong><br></p>
            </section>
            <!-- Historias destacadas -->
            {{-- <section class="flex gap-4 overflow-x-auto mt-4 pb-2">
                <div class="flex flex-col items-center">
                <div class="w-14 h-14 rounded-full bg-gray-300 mb-1"></div>
                <span class="text-xs text-center">Francia</span>
                </div>
                <div class="flex flex-col items-center">
                <div class="w-14 h-14 rounded-full bg-gray-300 mb-1"></div>
                <span class="text-xs text-center">Bélgica</span>
                </div>
                <div class="flex flex-col items-center">
                <div class="w-14 h-14 rounded-full bg-gray-300 mb-1"></div>
                <span class="text-xs text-center">Italia</span>
                </div>
            </section> --}}
            <!-- Estadísticas -->
            <section class="flex justify-between text-center mt-4 text-sm min-w-[250px]">
                <div>
                <span class="font-bold block">{{$posts->count()}} </span>
                <span class="text-gray-600">publicaciones</span>
                </div>
                <div>
                <span class="font-bold block">{{$user->followers()->count()}} </span>
                <span class="text-gray-600">@choice('Seguidor|Seguidores', $user->followers()->count())</span>
                </div>
                <div>
                <span class="font-bold block">{{$user->followings()->count()}} </span>
                <span class="text-gray-600">Siguiendo</span>
                </div>
            </section>
            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:items-start md:justify-center ml-5">

            </div>
        </div>
    </div>
    <section class="container mx-auto mt-10 ">
        <h2 class="text-4xl text-center font-black mb-5 border-b w-full">Publicaciones</h2>
        @if ($posts->count())

            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 ">
                @foreach ($posts as $post)
                <div >
                    <a href="{{route('post.show', ['post' => $post, 'user' => $user])}}">
                        <img src="{{ asset('uploads') . '/' . $post->imagen}}" alt="imagen del post {{ $post->titulo}}">
                    </a>
                </div>
                @endforeach

            </div>
            <div class="my-10">
                {{$posts->links()}}
            </div>
        @else
            <p class="text-gray-600 uppercase text-sm text-center font-bold">No hay Publicaciones</p>
        @endif
    </section>
@endsection
