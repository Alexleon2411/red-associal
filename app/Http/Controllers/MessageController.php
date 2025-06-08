<?php

// app/Http/Controllers/MessageController.php
namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar lista de conversaciones
    public function index()
    {
        // dd('el metodo se ha llamado');
        $conversations = Auth::user()->conversations()
            ->with(['lastMessage.user', 'participants'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('messages.index', compact('conversations'));
    }

    // Mostrar conversación específica
    public function show(Conversation $conversation)
    {
        // Verificar que el usuario pertenece a la conversación
        if (!$conversation->participants->contains(Auth::user())) {
            abort(403, 'No tienes acceso a esta conversación');
        }

        $messages = $conversation->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        // Marcar mensajes como leídos
        $conversation->messages()
            ->where('user_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.show', compact('conversation', 'messages'));
    }

    // Iniciar nueva conversación
    public function create(User $user)
    {
        if ($user->id === Auth::user()->id) {
            return redirect()->route('messages.index')
                ->with('error', 'No puedes enviarte mensajes a ti mismo');
        }

        $conversation = Conversation::createOrFindBetweenUsers(Auth::id(), $user->id);

        return redirect()->route('messages.show', $conversation);
    }

    // Enviar mensaje
    public function store(Request $request, Conversation $conversation)
    {
        // Verificar que el usuario pertenece a la conversación
        if (!$conversation->participants->contains(Auth::user())) {
            abort(403, 'No tienes acceso a esta conversación');
        }

        $this->validate($request, [
            'content' => 'required|max:1000',
            'type' => 'in:text,image,file'
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'type' => $request->type ?? 'text'
        ]);

        // Actualizar timestamp de la conversación
        $conversation->touch();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message->load('user'),
                'success' => true
            ]);
        }

        return back()->with('mensaje', 'Mensaje enviado correctamente');
    }

    // Eliminar mensaje
    public function destroy(Message $message)
    {
        if ($message->user_id !== Auth::id()) {
            abort(403, 'No puedes eliminar este mensaje');
        }

        $conversation = $message->conversation;
        $message->delete();

        return back()->with('mensaje', 'Mensaje eliminado correctamente');
    }

    // API para obtener mensajes nuevos (para tiempo real)
    public function getNewMessages(Conversation $conversation, Request $request)
    {
        if (!$conversation->participants->contains(Auth::user())) {
            abort(403);
        }

        $lastMessageId = $request->get('last_message_id', 0);

        $newMessages = $conversation->messages()
            ->with('user')
            ->where('id', '>', $lastMessageId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($newMessages);
    }
}
