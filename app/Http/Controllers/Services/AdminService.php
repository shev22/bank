<?php


/**
 * Created by PhpStorm.
 * User: Francis
 * Date: 030.03.2023
 * Time: 23:56
 */
 namespace App\Http\Controllers\Services;
 use App\Repositories\AdminRepository;

class AdminService
{
    private  $adminRepository;
    
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getUsers(): object
    {
        $users = $this->adminRepository->getUsers();
        return  $users;
    } 

    public function role( $request)
    {
        $this->adminRepository->role($request);
    }

    public function edit($request)
    {
        $this->adminRepository->edit($request);
    }

    public function update($request)
    {
        $this->adminRepository->update($request);
    }

    public function delete( $request)
    {
  
        $this->adminRepository->delete($request);
       return redirect()->route('admin');

    }

    public function currencyAPI()
    {
     return($this->adminRepository->currencyAPI());
       
    }

    
    public function addCurrency($request) // add currency to db afrom currencyAPI
    {
        $this->adminRepository->addCurrency($request);
        
    }

    public function operations( $request)
    {
      return($this->adminRepository->operations($request));
    }



}