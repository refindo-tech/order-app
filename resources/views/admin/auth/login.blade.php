@extends('admin.layouts.auth')

@section('title', 'Login Admin')

@section('content')
<div class="peers ai-s fxw-nw h-100vh">
    <!-- Left Side - Background Image -->
    <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv" 
         style='background-image: url("{{ asset('adminator/assets/static/images/bg.jpg') }}")'>
        <div class="pos-a centerXY">
            <div class="bgc-white bdrs-50p pos-r" style="width: 120px; height: 120px;">
                <img class="pos-a centerXY logo-auth" 
                     src="{{ asset('adminator/assets/static/images/logo.svg') }}" 
                     alt="{{ config('app.name') }}" 
                     style="max-width: 60px; max-height: 60px;">
            </div>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style="min-width: 320px;">
        <div class="text-center mB-40">
            <h4 class="fw-300 c-grey-900 mB-5">Admin Login</h4>
            <p class="c-grey-600 mB-0">{{ config('app.name') }}</p>
        </div>

        <!-- Error Messages -->
        @if(session('error'))
            <div class="alert alert-danger mB-20">
                <i class="ti-alert-triangle mR-10"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            
            <div class="mb-3">
                <label class="text-normal text-dark form-label">Email Address</label>
                <input type="email" 
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       placeholder="admin@order-app.com"
                       value="{{ old('email') }}" 
                       required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="text-normal text-dark form-label">Password</label>
                <input type="password" 
                       name="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       placeholder="Password"
                       required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="peers ai-c jc-sb fxw-nw">
                    <div class="peer">
                        <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                            <input type="checkbox" 
                                   id="remember" 
                                   name="remember" 
                                   class="peer"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="peers peer-greed js-sb ai-c form-label">
                                <span class="peer peer-greed">Remember Me</span>
                            </label>
                        </div>
                    </div>
                    <div class="peer">
                        <button type="submit" class="btn btn-primary btn-color">
                            <i class="ti-lock mR-5"></i>
                            Login
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom styles for better UX */
    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .alert {
        border: 1px solid transparent;
        border-radius: 0.25rem;
        padding: 0.75rem 1.25rem;
    }
    
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    
    .btn-color:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>
@endpush