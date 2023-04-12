



<!-- Create group chat  -->

<div class="modal fade" id="group-chat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore>
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Group chat title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="input-group input-group-outline mb-3">
          <label class="form-label">Group title</label>
          <input type="TEXT" class="form-control"   wire:model="groupName">
        </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-secondary" wire:click="createGroupChat()">Create</button>
            </div>            
            </div>
  
      </div>
    </div>
  </div>
</div>
