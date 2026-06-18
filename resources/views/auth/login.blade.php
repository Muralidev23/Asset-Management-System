<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — AssetFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
        }

        /* Left Panel */
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, #1e1b4b 0%, #0f172a 50%, #0c4a6e 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 48px;
            position: relative;
            overflow: hidden;
        }
        .auth-left::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,.25) 0%, transparent 70%);
            top: -100px; left: -100px;
        }
        .auth-left::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(6,182,212,.2) 0%, transparent 70%);
            bottom: -100px; right: -80px;
        }
        .auth-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 56px;
            position: relative; z-index: 1;
        }
        .auth-logo-icon {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            color: #fff;
            box-shadow: 0 8px 24px rgba(99,102,241,.5);
        }
        .auth-logo-text { font-size: 1.6rem; font-weight: 800; color: #f8fafc; letter-spacing: -.5px; }
        .auth-left-content { position: relative; z-index: 1; max-width: 380px; }
        .auth-left-content h2 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #f8fafc;
            line-height: 1.2;
            margin-bottom: 16px;
        }
        .auth-left-content h2 span { 
            background: linear-gradient(90deg, #a5b4fc, #67e8f9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .auth-left-content p { font-size: .9rem; color: #94a3b8; line-height: 1.7; margin-bottom: 36px; }

        .feature-list { list-style: none; }
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: .85rem;
            color: #cbd5e1;
            margin-bottom: 14px;
        }
        .feature-list li .fi {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: rgba(255,255,255,.08);
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem;
            flex-shrink: 0;
        }

        /* Right Panel */
        .auth-right {
            width: 480px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 48px;
        }
        .auth-form-wrap { width: 100%; }
        .auth-form-wrap h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .auth-form-wrap .auth-sub { font-size: .85rem; color: #64748b; margin-bottom: 32px; }

        .form-group { margin-bottom: 18px; }
        .form-label { font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: 7px; display: block; }
        .input-wrap {
            position: relative;
        }
        .input-wrap .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: .85rem;
            pointer-events: none;
        }
        .input-wrap input {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: .65rem 1rem .65rem 2.6rem;
            font-size: .875rem;
            font-family: 'Poppins', sans-serif;
            color: #0f172a;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .input-wrap input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.15);
        }
        .input-wrap input.is-invalid { border-color: #ef4444; }
        .invalid-feedback { font-size: .75rem; color: #ef4444; margin-top: 5px; display: block; }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .form-check-label { font-size: .8rem; color: #64748b; cursor: pointer; }
        .form-check-input:checked { background-color: #6366f1; border-color: #6366f1; }
        .forgot-link { font-size: .8rem; color: #6366f1; text-decoration: none; font-weight: 500; }
        .forgot-link:hover { text-decoration: underline; }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none;
            border-radius: 10px;
            padding: .75rem;
            font-size: .9rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(99,102,241,.4);
            transition: all .2s;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #4f46e5, #3730a3);
            box-shadow: 0 6px 20px rgba(99,102,241,.5);
            transform: translateY(-1px);
        }

        .auth-divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }
        .auth-divider::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            width: 100%; height: 1px;
            background: #e2e8f0;
        }
        .auth-divider span {
            position: relative;
            background: #f8fafc;
            padding: 0 12px;
            font-size: .78rem;
            color: #94a3b8;
        }

        .register-link {
            text-align: center;
            font-size: .82rem;
            color: #64748b;
        }
        .register-link a { color: #6366f1; font-weight: 600; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }

        @media (max-width: 900px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; }
            body { background: #f8fafc; }
        }
    </style>
</head>
<body>

    <!-- Left panel -->
    <div class="auth-left d-none d-lg-flex flex-column">
        <div class="auth-logo">
            <div class="auth-logo-icon"><i class="fa-solid fa-layer-group"></i></div>
            <span class="auth-logo-text">AssetFlow</span>
        </div>
        <div class="auth-left-content">
            <h2>Manage your team<br>& assets with <span>precision</span></h2>
            <p>A smart Employee & Asset Management System that helps your organization track, assign, and monitor company resources effortlessly.</p>
            <ul class="feature-list">
                <li>
                    <span class="fi"><i class="fa-solid fa-users" style="color:#a5b4fc"></i></span>
                    Employee onboarding with bulk CSV upload
                </li>
                <li>
                    <span class="fi"><i class="fa-solid fa-laptop" style="color:#67e8f9"></i></span>
                    Asset inventory & assignment tracking
                </li>
                <li>
                    <span class="fi"><i class="fa-solid fa-clock-rotate-left" style="color:#6ee7b7"></i></span>
                    Complete asset history & audit logs
                </li>
                <li>
                    <span class="fi"><i class="fa-solid fa-shield-halved" style="color:#fcd34d"></i></span>
                    Role-based access control
                </li>
            </ul>
        </div>
    </div>

    <!-- Right form panel -->
    <div class="auth-right">
        <div class="auth-form-wrap">

            <h3>Welcome back 👋</h3>
            <p class="auth-sub">Sign in to your AssetFlow account to continue.</p>

            @if (session('status'))
                <div style="background:rgba(16,185,129,.1);color:#065f46;border-radius:8px;padding:12px 16px;font-size:.82rem;margin-bottom:16px;">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
                        <input id="email" type="email" name="email"
                               value="{{ old('email') }}" required autocomplete="email" autofocus
                               placeholder="admin@company.com"
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    </div>
                    @error('email')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                        <input id="password" type="password" name="password"
                               required autocomplete="current-password"
                               placeholder="••••••••"
                               class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                    </div>
                    @error('password')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="remember-row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Sign In
                </button>
            </form>

            @if (Route::has('register'))
                <div class="auth-divider"><span>or</span></div>
                <div class="register-link">
                    New employee? <a href="{{ route('register') }}">Create your account</a>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
