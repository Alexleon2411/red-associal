<?php

// app/Models/Conversation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conversation extends Model
{
    protected $fillable = [
        'name',
        'type'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc');
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
                    ->withPivot(['joined_at', 'last_read_at'])
                    ->withTimestamps();
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    // Obtener conversación entre dos usuarios
    public static function betweenUsers($userId1, $userId2)
    {
        return self::where('type', 'private')
            ->whereHas('participants', function ($query) use ($userId1) {
                $query->where('user_id', $userId1);
            })
            ->whereHas('participants', function ($query) use ($userId2) {
                $query->where('user_id', $userId2);
            })
            ->first();
    }

    // Crear o encontrar conversación entre usuarios
    public static function createOrFindBetweenUsers($userId1, $userId2)
    {
        $conversation = self::betweenUsers($userId1, $userId2);

        if (!$conversation) {
            $conversation = self::create(['type' => 'private']);
            $conversation->participants()->attach([$userId1, $userId2], [
                'joined_at' => now()
            ]);
        }

        return $conversation;
    }
}
