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
use App\Models\Message;
use App\Models\UsersChat;
use App\Models\AccountType;
use Illuminate\Support\Facades\Auth;
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
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'id' => $user->id,
        ];

        echo json_encode($data);
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
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $user->save();
        Session::flash('message', 'User updated Successfully!');
        Session::flash('alert-class', 'alert-success');
    }

    public function delete($request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();

        Session::flash('message', 'User Deleted Successfully!');
        Session::flash('alert-class', 'alert-success');
    }

    public function currencyAPI()
    {
        return CurrencyTrait::currencyStore();
    }

    public function addCurrency($request)
    {
        // add currency to db afrom currencyAPI
        // dd($request);
        $validatedData = $request->validate([
            'code' => 'required',
        ]);

        $currencyPair = array_map(function ($item) {
            return explode(',', $item);
        }, $request->code);
        foreach ($currencyPair as $item) {
            $currency = AccountType::where(
                'account_description',
                $item[2]
            )->get();
            $toarray = collect($currency)->toArray();
            if (!$toarray == []) {
                Session::flash('message', 'Currency already Added!');
                Session::flash('alert-class', 'alert-danger');
            } else {
                AccountType::create([
                    'account_currency' => $item[1],
                    'account_symbol' => $item[0],
                    'account_description' => $item[2],
                ]);
                Session::flash('message', 'Added Successfully!');
                Session::flash('alert-class', 'alert-success');
            }
        }
    }

    public function operations($request)
    {
        switch ($request->id) {
            case str_contains($request->id, 'edit'):
                $id = str_replace('edit', '', $request->id);
                $data = [
                    'id' => $id,
                ];
                echo json_encode($data);
                break;

            case str_contains($request->id, 'delete'):
                $id = str_replace('delete', '', $request->id);
                $data = [
                    'id' => $id,
                ];
                echo json_encode($data);
                break;

            default:
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                break;
        }
    }

    public function updateCurrency($request)
    {
        switch ($request->id) {
            case str_contains($request->id, 'update'):
                $validatedData = $request->validate([
                    'name' => 'required',
                    'code' => 'required',
                    'symbol' => 'required',
                ]);

                $id = str_replace('update', '', $request->id);
                $currency = AccountType::findOrFail($id);
                $currency->update([
                    'account_currency' => $request->symbol,
                    'account_symbol' => $request->code,
                    'account_description' => $request->name,
                ]);
                $currency->save();

                Session::flash('message', 'Currency Updated Successfully!');
                Session::flash('alert-class', 'alert-success');
                break;
            case str_contains($request->id, 'destroy'):
                $id = str_replace('destroy', '', $request->id);
                $currency = AccountType::findOrFail($id);
                $currency->delete();
                Session::flash('message', 'Currency Removed!');
                Session::flash('alert-class', 'alert-success');
                break;
            default:
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                break;
        }
    }

    // CHAT SECTION  SET DEFAULT USER//

    public function setDefaultUser()
    {
        $defaultUser = Message::where('receiver_id', Auth::id())
            ->orWhere('sender_id', Auth::id())
            ->latest('created_at')
            ->first();

        if ($defaultUser) {
            if ($defaultUser->sender_id == Auth::id()) {
                return $defaultUser->receiver_id;
            } else {
                return $defaultUser->sender_id;
            }
        }
    }
}
