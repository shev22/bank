<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersChat extends Model
{
    use HasFactory;

    protected $table = 'users_chat';

    protected $fillable = [
        'user_id',
        'total_messages',
        'creator_id',
        'chat_id',
    ];

    
    public  function user()
    {
       return $this -> belongsTo(User::class, 'user_id', 'id');
    }
}
