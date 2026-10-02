<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — Library MS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #b7c2d4 0%, #312e81 100%);
            display: flex; align-items: center; justify-content: center;
            padding: 1rem;
        }
        .login-card { max-width: 960px; width: 100%; border-radius: 1rem; overflow: hidden; }
        .brand-panel {
            background: linear-gradient(135deg, #353542 0%, #3730a3 100%);
            color: #fff;
        }
        @media (max-width: 767.98px) { .brand-panel { display: none !important; } }
    </style>
</head>
<body>

<div class="card login-card shadow-lg border-0">
    <div class="row g-0">

        {{-- LEFT: Branding --}}
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
                    Forgot your<br>password?
                </h2>
                <p class="text-white-50 small mb-0">
                    No problem. Enter your registered email and we'll send you a
                    secure link to reset your password.
                </p>
            </div>
            <small class="text-white-50 mt-5">© {{ date('Y') }} Library Management System</small>
        </div>

        {{-- RIGHT: Form --}}
        <div class="col-md-6 bg-white p-4 p-md-5">

            <div class="d-md-none d-flex align-items-center gap-2 mb-4">
                <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center"
                     style="width:40px;height:40px;font-size:20px;">📚</div>
                <h1 class="h5 fw-bold text-dark mb-0">Library MS</h1>
            </div>

            <h2 class="h4 fw-bold text-dark mb-1">Reset Password</h2>
            <p class="text-muted small mb-4">
                Enter your email and we'll send a reset link.
            </p>

            {{-- Session Status (success message) --}}
            @if (session('status'))
                <div class="alert alert-success small py-2 mb-3">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label fw-medium">Email Address</label>
                    <div class="position-relative">
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="you@example.com"
                               required autofocus>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    <i class="bi bi-envelope me-2"></i> Send Reset Link
                </button>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="small text-decoration-none fw-medium">
                        <i class="bi bi-arrow-left me-1"></i> Back to Login
                    </a>
                </div>
            </form>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>