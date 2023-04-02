@section('content')
    @extends('layouts.app')
    @include('frontend.modals.modal')
    @include('layouts.inc.navbar')

    <div class="container-fluid py-4" style="height: 100vh">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Admin Panel
                              
                            </h6>
                        </div>
                        <hr class="horizontal dark my-2">
                    </div>



                    <nav>
                        <div class="nav nav-tabs px-3" id="nav-tab" role="tablist">
                            <button class="nav-link active fw-bold" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true" wire:ignore>Users</button>
                            <button class="nav-link fw-bold" id="nav-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                                aria-selected="false" wire:ignore>Currencies</button>
                            <button class="nav-link fw-bold" id="nav-contact-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                                aria-selected="false">Contact</button>
                            <button class="nav-link fw-bold" id="nav-disabled-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled"
                                aria-selected="false" disabled>Disabled</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent" wire:ignore>
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                            tabindex="0">

                            <div class="card-body px-0 pb-2 py-3 ">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                                    №</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ">
                                                    Name</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ">
                                                    Address</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2 ">
                                                    Phone Number</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                                    Accounts</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                                    Balance</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                                    Role</th>



                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                                $№ = 1;
                                            @endphp
                                            @foreach ($users as $user)
                                                <tr>

                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $№++ }}</p>

                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $user->name }}
                                                        </p>

                                                    </td>

                                                    <td class="">
                                                        <p class="text-xs font-weight-bold mb-0 ">{{ $user->address }}
                                                        </p>

                                                    </td>
                                                    <td class="ml-5">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $user->phone }}</p>

                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0">[USD, BYN, EUR]</p>

                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        $1000
                                                    </td>

                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0">

                                                        <form method="post" action="role">
                                                            @csrf
                                                            @if ($user->isAdmin == 1)
                                                                <button class="btn btn-outline-secondary btn-sm"
                                                                    name="id"
                                                                    value="{{ $user->id }}">Admin</button>
                                                            @else
                                                                <button class="btn btn-outline-primary btn-sm"
                                                                    name="id" value="{{ $user->id }}">User</button>
                                                            @endif
                                                            <button data-bs-toggle="modal" data-bs-target="#edit-user"
                                                                class="btn btn-outline-info btn-sm edit-user"
                                                                id="{{ $user->id }}">Edit</button>
                                                        </form>


                                                    </td>


                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                {!! $users->links() !!}
                            </div>

                        </div>


                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                            tabindex="0"  wire:ignore>
                        

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mx-4">
                                                Available Currencies
                                                <a href="#" class="btn btn-primary btn-sm text-white float-end mx-3" data-bs-toggle="modal" data-bs-target="#add-currency">
                                                    Add Currency</a>
                                            </h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="card-body p-0">
                                                <table class="table table-bordered table-striped p-0">
                                                    <thead>
                                                        <tr>
                                                            <th  class="text-center text-xs">№</th>
                                                            <th  class=" text-xs">Name</th>
                                                            <th  class="text-center text-xs">Code</th>
                                                            <th  class="text-center text-xs">Symbol</th>
                                                            <th  class="text-center text-xs">Operations</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                          $№ = 1;
                                                          @endphp
                                                       
                                                            @csrf
                                                        @foreach ($accounts_types as $accounts_type)
                                                        <input type="hidden" value="{{ $accounts_type['id'] }}" name="id">
                                                        <tr>
                                                            <td>  <p class="text-xs font-weight-bold mt-3 text-center" >{{  $№++ }}</p></td>
                                                            <td> <p class="text-xs font-weight-bold mt-3 ">{{ $accounts_type['account_description'] }}</p></td>
                                                            <td> <p class="text-xs font-weight-bold mt-3 text-center" >{{ $accounts_type['account_symbol'] }} </p></td>
                                                            <td> <p class="text-xs font-weight-bold mt-3 text-center">{{ $accounts_type['account_currency'] }} </p></td>
                                                           
                                                            <td  class="text-center mt-1">
                                                               
                                                                <a href="{{url('operations/'. $accounts_type['id'])}}"  class="btn btn-outline-dark btn-sm" name="edit" value="edit">Edit</a>
                                                                <a href="{{url('operations/'. $accounts_type['id'])}}" onclick="return confirm('Are you sure you wanty to delete')" class="btn btn-outline-danger btn-sm" name="delete" value="delete">Delete</a>
                                                              
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

                  
                        
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"
                            tabindex="0">...</div>
                        <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab"
                            tabindex="0">...</div>
                    </div>

                </div>
            </div>
        </div>

    </div>



    @include('layouts.inc.plugins')
@endsection
