@extends('layouts.app')

@section('title', 'Update Password')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Update Password</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Update Password</div>
    </div>
  </div>
  <div class="section-body">
    <h2 class="section-title">Update Password</h2>
    <p class="section-lead">This page is for managing password.</p>
    <div class="card">
      <form method="POST" action="{{ route('user-password.update') }}">
        @method('PUT')
        @csrf
        <div class="card-body">
          <div class="row">                               
            <div class="form-group col-md-12 col-12">
              <label for="current_password">Current Password</label>
              <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" name="current_password" id="current_password">
              @error('current_password', 'updatePassword')
              <span class="invalid-feedback" role="alert">
                  <small>{{ $message }}</small>
              </span>
              @enderror
            </div>
            <div class="form-group col-md-6 col-12">
              <label for="password">New Password</label>
              <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" name="password" id="password">
              @error('password', 'updatePassword')
              <span class="invalid-feedback" role="alert">
                  <small>{{ $message }}</small>
              </span>
              @enderror
            </div>
            <div class="form-group col-md-6 col-12">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
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