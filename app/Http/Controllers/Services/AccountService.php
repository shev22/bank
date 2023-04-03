<?php
/**
 * Created by PhpStorm.
 * User: Francis
 * Date: 07.03.2023
 * Time: 9:12
 */
namespace App\Http\Controllers\Services;

use App\Repositories\AccountRepository;

class AccountService
{
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function getAccountCurrencies(): array
    {
        $accounts =  $this->accountRepository->getAccountTypes();
        return $accounts;
    }

    public function getUserAccounts()
    {
        $accounts =  $this->accountRepository->getUserAccounts();
        return $accounts;
    }

    public function createAccount( $request)
    {
        $this->accountRepository->createAccount($request);
    }

    public function getAccountDetail($request)
    {
        $this->accountRepository->getAccountDetail($request);
    }
}