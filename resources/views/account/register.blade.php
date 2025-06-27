@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<section class="section-login p-3 p-md-4 p-xl-5">
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                <div class="card-login card border border-light-subtle rounded-4">
                    <div class="card-body-login p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="login-title mb-5">
                                    <h2 class="text-center">Register Here</h2>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('account.processRegister') }}" method="POST">
                            @csrf
                            <div class="row gy-3 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') }}">
                                        <label for="name" class="form-label">Name</label>
                                        @error('name')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" value="{{ old('email') }}">
                                        <label for="email" class="form-label">Email</label>
                                        @error('email')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                                        <label for="password" class="form-label">Password</label>
                                        @error('password')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password-confirmation" placeholder="Confirm Password">
                                        <label for="password-confirmation" class="form-label">Confirm Password</label>
                                        @error('password_confirmation')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn-login btn bsb-btn-xl py-3" type="submit">Register Now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <hr class="login-divider mt-5 mb-4 border-secondary-subtle">
                                <div class="login-links d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-center">
                                    <a href="{{ route('account.login') }}" class="link-secondary text-decoration-none "><h5>Click here to login</h5></a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card-body-login -->
                </div> <!-- end card-login -->
            </div>
        </div>
    </div>
</section>

@endsection