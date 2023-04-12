<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatTitle extends Model
{
    use HasFactory;
   
    protected $table = 'chat_titles';

    protected $fillable = [
        'title',
        
    ];
}
