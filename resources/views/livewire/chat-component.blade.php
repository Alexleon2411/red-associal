<div class="flex flex-col h-full">
    {{-- Header del chat --}}
    <div class="p-4 border-b bg-white">
        <div class="flex items-center">
            @if($conversation->type === 'private')
                @php
                    $otherUser = $conversation->participants->where('id', '!=', auth()->id())->first();
                @endphp
                <img src="{{ $otherUser->imagen ? asset('perfiles/' . $otherUser->imagen) : asset('img/usuario.svg') }}"
                     alt="{{ $otherUser->name }}"
                     class="w-10 h-10 rounded-full mr-3">
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $otherUser->name }}</h3>
                    <p class="text-sm text-gray-500">{{ '@' . $otherUser->username }}</p>
                </div>
            @else
                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $conversation->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $conversation->participants->count() }} participantes</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Contenedor principal --}}
    <div class="flex-1 overflow-hidden flex flex-col">
        <div class="flex-1"></div>

        {{-- Mensajes --}}
        <div class="overflow-y-auto p-4 space-y-4 max-h-[580px]" id="messages-container">
            @foreach(collect($messages)->reverse() as $message)
                <div class="flex {{ $message['user_id'] === auth()->id() ? 'justify-end' : 'justify-start' }} my-2">
                    <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message['user_id'] === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                        @if($message['user_id'] !== auth()->id())
                            <p class="text-xs font-semibold mb-1">{{ $message['user']['name'] }}</p>
                        @endif
                        <p class="text-sm">{{ $message['content'] }}</p>
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-xs opacity-75">
                                {{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}
                            </p>
                            @if($message['user_id'] === auth()->id())
                                <button wire:click="deleteMessage({{ $message['id'] }})"
                                        class="text-xs opacity-75 hover:opacity-100 ml-2"
                                        onclick="return confirm('¿Eliminar mensaje?')">
                                    Eliminar
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Input para nuevo mensaje --}}
    <div class="p-4 border-t bg-white w-full">
        <form wire:submit="sendMessage" class="flex md:space-x-2">
            <input type="text"
                   wire:model="newMessage"
                   placeholder="Escribe un mensaje..."
                   class="md:flex-1 px-2 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 mr-1"
                   maxlength="1000">
            <button type="submit"
                    class="px-2 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Enviar
            </button>
        </form>
        @error('newMessage')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            let isInitialLoad = true;
            let shouldAutoScroll = false;

            function scrollToBottom() {
                const container = document.getElementById('messages-container');
                if (container && shouldAutoScroll) {
                    container.scrollTo({
                        top: container.scrollHeight,
                        behavior: isInitialLoad ? 'auto' : 'smooth'
                    });
                    shouldAutoScroll = false; // Reset después del scroll
                }
                isInitialLoad = false;
            }

            // // Scroll inicial
            setTimeout(() => {
                shouldAutoScroll = true;
                scrollToBottom();
            }, 100);

            // SOLO cuando se dispara el evento específico desde este componente
            Livewire.on('scroll-to-bottom', () => {
                shouldAutoScroll = true;
                setTimeout(scrollToBottom, 5000);
            });

            // // Hook más específico - solo para este componente
            // Livewire.hook('morph.updated', ({ component, el }) => {
            //     // Solo si es específicamente el componente de chat Y tiene el flag
            //     if (component.name === 'chat-component' && shouldAutoScroll) {
            //         setTimeout(scrollToBottom, 50000);
            //     }
            // });
        });

        // Polling separado y más controlado
        document.addEventListener('livewire:init', () => {
            // setInterval(() => {
            //     // Solo verificar si estamos en la página de chat activa
            // }, 30000);
            if (document.getElementById('messages-container')) {
                @this.call('checkNewMessages');
            }
        });
    </script>
</div>
