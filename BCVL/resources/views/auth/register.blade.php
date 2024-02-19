@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-5">
                <div class="card shadow border border-0 pb-5">
                    <div class="card-header">{{ __('Sign up') }}</div>

                    <div class="card-body ps-5 pe-5">
                        <form method="POST" class="ps-5 pe-5" action="{{ route('register') }}">
                            @csrf

                            <div class="col-md-6 mt-3">
                                <select class="form-select" required name="role" autocomplete="role" autofocus>
                                    <option selected disabled value="">Sign up as</option>
                                    <option>Instructor</option>
                                    <option>Student</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a role.
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                {{-- <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label> --}}

                                <div class="col-md-6 mb-1" style="width: 100%">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" placeholder="Full Name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                {{-- <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> --}}

                                <div class="col-md-6 mb-1" style="width: 100%">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" placeholder="Email">


                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                {{-- <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> --}}

                                <div class="col-md-6 mb-1" style="width: 100%">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" placeholder="Password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                {{-- <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label> --}}

                                <div class="col-md-6 mb-2" style="width: 100%">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="Confirm Password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6" style="width:70%">
                                    <button type="submit" class="btn btn-primary" style="width:50%">
                                        {{ __('Sign Up') }}
                                    </button>
                                </div>
                                <p class="mt-3 text-center">Already have an Account? <a
                                        href="{{ route('login') }}">{{ __('Log in') }}</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
