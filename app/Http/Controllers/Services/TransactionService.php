<?php
/**
 * Created by PhpStorm.
 * User: Francis
 * Date: 17.03.2023
 * Time: 5:12
 */
namespace App\Http\Controllers\Services;

use App\Http\Livewire\TransactionRepository\TransactionRepository;



class TransactionService
{
    private $TransactionRepository;

    public function __construct(TransactionRepository $TransactionRepository)
    {
        $this->TransactionRepository = $TransactionRepository;
    }

    public function getTransactions($request)
    {
        $transactions =  $this->TransactionRepository->getTransactions($request);
        return $transactions;
    }

    public function getNotifications()
    {
        return  $this->TransactionRepository->getNotifications();
    }
   
    public function  readNotification($request)
    {
        return  $this->TransactionRepository->readNotification($request);
    }

    public function  statement($request)
    {
        return  $this->TransactionRepository->statement($request);
    }
    
   
}