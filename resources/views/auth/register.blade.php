<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register — AssetFlow</title>
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
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0c4a6e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .register-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 24px 80px rgba(0,0,0,.35);
            width: 100%;
            max-width: 760px;
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            padding: 32px 40px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .register-header-icon {
            width: 52px; height: 52px;
            background: rgba(255,255,255,.2);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            color: #fff;
        }
        .register-header h2 { font-size: 1.4rem; font-weight: 700; color: #fff; margin: 0; }
        .register-header p  { font-size: .82rem; color: rgba(255,255,255,.75); margin: 3px 0 0; }

        .register-body { padding: 36px 40px; }

        .section-label {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #6366f1;
            border-left: 3px solid #6366f1;
            padding-left: 10px;
            margin-bottom: 20px;
        }
        .section-divider { border: none; border-top: 1px solid #f1f5f9; margin: 26px 0; }

        .form-label { font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: 6px; display: block; }
        .required-star { color: #ef4444; }
        .form-control, .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 9px;
            font-size: .875rem;
            font-family: 'Poppins', sans-serif;
            padding: .6rem .9rem;
            transition: border-color .2s, box-shadow .2s;
            color: #0f172a;
        }
        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.15);
            outline: none;
        }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-msg { font-size: .75rem; color: #ef4444; margin-top: 5px; display: block; }

        .btn-register {
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
            margin-top: 8px;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #4f46e5, #3730a3);
            box-shadow: 0 6px 20px rgba(99,102,241,.5);
            transform: translateY(-1px);
        }
        .login-link { text-align: center; margin-top: 18px; font-size: .82rem; color: #64748b; }
        .login-link a { color: #6366f1; font-weight: 600; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }

        .form-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
            position: absolute; top: 22px; left: 24px;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <!-- Header -->
        <div class="register-header">
            <div class="register-header-icon"><i class="fa-solid fa-user-plus"></i></div>
            <div>
                <h2>Employee Self Registration</h2>
                <p>Create your account and set up your employee profile</p>
            </div>
        </div>

        <!-- Body -->
        <div class="register-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Account Credentials -->
                <div class="section-label"><i class="fa-solid fa-lock me-1"></i> Account Credentials</div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="name">Full Name <span class="required-star">*</span></label>
                        <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               name="name" value="{{ old('name') }}" required autofocus placeholder="e.g. John Doe">
                        @error('name') <span class="invalid-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="email">Email Address <span class="required-star">*</span></label>
                        <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               name="email" value="{{ old('email') }}" required placeholder="john.doe@company.com">
                        @error('email') <span class="invalid-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="password">Password <span class="required-star">*</span></label>
                        <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               name="password" required placeholder="Min. 8 characters">
                        @error('password') <span class="invalid-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="password-confirm">Confirm Password <span class="required-star">*</span></label>
                        <input id="password-confirm" type="password" class="form-control"
                               name="password_confirmation" required placeholder="Re-enter password">
                    </div>
                </div>

                <hr class="section-divider">

                <!-- Employee Profile -->
                <div class="section-label"><i class="fa-solid fa-id-card me-1"></i> Employee Profile</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="emp_id">Employee ID <span class="required-star">*</span></label>
                        <input id="emp_id" type="text" class="form-control {{ $errors->has('emp_id') ? 'is-invalid' : '' }}"
                               name="emp_id" value="{{ old('emp_id') }}" required placeholder="e.g. EMP-001">
                        @error('emp_id') <span class="invalid-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="doj">Date of Joining <span class="required-star">*</span></label>
                        <input id="doj" type="date" class="form-control {{ $errors->has('doj') ? 'is-invalid' : '' }}"
                               name="doj" value="{{ old('doj') }}" required>
                        @error('doj') <span class="invalid-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="department">Department <span class="required-star">*</span></label>
                        <input id="department" type="text" class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}"
                               name="department" value="{{ old('department') }}" required placeholder="e.g. Technology">
                        @error('department') <span class="invalid-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="designation">Designation <span class="required-star">*</span></label>
                        <input id="designation" type="text" class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}"
                               name="designation" value="{{ old('designation') }}" required placeholder="e.g. Software Engineer">
                        @error('designation') <span class="invalid-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="emp_role">Role / Specialty <span class="required-star">*</span></label>
                        <input id="emp_role" type="text" class="form-control {{ $errors->has('emp_role') ? 'is-invalid' : '' }}"
                               name="emp_role" value="{{ old('emp_role') }}" required placeholder="e.g. Full Stack Developer">
                        @error('emp_role') <span class="invalid-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="submit" class="btn-register mt-4">
                    <i class="fa-solid fa-user-plus me-2"></i>Register Employee Account
                </button>
            </form>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Sign in here</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
