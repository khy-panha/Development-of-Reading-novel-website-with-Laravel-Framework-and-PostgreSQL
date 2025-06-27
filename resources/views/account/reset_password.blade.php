@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<section class="section-login p-3 p-md-4 p-xl-5">
    <div class="container-login">
        @include('layouts.message')

        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                <div class="card-login card border border-light-subtle rounded-4">
                    <div class="card-body-login p-3 p-md-4 p-xl-5">

                        <div class="row">
                            <div class="col-12">
                                <div class="login-title mb-5">
                                    <h4 class="text-center">Reset Password</h4>
                                    <p class="text-center text-muted small">Enter your new password below.</p>
                                </div>
                            </div>
                        </div>

                        @if($errors->any())
                        <div class="alert-custom-danger mb-4">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        @endif

                        <form method="POST" action="{{ route('account.updatePassword') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ old('email') }}">

                            <div class="row gy-3 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $email) }}" readonly>
                                        <label for="email" class="form-label">Email Address</label>
                                        @error('email')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                        <small class="text-muted">You cannot change your email address.</small>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="New Password" required>
                                        <label for="password" class="form-label">New Password</label>
                                        @error('password')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn-login btn bsb-btn-xl btn-primary py-3">Reset Password</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if (session('success'))
                        <div class="alert-custom-success mt-4">
                            {{ session('success') }}
                        </div>
                        @endif

                    </div> <!-- end card-body-login -->
                </div> <!-- end card-login -->
            </div>
        </div>
    </div>
</section>
@endsection
