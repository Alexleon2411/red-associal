<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MessageNotifications extends Component
{
    public $unreadCount = 0;

    public function mount()
    {
        $this->updateUnreadCount();
    }

    public function updateUnreadCount()
    {
        $this->unreadCount = Auth::user()->conversations()
            ->withCount(['messages' => function ($query) {
                $query->where('user_id', '!=', Auth::id())
                      ->whereNull('read_at');
            }])
            ->get()
            ->sum('messages_count');
    }

    public function render()
    {
        return view('livewire.message-notifications');
    }
}
