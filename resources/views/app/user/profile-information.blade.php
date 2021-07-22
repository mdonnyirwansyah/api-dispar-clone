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
    <div class="section-header-back">
      <a href="{{ route('dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Profile Information</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Profile Information</div>
    </div>
  </div>
  <div class="section-body">
    <h2 class="section-title">All About Profile Information</h2>
    <p class="section-lead">You can adjust all profile information here.</p>

    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h4 class="text-dark">Jump To</h4>
          </div>
          <div class="card-body">
            <ul class="nav nav-pills flex-column">
              <li class="nav-item">
                <a href="{{ route('user-profile-information') }}" class="nav-link active">Profile Information</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user-password') }}" class="nav-link text-dark">Update Password</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user-two-factor-authentication') }}" class="nav-link text-dark">Two Factor Authentication</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <form method="POST" action="{{ route('user-profile-information.update') }}">
          @method('PUT')
          @csrf
          <div class="card" id="settings-card">
            <div class="card-body">
              <div class="form-group row align-items-center">
                <label for="email" class="form-control-label col-sm-3 text-md-right">Email</label>
                <div class="col-sm-6 col-md-9">
                  <input type="text" name="email" class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror" id="email" value="{{ old('email') ?? Auth::user()->email }}">
                  @error('email', 'updateProfileInformation')
                  <span class="invalid-feedback" role="alert">
                      <small>{{ $message }}</small>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="name" class="form-control-label col-sm-3 text-md-right">Name</label>
                <div class="col-sm-6 col-md-9">
                  <input type="text" name="name" class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror" id="name" value="{{ old('name') ?? Auth::user()->name }}">
                  @error('name', 'updateProfileInformation')
                  <span class="invalid-feedback" role="alert">
                      <small>{{ $message }}</small>
                  </span>
                  @enderror
                </div>
              </div>
            </div>
            <div class="card-footer bg-whitesmoke text-md-right">
              <button class="btn btn-primary" type="submit">Save Changes</button>
              <button class="btn btn-secondary" type="reset">Reset</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection