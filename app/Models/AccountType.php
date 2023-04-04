<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasFactory;
   
    protected $table = 'account_types';

    protected $fillable = [
      
        'account_currency',
        'account_symbol',
        'account_description',
  
    ];

    // public static function getCurrencySymbol($id) :string
    // {
    //    $result = AccountType::where('id',$id)->pluck('account_currency')->toArray();
    //    $symbol = implode($result);
    //    return  $symbol; 
    // }
}
