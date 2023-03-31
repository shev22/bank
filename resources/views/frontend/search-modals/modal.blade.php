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
        <div class="modal-footer">
         
        </div>
      </div>
    </div>
  </div>