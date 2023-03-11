<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';

    protected $fillable = [
        'user_id',
        'account_currency_id',
        'account_name',
        'account_number',
        'account_currency',
        'account_balance',
      
    ];

    public  function accounType()
    {
       return $this -> belongsTo(AccountType::class, 'account_currency_id', 'id');
    }
}



