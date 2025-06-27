@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<section class="section-login p-3 p-md-4 p-xl-5">
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                @include('layouts.message')
                <div class="card-login card border border-light-subtle rounded-4">
                    <div class="card-body-login p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="login-title mb-5">
                                    <h2 class="text-center">Login Here</h2>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('account.authenticate')}}" method="POST">
                            @csrf
                            <div class="row gy-3 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input value="{{ old('email') }}" type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com">
                                        <label for="email" class="form-label">Email</label>
                                        @error('email')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                                        <label for="password" class="form-label">Password</label>
                                        @error('password')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn-login btn bsb-btn-xl btn-primary py-3" type="submit">Log In Now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <hr class="login-divider mt-5 mb-4 border-secondary-subtle">
                                <div class="login-links d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-center">
                                    <a href="{{ route('account.register') }}" class="link-secondary text-decoration-none"><h5>Create new account</h5></a>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                    <a href="{{ route('account.forgotPassword') }}" class="text-decoration-none small"><h5>Forgot your password?</h5></a>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
