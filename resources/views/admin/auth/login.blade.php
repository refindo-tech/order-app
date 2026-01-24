<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - {{ config('app.name') }}</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f3f4f6;
        }
        .login-form {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.25rem;
            font-weight: 500;
            color: #374151;
        }
        .form-input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .btn-primary {
            width: 100%;
            background-color: #3b82f6;
            color: white;
            padding: 0.5rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #2563eb;
        }
        .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .alert {
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h1 style="text-align: center; margin-bottom: 2rem; color: #374151; font-size: 1.5rem;">
                Admin Login
            </h1>

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-input" 
                           value="{{ old('email') }}" 
                           required>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-input" 
                           required>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-primary">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>