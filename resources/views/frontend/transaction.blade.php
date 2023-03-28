@section('content')
    @extends('layouts.app')
    @include('layouts.inc.navbar')


    <div class="container-fluid py-4" style="height: 100vh">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Transactions
                                <a class="btn btn-sm btn-outline-light float-end mx-2" id="toggle">Filter</a>
                                <a class="btn btn-sm btn-outline-light float-end d-none" id="statement">Statement</a>

                                <form method="post" action="{{ url('statement') }}" class=" float-end mx-3 btn btn-sm btn-outline-light mb-3"
                                    id="statementDiv"  style="display: none">
                                    @csrf
                                    <select class="" aria-label=".form-select-sm example" name='account_number'
                                        style="height:25px; border-radius:4px" id="account_number">
                                        <option value="">Select Accounts</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->account_number }}" >
                                                &nbsp; {{ $account->account_number }} &nbsp;
                                                {{ $account->accounType->account_symbol }} </option>
                                        @endforeach
                                    </select>

                                    <input type="date" class="p-2 fw-bold " style="height:25px; border-radius:4px"
                                        name="start" id="start">
                                    <input type="date" class="p-2 fw-bold" style="height:25px; border-radius:4px"
                                        name="end" id="end">
                                
                                    <button class=" statement"
                                       >view</button>
                                </form>

                            </h6>
                        </div>
                  
                        <hr class="horizontal dark my-2">
                    </div>
                    <div class="card-body px-0 pb-2 py-0" id="toggleDiv" style="display:none"> 
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0 table-primary">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                            Select Account</th>
                                        <th
                                            class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                            Select Period</th>
                                        <th
                                            class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                            Download Statement</th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Email Statement</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Apply</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form method="post" action="{{ url('transactions') }}">
                                        @csrf
                                        <tr>

                                            <td class="align-middle text-center">
                                                <p class="text-xs font-weight-bold mb-0 mx-3">    
                                                     <select class="form-select form-select-sm " aria-label=".form-select-sm example"
                                                    name='account_number' style="width:110px; border-radius:4px">
                                                    <option value="">Select Accounts</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->account_number }}   ">
                                                            &nbsp; {{ $account->account_number }} &nbsp;
                                                            {{ $account->accounType->account_symbol }} </option>
                                                    @endforeach
                                                </select></p>

                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs font-weight-bold mt-2"> <input type="date" class=" fw-bold px-3 text-sm" name="start" style="height:25px; border-radius:4px">
                                                    &nbsp;<input type="date" class=" fw-bold px-3 text-sm" name="end" style="height:25px; border-radius:4px">
                                                </p>

                                            </td>

                                            <td class="align-middle text-center">
                                                <p class="text-xs font-weight-bold mb-0"><button class="btn btn-outline-dark btn-sm mx-5"name="download-statement" value="download-statement" >download</button>
                                                </p>

                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 text-center"><button class="btn btn-outline-dark btn-sm mx-5" name="email-statement" value="email-statement" >Email</button></p>

                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs font-weight-bold mb-0"><button class="btn btn-outline-dark btn-sm mx-5">Apply</button></p>

                                            </td>
                                          
                                        </tr>
                             
                                    </form>
                                </tbody>
                            </table>
                        </div>
                
                    </div>
                    <div class="card-body px-0 pb-2 py-0 ">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                            №</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Account Number</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Transaction Id</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Operation</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Comment</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Account Currency</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Date</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Amount</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Balance</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $№ = 1;
                                    @endphp
                                    @foreach ($transactions as $transaction)
                                        <tr>

                                            <td class="align-middle text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $№++ }}</p>

                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->account_number }}
                                                </p>

                                            </td>

                                            <td class="align-middle text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->transaction_id }}
                                                </p>

                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->operation }}</p>

                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->comment }}</p>

                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-{{ $transaction->status == 'Success' ? 'success' : 'danger' }}">{{ $transaction->status }}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $transaction->currency }}</span>
                                            </td>

                                            <td class="align-middle text-center ">

                                                <p class="text-xs font-weight-bold mb-0  ">{{ $transaction->created_at }}
                                                </p>
                                                </a>
                                            </td>
                                            <td class="align-middle text-center">

                                                @if ($transaction->operation == 'Withdrawal' || str_contains($transaction->comment, 'Debited'))
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold text-danger">-{{ $transaction->amount }}</span>
                                                @else
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold text-success">+{{ $transaction->amount }}</span>
                                                @endif

                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $transaction->available_balance }}</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        {{-- {!! $transactions->links() !!} --}}
                    </div>
                </div>
            </div>
        </div>

    </div>



    @include('layouts.inc.plugins')
@endsection
