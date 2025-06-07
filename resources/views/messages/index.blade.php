{{-- resources/views/messages/index.blade.php --}}
@extends('layouts.app')

@section('titulo')
    Mensajes
@endsection

@section('contenido')
<div class="container mx-auto px-4 py-6">
    <div class="flex h-screen bg-white rounded-lg shadow-lg overflow-hidden">

        {{-- Lista de conversaciones --}}
        <div class="w-1/3 bg-gray-50 border-r">
            <div class="p-4 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Mensajes</h2>
                <div class="mt-3">
                    <input type="text"
                           placeholder="Buscar conversaciones..."
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="overflow-y-auto h-full">
                @livewire('conversations-list')
            </div>
        </div>

        {{-- Área de chat --}}
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
@endsection
