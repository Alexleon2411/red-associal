<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @stack('styles')
        <title>Login app PHP</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>

    <body>
        <header class="p-5 border-c bg-white shadow">
            <div class="container flex justify-between items-center">
                <a href="{{route('home')}}">

                    <h1 class="text-3xl font-bold text-red-800"> Red-Associal</h1>
                </a>
                @auth
                    <nav class="flex gap-2 items-center">
                        <a href="{{route('posts.create')}}" class="font-bold text-gray-600 text-sm flex items-center gap-2 bg-white border p-2 roundded uppercase cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M0 4c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm11 9l-3-3l-6 6h16l-5-5zm4-4a2 2 0 1 0 0-4a2 2 0 0 0 0 4"/></svg>Crear </a>
                        <a href="{{route('post.index', auth()->user()->username)}}" class="font-bold text-gray-600 text-sm">
                            Hola:
                            <span class="font-normal"> {{auth()->user()->username}}</span>
                        </a>

                        <form method="POST" action="{{route('logout')}}">
                            @csrf
                            <button type="submit"  class="font-bold uppercase text-gray-600 text-sm">Cerrar sesion</button>
                        </form>
                    </nav>
                @endauth

                @guest
                <nav class="flex gap-2 items-center">
                    <a href="{{route('login')}}"  class="font-bold uppercase text-gray-600 text-sm">Login</a>
                    <a href="{{route('register')}}" class="font-bold uppercase text-gray-600 text-sm">Crear Cuenta</a>
                </nav>
                @endguest
            </div>
        </header>
        <main class="container mx-auto mt-10">
            <h2 class="font-black text-center text-3xl mb-10 ">
                @yield('titulo')
            </h2>
            @yield('contenido')
        </main>
        <footer class="text-center p-5 text-gray-500 font-bold uppercase mt-10">
            Red-Associal - Todos los derechos reservados  {{now() -> year}}
        </footer>
        @livewireScripts
    </body>
</html>
