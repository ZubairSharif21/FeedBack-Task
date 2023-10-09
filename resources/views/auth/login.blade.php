
@extends('layouts.front.layout')
@section('title')
    Login Page
@endsection

@section('content')
    <section class="vh-100">
        <div class="container-fluid h-custom h-75 mt-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf


                        {{-- @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <p>{{ $errors->first() }}</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif --}}


                        <div class="text-center mb-4">
                            <h2>User Login</h2>
                            <div class="border-top"></div>
                        </div>
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label for="email" class="col-md-4 col-form-label ">{{ __('Email Address') }}</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror



                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label for="password" class="col-md-4 col-form-label ">{{ __('Password') }}</label>


                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror






            <div class="d-flex mb-3">
                <div class="col-md-6 mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
               <div class="">
                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
               </div>

            </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">{{ __('Login') }}</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ route('register') }}"
                                    class="link-danger">{{ __('Register') }}</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>











@endsection






