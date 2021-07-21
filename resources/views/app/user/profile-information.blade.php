@extends('layouts.app')

@section('title', 'Profile Information')

@push('javascript')
@if(session()->has('status'))
<script>
  toastr.success("{{ __('Profile Information has been updated') }}", 'Congratulations,');
</script>
@endif
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Profile Information</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Profile Information</div>
    </div>
  </div>
  <div class="section-body">
    <h2 class="section-title">Profile Information</h2>
    <p class="section-lead">This page is for managing profile information.</p>
    <div class="card">
      <form method="POST" action="{{ route('user-profile-information.update') }}">
        @method('PUT')
        @csrf
        <div class="card-body">
          <div class="row">                               
            <div class="form-group col-md-6 col-12">
              <label for="name">Name</label>
              <input type="text" class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror" name="name" id="name" value="{{ old('name') ?? Auth::user()->name }}">
              @error('name', 'updateProfileInformation')
              <span class="invalid-feedback" role="alert">
                  <small>{{ $message }}</small>
              </span>
              @enderror
            </div>
            <div class="form-group col-md-6 col-12">
              <label for="email">Email</label>
              <input type="text" class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror" name="email" id="email" value="{{ old('email') ?? Auth::user()->email }}">
              @error('email', 'updateProfileInformation')
              <span class="invalid-feedback" role="alert">
                  <small>{{ $message }}</small>
              </span>
              @enderror
            </div>
          </div>
        </div>
        <div class="card-footer text-right bg-whitesmoke">
            <button class="btn btn-primary" type="submit">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection