<?php
/**
 * Created by PhpStorm.
 * User: Francis
 * Date: 030.03.2023
 * Time: 23:56
 */

namespace App\Repositories;

use stdClass;
use App\Models\User;
use App\Models\AccountType;
use Illuminate\Support\Facades\Session;
use App\Repositories\traits\CurrencyTrait;

class AdminRepository
{
    public function getUsers(): object
    {
        $users = User::paginate(50);
        return $users;
    }

    public function role($request)
    {
        $user = User::findOrFail($request->id);
        if ($user->isAdmin == 1) {
            $user->isAdmin = 0;
            $user->update();
        } else {
            $user->isAdmin = 1;
            $user->update();
        }
    }

    public function edit($request)
    {
        $user = User::findOrFail($request->id);
        $data = [

            'name' =>   $user->name,
            'email' =>   $user->email,
            'phone' =>   $user->phone,
            'address' =>   $user->address,
            'id' =>   $user->id,

        ];
        
      echo  json_encode( $data);
    }

    public function update($request)
    {
     
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
             
         ]);


       $user = User::findOrFail($request->edit_id);
       $user->update([
        'name' =>   $request->name,
        'email' =>  $request->email,
        'phone' =>  $request->phone,
        'address'=> $request->address,
       ]);

       $user->save();
       Session::flash('message', 'User updated Successfully!'); 
        Session::flash('alert-class', 'alert-success');  

    }

    public function delete( $request)
    {
        $user = User::findOrFail($request->id);
        $user -> delete();

        Session::flash('message', 'User Deleted Successfully!'); 
        Session::flash('alert-class', 'alert-success');  

    }

    public function currencyAPI()
    {
      return (CurrencyTrait::currencyStore()); 
      
    }

    public function addCurrency($request) // add currency to db afrom currencyAPI
    {

        $validatedData = $request->validate([
            'code' => 'required',
             
         ]);

        $currencyPair = explode(',',$request->code);

        AccountType::create([
            'account_currency' =>  $currencyPair[1],
            'account_symbol' => $currencyPair[0],
            'account_description' =>  $currencyPair[2],
        ]); 
        Session::flash('message', 'Currency Added Successfully!'); 
        Session::flash('alert-class', 'alert-success'); 
       
        
    }

    public function operations( $request)
    {

      if(str_contains($request->id , 'edit'))
      {
        $id = str_replace('edit', '', $request->id);
      
        $user = AccountType::findOrFail($id);
        var_dump($user);

      }

    //   }elseif(str_contains($request->id , 'delete'))
    //   {
    //     $id = str_replace('delete', '', $request->id);
    //     dd($id);
    //     $currency = AccountType::findOrFail($request->id);
    //     $currency->delete();
    //   }
    }




}
