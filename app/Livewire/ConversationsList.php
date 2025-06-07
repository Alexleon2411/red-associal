<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ConversationsList extends Component
{
    public $conversations = [];
    public $search = '';

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $query = Auth::user()->conversations()
            ->with(['lastMessage.user', 'participants'])
            ->orderBy('updated_at', 'desc');

        if ($this->search) {
            $query->whereHas('participants', function ($q) {
                $q->where('users.name', 'like', '%' . $this->search . '%')
                  ->where('users.id', '!=', Auth::id());
            });
        }

        $this->conversations = $query->get();
    }

    public function updatedSearch()
    {
        $this->loadConversations();
    }

    #[On('conversation-updated')]
    public function refreshConversations()
    {
        $this->loadConversations();
    }

    public function render()
    {
        return view('livewire.conversations-list');
    }
}
