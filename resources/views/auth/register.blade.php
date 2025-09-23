@extends('layouts.app')
@section('content')
    <section class="register-wrapper">
        <!-- Animated Background -->
        <div class="bg-animation">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="shape shape-5"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-11 col-sm-9 col-md-7 col-lg-6 col-xl-5">
                    
                    <!-- Glass Card -->
                    <div class="glass-card">
                        <!-- Header -->
                        <div class="card-header">
                            <div class="logo-container">
                                <img src="{{asset('media/logo/logo.png')}}" alt="Logo" class="logo">
                            </div>
                            <h2 class="welcome-title">Create Account</h2>
                            <p class="welcome-subtitle">Join us today and get started</p>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('register') }}" class="register-form">
                            @csrf
                            
                            <!-- Name Input -->
                            <div class="input-group">
                                <div class="input-wrapper">
                                    <input id="name" 
                                           type="text"
                                           class="modern-input @error('name') error @enderror" 
                                           name="name"
                                           value="{{ old('name') }}" 
                                           required 
                                           autocomplete="name" 
                                           autofocus>
                                    <label for="name" class="input-label">Full Name</label>
                                    <div class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </div>
                                </div>
                                @error('name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email Input -->
                            <div class="input-group">
                                <div class="input-wrapper">
                                    <input id="email" 
                                           type="email"
                                           class="modern-input @error('email') error @enderror" 
                                           name="email"
                                           value="{{ old('email') }}" 
                                           required 
                                           autocomplete="email">
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
                                           autocomplete="new-password">
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

                            <!-- Confirm Password Input -->
                            <div class="input-group">
                                <div class="input-wrapper">
                                    <input id="password-confirm" 
                                           type="password"
                                           class="modern-input" 
                                           name="password_confirmation"
                                           required 
                                           autocomplete="new-password">
                                    <label for="password-confirm" class="input-label">Confirm Password</label>
                                    <div class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M9 12l2 2 4-4"></path>
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                    </div>
                                    <button type="button" class="toggle-password" onclick="togglePassword('password-confirm')">
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
                            </div>

                            <!-- Terms Checkbox -->
                            <div class="form-options">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="terms" required>
                                    <span class="checkmark"></span>
                                    I agree to the <a href="#" class="terms-link">Terms & Conditions</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="submit-btn">
                                <span class="btn-content">
                                    <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="8.5" cy="7" r="4"></circle>
                                        <line x1="20" y1="8" x2="20" y2="14"></line>
                                        <line x1="23" y1="11" x2="17" y2="11"></line>
                                    </svg>
                                    <span class="btn-text">Create Account</span>
                                </span>
                                <div class="btn-loader">
                                    <div class="spinner"></div>
                                </div>
                            </button>
                        </form>

                        <!-- Navigation Links -->
                        <div class="navigation-links">
                            <a href="{{route('login')}}" class="nav-link secondary">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M21 12H3"></path>
                                </svg>
                                Already have an account? Sign In
                            </a>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="nav-link primary">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 2H3a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7l-2 3v-3H3a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h18a2 2 0 0 1 2 2v6"></path>
                                    <line x1="23" y1="13" x2="17" y2="13"></line>
                                    <polyline points="20,10 23,13 20,16"></polyline>
                                </svg>
                                Forgot Password?
                            </a>
                            @endif
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

        .register-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #1e3c72 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 30px 0;
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
            animation: float 8s ease-in-out infinite;
        }

        .shape-1 { width: 90px; height: 90px; top: 15%; left: 8%; animation-delay: 0s; }
        .shape-2 { width: 70px; height: 70px; top: 70%; right: 15%; animation-delay: 2s; }
        .shape-3 { width: 120px; height: 120px; bottom: 15%; left: 25%; animation-delay: 4s; }
        .shape-4 { width: 50px; height: 50px; top: 35%; right: 8%; animation-delay: 1s; }
        .shape-5 { width: 80px; height: 80px; top: 60%; left: 50%; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-25px) rotate(180deg); opacity: 0.6; }
        }

        /* Glass Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 32px 28px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            z-index: 1;
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header */
        .card-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container {
            margin-bottom: 12px;
        }

        .logo {
            width: 65px;
            height: 65px;
            object-fit: contain;
            filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.2));
        }

        .welcome-title {
            color: white;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .welcome-subtitle {
            color: rgba(255, 255, 255, 0.75);
            font-size: 14px;
            margin: 0;
        }

        /* Input Groups */
        .input-group {
            margin-bottom: 16px;
        }

        .input-wrapper {
            position: relative;
        }

        .modern-input {
            width: 100%;
            height: 50px;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            padding: 16px 70px 8px 16px;
            color: white;
            font-size: 14px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .modern-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .modern-input.error {
            border-color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
        }

        .input-label {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.65);
            font-size: 14px;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .modern-input:focus + .input-label,
        .modern-input:not(:placeholder-shown) + .input-label {
            top: 12px;
            font-size: 10px;
            color: rgba(255, 255, 255, 0.85);
        }

        .input-icon {
            position: absolute;
            right: 45px;
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
            font-size: 12px;
            margin-top: 6px;
            display: block;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-3px); }
            75% { transform: translateX(3px); }
        }

        /* Form Options */
        .form-options {
            margin-bottom: 20px;
        }

        .checkbox-container {
            display: flex;
            align-items: flex-start;
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            cursor: pointer;
            user-select: none;
            line-height: 1.4;
        }

        .checkbox-container input {
            display: none;
        }

        .checkmark {
            width: 16px;
            height: 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            border-radius: 3px;
            margin-right: 10px;
            margin-top: 2px;
            position: relative;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .checkbox-container input:checked + .checkmark {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(255, 255, 255, 0.9);
        }

        .checkbox-container input:checked + .checkmark::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 5px;
            height: 8px;
            border: solid #2a5298;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .terms-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: underline;
        }

        .terms-link:hover {
            color: white;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.18), rgba(255, 255, 255, 0.12));
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            margin-bottom: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.22), rgba(255, 255, 255, 0.16));
        }

        .btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
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
            width: 18px;
            height: 18px;
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
            gap: 8px;
            width: 100%;
            height: 46px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
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
                padding: 24px 18px;
                margin: 10px;
                border-radius: 12px;
            }

            .welcome-title {
                font-size: 20px;
            }

            .modern-input {
                height: 48px;
                font-size: 14px;
            }

            .register-wrapper {
                padding: 20px 0;
            }

            .nav-link {
                font-size: 12px;
                height: 44px;
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

        // Form submission and validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.register-form');
            const submitBtn = document.querySelector('.submit-btn');
            
            form.addEventListener('submit', function(e) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            });

            // Password confirmation validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password-confirm');
            
            function validatePasswords() {
                if (confirmPassword.value && password.value !== confirmPassword.value) {
                    confirmPassword.classList.add('error');
                } else {
                    confirmPassword.classList.remove('error');
                }
            }
            
            password.addEventListener('input', validatePasswords);
            confirmPassword.addEventListener('input', validatePasswords);

            // Input validation and animations
            const inputs = document.querySelectorAll('.modern-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
        });
    </script>
@endsection