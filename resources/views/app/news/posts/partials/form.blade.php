@can('is-author', 'is-editor')
<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="title">Title</label>
  <div class="col-sm-12 col-md-7">
      <input type="text" class="form-control form-control-sm" name="title" id="title" @isset($newsPost) value="{{ $newsPost->title }}" @endisset />
      <small class="invalid-feedback title_err"></small>
  </div>
</div>
@endcan

@can('is-editor')
@isset($newsPost)
<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="title_en">Title EN</label>
  <div class="col-sm-12 col-md-7">
      <input type="text" class="form-control form-control-sm" name="title_en" id="title_en" @isset($newsPost) value="{{ $newsPost->title_en }}" @endisset />
      <small class="invalid-feedback title_en_err"></small>
  </div>
</div>
@endisset
@endcan

@can('is-author', 'is-editor')
<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="category">Category</label>
  <div class="col-sm-12 col-md-7">
    <select class="form-control select2" style="width: 100%" name="category" id="category">
      @isset($newsPost)
      @else
      <option value="" selected>Select Category</option>
      @endisset
      @foreach ($newsCategories as $newsCategory)
      <option value="{{ $newsCategory->id }}" @isset($newsPost) @if ($newsPost->category_id == $newsCategory->id) selected @endif @endisset>{{ $newsCategory->name }}</option>
      @endforeach
    </select>
    <small class="invalid-feedback category_err"></small>
  </div>
</div>
<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="content">Content</label>
  <div class="col-sm-12 col-md-7">
    <textarea class="form-control form-control-sm" name="content" id="content">
      @isset($newsPost) {{ $newsPost->content }} @endisset
    </textarea>
    <small class="invalid-feedback content_err"></small>
  </div>
</div>
@endcan

@can('is-editor')
@isset($newsPost)
<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="content_en">Content EN</label>
  <div class="col-sm-12 col-md-7">
    <textarea class="form-control form-control-sm" name="content_en" id="content_en">
      @isset($newsPost) {{ $newsPost->content_en }} @endisset
    </textarea>
    <small class="invalid-feedback content_en_err"></small>
  </div>
</div>
@endisset
@endcan

@can('is-author', 'is-editor')
<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="source">Source</label>
  <div class="col-sm-12 col-md-7">
    <input type="text" class="form-control form-control-sm" name="source" id="source"  @isset($newsPost) value="{{ $newsPost->source }}" @endisset />
    <small class="invalid-feedback source_err"></small>
  </div>
</div>
<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="thumbnail">Thumbnail</label>
  <div class="col-sm-12 col-md-7">
    @isset($newsPost->thumbnail) <img src="{{ asset('storage/'.$newsPost->thumbnail) }}" alt="preview" class="img-fluid img-thumbnail mb-2"> @endisset
    <div class="custom-file" id="thumbnail-input">
      <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail" />
      <label class="custom-file-label" for="customFile">Choose file</label>
    </div>
    <footer class="blockquote-footer">
      The thumbnail must be a file of type:
      <cite title="Source Title">jpg, jpeg, png, webp. And max 2048 kb.</cite>
    </footer>
    <small class="invalid-feedback thumbnail_err"></small>
  </div>
</div>
<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tags</label>
  <div class="col-sm-12 col-md-7">
    <select class="form-control select2" style="width: 100%" name="tags[]" id="tags" multiple>
        @foreach ($tags as $tag)
        <option value="{{ $tag->id }}" @isset($newsPost) @if(in_array($tag->id, $newsPost->tags->pluck('id')->toArray())) selected @endif @endisset>{{ $tag->name }}</option>
        @endforeach
    </select>
  </div>
</div>
@endcan

<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="status">Status</label>
  <div class="col-sm-12 col-md-7">
  <select class="form-control select2" style="width: 100%" name="status" id="status">
    @can('is-author')
    <option value="Draft" @isset($newsPost) @if ($newsPost->status == 'Draft') selected @endif @endisset>Draft</option>
    @endcan
    <option value="Pending" @isset($newsPost) @if ($newsPost->status == 'Pending') selected @endif @endisset>Pending</option>
    <option value="Published" @isset($newsPost) @if ($newsPost->status == 'Published') selected @endif @endisset>Publish</option>
  </select>
  </div>
</div>
<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
  <div class="col-sm-12 col-md-7">
    <button class="btn btn-primary" id="btn">
      @isset($newsPost)
        Save Changes
      @else
        Submit
      @endisset
    </button>
  </div>
</div>
