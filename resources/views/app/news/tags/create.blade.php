<div class="modal fade" tabindex="-1" role="dialog" id="modal-form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('news.tags.store') }}" id="form-action" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-title">Create New News Tag</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @include('app.news.tags.partials.form')
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" id="btn" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
