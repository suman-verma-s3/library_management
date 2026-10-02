<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Library Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #57667e 0%, #d4d4da 100%);
        }
        .login-card { max-width: 960px; width: 100%; border-radius: 1rem; overflow: hidden; }
        .brand-panel {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            color: #fff;
        }
        @media (max-width: 767.98px) { .brand-panel { display: none !important; } }

        /* Eye toggle button styling */
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #0c4bc9;
            cursor: pointer;
            padding: 4px;
            line-height: 1;
            z-index: 5;
        }
        .password-toggle:hover { color: #4f46e5; }
        .password-toggle:focus { outline: none; }

        /* Add space so text doesn't hide behind the icon */
        #password { padding-right: 42px; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">

    <div class="card login-card shadow-lg border-0">
        <div class="row g-0">

            <!-- LEFT: Branding -->
            <div class="col-md-6 brand-panel p-5 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="bg-white bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;font-size:24px;">📚</div>
                        <div>
                            <h1 class="h5 fw-bold mb-0">Library MS</h1>
                            <small class="text-white-50">Management System</small>
                        </div>
                    </div>

                    <h2 class="fw-bold mb-3" style="font-size:1.75rem; line-height:1.3;">
                        Welcome back,<br>reader.
                    </h2>
                    <p class="text-white-50 small mb-0">
                        Manage books, students, and borrowing — all in one place.
                        Sign in to continue to your dashboard.
                    </p>
                </div>
                <small class="text-white-50 mt-5">© {{ date('Y') }} Library Management System</small>
            </div>

            <!-- RIGHT: Form -->
            <div class="col-md-6 bg-white p-4 p-md-5">
                <div class="d-md-none d-flex align-items-center gap-2 mb-4">
                    <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center"
                         style="width:40px;height:40px;font-size:20px;">📚</div>
                    <h1 class="h5 fw-bold text-dark mb-0">Library MS</h1>
                </div>

                <h2 class="h4 fw-bold text-dark mb-1">Sign in</h2>
                <p class="text-muted small mb-4">Enter your credentials to access your account.</p>

                <x-auth-session-status class="mb-3" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <x-input-label for="email" :value="__('Email')" class="form-label fw-medium" />
                        <x-text-input id="email"
                                      class="form-control "
                                      type="email" name="email" :value="old('email')"
                                      required autofocus autocomplete="username"
                                      placeholder="you@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="invalid-feedback d-block" />
                    </div>

                    <!-- Password with Eye Toggle -->
                    <div class="mb-3">
                        <x-input-label for="password" :value="__('Password')" class="form-label fw-medium" />
                        <div class="position-relative">
                            <x-text-input id="password"
                                          class="form-control "
                                          type="password" name="password"
                                          required autocomplete="current-password"
                                          placeholder="••••••••" />
                            <button type="button"
                                    class="password-toggle"
                                    id="togglePassword"
                                    aria-label="Show password"
                                    tabindex="-1">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="invalid-feedback d-block" />
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label small text-secondary">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="small text-primary fw-medium text-decoration-none"
                               href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <x-primary-button class="btn btn-primary w-100 py-2 fw-semibold">
                        {{ __('Sign in') }}
                    </x-primary-button>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Password Eye Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn  = document.getElementById('togglePassword');
            const toggleIcon = document.getElementById('toggleIcon');
            const password   = document.getElementById('password');

            if (!toggleBtn || !password) return;

            toggleBtn.addEventListener('click', function () {
                const isPassword = password.type === 'password';
                password.type = isPassword ? 'text' : 'password';

                // Swap icon
                toggleIcon.classList.toggle('bi-eye');
                toggleIcon.classList.toggle('bi-eye-slash');

                // Update accessibility label
                toggleBtn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
            });
        });
    </script>
</body>
</html>