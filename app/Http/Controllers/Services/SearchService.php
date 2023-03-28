<?php
/**
 * Created by PhpStorm.
 * User: Francis
 * Date: 027.03.2023
 * Time: 12:44
 */
namespace App\Http\Controllers\Services;

use App\Repositories\SearchRepository;



class SearchService
{

    private $searchRepository;

    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }


    public function search($request)
    {
       $results = $this->searchRepository->search($request);
        return $results;
    }

    public function setHeader($search):string
    {
      return  $this->searchRepository->setHeader($search);
    }

}