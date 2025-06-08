{{-- resources/views/messages/index.blade.php --}}
@extends('layouts.app')

@section('titulo')
    Mensajes
@endsection

@section('contenido')
{{-- <div class="container mx-auto px-4 py-6">
    <div class="flex h-screen bg-white rounded-lg shadow-lg overflow-hidden">


        <div id="conversations-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden hidden"></div>


        <div id="conversations-sidebar" class="
            fixed inset-y-0 left-0 z-50 w-80 bg-gray-50 border-r transform -translate-x-full transition-transform duration-300 ease-in-out
            md:relative md:translate-x-0 md:w-1/3 md:flex md:flex-col">

            <div class="flex items-center justify-between p-4 border-b md:justify-center">
                <h2 class="text-xl font-semibold text-gray-800">Mensajes</h2>
                <button id="close-conversations" class="md:hidden p-2 rounded-md text-gray-600 hover:text-red-600 hover:bg-gray-100 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="overflow-y-auto flex-1">
                @livewire('conversations-list')
            </div>
        </div>


        <div class="flex-1 flex items-center justify-center bg-gray-100">
            <div class="text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Selecciona una conversación</h3>
                <p class="mt-1 text-sm text-gray-500">Elige una conversación de la lista para comenzar a chatear</p>
            </div>
        </div>
    </div>
</div> --}}
<div class="container mx-auto px-4 ">
    <div class="flex h-screen bg-white rounded-lg shadow-lg overflow-hidden relative">

        {{-- Overlay para cerrar el menú en móvil --}}
        <div id="conversations-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden hidden"></div>

        {{-- Lista de conversaciones --}}
        <div id="conversations-sidebar" class="
            fixed inset-y-0 left-0 z-50 w-80 bg-gray-50 border-r transform -translate-x-full transition-transform duration-300 ease-in-out
            md:relative md:translate-x-0 md:w-1/3 md:flex md:flex-col
        ">
            {{-- Header del sidebar en móvil --}}
            <div class="flex items-center justify-between p-4 border-b md:justify-center">
                <h2 class="text-xl font-semibold text-gray-800">Mensajes</h2>
                <button id="close-conversations" class="md:hidden p-2 rounded-md text-gray-600 hover:text-red-600 hover:bg-gray-100 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="overflow-y-auto flex-1">
                @livewire('conversations-list')
            </div>
        </div>

        {{-- Chat activo --}}
        <div class="border max-h-[50px]">
            <button id="show-conversations" class="md:hidden p-2 rounded-md text-gray-600 hover:text-red-600 hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
       <div class="flex-1 flex items-center justify-center bg-gray-100">
            <div class="text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Selecciona una conversación</h3>
                <p class="mt-1 text-sm text-gray-500">Elige una conversación de la lista para comenzar a chatear</p>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showConversationsBtn = document.getElementById('show-conversations');
        const closeConversationsBtn = document.getElementById('close-conversations');
        const conversationsSidebar = document.getElementById('conversations-sidebar');
        const conversationsOverlay = document.getElementById('conversations-overlay');

        // Mostrar lista de conversaciones
        if (showConversationsBtn) {
            showConversationsBtn.addEventListener('click', function() {
                conversationsSidebar.classList.remove('-translate-x-full');
                conversationsOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevenir scroll del body
            });
        }

        // Cerrar lista de conversaciones
        function closeConversations() {
            conversationsSidebar.classList.add('-translate-x-full');
            conversationsOverlay.classList.add('hidden');
            document.body.style.overflow = ''; // Restaurar scroll del body
        }

        if (closeConversationsBtn) {
            closeConversationsBtn.addEventListener('click', closeConversations);
        }

        if (conversationsOverlay) {
            conversationsOverlay.addEventListener('click', closeConversations);
        }

        // Cerrar al presionar ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeConversations();
            }
        });

        // Manejar redimensionamiento de ventana
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) { // md breakpoint
                closeConversations();
            }
        });
    });

    // Polling para nuevos mensajes cada 3 segundos
    setInterval(() => {
        Livewire.dispatch('check-new-messages');
    }, 3000);
</script>

<style>
    /* Asegurar que el chat ocupe toda la altura disponible */
    .h-screen {
        height: calc(100vh - 8rem); /* Ajustar según el header */
    }

    /* Smooth scrolling para las conversaciones */
    .overflow-y-auto {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }

    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f7fafc;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 3px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background-color: #a0aec0;
    }

    /* Animación de entrada más suave */
    @media (max-width: 767px) {
        #conversations-sidebar {
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
    }
</style>

@endsection
