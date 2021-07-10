<div class="modal fade" tabindex="-1" role="dialog" id="modal-form">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="form-action" enctype="multipart/form-data">
        @isset($update)
            {{ method_field('PUT') }}
        @endisset
          <div class="modal-header">
            <h5 class="modal-title" id="modal-title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group row">
                <label for="name" class="col-form-label col-md-3">Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control form-control-sm" id="name" name="name" />
                  <small class="invalid-feedback name_err"></small>
                </div>
              </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" id="form-btn" class="btn btn-primary"></button>
          </div>
        </form>
      </div>
    </div>
</div>