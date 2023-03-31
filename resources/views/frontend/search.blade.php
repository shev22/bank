@section('content')
    @extends('layouts.app')
    @include('frontend.search-modals.modal')
    @include('layouts.inc.navbar')


    <div class="container-fluid py-4" style="height: 100vh">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Search

                                <div class="ms-md-auto pe-md-3 d-flex align-items-center float-end">

                                </div>

                            </h6>
                        </div>
                    </div>


                    <div class="col-md-9 mt-4 mx-auto mb-5">
                        <div class="card">
                            <div class="card-header pb-0 px-3">
                                <h6 class="mb-0">{{ strtoupper($searchTitle) }} </h6>
                            </div>
                            <div class="card-body pt-4 p-3">
                                <ul class="list-group">
                                    @foreach ($search as $key => $value)
                                        @foreach ($value as $searchItem)
                                            @if ($searchItem->name)
                                                <li
                                                    class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                    <div class="d-flex flex-column">

                                                        <h6 class="mb-3 text-sm">
                                                            {{ ucwords(strtolower($searchItem->name)) }}</h6>
                                                        <span class="mb-2 text-xs">Accounts: <span
                                                                class="text-dark font-weight-bold ms-sm-2">[


                                                                @foreach ($search['accounts'] as $account)
                                                                    @if ($account->user_id == $searchItem->id)
                                                                        {{ $account->accounType->account_symbol }}
                                                                        @if (!$loop->last)
                                                                            ,
                                                                        @endif
                                                                    @endif
                                                                @endforeach

                                                                ]
                                                            </span></span>
                                                        <span class="mb-2 text-xs">Email Address : <span
                                                                class="text-dark ms-sm-2 font-weight-bold">{{ $searchItem->email }}</span></span>


                                                        <span class="mb-2 text-xs">Phone number : <span
                                                                class="text-dark ms-sm-2 font-weight-bold">{{ $searchItem->phone }}</span></span>

                                                        <span class="mb-2  text-xs">Registered : <span
                                                                class="text-dark ms-sm-2 font-weight-bold">
                                                                {{ Carbon\Carbon::parse($searchItem->created_at)->diffForHumans() }}
                                                            </span></span>
                                                        <span class="mb-2  text-xs">Balance: <span
                                                                class="mb-2 text-dark ms-sm-2 font-weight-bold">
                                                                @php
                                                                    $balance = 0;
                                                                @endphp
                                                                @foreach ($search['accounts'] as $account)
                                                                    @if ($account->user_id == $searchItem->id)
                                                                        @php $balance += $account->account_balance      @endphp
                                                                    @endif
                                                                @endforeach
                                                                ${{ number_format($balance) }}

                                                            </span></span>
                                                        <span class="mb-2 text-xs">Address : <span
                                                                class="mb-2 text-dark ms-sm-2 font-weight-bold">{{ $searchItem->address }}
                                                            </span></span>


                                                    </div>

                                                    @if (Auth::user()->isAdmin == 1)
                                                        <div class="ms-auto text-end">

                                                            <a class="btn btn-link text-danger text-gradient px-3 mb-0 edit-user"
                                                                id="{{ $searchItem->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#delete-user"><i
                                                                    class="material-icons text-sm me-2">delete</i>Delete</a>
                                                            <a class="btn btn-link text-dark px-3 mb-0 edit-user"
                                                                id="{{ $searchItem->id }}" href="javascript:;"
                                                                data-bs-toggle="modal" data-bs-target="#edit-user">


                                                                <i class="material-icons text-sm me-2">edit</i>
                                                                Edit</a>
                                                        </div>
                                                    @endif
                                                </li>
                                            @endif


                                            @if ($searchItem->transaction_id)
                                                <li
                                                    class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-3 text-sm">
                                                            {{ ucwords(strtolower($searchItem->name)) }}</h6>
                                                        <span class="mb-2 text-xs">Account Number : <span
                                                                class="text-dark font-weight-bold ms-sm-2">{{ $searchItem->account_number }}</span></span>
                                                        <span class="mb-2 text-xs">Transaction ID: <span
                                                                class="text-dark ms-sm-2 font-weight-bold">{{ $searchItem->transaction_id }}</span></span>

                                                        <span class="mb-2  text-xs">operation : <span
                                                                class="text-dark ms-sm-2 font-weight-bold">
                                                                {{ $searchItem->operation }} </span></span>
                                                        <span class="mb-2  text-xs">Currency: <span
                                                                class="mb-2 text-dark ms-sm-2 font-weight-bold">{{ $searchItem->currency }}
                                                            </span></span>
                                                        <span class="mb-2 text-xs">Status : <span
                                                                class="mb-2 text-{{ $searchItem->status == 'Success' ? 'success' : 'danger' }} ms-sm-2 font-weight-bold">
                                                                {{ $searchItem->status }} </span></span>
                                                        <span class="mb-2 text-xs">Amount : <span
                                                                class="mb-2 text-dark ms-sm-2 font-weight-bold">
                                                                ${{ $searchItem->amount }} </span></span>
                                                        <span class="mb-2 text-xs">Account Balance: <span
                                                                class="mb-2 text-dark ms-sm-2 font-weight-bold">
                                                                ${{ $searchItem->available_balance }} </span></span>
                                                        <span class="mb-2 text-xs">Transaction Time : <span
                                                                class="mb-2 text-dark ms-sm-2 font-weight-bold">
                                                                {{ $searchItem->created_at }} </span></span>
                                                        <span class="mb-2 text-xs">Description : <span
                                                                class="mb-2  ms-sm-2 font-weight-bold fst-italic">
                                                                {{ $searchItem->description }} </span></span>
                                                    </div>
                                                    <div class="ms-auto text-end">
                                                        <a class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                            href="javascript:;"><i
                                                                class="material-icons text-sm me-2">delete</i>Delete</a>
                                                        <a class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                            href="javascript:;"><i
                                                                class="material-icons text-sm me-2">delete</i>Delete</a>

                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    @if (!$searchTitle)
                                        <div class="mx-auto">
                                            <h6 class="mb-3">No Results </h6>
                                        </div>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    @include('layouts.inc.plugins')
@endsection
