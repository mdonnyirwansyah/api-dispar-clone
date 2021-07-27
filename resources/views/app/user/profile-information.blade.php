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
              <li class="nav-item">
                <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
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
              <div class="form-group row align-items-center">
                <label for="roles" class="form-control-label col-sm-3 text-md-right">Roles</label>
                <div class="col-sm-6 col-md-9">
                  <input type="text" class="form-control" id="roles" value="{{ old('roles') ?? Auth::user()->roles()->get()->implode('name', ', ') }}" readonly>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="gender" class="form-control-label col-sm-3 text-md-right">Gender</label>
                <div class="col-sm-6 col-md-9">
                    <div class="d-flex @error('gender', 'updateProfileInformation') is-invalid @enderror">
                        <div class="custom-control custom-radio mr-5">
                            <input type="radio" class="custom-control-input @error('gender', 'updateProfileInformation') is-invalid @enderror" name="gender" id="Male" value="Male" @isset(Auth::user()->userDetail->gender) @if (Auth::user()->userDetail->gender == 'Male') checked @endif @endisset>
                            <label class="custom-control-label" for="Male">Male</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input @error('gender', 'updateProfileInformation') is-invalid @enderror" name="gender" id="Female" value="Female" @isset(Auth::user()->userDetail->gender) @if (Auth::user()->userDetail->gender == 'Female') checked @endif @endisset>
                            <label class="custom-control-label" for="Female">Female</label>
                        </div>
                    </div>
                    @error('gender', 'updateProfileInformation')
                    <span class="invalid-feedback" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                    @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="phone" class="form-control-label col-sm-3 text-md-right">Phone</label>
                <div class="col-sm-6 col-md-9">
                  <input type="text" name="phone" class="form-control @error('phone', 'updateProfileInformation') is-invalid @enderror" id="phone" value="{{ old('phone') ?? Auth::user()->userDetail->phone ?? '' }}">
                  @error('phone', 'updateProfileInformation')
                  <span class="invalid-feedback" role="alert">
                      <small>{{ $message }}</small>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="country" class="form-control-label col-sm-3 text-md-right">Country</label>
                <div class="col-sm-6 col-md-9">
                  <input type="text" name="country" class="form-control @error('country', 'updateProfileInformation') is-invalid @enderror" id="country" value="{{ old('country') ?? Auth::user()->userDetail->country ?? '' }}">
                  @error('country', 'updateProfileInformation')
                  <span class="invalid-feedback" role="alert">
                      <small>{{ $message }}</small>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="city" class="form-control-label col-sm-3 text-md-right">City</label>
                <div class="col-sm-6 col-md-9">
                  <input type="text" name="city" class="form-control @error('city', 'updateProfileInformation') is-invalid @enderror" id="city" value="{{ old('city') ?? Auth::user()->userDetail->city ?? '' }}">
                  @error('city', 'updateProfileInformation')
                  <span class="invalid-feedback" role="alert">
                      <small>{{ $message }}</small>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="address" class="form-control-label col-sm-3 text-md-right">Address</label>
                <div class="col-sm-6 col-md-9">
                  <input type="text" name="address" class="form-control @error('address', 'updateProfileInformation') is-invalid @enderror" id="address" value="{{ old('address') ?? Auth::user()->userDetail->address ?? '' }}">
                  @error('address', 'updateProfileInformation')
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
