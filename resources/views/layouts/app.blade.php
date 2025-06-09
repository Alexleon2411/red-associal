<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link rel="manifest" href="/manifest.json">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @stack('styles')
        <title>Red-Associal</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>

    <body>
        <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200 shadow-sm">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16 lg:h-18">
                    <!-- Logo -->
                    <a href="{{route('home')}}" class="flex-shrink-0 transition-transform hover:scale-105">
                        <h1 class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-red-600 to-red-800 bg-clip-text text-transparent">
                            Red-Associal
                        </h1>
                    </a>

                    @auth
                        <!-- Desktop Navigation -->
                        <nav class="hidden md:flex items-center space-x-6">
                            <!-- Crear Post Button -->
                            <a href="{{route('posts.create')}}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20" class="flex-shrink-0">
                                    <path fill="currentColor" d="M0 4c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm11 9l-3-3l-6 6h16l-5-5zm4-4a2 2 0 1 0 0-4a2 2 0 0 0 0 4"/>
                                </svg>
                                Crear Post
                            </a>

                            {{-- para los mensajes --}}
                            <div class="flex items-center space-x-4">
                                {{-- <a href="{{route('messages.index')}}"
                                class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 14 14"><g fill="none"><path fill="#8fbffa" fill-rule="evenodd" d="M12.722.037a1.6 1.6 0 0 0-.9.06L1.107 3.673l-.003.001a1.62 1.62 0 0 0-1.07 1.238A1.6 1.6 0 0 0 .472 6.36L3.06 8.944l-.085 3.253a.5.5 0 0 0 .73.457l2.014-1.042l1.917 1.909a1.6 1.6 0 0 0 1.52.434a1.62 1.62 0 0 0 1.168-1.068v-.001l3.575-10.712A1.62 1.62 0 0 0 12.722.037" clip-rule="evenodd"/><path fill="#2859c5" d="m3.059 8.944l-.085 3.253a.5.5 0 0 0 .73.457l2.014-1.042z"/><path fill="#2859c5" fill-rule="evenodd" d="m3.057 9.013l7.045-5.117a.625.625 0 0 0-.735-1.012L2.203 8.088l.856.856z" clip-rule="evenodd"/></g></svg>
                                </a> --}}
                                @livewire('message-notifications')
                            </div>
                            <!-- User Info -->
                            <div class="flex items-center space-x-4">
                                <a href="{{route('post.index', auth()->user()->username)}}"
                                class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200">
                                    Mi Perfil (<span class="font-semibold">{{auth()->user()->username}}</span>)
                                </a>

                                <!-- Logout Button -->
                                <form method="POST" action="{{route('logout')}}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="text-gray-600 hover:text-red-600 font-medium text-sm transition-colors duration-200 px-3 py-2 rounded-md hover:bg-gray-50">
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>

                        </nav>

                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-gray-600 hover:text-red-600 hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Mobile Menu -->
                        <div id="mobile-menu" class="hidden md:hidden absolute top-16 left-0 right-0 bg-white border-b border-gray-200 shadow-lg">
                            <div class="px-4 py-3 space-y-3">
                                <a href="{{route('posts.create')}}"
                                class="flex items-center gap-3 w-[150px] px-4 py-3 hover:bg-gray-50  text-back hover:text-red-700 font-medium rounded-lg transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                        <path fill="currentColor" d="M0 4c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm11 9l-3-3l-6 6h16l-5-5zm4-4a2 2 0 1 0 0-4a2 2 0 0 0 0 4"/>
                                    </svg>
                                    Crear Post
                                </a>
                                {{-- <a href="{{route('messages.index')}}"
                                class="flex items-center gap-3 w-[150px] px-4 py-3 hover:bg-gray-50  text-back hover:text-red-700 font-medium rounded-lg transition-colors duration-200">
                                    Mensajes
                                </a>
                                 --}}
                                 <div class="flex items-center gap-3 w-[150px] px-4 py-3">
                                    @livewire('message-notifications')
                                </div>
                                <a href="{{route('post.index', auth()->user()->username)}}"
                                class="block px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                    Mi Perfil (<span class="font-semibold">{{auth()->user()->username}}</span>)
                                </a>

                                <form method="POST" action="{{route('logout')}}" class="w-full">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 font-medium">
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    @guest
                        <!-- Guest Navigation -->
                        <nav class="flex items-center space-x-3">
                            <a href="{{route('login')}}"
                            class="hidden sm:inline-flex px-4 py-2 text-gray-700 hover:text-red-600 font-medium transition-colors duration-200 rounded-md hover:bg-gray-50">
                                Iniciar Sesión
                            </a>
                            <a href="{{route('register')}}"
                            class="hidden sm:inline-flex px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg text-sm sm:text-base">
                                Crear Cuenta
                            </a>

                            <!-- Mobile Login Link -->
                            <a href="{{route('login')}}"
                                class="sm:hidden p-2 text-gray-700 hover:text-red-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                            </a>
                            <a href="{{route('register')}}"
                                class="sm:hidden p-2 text-gray-700 hover:text-red-600 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v6m3-3h-6m-2 4a4 4 0 01-8 0m4-4a4 4 0 110-8 4 4 0 010 8z" />
                                </svg>
                            </a>
                        </nav>
                    @endguest
                </div>
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
    <script>
        // Toggle mobile menu
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js');
        }
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });

                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }
        });
        </script>
</html>
