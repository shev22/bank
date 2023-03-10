{{-- create an account --}}

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form role="form" class="text-start" method="Post" action="{{ url('create-account') }}">
                    @csrf
                    <div class="input-group input-group-outline my-3">

                        <input type="text" name="account_name"
                            class="form-control" placeholder="Account Name">
                        
                    </div>
                    {{-- <select class="form-control" name="account_currency" aria-label="size 3 select example">
            <option value="" >Currency</option>
           @foreach ($accounts as $account)     
            <option  value="{{ $account['id']}}" >{{ $account['account_currency'] }}</option>
            @endforeach  
          </select> --}}

                    <label for="currency">Currency</label>
                    <select class="form-select @error('currency') is-invalid @enderror" size="5" name="account_currency"
                        aria-label="size 3 select example">
                        @foreach ($accounts_types as $accounts_type)
                        {{-- <input type="hidden" name="account_currency_id" value="{{ $accounts_type['id'] }}"> --}}
                            <option value="{{ $accounts_type['account_currency'] }}">{{ $accounts_type['account_description'] }}</option>
                         
                        @endforeach
                    </select>

                  
                  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
            </form>
        </div>
    </div>
</div>
