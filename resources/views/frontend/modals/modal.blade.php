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
                        <input type="text" name="account_name" class="form-control" placeholder="Account Name">
                    </div>
                    <label for="currency">Currency</label>
                    <select class="form-select " size="10" name="account_currency[]"
                        aria-label="size 3 select example" multiple>
                   
                        @foreach ($accounts_types as $accounts_type)  
     
                            <option value="{{ $accounts_type['id'] }}" >
                                &nbsp;&nbsp;{{ $accounts_type['account_symbol'] }} &nbsp;&nbsp; {{ $accounts_type['account_description'] }}</option>
                                {{-- <input type="hidden" name = "account_currency" value="{{ $accounts_type['account_currency'] }}"> --}}
                        @endforeach
                    </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Create</button>
            </div>
            </form>
        </div>
    </div>
</div>



 <!-- Modal accounts details-->
 <div class="modal fade modal_class"  data-bs-backdrop="static" id="staticBackdropAccounts" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body ">
        
              <li class=" border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                <div class="d-flex flex-column">
                    <h6 class="mb-3 text-sm"></h6>
                    <span class="mb-2 text-xs">Account Name: <span
                            class="text-dark font-weight-bold ms-sm-2" id="name"></span></span>
                    <span class="mb-2 text-xs">Account Number: <span
                            class="text-dark ms-sm-2 font-weight-bold" id="number"></span></span>
                    <span class="mb-2 text-xs">Account Balance: <span
                            class="mb-2 text-dark ms-sm-2 font-weight-bold" id="balance"></span></span>
                    <span class="text-xs">Creation Date: <span
                              class="text-dark ms-sm-2 font-weight-bold" id="created_at" ></span></span>
                </div>


                <div class="ms-auto text-end">
                  <form role="form" class="text-start" method="Post" action="{{ url('delete-account') }}">
                    @csrf
                  <input type="hidden" id="account_id" name="id">
                    <button class="btn btn-link text-danger text-gradient px-3 mb-0 delete-account" type="submit" onclick="return confirm('Are you sure you wanty to delete')"><i
                            class="material-icons text-sm me-2">delete</i>Delete</button>
                  </form>
                  <button type="submit" class="btn btn-link text-dark px-3 mb-0" id="statement"> Statement</button>
                        <div class="col-md-12 float_end " style="display:none" id="statementDiv">
                            <input type="date" class="form-control fw-bold px-3 p-0 " >
                            <input type="date" class="form-control fw-bold px-3 p-0" >
                            <button class = "btn btn-success btn-sm p-1 mx-3" >Request</button>
                           
                        </div>
           

                </div>
            </li>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    
        </div>
      </div>
    </div>
  </div>


  {{-- delete user  --}}
  
  <div class="modal fade" id="delete-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="delete" method="POST">
            @csrf
           <p class="fw-bold"> Are you sure you want to Delete ?</p>
            <div class="modal-footer ">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="subit" class="btn btn-primary" name="id" id="id" >Delete</button>
            </div>
          </form>
      
        </div>
      
      </div>
    </div>
  </div>



  {{-- Edit user --}}

  <div class="modal fade" id="edit-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Update User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form role="form"  method="post" action="update">
            @csrf
            <div class="input-group input-group-outline mb-3">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" >
       
            </div>
            <div class="input-group input-group-outline mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="input-group input-group-outline mb-3">
              <label class="form-label">Phone</label>
              <input type="phone" class="form-control" id="phone" name="phone">
            </div>
            <div class="input-group input-group-outline mb-3">
              <label class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address">
            </div>
          
            <input type="hidden" name="edit_id" id="edit_id">
            <div class="modal-footer ">
            <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary " >Update</button>
          </div>
          
          </form>
      
        </div>
      
      </div>
    </div>
  </div>



    {{-- add currency --}}

    <div class="modal fade" id="add-currency" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add Currency</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form role="form"  method="post" action="currency">
                @csrf
           
              <div class="input-group input-group-outline mb-3">
                <label for="id_label_multiple">
                  Select Currencies
              <select class="form-select multiple-select "  name="code[]"  multiple="multiple" style="width: 20rem">
         
          @foreach($currencies as $key => $value)
    
          <option value="{{ $key }},{{ $value['symbol'] }},{{$value['name']  }}"> &nbsp; &nbsp;{{ $value['name']  }}</option>

          @endforeach 
              </select>  
            </div>
              <div class="text-center">
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>            
                </div>
            </form>



          </div>
         
        </div>
      </div>
    </div>




    <!-- edit currency modal -->

  
 <!-- Modal -->

  <div class="modal fade" id="edit-currency" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">Edit Currency</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form role="form"  method="post" action="actions">
                @csrf
                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Name</label>
                  <input type="text" class="form-control"  name="name" >
           
                </div>
                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Symbol</label>
                  <input type="TEXT" class="form-control"  name="symbol">
                </div>
                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Code</label>
                  <input type="phone" class="form-control" name="code">
                </div>
                
              
                <input type="hidden" name="id" id="currency_id">
                <div class="modal-footer ">
                <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary " >Update</button>
              </div>
              
              </form>
        </div>
      
      </div>
    </div>
  </div>
   

    {{-- delete currency  --}}
  
    <div class="modal fade" id="delete-currency" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete User</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="actions" method="POST">
                @csrf
               <p class="fw-bold"> Are you sure you want to Delete ?</p>
               <input type="hidden" name="id" id="delete_currency_id">
                <div class="modal-footer ">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="subit" class="btn btn-primary"  >Delete</button>
                </div>
              </form>
          
            </div>
          
          </div>
        </div>
      </div>