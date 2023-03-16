<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'operation',
        'currency',
        'status',
        'description',
        'amount',
        'comment',
        'transaction_id',
        'available_balance',
    ];
}



