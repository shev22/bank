@section('content')
@extends('layouts.app')
@include('layouts.inc.navbar')















<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-capitalize ps-3">Transactions</h6>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">

                <thead>

                  <tr>
                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">№</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Account Number</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Transaction Id</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Operation</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Comment</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Currency</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Description</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Amount</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Balance</th>
                  
                
                  </tr>
                </thead>
                <tbody>

                    @php
                        $№ = 1;
                    @endphp  
           @foreach($transactions as $transaction)
                       
          
                  <tr>
                  
                    <td class="align-middle text-center">
                        <p class="text-xs font-weight-bold mb-0">{{$№++}}</p>
                       
                      </td>
                    <td class="align-middle text-center">
                      <p class="text-xs font-weight-bold mb-0">{{ $transaction->account_number }}</p>
                     
                    </td>

                    <td class="align-middle text-center">
                        <p class="text-xs font-weight-bold mb-0">{{ $transaction->transaction_id }}</p>
                       
                      </td >
                    <td >
                        <p class="text-xs font-weight-bold mb-0">{{ $transaction->operation }}</p>
                       
                      </td>
                      <td class="align-middle text-center"> 
                        <p class="text-xs font-weight-bold mb-0">{{ $transaction->comment }}</p>
                       
                      </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-gradient-{{ $transaction->status == 'Success' ? 'success' : 'danger'  }}">{{ $transaction->status }}</span>
                    </td>

                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{ $transaction->currency }}</span>
                    </td>

                    <td class="align-middle text-center " >
                     
                       <p class="text-xs font-weight-bold mb-0  ">{{ $transaction->description }}</p>
                      </a>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold ">{{ $transaction->amount }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $transaction->available_balance }}</span>
                      </td>


                  </tr>
                  @endforeach 
                 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
   
    </div>
    <footer class="footer py-4  ">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              © <script>
                document.write(new Date().getFullYear())
              </script>,
              made with <i class="fa fa-heart"></i> by
              <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
              for a better web.
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>










































@include('layouts.inc.plugins')
@endsection