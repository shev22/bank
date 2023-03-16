<div>
    
    <div class="container-fluid py-4">
        
        <div class="row">
            
            <div class="col-lg-8">
                
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    
                    <li class="nav-item" role="presentation" wire:ignore>
                        <button class="nav-link active " id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                            aria-selected="true"><span class="fw-bold">Deposit</span> </button>
                    </li>
                    <li class="nav-item" role="presentation" wire:ignore>
                        <button wire:click="resetInput()" class="nav-link" id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#profile-tab-pane" type="button" role="tab"
                            aria-controls="profile-tab-pane" aria-selected="false"><span
                                class="fw-bold">Withdraw</span></button>
                    </li>
                    <li class="nav-item" role="presentation" wire:ignore>
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                            data-bs-target="#contact-tab-pane" type="button" role="tab"
                            aria-controls="contact-tab-pane" aria-selected="false"><span
                                class="fw-bold">Transfer</span></button>
                    </li>
                    <li class="nav-item" role="presentation" wire:ignore>
                        <button class="nav-link" id="disabled-tab" data-bs-toggle="tab"
                            data-bs-target="#disabled-tab-pane" type="button" role="tab"
                            aria-controls="disabled-tab-pane" aria-selected="false"><span class="fw-bold">Currency
                                Conveter</span></button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

              
                    {{-- =========== DEPOSIT SECTION ========= --}}
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                        tabindex="0" wire:ignore.self>
                        <div class="row mt-3">
                            <div class="col-xl-6 mb-xl-0 mb-4 ">
                                <div class="card bg-transparent shadow-xl">
                                    <div class="overflow-hidden position-relative border-radius-xl">
                                        <img src="../assets/img/illustrations/pattern-tree.svg"
                                            class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-100"
                                            alt="pattern-tree">
                                        <span class="mask bg-gradient-dark opacity-10"></span>
                                        <div class="card-body position-relative z-index-1 p-3">
                                            <i class="material-icons text-white p-2">wifi</i>
                                            <h5 class="text-white mt-4 mb-5 pb-2">
                                                4562&nbsp;&nbsp;&nbsp;1122&nbsp;&nbsp;&nbsp;4594&nbsp;&nbsp;&nbsp;7852
                                            </h5>
                                            <div class="d-flex">
                                                <div class="d-flex">
                                                    <div class="me-4">
                                                        <p class="text-white text-sm opacity-8 mb-0">Card Holder</p>
                                                        <h6 class="text-white mb-0">{{ $this->accountName }}</h6>
                                                    </div>
                                                    <div>
                                                        <p class="text-white text-sm opacity-8 mb-0">Expires</p>
                                                        <h6 class="text-white mb-0">11/22</h6>
                                                    </div>
                                                </div>
                                                <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                                                    <img class="w-60 mt-2" src="../assets/img/logos/mastercard.png"
                                                        alt="logo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-md-6 col-6">
                                        <div class="card">
                                            <div class="card-header mx-4 p-3 text-center">

                                                <div
                                                    class="icon icon-shape icon-lg 
                                                            
                                                    @if ($this->currency == 'BYN') bg-gradient-dark shadow-dark 
                                                    @elseif($this->currency == 'USD')
                                                    bg-gradient-success shadow-success 
                                                    @elseif ($this->currency == 'EUR') 
                                                    bg-gradient-primary shadow-primary 
                                                    @elseif($this->currency == 'RUB')
                                                    bg-gradient-info shadow-info 
                                                    @elseif($this->currency == 'NGN')
                                                    bg-gradient-warning shadow-warning 
                                                    @elseif($this->currency == 'GBP')
                                                    bg-gradient-secondary shadow-secondary
                                                    @else
                                                    bg-gradient-primary shadow-primary @endif
                                                            shadow text-center border-radius-lg">
                                                    <i class="material-icons opacity-10">account_balance</i>
                                                </div>

                                            </div>
                                            <div class="card-body pt-0 p-3 text-center">
                                                @if ($this->currency)
                                                    <h6 class="text-center mb-0"> {{ $this->currency }}</h6>
                                                @else
                                                    <h6 class="text-center mb-0">Deposit</h6>
                                                @endif

                                                <span class="text-xs">Available Balance</span>
                                                <hr class="horizontal dark my-3">

                                                @if ($this->balance == 0)
                                                    <h5 class="mb-0">0.00</h5>
                                                @else
                                                    <h5 class="mb-0">{{ $this->symbol }} {{ $this->balance }}</h5>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <div class="card">
                                            <div class="card-header mx-4 p-3 text-center">
                                                <div
                                                    class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">

                                                    <i class="material-icons opacity-10">account_balance_wallet</i>
                                                </div>
                                            </div>

                                            <div class="card-body pt-0 p-3 text-center">


                                                <select class="form-select" size="4"
                                                    style="font-size: 13px; color:rgb(5, 5, 24);"
                                                    aria-label="size 4 select example" wire:model.defer="account_id"
                                                    wire:click="getSelectedAccount()">

                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}">
                                                            {{ $account->account_number }}
                                                            {{ $account->account_currency }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-xs">Secure Payment</span>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-lg-0 mb-4">
                                <div class="card mt-4">
                                    <form wire:submit.prevent="deposit">
                                        <div class="card-header pb-0 p-3">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center">
                                                    <h6 class="mb-0">Enter Deposit Amount</h6>
                                                </div>

                                                <div class="col-6 text-end">
                                                    <button type="submit" class="btn bg-gradient-dark mb-0"><i
                                                            class="material-icons text-sm">add</i>&nbsp;&nbsp;Deposit</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="col-md-12 mb-md-0 mb-4">
                                                <input type="text" class="form-control fw-bold px-3"
                                                    placeholder=" {{ $this->currency }} Deposit Amount"
                                                    wire:model.defer="amount">
                                                @error('amount')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    ` {{-- =========== DEPOSIT SECTION  END ========= --}}



                    {{-- =========== WITHDRAWAL SECTION ========= --}}


                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                        tabindex="0" wire:ignore.self>
                        <div class="row mt-3">
                            <div class="col-xl-6 mb-xl-0 mb-4 ">
                                <div class="card bg-transparent shadow-xl">
                                    <div class="overflow-hidden position-relative border-radius-xl">
                                        <img src="../assets/img/illustrations/pattern-tree.svg"
                                            class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-100"
                                            alt="pattern-tree">
                                        <span class="mask bg-gradient-dark opacity-10"></span>
                                        <div class="card-body position-relative z-index-1 p-3">
                                            <i class="material-icons text-white p-2">wifi</i>
                                            <h5 class="text-white mt-4 mb-5 pb-2">
                                                4562&nbsp;&nbsp;&nbsp;1122&nbsp;&nbsp;&nbsp;4594&nbsp;&nbsp;&nbsp;7852
                                            </h5>
                                            <div class="d-flex">
                                                <div class="d-flex">
                                                    <div class="me-4">
                                                        <p class="text-white text-sm opacity-8 mb-0">Card Holder</p>
                                                        <h6 class="text-white mb-0">{{ $this->accountName }}</h6>
                                                    </div>
                                                    <div>
                                                        <p class="text-white text-sm opacity-8 mb-0">Expires</p>
                                                        <h6 class="text-white mb-0">11/22</h6>
                                                    </div>
                                                </div>
                                                <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                                                    <img class="w-60 mt-2" src="../assets/img/logos/mastercard.png"
                                                        alt="logo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-md-6 col-6">
                                        <div class="card">
                                            <div class="card-header mx-4 p-3 text-center">

                                                <div
                                                    class="icon icon-shape icon-lg 
                                                            
                                                    @if ($this->symbol == 'BYN') bg-gradient-dark shadow-dark 
                                                    @elseif($this->symbol == '$')
                                                    bg-gradient-success shadow-success 
                                                    @elseif ($this->symbol == '€') 
                                                    bg-gradient-primary shadow-primary 
                                                    @elseif($this->symbol == '₽')
                                                    bg-gradient-info shadow-info 
                                                    @elseif($this->symbol == '₦')
                                                    bg-gradient-warning shadow-warning 
                                                    @elseif($this->symbol == '£')
                                                    bg-gradient-secondary shadow-secondary 
                                                    @else
                                                    bg-gradient-primary shadow-primary @endif
                                                            shadow text-center border-radius-lg">
                                                    <i class="material-icons opacity-10">account_balance</i>
                                                </div>

                                            </div>
                                            <div class="card-body pt-0 p-3 text-center">
                                                @if ($this->currency)
                                                    <h6 class="text-center mb-0"> {{ $this->currency }}</h6>
                                                @else
                                                    <h6 class="text-center mb-0">Withdraw</h6>
                                                @endif

                                                <span class="text-xs">Available Balance</span>
                                                <hr class="horizontal dark my-3">

                                                @if ($this->balance == 0)
                                                    <h5 class="mb-0">0.00</h5>
                                                @else
                                                    <h5 class="mb-0">{{ $this->symbol }} {{ $this->balance }}</h5>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <div class="card">
                                            <div class="card-header mx-4 p-3 text-center">
                                                <div
                                                    class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">

                                                    <i class="material-icons opacity-10">account_balance_wallet</i>
                                                </div>
                                            </div>

                                            <div class="card-body pt-0 p-3 text-center">


                                                <select class="form-select" size="4"
                                                    style="font-size: 13px; color:rgb(5, 5, 24);"
                                                    aria-label="size 4 select example" wire:model.defer="account_id"
                                                    wire:click="getSelectedAccount()">

                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}">
                                                            {{ $account->account_number }}
                                                            {{ $account->account_currency }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-xs">Secure Payment</span>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-lg-0 mb-4">
                                <div class="card mt-4">
                                    <form wire:submit.prevent="withdraw">
                                        <div class="card-header pb-0 p-3">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center">
                                                    <h6 class="mb-0">Enter Withdrawal Amount</h6>
                                                </div>

                                                <div class="col-6 text-end">
                                                    <button type="submit" class="btn bg-gradient-dark mb-0"> <i
                                                            class="material-icons text-sm">add</i>&nbsp;&nbsp;Withdraw</a></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="col-md-12 mb-md-0 mb-4">
                                                <input type="text" class="form-control fw-bold px-3"
                                                    placeholder="  {{ $this->currency }} Withdrawal Amount"
                                                    wire:model.defer="amount">
                                                @error('amount')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =========== WITHDRAWAL SECTION  END========= --}}




                    {{-- =========== TRANSFER SECTION ========= --}}

                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                        tabindex="0" wire:ignore.self>
                        <div class="row mt-4">
                            <div class="col-xl-3 mb-xl-0 mb-4 ">
                                <div class="card bg-transparent shadow-xl">
                                    <div class="overflow-hidden position-relative border-radius-xl">
                                        <img src="../assets/img/illustrations/pattern-tree.svg"
                                            class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-100"
                                            alt="pattern-tree">

                                        @switch($this->fromCurrency)
                                            @case('EUR')
                                                <span class="mask bg-gradient-primary opacity-10"></span>
                                            @break

                                            @case('NGN')
                                                <span class="mask bg-gradient-warning opacity-10"></span>
                                            @break

                                            @case('RUB')
                                                <span class="mask bg-gradient-info opacity-10"></span>
                                            @break

                                            @case('BYN')
                                                <span class="mask bg-gradient-dark opacity-10"></span>
                                            @break

                                            @case('GBP')
                                                <span class="mask bg-gradient-secondary opacity-10"></span>
                                            @break

                                            @case('USD')
                                                <span class="mask bg-gradient-success opacity-10"></span>
                                            @break

                                            @default
                                                <span class="mask bg-gradient-dark opacity-10"></span>
                                        @endswitch

                                        <div class="card-body position-relative z-index-1 p-3">
                                            <i class="material-icons text-white p-1 fs-6">wifi</i>
                                            <h6 class="material-icons text-white p-1 float-end fw-bold"
                                                style="font-size: 13px">{{ $this->fromCurrency }}</h6>
                                            <h6 class="text-white mt-2 mb-0 pb-2 " style="font-size: 13px">
                                                4562&nbsp;&nbsp;&nbsp;1122&nbsp;&nbsp;&nbsp;4594&nbsp;&nbsp;&nbsp;7852
                                            </h6>
                                            <div class="d-flex">
                                                <div class="d-flex">
                                                    <div class="me-4">
                                                        <p class="text-white  opacity-8 mb-0" style="font-size: 9px">
                                                            Card Holder</p>
                                                        <h6 class="text-white mb-0" style="font-size: 9px">
                                                            {{ $this->fromName }}</h6>
                                                    </div>
                                                    <div>
                                                        <p class="text-white  opacity-8 mb-0" style="font-size: 9px">
                                                            Expires</p>
                                                        <h6 class="text-white mb-0" style="font-size: 9px">11/22</h6>
                                                    </div>

                                                </div>
                                                <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                                                    <img class="w-60 mt-2" src="../assets/img/logos/mastercard.png"
                                                        alt="logo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="row ">
                                    <div class="col-md-6 col-6">
                                        <div class="card">
                                            <div class="card-header mx-4 p-3 text-center">
                                                <div
                                                    class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">

                                                    <i class="material-icons opacity-10">account_balance</i>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0 p-3 text-center">
                                                <h6 class="text-center mb-0">From Account</h6>


                                                <select wire:click="fromAccount()" wire:model.defer="fromAccount"
                                                    class="form-select" size="3"
                                                    aria-label="size 3 select example">
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->account_number }}">
                                                            {{ $account->account_number }}
                                                            {{ $account->accounType->account_currency }}
                                                        </option>
                                                    @endforeach
                                                </select>


                                                <input type="text" name=""
                                                    class="form-control fw-bold px-3" placeholder="Enter Account"
                                                    wire:model="fromAccount">


                                                <h5 class="mb-0" style="font-size: 17px">{{ $this->fromSymbol }}
                                                    {{ $this->fromBalance }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <div class="card">
                                            <div class="card-header mx-4 p-3 text-center">
                                                <div
                                                    class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                    <i class="material-icons opacity-10">account_balance_wallet</i>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0 p-3 text-center">
                                                <h6 class="text-center mb-0">To Account</h6>


                                                <select wire:click="toAccount()" wire:model.defer="toAccount"
                                                    class="form-select" size="3"
                                                    aria-label="size 3 select example">
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->account_number }}">
                                                            {{ $account->account_number }}
                                                            {{ $account->accounType->account_currency }}
                                                        </option>
                                                    @endforeach
                                                </select>


                                                <input type="text" name=""
                                                    class="form-control fw-bold px-3" placeholder="Enter Account"
                                                    wire:model="toAccount">
                                                <h5 class="mb-0" style="font-size: 17px">{{ $this->toSymbol }}
                                                    {{ $this->toBalance }}</h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 mb-xl-0 mb-4 ">
                                <div class="card bg-transparent shadow-xl">
                                    <div class="overflow-hidden position-relative border-radius-xl">
                                        <img src="../assets/img/illustrations/pattern-tree.svg"
                                            class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-100"
                                            alt="pattern-tree">

                                        @switch($this->toCurrency)
                                            @case('EUR')
                                                <span class="mask bg-gradient-primary opacity-10"></span>
                                            @break

                                            @case('NGN')
                                                <span class="mask bg-gradient-warning opacity-10"></span>
                                            @break

                                            @case('RUB')
                                                <span class="mask bg-gradient-info opacity-10"></span>
                                            @break

                                            @case('BYN')
                                                <span class="mask bg-gradient-dark opacity-10"></span>
                                            @break

                                            @case('GBP')
                                                <span class="mask bg-gradient-secondary opacity-10"></span>
                                            @break

                                            @case('USD')
                                                <span class="mask bg-gradient-success opacity-10"></span>
                                            @break

                                            @default
                                                <span class="mask bg-gradient-dark opacity-10"></span>
                                        @endswitch

                                        <div class="card-body position-relative z-index-1 p-3">
                                            <i class="material-icons text-white p-1 fs-6">wifi</i>
                                            <h6 class="material-icons text-white p-1 float-end fw-bold"
                                                style="font-size: 13px">{{ $this->toCurrency }}</h6>
                                            <h6 class="text-white mt-2 mb-0 pb-2 " style="font-size: 13px">
                                                4562&nbsp;&nbsp;&nbsp;1122&nbsp;&nbsp;&nbsp;4594&nbsp;&nbsp;&nbsp;7852
                                            </h6>
                                            <div class="d-flex">
                                                <div class="d-flex">
                                                    <div class="me-4">
                                                        <p class="text-white  opacity-8 mb-0" style="font-size: 9px">
                                                            Card Holder</p>
                                                        <h6 class="text-white mb-0" style="font-size: 9px">
                                                            {{ $this->toName }}</h6>
                                                    </div>
                                                    <div>
                                                        <p class="text-white  opacity-8 mb-0" style="font-size: 9px">
                                                            Expires</p>
                                                        <h6 class="text-white mb-0" style="font-size: 9px">11/22</h6>
                                                    </div>

                                                </div>
                                                <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                                                    <img class="w-60 mt-2" src="../assets/img/logos/mastercard.png"
                                                        alt="logo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-lg-0 mb-4">
                                <div class="card mt-4">
                                    <form wire:submit.prevent="transfer">
                                        <div class="card-header pb-0 p-3">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center">
                                                    <h6 class="mb-0">Enter Transfer Amount</h6>
                                                </div>

                                                <div class="col-6 text-end">
                                                    <button type="submit" class="btn bg-gradient-dark mb-0"> <i
                                                            class="material-icons text-sm">add</i>&nbsp;&nbsp;Transfer</a></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="col-md-12 mb-md-0 mb-4">
                                                <input type="text" class="form-control fw-bold px-3"
                                                    placeholder="  {{ $this->currency }} Transfer  Amount"
                                                    wire:model.defer="amount">
                                                @error('amount')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- =========== TRANSFER SECTION END========= --}}



                    {{-- =========== CONVERTER SECTION ========= --}}


                    <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                        tabindex="0" wire:ignore.self>
                        <div class="row mt-4">
                            <div class="col-xl-3 mb-xl-0 mb-4 ">
                                <div class="card bg-transparent shadow-xl">
                                    <div class="overflow-hidden position-relative border-radius-xl">
                                        <img src="../assets/img/illustrations/pattern-tree.svg"
                                            class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-100"
                                            alt="pattern-tree">

                                        @switch($this->fromCurrency)
                                            @case('EUR')
                                                <span class="mask bg-gradient-primary opacity-10"></span>
                                            @break

                                            @case('NGN')
                                                <span class="mask bg-gradient-warning opacity-10"></span>
                                            @break

                                            @case('RUB')
                                                <span class="mask bg-gradient-info opacity-10"></span>
                                            @break

                                            @case('BYN')
                                                <span class="mask bg-gradient-dark opacity-10"></span>
                                            @break

                                            @case('GBP')
                                                <span class="mask bg-gradient-secondary opacity-10"></span>
                                            @break

                                            @case('USD')
                                                <span class="mask bg-gradient-success opacity-10"></span>
                                            @break

                                            @default
                                                <span class="mask bg-gradient-dark opacity-10"></span>
                                        @endswitch

                                        <div class="card-body position-relative z-index-1 p-3">
                                            <i class="material-icons text-white p-1 fs-6">wifi</i>
                                            <h6 class="material-icons text-white p-1 float-end fw-bold"
                                                style="font-size: 13px">{{ $this->fromCurrency }}</h6>
                                            <h6 class="text-white mt-2 mb-0 pb-2 " style="font-size: 13px">
                                                4562&nbsp;&nbsp;&nbsp;1122&nbsp;&nbsp;&nbsp;4594&nbsp;&nbsp;&nbsp;7852
                                            </h6>
                                            <div class="d-flex">
                                                <div class="d-flex">
                                                    <div class="me-4">
                                                        <p class="text-white  opacity-8 mb-0" style="font-size: 9px">
                                                            Card Holder</p>
                                                        <h6 class="text-white mb-0" style="font-size: 9px">
                                                            {{ $this->fromName }}</h6>
                                                    </div>
                                                    <div>
                                                        <p class="text-white  opacity-8 mb-0" style="font-size: 9px">
                                                            Expires</p>
                                                        <h6 class="text-white mb-0" style="font-size: 9px">11/22</h6>
                                                    </div>

                                                </div>
                                                <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                                                    <img class="w-60 mt-2" src="../assets/img/logos/mastercard.png"
                                                        alt="logo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="row ">
                                    <div class="col-md-6 col-6">
                                        <div class="card">
                                            <div class="card-header mx-4 p-3 text-center">

                                                <div
                                                    class="icon icon-shape icon-lg 
                                                            
                                                   
                                                    bg-gradient-primary shadow-primary 
                                                    
                                                            shadow text-center border-radius-lg">
                                                    <i class="material-icons opacity-10">account_balance</i>
                                                </div>










                                            </div>
                                            <div class="card-body pt-0 p-3 text-center">
                                                <h6 class="text-center mb-0">{{ $this->fromCurrency }}</h6>


                                                <select wire:click="fromAccount()" wire:model.defer="fromAccount"
                                                    class="form-select" size="3"
                                                    aria-label="size 3 select example">
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->account_number }}">
                                                            {{ $account->account_number }}
                                                            {{ $account->accounType->account_currency }}
                                                        </option>
                                                    @endforeach
                                                </select>


                                                <input type="text" name=""
                                                    class="form-control fw-bold px-3" placeholder="Enter Account"
                                                    wire:model="fromAccount">



                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <div class="card">
                                            <div class="card-header mx-4 p-3 text-center">
                                                <div
                                                    class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                    <i class="material-icons opacity-10">account_balance_wallet</i>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0 p-3 text-center">
                                                <h6 class="text-center mb-0">{{ $this->toCurrency }}</h6>


                                                <select wire:click="toAccount()" wire:model.defer="toAccount"
                                                    class="form-select" size="3"
                                                    aria-label="size 3 select example">
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->account_number }}">
                                                            {{ $account->account_number }}
                                                            {{ $account->accounType->account_currency }}
                                                        </option>
                                                    @endforeach
                                                </select>


                                                <input type="text" class="form-control fw-bold px-3"
                                                    placeholder="Enter Account" wire:model="toAccount">


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 mb-xl-0 mb-4 ">
                                <div class="card bg-transparent shadow-xl">
                                    <div class="overflow-hidden position-relative border-radius-xl">
                                        <img src="../assets/img/illustrations/pattern-tree.svg"
                                            class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-100"
                                            alt="pattern-tree">

                                        @switch($this->toCurrency)
                                            @case('EUR')
                                                <span class="mask bg-gradient-primary opacity-10"></span>
                                            @break

                                            @case('NGN')
                                                <span class="mask bg-gradient-warning opacity-10"></span>
                                            @break

                                            @case('RUB')
                                                <span class="mask bg-gradient-info opacity-10"></span>
                                            @break

                                            @case('BYN')
                                                <span class="mask bg-gradient-dark opacity-10"></span>
                                            @break

                                            @case('GBP')
                                                <span class="mask bg-gradient-secondary opacity-10"></span>
                                            @break

                                            @case('USD')
                                                <span class="mask bg-gradient-success opacity-10"></span>
                                            @break

                                            @default
                                                <span class="mask bg-gradient-dark opacity-10"></span>
                                        @endswitch

                                        <div class="card-body position-relative z-index-1 p-3">
                                            <i class="material-icons text-white p-1 fs-6">wifi</i>
                                            <h6 class="material-icons text-white p-1 float-end fw-bold"
                                                style="font-size: 13px">{{ $this->toCurrency }}</h6>
                                            <h6 class="text-white mt-2 mb-0 pb-2 " style="font-size: 13px">
                                                4562&nbsp;&nbsp;&nbsp;1122&nbsp;&nbsp;&nbsp;4594&nbsp;&nbsp;&nbsp;7852
                                            </h6>
                                            <div class="d-flex">
                                                <div class="d-flex">
                                                    <div class="me-4">
                                                        <p class="text-white  opacity-8 mb-0" style="font-size: 9px">
                                                            Card Holder</p>
                                                        <h6 class="text-white mb-0" style="font-size: 9px">
                                                            {{ $this->toName }}</h6>
                                                    </div>
                                                    <div>
                                                        <p class="text-white  opacity-8 mb-0" style="font-size: 9px">
                                                            Expires</p>
                                                        <h6 class="text-white mb-0" style="font-size: 9px">11/22</h6>
                                                    </div>

                                                </div>
                                                <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                                                    <img class="w-60 mt-2" src="../assets/img/logos/mastercard.png"
                                                        alt="logo">
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            @if ($this->result)
                                &nbsp; &nbsp;<h5>{{ $this->toSymbol }}{{ $this->result }}</h5>
                            @endif

                            <div class="col-md-12 mb-lg-0 mb-4">
                                <div class="card mt-4">
                                    <form wire:submit.prevent="exchange">
                                        <div class="card-header pb-0 p-3">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center">
                                                    <h6 class="mb-0">Enter Exchange Amount </h6>
                                                </div>


                                                <div class="col-6 text-end">
                                                    <div wire:loading wire:target="exchange" wire:key="exchange"><i
                                                            class="fa fa-spinner fa-spin  ml-2"
                                                            style="color: #A10000;  font-size: 19px;"></i> </div>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <button type="submit" class="btn bg-gradient-dark mb-0">

                                                        <i
                                                            class="material-icons text-sm">add</i>&nbsp;&nbsp;Exchange</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="col-md-12 mb-md-0 mb-4">
                                                <input type="text" class="form-control fw-bold px-3"
                                                    placeholder="  {{ $this->fromCurrency }} Exchange Amount"
                                                    wire:model.defer="amount">
                                                @error('amount')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- =========== CONVERTER SECTION END========= --}}
                </div>
            </div>



            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h6 class="mb-0">Exchange rates</h6>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn btn-outline-primary btn-sm mb-0">View All</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3 pb-0">
                        <ul class="list-group">
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">March, 01, 2020</h6>
                                    <span class="text-xs">#MS-415646</span>
                                </div>
                                <div class="d-flex align-items-center text-sm">
                                    $180
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                            class="material-icons text-lg position-relative me-1">picture_as_pdf</i>
                                        PDF</button>
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="text-dark mb-1 font-weight-bold text-sm">February, 10, 2021</h6>
                                    <span class="text-xs">#RV-126749</span>
                                </div>
                                <div class="d-flex align-items-center text-sm">
                                    $250
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                            class="material-icons text-lg position-relative me-1">picture_as_pdf</i>
                                        PDF</button>
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="text-dark mb-1 font-weight-bold text-sm">April, 05, 2020</h6>
                                    <span class="text-xs">#FB-212562</span>
                                </div>
                                <div class="d-flex align-items-center text-sm">
                                    $560
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                            class="material-icons text-lg position-relative me-1">picture_as_pdf</i>
                                        PDF</button>
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="text-dark mb-1 font-weight-bold text-sm">June, 25, 2019</h6>
                                    <span class="text-xs">#QW-103578</span>
                                </div>
                                <div class="d-flex align-items-center text-sm">
                                    $120
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                            class="material-icons text-lg position-relative me-1">picture_as_pdf</i>
                                        PDF</button>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="text-dark mb-1 font-weight-bold text-sm">March, 01, 2019</h6>
                                    <span class="text-xs">#AR-803481</span>
                                </div>
                                <div class="d-flex align-items-center text-sm">
                                    $300
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                            class="material-icons text-lg position-relative me-1">picture_as_pdf</i>
                                        PDF</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 mt-4">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-0">Billing Information</h6>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-sm">Oliver Liam</h6>
                                    <span class="mb-2 text-xs">Company Name: <span
                                            class="text-dark font-weight-bold ms-sm-2">Viking Burrito</span></span>
                                    <span class="mb-2 text-xs">Email Address: <span
                                            class="text-dark ms-sm-2 font-weight-bold">oliver@burrito.com</span></span>
                                    <span class="text-xs">VAT Number: <span
                                            class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
                                </div>
                                <div class="ms-auto text-end">
                                    <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                                            class="material-icons text-sm me-2">delete</i>Delete</a>
                                    <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                            class="material-icons text-sm me-2">edit</i>Edit</a>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-sm">Lucas Harper</h6>
                                    <span class="mb-2 text-xs">Company Name: <span
                                            class="text-dark font-weight-bold ms-sm-2">Stone Tech Zone</span></span>
                                    <span class="mb-2 text-xs">Email Address: <span
                                            class="text-dark ms-sm-2 font-weight-bold">lucas@stone-tech.com</span></span>
                                    <span class="text-xs">VAT Number: <span
                                            class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
                                </div>
                                <div class="ms-auto text-end">
                                    <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                                            class="material-icons text-sm me-2">delete</i>Delete</a>
                                    <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                            class="material-icons text-sm me-2">edit</i>Edit</a>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-sm">Ethan James</h6>
                                    <span class="mb-2 text-xs">Company Name: <span
                                            class="text-dark font-weight-bold ms-sm-2">Fiber Notion</span></span>
                                    <span class="mb-2 text-xs">Email Address: <span
                                            class="text-dark ms-sm-2 font-weight-bold">ethan@fiber.com</span></span>
                                    <span class="text-xs">VAT Number: <span
                                            class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
                                </div>
                                <div class="ms-auto text-end">
                                    <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                                            class="material-icons text-sm me-2">delete</i>Delete</a>
                                    <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                            class="material-icons text-sm me-2">edit</i>Edit</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-5 mt-4">
                <div class="card h-100 mb-4">
                    <div class="card-header pb-0 px-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-0">Your Transaction's</h6>
                            </div>
                            <div
                                class="col-md-6 d-flex justify-content-start justify-content-md-end align-items-center">
                                <i class="material-icons me-2 text-lg">date_range</i>
                                <small>23 - 30 March 2020</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6>
                        <ul class="list-group">
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <button
                                        class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                                            class="material-icons text-lg">expand_more</i></button>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Netflix</h6>
                                        <span class="text-xs">27 March 2020, at 12:30 PM</span>
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                                    - $ 2,500
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <button
                                        class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                                            class="material-icons text-lg">expand_less</i></button>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Apple</h6>
                                        <span class="text-xs">27 March 2020, at 04:30 AM</span>
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                    + $ 2,000
                                </div>
                            </li>
                        </ul>
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Yesterday</h6>
                        <ul class="list-group">
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <button
                                        class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                                            class="material-icons text-lg">expand_less</i></button>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Stripe</h6>
                                        <span class="text-xs">26 March 2020, at 13:45 PM</span>
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                    + $ 750
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <button
                                        class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                                            class="material-icons text-lg">expand_less</i></button>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">HubSpot</h6>
                                        <span class="text-xs">26 March 2020, at 12:30 PM</span>
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                    + $ 1,000
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <button
                                        class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                                            class="material-icons text-lg">expand_less</i></button>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Creative Tim</h6>
                                        <span class="text-xs">26 March 2020, at 08:30 AM</span>
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                    + $ 2,500
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <button
                                        class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                                            class="material-icons text-lg">priority_high</i></button>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Webflow</h6>
                                        <span class="text-xs">26 March 2020, at 05:00 AM</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    Pending
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.inc.footer')
    </div>


</div>
