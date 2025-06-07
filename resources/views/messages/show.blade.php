{{-- resources/views/messages/show.blade.php --}}
@extends('layouts.app')

@section('titulo')
    Chat - {{ $conversation->type === 'private' ? $conversation->participants->where('id', '!=', auth()->id())->first()->name : $conversation->name }}
@endsection

@section('contenido')
<div class="container mx-auto px-4 py-6">
    <div class="flex h-screen bg-white rounded-lg shadow-lg overflow-hidden">

        {{-- Lista de conversaciones --}}
        <div class="w-1/3 bg-gray-50 border-r">
            <div class="p-4 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Mensajes</h2>
            </div>
            <div class="overflow-y-auto h-full">
                @livewire('conversations-list')
            </div>
        </div>

        {{-- Chat activo --}}
        <div class="flex-1 flex flex-col">
            @livewire('chat-component', ['conversation' => $conversation])
        </div>
    </div>
</div>

<script>
    // Polling para nuevos mensajes cada 3 segundos
    setInterval(() => {
        Livewire.dispatch('check-new-messages');
    }, 3000);
</script>
@endsection
