<?php

// app/Livewire/ChatComponent.php
namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class ChatComponent extends Component
{
    public $conversation;
    public $messages = [];
    public $newMessage = '';
    public $lastMessageId = 0;

    public function mount(Conversation $conversation)
    {
        // Verificar acceso
        if (!$conversation->participants->contains(Auth::user())) {
            abort(403);
        }

        $this->conversation = $conversation;
        $this->loadMessages();
        $this->markMessagesAsRead();
    }

    public function loadMessages()
    {
        $this->messages = $this->conversation->messages()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        if (!empty($this->messages)) {
            $this->lastMessageId = end($this->messages)['id'];
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|max:1000'
        ]);

        $message = Message::create([
            'conversation_id' => $this->conversation->id,
            'user_id' => Auth::id(),
            'content' => trim($this->newMessage),
            'type' => 'text'
        ]);

        // Actualizar conversación
        $this->conversation->touch();

        // Limpiar input
        $this->newMessage = '';

        // Recargar mensajes
        $this->loadMessages();

        // Emitir evento para otros usuarios (si usas broadcasting)
        $this->dispatch('message-sent', [
            'conversationId' => $this->conversation->id,
            'message' => $message->load('user')
        ]);

        // Scroll to bottom
        $this->dispatch('scroll-to-bottom');
        // También emitir para actualizar contadores
        $this->dispatch('messageReceived');
        $this->dispatch('conversationUpdated');
    }

    public function deleteMessage($messageId)
    {
        $message = Message::find($messageId);

        if ($message && $message->user_id === Auth::id()) {
            $message->delete();
            $this->loadMessages();

            session()->flash('mensaje', 'Mensaje eliminado');
        }
    }

    public function markMessagesAsRead()
    {
        $this->conversation->messages()
            ->where('user_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    #[On('check-new-messages')]
    public function checkNewMessages()
    {
        $newMessages = $this->conversation->messages()
            ->with('user')
            ->where('id', '>', $this->lastMessageId)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($newMessages->count() > 0) {
            $this->loadMessages();
            $this->markMessagesAsRead();
            $this->dispatch('scroll-to-bottom');
        }
    }

    public function render()
    {
        return view('livewire.chat-component');
    }
}
