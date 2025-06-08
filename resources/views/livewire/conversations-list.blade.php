{{-- resources/views/livewire/conversations-list.blade.php --}}
<div class="flex flex-col h-full">
    {{-- Barra de búsqueda --}}
    <div class="flex-shrink-0 p-4 border-b bg-white">
        <div class="relative">
            <input type="text"
                   wire:model.live="search"
                   placeholder="Buscar conversaciones..."
                   class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Lista de conversaciones --}}
    <div class="flex-1 overflow-y-auto">
        @forelse($conversations as $conversation)
            @php
                $otherUser = $conversation->participants->where('id', '!=', auth()->id())->first();
                $lastMessage = $conversation->lastMessage;
                $unreadCount = $conversation->messages()
                    ->where('user_id', '!=', auth()->id())
                    ->whereNull('read_at')
                    ->count();
                $isActive = request()->route('conversation')?->id === $conversation->id;
            @endphp

            <a href="{{ route('messages.show', $conversation) }}"
               class="block relative transition-all duration-200 {{ $isActive ? 'bg-red-50 border-r-3 border-red-500' : 'hover:bg-gray-50' }}">

                <div class="flex items-center space-x-3 p-4">
                    {{-- Avatar --}}
                    <div class="flex-shrink-0 relative">
                        @if($conversation->type === 'private' && $otherUser)
                            @if($otherUser->imagen)
                                <img src="{{ asset('perfiles/' . $otherUser->imagen) }}"
                                     alt="{{ $otherUser->name }}"
                                     class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-sm">
                            @else
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center ring-2 ring-white shadow-sm">
                                    <span class="text-lg font-semibold text-white">
                                        {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Indicador de estado online (opcional) --}}
                            <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-400 border-2 border-white rounded-full"></div>
                        @else
                            {{-- Avatar de grupo --}}
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center ring-2 ring-white shadow-sm">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Información de la conversación --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-sm font-semibold text-gray-900 truncate {{ $unreadCount > 0 ? 'font-bold' : '' }}">
                                @if($conversation->type === 'private' && $otherUser)
                                    {{ $otherUser->name }}
                                @else
                                    {{ $conversation->name ?? 'Chat Grupal' }}
                                @endif
                            </h3>

                            @if($lastMessage)
                                <span class="text-xs text-gray-500 flex-shrink-0 ml-2">
                                    {{ $lastMessage->created_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>

                        {{-- Username o participantes --}}
                        @if($conversation->type === 'private' && $otherUser)
                            <p class="text-xs text-gray-500 mb-1">{{ '@' . $otherUser->username }}</p>
                        @else
                            <p class="text-xs text-gray-500 mb-1">{{ $conversation->participants->count() }} participantes</p>
                        @endif

                        {{-- Último mensaje --}}
                        <div class="flex items-center justify-between">
                            @if($lastMessage)
                                <p class="text-sm text-gray-600 truncate flex-1 {{ $unreadCount > 0 ? 'font-medium text-gray-900' : '' }}">
                                    @if($lastMessage->user_id === auth()->id())
                                        <span class="text-gray-500">Tú: </span>
                                    @endif
                                    {{ Str::limit($lastMessage->content, 35) }}
                                </p>
                            @else
                                <p class="text-sm text-gray-400 italic flex-1">No hay mensajes</p>
                            @endif

                            {{-- Contador de mensajes no leídos --}}
                            @if($unreadCount > 0)
                                <div class="flex-shrink-0 ml-2">
                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full min-w-[20px] h-5">
                                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Indicador de conversación activa --}}
                @if($isActive)
                    <div class="absolute right-0 top-0 bottom-0 w-1 bg-red-500"></div>
                @endif
            </a>
        @empty
            <div class="flex flex-col items-center justify-center p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay conversaciones</h3>
                <p class="text-sm text-gray-500 mb-4">Comienza una nueva conversación con tus amigos</p>

                {{-- Botón para iniciar nueva conversación (opcional) --}}
                <button class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nueva Conversación
                </button>
            </div>
        @endforelse
    </div>

    {{-- Footer opcional con acciones rápidas --}}
    <div class="flex-shrink-0 p-3 border-t bg-gray-50">
        <div class="flex justify-between items-center">
            <span class="text-xs text-gray-500">
                {{ $conversations->count() }} conversación{{ $conversations->count() !== 1 ? 'es' : '' }}
            </span>

            {{-- Botón de actualizar --}}
            <button wire:click="$refresh"
                    class="p-1.5 text-gray-400 hover:text-red-600 rounded-md hover:bg-white transition-colors duration-200"
                    title="Actualizar conversaciones">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<style>
    /* Scrollbar personalizado para la lista */
    .overflow-y-auto {
        scrollbar-width: thin;
        scrollbar-color: #e5e7eb #f9fafb;
    }

    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f9fafb;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background-color: #e5e7eb;
        border-radius: 2px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background-color: #d1d5db;
    }

    /* Animación para el indicador de estado */
    .bg-green-400 {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    /* Efecto de hover más suave */
    a:hover .bg-gradient-to-br {
        transform: scale(1.05);
        transition: transform 0.2s ease-in-out;
    }
</style>
