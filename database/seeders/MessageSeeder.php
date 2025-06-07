<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run()
    {
        // Crear algunas conversaciones de prueba
        $users = User::take(4)->get();

        if ($users->count() >= 2) {
            // Conversación privada entre usuario 1 y 2
            $conversation1 = Conversation::create(['type' => 'private']);
            $conversation1->participants()->attach([
                $users[0]->id => ['joined_at' => now()],
                $users[1]->id => ['joined_at' => now()]
            ]);

            // Algunos mensajes de prueba
            Message::create([
                'conversation_id' => $conversation1->id,
                'user_id' => $users[0]->id,
                'content' => '¡Hola! ¿Cómo estás?',
                'type' => 'text'
            ]);

            Message::create([
                'conversation_id' => $conversation1->id,
                'user_id' => $users[1]->id,
                'content' => '¡Hola! Todo bien por aquí, ¿y tú?',
                'type' => 'text'
            ]);

            // Conversación grupal
            if ($users->count() >= 4) {
                $groupConversation = Conversation::create([
                    'type' => 'group',
                    'name' => 'Grupo de Amigos'
                ]);

                $groupConversation->participants()->attach([
                    $users[0]->id => ['joined_at' => now()],
                    $users[1]->id => ['joined_at' => now()],
                    $users[2]->id => ['joined_at' => now()],
                    $users[3]->id => ['joined_at' => now()]
                ]);

                Message::create([
                    'conversation_id' => $groupConversation->id,
                    'user_id' => $users[0]->id,
                    'content' => '¡Bienvenidos al grupo!',
                    'type' => 'text'
                ]);
            }
        }
    }
}
