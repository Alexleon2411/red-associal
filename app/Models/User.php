<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Conversation;
use App\Models\Message;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function followers()
    {
        //para poder agregar los usuarios que te siguen en la tabla, esta especificacion se hace porque ya estamos usando la misma tabla de datos que
        // en este caso es la tabla de usuarios que es de donde obtenemos los id's de los usuarios que se estan siguiendo

        /// se debe tener en cuanta que follower se refiere a ti y user_id se refiere al usuario al que estamos tratando de seguir
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }



    public function followings()
    {
        //para poder agregar los usuarios que te siguen en la tabla, esta especificacion se hace porque ya estamos usando la misma tabla de datos que
        // en este caso es la tabla de usuarios que es de donde obtenemos los id's de los usuarios que se estan siguiendo

        /// se debe tener en cuanta que follower se refiere a ti y user_id se refiere al usuario al que estamos tratando de seguir
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }
    // Usuarios que este usuario sigue
    public function siguiendo()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function siguiendo2(User $user)
    {
        return $this->followers->contains($user->id);
    }

    // esta parte se encarga de los mensajes

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
                    ->withPivot(['joined_at', 'last_read_at'])
                    ->withTimestamps();
    }

    public function personalConversations()
    {
        return $this->belongsToMany(
            Conversation::class,
            'conversation_participants', // tabla pivote
            'user_id',                  // foreign key del usuario actual
            'conversation_id'           // foreign key de la conversación
        );
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc');
    }

    // Helper para obtener conversaciones con mensajes no leídos
    public function getUnreadMessagesCountAttribute()
    {
        return $this->conversations()
            ->withCount(['messages' => function ($query) {
                $query->where('user_id', '!=', $this->id)
                    ->whereNull('read_at');
            }])
            ->get()
            ->sum('messages_count');
    }

    // Scope para conversaciones con mensajes no leídos
    public function conversationsWithUnreadMessages()
    {
        return $this->conversations()
            ->whereHas('messages', function ($query) {
                $query->where('user_id', '!=', $this->id)
                    ->whereNull('read_at');
            });
    }
}
