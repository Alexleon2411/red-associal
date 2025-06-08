<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class SearchUsers extends Component
{
use WithPagination;

    public $search = '';
    public $showResults = false;
    public $users = [];

    protected $paginationTheme = 'tailwind';

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->searchUsers();
            $this->showResults = true;
        } else {
            $this->users = [];
            $this->showResults = false;
        }
        $this->resetPage();
    }

    public function searchUsers()
    {
        $this->users = User::where('id', '!=', Auth::id())
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->with(['followers']) // para contar seguidores
            ->limit(10)
            ->get();
    }


    public function followUser($userId)
    {
        $user = User::find($userId);
        if ($user && !Auth::user()->siguiendo->contains($userId)) {
            Auth::user()->siguiendo()->attach($userId);
            $this->dispatch('user-followed', userId: $userId);
            session()->flash('mensaje', 'Ahora sigues a ' . $user->name);
        }
    }

    public function unfollowUser($userId)
    {
        $user = User::find($userId);
        if ($user && Auth::user()->siguiendo->contains($userId)) {
            Auth::user()->siguiendo()->detach($userId);
            $this->dispatch('user-unfollowed', userId: $userId);
            session()->flash('mensaje', 'Has dejado de seguir a ' . $user->name);
        }
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->users = [];
        $this->showResults = false;
    }

   public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('siguiendo');
        return view('livewire.search-users');
    }
}
