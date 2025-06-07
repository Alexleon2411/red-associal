
{{-- resources/views/livewire/conversations-list.blade.php --}}
<div>
    <div class="p-4">
        <input type="text"
               wire:model.live="search"
               placeholder="Buscar conversaciones..."
               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="space-y-1">
        @forelse($conversations as $conversation)
            @php
                $otherUser = $conversation->participants->where('id', '!=', auth()->id())->first();
                $lastMessage = $conversation->lastMessage;
            @endphp

            <a href="{{ route('messages.show', $conversation) }}"
               class="block p-4 hover:bg-gray-100 border-b transition-colors">
                <div class="flex items-center space-x-3">
                    @if($conversation->type === 'private' && $otherUser)
                        <img src="{{ $otherUser->imagen ? asset('perfiles/' . $otherUser->imagen) : asset('img/usuario.svg') }}"
                             alt="{{ $otherUser->name }}"
                             class="w-12 h-12 rounded-full">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $otherUser->name }}</p>
                            <p class="text-sm text-gray-600 truncate">{{ '@' . $otherUser->username }}</p>
                        </div>
                    @else
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $conversation->name }}</p>
                            <p class="text-sm text-gray-600">{{ $conversation->participants->count() }} participantes</p>
                        </div>
                    @endif

                    <div class="text-right">
                        @if($lastMessage)
                            <p class="text-xs text-gray-500">
                                {{ $lastMessage->created_at->diffForHumans() }}
                            </p>
                            <p class="text-sm text-gray-600 truncate max-w-24">
                                {{ Str::limit($lastMessage->content, 20) }}
                            </p>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay conversaciones</h3>
                <p class="mt-1 text-sm text-gray-500">Comienza una nueva conversación con tus amigos</p>
            </div>
        @endforelse
    </div>
</div>
