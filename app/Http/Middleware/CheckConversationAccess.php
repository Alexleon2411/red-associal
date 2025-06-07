<?php

namespace App\Http\Middleware;

use App\Models\Conversation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckConversationAccess
{
    public function handle(Request $request, Closure $next)
    {
        $conversation = $request->route('conversation');

        if ($conversation && !$conversation->participants->contains(Auth::user())) {
            abort(403, 'No tienes acceso a esta conversación');
        }

        return $next($request);
    }
}

