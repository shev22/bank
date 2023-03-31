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
        //  dd($request->edit_id);
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
        dd($request->id);
        $user = User::findOrFail($request->id);
        $user -> delete();
        
        Session::flash('message', 'User Deleted Successfully!'); 
        Session::flash('alert-class', 'alert-success');  

    }


}
