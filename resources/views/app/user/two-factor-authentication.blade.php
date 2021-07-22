@extends('layouts.app')

@section('title', 'Two Factor Authentication')

@push('javascript')
@if(session()->has('status'))
<script>
  toastr.success("{{ __('Two Factor Authentication has been updated') }}", 'Congratulations,');
</script>
@endif
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <div class="section-header-back">
      <a href="features-settings.html" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Two Factor Authentication</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">Two Factor Authentication</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">You Have Enabled Two Factor Authentication</h2>
    <p class="section-lead">Add additional security to your account using two factor authentication.</p>

    <div id="output-status"></div>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h4 class="text-dark">Jump To</h4>
          </div>
          <div class="card-body">
            <ul class="nav nav-pills flex-column">
              <li class="nav-item">
                <a href="{{ route('user-profile-information') }}" class="nav-link text-dark">Profile Information</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user-password') }}" class="nav-link text-dark">Update Password</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user-two-factor-authentication') }}" class="nav-link active">Two Factor Authentication</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-8">
          <div class="card" id="settings-card">
            <div class="card-body">
                <p class="text-muted text-justify">When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.</p>
                <div class="form-group row align-items-center">
                    <label class="form-control-label col-8 col-sm-6 col-md-5 text-sm-right text-md-right">Two Factor Authentication</label>
                    <div class="col-4 col-sm-6 col-md-4">                        
                        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                            @csrf
                            @if (Auth::user()->two_factor_secret)
                            @method('DELETE')
                            <button class="btn btn-sm btn-block btn-danger" type="submit">Disable</button>
                            @else
                            <button class="btn btn-sm btn-block btn-success" type="submit">Enable</button>
                            @endif
                        </form>
                    </div>
                </div>
                @if (Auth::user()->two_factor_secret)
                <p class="text-muted text-justify">Two factor authentication is now <span class="text-success font-weight-bold"><u><strong>enabled</strong></u></span>. Scan the following QR Code using your phone's authenticator application.</p>
                <div class="form-group row align-items-center">
                    <label class="form-control-label pr-0 pr-sm-3 pr-md-4 col-3 col-sm-6 col-sm-4 col-md-5 text-sm-right text-md-right">Scan QR Code</label>
                    <div class="col-9 col-sm-6 col-md-4">
                        {!! Auth::user()->twoFactorQrCodeSvg() !!}
                    </div>
                </div>
                <p class="text-muted text-justify">Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.</p>
                <div class="form-group row">
                    <label class="form-control-label pr-0 pr-sm-3 pr-md-4 col-3 col-sm-6 col-md-5 text-sm-right text-md-right">Recovery Codes</label>
                    <div class="pl-0 col-9 col-sm-6 col-md-6">
                        <ol class="pl-4">
                            @foreach (Auth::user()->recoveryCodes() as $recoveryCode)
                            <li>{{ $recoveryCode }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                @endif
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection