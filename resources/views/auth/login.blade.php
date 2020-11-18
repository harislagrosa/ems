@extends('layouts.login')

@section('content')
<!-- Hero Section Begin -->
<section class="hero-section set-bg about-us" style="max-height: 100px">
</section>
<!-- Hero Section End -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5 contact-form ">
            <h2 class="text-center main-text mb-4 font-weight-bold"> Login </h2>
            <form method="POST" action="{{ route('login') }}" class="needs-validation mb-5 mt-5" novalidate>
                @csrf
                <div class="row">
                    @if (session('error'))
                        <div class="col-md-12 mb-3 text-center">
                            <span class="text-danger">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="col-12 mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autofocus id="email" required placeholder="Email Address">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @else
                            <span class="invalid-feedback" role="alert">
                                <strong> Your Email is required </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password" id="password" required placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @else
                            <span class="invalid-feedback" role="alert">
                                <strong>Please Enter your Password</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary w-100  mt-4" type="submit"> Login </button>
            </form>
        </div>
    </div>
</div>
@endsection