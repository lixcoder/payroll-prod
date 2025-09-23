@extends('layouts.login')
@section('content')
    <section class="login-wrapper">
        <!-- Animated Background -->
        <div class="bg-animation">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    
                    <!-- Glass Card -->
                    <div class="glass-card">
                        <!-- Header -->
                        <div class="card-header">
                            <div class="logo-container">
                                <img src="{{asset('media/logo/logo.png')}}" alt="Logo" class="logo">
                            </div>
                            <h2 class="welcome-title">Lixnet Technologies</h2>
                            <p class="welcome-subtitle">Sign in to your account</p>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf
                            
                            <!-- Email Input -->
                            <div class="input-group">
                                <div class="input-wrapper">
                                    <input id="email" 
                                           type="email"
                                           class="modern-input @error('email') error @enderror" 
                                           name="email"
                                           value="{{ old('email') }}" 
                                           required 
                                           autocomplete="email" 
                                           autofocus>
                                    <label for="email" class="input-label">Email Address</label>
                                    <div class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="input-group">
                                <div class="input-wrapper">
                                    <input id="password" 
                                           type="password"
                                           class="modern-input @error('password') error @enderror" 
                                           name="password"
                                           required 
                                           autocomplete="current-password">
                                    <label for="password" class="input-label">Password</label>
                                    <div class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <circle cx="12" cy="16" r="1"></circle>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                    </div>
                                    <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                        <svg class="eye-open" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <svg class="eye-closed d-none" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                            <line x1="1" y1="1" x2="23" y2="23"></line>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="form-options">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    Remember me
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-link">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="submit-btn">
                                <span class="btn-content">
                                    <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M21 12H3"></path>
                                    </svg>
                                    <span class="btn-text">Sign In</span>
                                </span>
                                <div class="btn-loader">
                                    <div class="spinner"></div>
                                </div>
                            </button>
                        </form>

                        <!-- Navigation Links -->
                        <div class="navigation-links">
                            <a href="{{url('register')}}" class="nav-link primary">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg>
                                Create New Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        * {
            box-sizing: border-box;
        }

        .login-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #1e3c72 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 10px 0;
        }

        /* Animated Background Shapes */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 20%;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .shape-4 {
            width: 40px;
            height: 40px;
            top: 40%;
            right: 10%;
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Glass Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 36px 28px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            z-index: 1;
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .card-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo-container {
            margin-bottom: 16px;
        }

        .logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }

        .welcome-title {
            color: white;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 6px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .welcome-subtitle {
            color: rgba(255, 255, 255, 0.75);
            font-size: 14px;
            margin: 0;
        }

        /* Input Groups */
        .input-group {
            margin-bottom: 20px;
        }

        .input-wrapper {
            position: relative;
        }

        .modern-input {
            width: 100%;
            height: 52px;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            padding: 18px 45px 8px 18px;
            color: white;
            font-size: 15px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .modern-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .modern-input.error {
            border-color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
        }

        .modern-input::placeholder {
            color: transparent;
        }

        .input-label {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.65);
            font-size: 15px;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .modern-input:focus + .input-label,
        .modern-input:not(:placeholder-shown) + .input-label {
            top: 14px;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.85);
        }

        .input-icon {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .toggle-password:hover {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
        }

        .error-message {
            color: #ff6b6b;
            font-size: 14px;
            margin-top: 8px;
            display: block;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Form Options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-container input {
            display: none;
        }

        .checkmark {
            width: 18px;
            height: 18px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            margin-right: 10px;
            position: relative;
            transition: all 0.3s ease;
        }

        .checkbox-container input:checked + .checkmark {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(255, 255, 255, 0.9);
        }

        .checkbox-container input:checked + .checkmark::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 2px;
            width: 6px;
            height: 10px;
            border: solid #2a5298;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .forgot-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: white;
            text-decoration: underline;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.18), rgba(255, 255, 255, 0.12));
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            margin-bottom: 25px;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.22), rgba(255, 255, 255, 0.16));
        }

        .btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .submit-btn.loading .btn-content {
            opacity: 0;
        }

        .submit-btn.loading .btn-loader {
            opacity: 1;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Navigation Links */
        .navigation-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            height: 50px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .nav-link.primary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
        }

        .nav-link.primary:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateY(-1px);
            text-decoration: none;
        }

        .nav-link.secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
        }

        .nav-link.secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
            transform: translateY(-1px);
            text-decoration: none;
        }

        /* Mobile Responsiveness */
        @media (max-width: 576px) {
            .glass-card {
                padding: 30px 20px;
                margin: 10px;
                border-radius: 15px;
            }

            .welcome-title {
                font-size: 22px;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .nav-link {
                font-size: 14px;
                height: 46px;
            }
        }
    </style>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.parentElement.querySelector('.toggle-password');
            const eyeOpen = button.querySelector('.eye-open');
            const eyeClosed = button.querySelector('.eye-closed');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('d-none');
                eyeClosed.classList.remove('d-none');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('d-none');
                eyeClosed.classList.add('d-none');
            }
        }

        // Form submission with loading state
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.login-form');
            const submitBtn = document.querySelector('.submit-btn');
            
            form.addEventListener('submit', function(e) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            });

            // Input validation and animations
            const inputs = document.querySelectorAll('.modern-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                    if (this.value.trim() !== '') {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                });
            });
        });
    </script>
@endsection