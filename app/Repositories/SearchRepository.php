<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 7.03.2023
 * Time: 8:37
 */

namespace App\Repositories;

use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;

class SearchRepository
{
    public function search($request): array
    {
       
        $keyWord = $request->search;
        $results['users'] = User::where('name', 'LIKE', '%' . $keyWord . '%')
            ->orWhere('email', 'LIKE', '%' . $keyWord . '%')
            ->orWhere('address', 'LIKE', '%' . $keyWord . '%')
            ->orWhere('phone', 'LIKE', '%' . $keyWord . '%')
            ->get();

        $results['transactions'] = Transaction::where('transaction_id', 'LIKE', '%' . $keyWord . '%' )
            ->orWhere('account_number', 'LIKE', '%' . $keyWord . '%')
            ->get();
        $results['accounts'] = Account::wherein(
            'user_id',
            $this->getUserAccounts($results['users'])
        )->get();

        return $results;
    }

    private function getUserAccounts($data): array
    {
        $ids = [];

        foreach ($data as $result) {
            array_push($ids, $result->id);
        }

        return $ids;
    }

    public function setHeader($results): string
    {
        $response = collect($results)->toArray();

        $responseArray = function () use ($response) {
            array_pop($response);
            return $response;
        };

        $searchTitle = [];
        foreach ($responseArray() as $key => $value) {
            if ($value !== []) {
                $searchTitle[] = $key;
            }
        }
        return implode($searchTitle);
    }
}
