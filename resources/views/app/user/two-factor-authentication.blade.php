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
        <div class="d-md-flex justify-content-md-between">
            <div class="card col-md-5">
                <div class="card-body">                        
                    <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-form-label text-muted text-justify col-12">When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.</label>
                            <label class="col-form-label col-8">Two Factor Authentication</label>
                            <div class="col-4">
                                @if (Auth::user()->two_factor_secret)
                                @method('DELETE')
                                <button class="btn btn-sm btn-block btn-danger" type="submit">Disable</button>
                                @else
                                <button class="btn btn-sm btn-block btn-success" type="submit">Enable</button>
                                @endif
                            </div>
                        </div>
                        @if (Auth::user()->two_factor_secret)
                        <div class="form-group row">
                            <label class="col-form-label text-muted text-justify col-12">Two factor authentication is now <span class="text-success font-weight-bold"><u><strong>enabled</strong></u></span>. Scan the following QR Code using your phone's authenticator application.</label>
                            <label class="col-form-label col-4">Scan QR Code: </label>
                            <div class="col-8 d-flex justify-content-end pt-md-2 pt-1">
                                {!! Auth::user()->twoFactorQrCodeSvg() !!}
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            @if (Auth::user()->two_factor_secret)
            <div class="card col-md-6">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-form-label col-md-5">Recovery Codes: </label>
                        <div class="col-md-7 pt-1">
                            <ol>
                                @foreach (Auth::user()->recoveryCodes() as $recoveryCode)
                                <li>{{ $recoveryCode }}</li>
                                @endforeach
                            </ol>
                        </div>
                        <label class="col-form-label text-muted text-justify col-12">Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.</label>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection