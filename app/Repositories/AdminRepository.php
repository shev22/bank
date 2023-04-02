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
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //   CURLOPT_URL => "https://api.apilayer.com/currency_data/list",
        //   CURLOPT_HTTPHEADER => array(
        //     "Content-Type: text/plain",
        //     "apikey: XByj6XjTvKFtHHsmUbJkyeat6Qfs8OtM"
        //   ),
        //   CURLOPT_RETURNTRANSFER => true,
        //   CURLOPT_ENCODING => "",
        //   CURLOPT_MAXREDIRS => 10,
        //   CURLOPT_TIMEOUT => 0,
        //   CURLOPT_FOLLOWLOCATION => true,
        //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //   CURLOPT_CUSTOMREQUEST => "GET"
        // ));
        
        // $response = curl_exec($curl);
        // curl_close($curl);
        // $result = json_decode($response, true);
        // dd( $result );

        $result=[];


       return $result;
       
    }

    public function addCurrency($request) // add currency to db afrom currencyAPI
    {
        $validatedData = $request->validate([
            'symbol' => 'required',
             
         ]);

        $currencyPair = explode(',',$request->code);
        $currencyPair[2] =  $request->symbol;
        
        AccountType::create([
            'account_currency' =>  $currencyPair[2],
            'account_symbol' => $currencyPair[0],
            'account_description' =>  $currencyPair[1],
        ]); 
        Session::flash('message', 'Currency Added Successfully!'); 
        Session::flash('alert-class', 'alert-success'); 
       
        
    }

    public function operations( $request)
    {
      dd($request->id);
      if($request->edit == 'edit')
      {
        $user = User::findOrFail($request->edit_id);
      }elseif($request->delete == 'delete')
      {
        $currency = AccountType::findOrFail($request->id);
        $currency->delete();
      }
    }




}
