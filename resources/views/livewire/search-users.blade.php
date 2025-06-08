{{-- resources/views/livewire/user-search.blade.php --}}
<div class="w-full max-w-2xl mx-auto my-3">
    {{-- Barra de búsqueda --}}
    <div class="relative">
        <div class="relative">
            <input type="text"
                   wire:model.live.debounce.300ms="search"
                   placeholder="Buscar usuarios por nombre, username o email..."
                   class="w-full px-4 py-3 pl-10 pr-10 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

            {{-- Ícono de búsqueda --}}
            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            {{-- Botón limpiar --}}
            @if($search)
                <button wire:click="clearSearch"
                        class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            @endif
        </div>

    {{-- Resultados de búsqueda --}}
    @if($showResults && count($users) > 0)
        <div class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-96 overflow-y-auto">
            @foreach($users as $user)
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between p-4 hover:bg-gray-50 border-b border-gray-100 last:border-b-0 gap-4">
                    {{-- Info del usuario --}}
                    <div class="flex items-center space-x-3">
                        <img src="{{ $user->imagen ? asset('perfiles/' . $user->imagen) : asset('img/usuario.svg') }}"
                             alt="{{ $user->name }}"
                             class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-600">{{ '@' . $user->username }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $user->followers->count() }} seguidores
                            </p>
                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div class="flex items-center space-x-2">
                        {{-- Botón seguir/no seguir --}}
                        @if(auth()->user()->siguiendo->contains($user->id))
                            <button wire:click="unfollowUser({{ $user->id }})"
                                    class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">
                                Dejar de seguir
                            </button>
                        @else
                            <button wire:click="followUser({{ $user->id }})"
                                    class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                                Seguir
                            </button>
                        @endif

                        {{-- Botón mensaje --}}
                        <a href="{{ route('messages.create', $user) }}"
                           class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors">
                            Mensaje
                        </a>

                        {{-- Botón perfil --}}
                        <a href="{{ route('post.index', $user) }}"
                           class="px-4 py-2 text-sm font-medium text-green-600 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors">
                            Ver perfil
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @elseif($showResults && $search && count($users) === 0)
        <div class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg p-4">
            <div class="text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron usuarios</h3>
                <p class="mt-1 text-sm text-gray-500">Intenta con otro término de búsqueda</p>
            </div>
        </div>
    @endif
    </div>

    {{-- Mensajes flash --}}
    @if (session()->has('mensaje'))
        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('mensaje') }}
        </div>
    @endif
</div>
