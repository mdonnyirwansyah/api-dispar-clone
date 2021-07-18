<div class="form-group row">
  <label for="name" class="col-form-label col-md-3">Name</label>
  <div class="col-md-9">
    <input type="text" class="form-control form-control-sm" id="name" name="name" @isset($newsCategory) value="{{ $newsCategory->name }}" @endisset />
    <small class="invalid-feedback name_err"></small>
  </div>
</div>