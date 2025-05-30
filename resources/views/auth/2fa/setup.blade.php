{{-- @extends('vr-content.user.vsapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Set Up Two-Factor Authentication') }}</div>

                <div class="card-body">
                    <p>1. Install Google Authenticator app on your phone:</p>
                    <ul>
                        <li><a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">Android</a></li>
                        <li><a href="https://apps.apple.com/us/app/google-authenticator/id388497605" target="_blank">iOS</a></li>
                    </ul>

                    <p>2. Scan this QR code with the app:</p>
                    <div class="text-center my-4">
                        <div style="max-width: 300px; margin: 0 auto;">
                            {!! $qrCode !!}
                        </div>
                    </div>

                    <p>3. Or manually enter this key in the app: <strong>{{ $secret }}</strong></p>

                    <form method="POST" action="{{ route('2fa.enable') }}" class="mt-4">
                        @csrf
                        <input type="hidden" name="secret" value="{{ $secret }}">

                        <div class="form-group row">
                            <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Authentication Code') }}</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="off" autofocus>

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enable Two-Factor Authentication') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 --}}

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Хоёр түвшний баталгаажуулалт тохируулах</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .setup-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .security-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .security-icon::before {
            content: '🛡️';
            font-size: 32px;
        }

        .card-header h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
        }

        .card-body {
            padding: 40px 30px;
        }

        .step {
            margin-bottom: 40px;
            padding: 25px;
            border-radius: 15px;
            background: #f8fafc;
            border-left: 4px solid #4f46e5;
            transition: all 0.3s ease;
            position: relative;
        }

        .step:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .step-number {
            position: absolute;
            top: -10px;
            left: 20px;
            background: #4f46e5;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .step-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 15px;
            margin-top: 10px;
        }

        .app-links {
            display: flex;
            gap: 15px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .app-link {
            display: inline-flex;
            align-items: center;
            padding: 12px 20px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .app-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .app-link:hover::before {
            left: 100%;
        }

        .app-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
            color: white;
            text-decoration: none;
        }

        .qr-container {
            text-align: center;
            margin: 25px 0;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .qr-placeholder {
            width: 200px;
            height: 200px;
            margin: 0 auto;
            background: #f3f4f6;
            border: 2px dashed #d1d5db;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #9ca3af;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .secret-key {
            background: #1f2937;
            color: #10b981;
            padding: 15px 20px;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 1.1rem;
            font-weight: bold;
            letter-spacing: 2px;
            text-align: center;
            margin: 15px 0;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .secret-key:hover {
            background: #374151;
            transform: scale(1.02);
        }

        .copy-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            opacity: 0.7;
        }

        .form-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .form-input.error {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .code-input {
            text-align: center;
            letter-spacing: 0.5em;
            font-family: 'Courier New', monospace;
            font-size: 1.2rem;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 8px;
            display: flex;
            align-items: center;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .error-message::before {
            content: '⚠️';
            margin-right: 8px;
        }

        .submit-btn {
            width: 100%;
            padding: 18px 24px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .loading {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .submit-btn.submitting .loading {
            display: inline-block;
        }

        .submit-btn.submitting {
            pointer-events: none;
            opacity: 0.8;
        }

        .warning-box {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-top: 30px;
            text-align: center;
            font-weight: 500;
        }

        .warning-box::before {
            content: '⚡';
            font-size: 1.5rem;
            display: block;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .container {
                margin: 0 10px;
            }

            .card-body {
                padding: 30px 20px;
            }

            .step {
                padding: 20px 15px;
                margin-bottom: 30px;
            }

            .app-links {
                justify-content: center;
            }

            .secret-key {
                font-size: 0.9rem;
                letter-spacing: 1px;
                word-break: break-all;
            }
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip-text {
            visibility: hidden;
            width: 120px;
            background-color: #1f2937;
            color: white;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            font-size: 0.8rem;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="setup-card">
            <div class="card-header">
                <div class="security-icon"></div>
                <h1>Хоёр түвшний баталгаажуулалт тохируулах</h1>
                <p>Таны дэнс илүү хамгаалалттай болгоцгооё</p>
            </div>

            <div class="card-body">
                <!-- Step 1: Install App -->
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-title">Google Authenticator апп татаж суулгана уу:</div>
                    <p>Доорх холбоосоор дамжуулан аппыг өөрийн утсанд суулгана уу:</p>
                    <div class="app-links">
                        <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2"
                           target="_blank" class="app-link">
                            📱 Android (Google Play)
                        </a>
                        <a href="https://apps.apple.com/us/app/google-authenticator/id388497605"
                           target="_blank" class="app-link">
                            🍎 iOS (App Store)
                        </a>
                    </div>
                </div>

                <!-- Step 2: Scan QR Code -->
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-title">QR кодыг аппаар уншуулна уу:</div>
                    <p>Google Authenticator аппаа нээж, доорх QR кодыг скан хийнэ үү:</p>
                    <div class="qr-container">
                        <div class="qr-placeholder">
                            {!! $qrCode !!}
                        </div>
                        <p style="margin-top: 15px; color: #6b7280; font-size: 0.9rem;">
                            QR код энд харагдана
                        </p>
                    </div>
                </div>

                <!-- Step 3: Manual Entry -->
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-title">Эсвэл гар аргаар түлхүүр оруулна уу:</div>
                    <p>Хэрэв QR код уншуулж чадахгүй бол доорх түлхүүрийг гар аргаар оруулна уу:</p>
                    <div class="tooltip">
                        <div class="secret-key" onclick="copySecret()">
                            {{ $secret }}
                            <span class="copy-icon">📋</span>
                        </div>
                        <span class="tooltip-text">Хуулахын тулд товшино уу</span>
                    </div>
                </div>

                <!-- Step 4: Verification Form -->
                <div class="form-section">
                    <h3 style="margin-bottom: 20px; color: #1f2937;">Баталгаажуулалт хийх</h3>

                    <form id="setupForm" method="POST" action="{{ route('2fa.enable') }}">
    @csrf
    <input type="hidden" name="secret" value="{{ $secret }}">

    <div class="form-section">
        <h3 style="margin-bottom: 20px; color: #1f2937;">Баталгаажуулалт хийх</h3>

        <!-- Code Input -->
        <div class="form-group">
            <label for="code" class="form-label">Баталгаажуулалтын код (6 орон)</label>
            <input
                id="code"
                type="text"
                class="form-input code-input @error('code') error @enderror"
                name="code"
                required
                autocomplete="off"
                autofocus
                maxlength="6"
                placeholder="000000"
            >
            @error('code')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password Input -->
        <div class="form-group">
            <label for="password" class="form-label">Одоогийн нууц үг</label>
            <input
                id="password"
                type="password"
                class="form-input @error('password') error @enderror"
                name="password"
                required
                placeholder="Нууц үгээ оруулна уу"
            >
            @error('password')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">
            🔒 Хоёр түвшний баталгаажуулалт идэвхжүүлэх
        </button>
    </div>
</form>

<!-- Add error display at the top -->
@if($errors->any())
<div class="warning-box" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
    @foreach ($errors->all() as $error)
        <div class="error-message">{{ $error }}</div>
    @endforeach
</div>
@endif
                </div>

                <div class="warning-box">
                    <strong>Анхаарах зүйл:</strong><br>
                    Хоёр түвшний баталгаажуулалт идэвхжсэний дараа нэвтрэх бүрт код шаардлагатай болно.
                    Утсаа алдвал backup кодуудыг хадгалж байгаарай.
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        const form = document.getElementById('setupForm');
        const codeInput = document.getElementById('code');
        const passwordInput = document.getElementById('password');
        const submitBtn = document.getElementById('submitBtn');
        const codeError = document.getElementById('code-error');
        const passwordError = document.getElementById('password-error');

        // Auto-format code input
        codeInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 6) {
                value = value.slice(0, 6);
            }
            e.target.value = value;

            // Clear error state when user starts typing
            if (codeInput.classList.contains('error')) {
                codeInput.classList.remove('error');
                codeError.style.display = 'none';
            }
        });

        // Clear password error on input
        passwordInput.addEventListener('input', function() {
            if (passwordInput.classList.contains('error')) {
                passwordInput.classList.remove('error');
                passwordError.style.display = 'none';
            }
        });

        // Form submission
form.addEventListener('submit', async function(e) {
    e.preventDefault();

    let isValid = true;

    // Validate inputs
    const code = codeInput.value.trim();
    const password = passwordInput.value.trim();

    if (code.length !== 6 || !/^\d{6}$/.test(code)) {
        showError(codeInput, codeError, '6 оронтой тоо оруулна уу');
        isValid = false;
    }

    if (password.length === 0) {
        showError(passwordInput, passwordError, 'Нууц үг оруулна уу');
        isValid = false;
    }

    if (!isValid) return;

    submitBtn.classList.add('submitting');
    submitBtn.querySelector('.btn-text').textContent = '🔄 Тохируулж байна...';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                code: code,
                password: password,
                secret: form.querySelector('input[name="secret"]').value
            })
        });

        if (response.ok) {
            submitBtn.querySelector('.btn-text').textContent = '✅ Амжилттай идэвхжлээ!';
            submitBtn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 1500);
        } else {
            showError(codeInput, codeError, 'Буруу код эсвэл нууц үг');
            resetSubmitButton();
        }
    } catch (error) {
        console.error(error);
        showError(codeInput, codeError, 'Сүлжээний алдаа.');
        resetSubmitButton();
    }
});

        function showError(input, errorElement, message) {
            input.classList.add('error');
            errorElement.textContent = message;
            errorElement.style.display = 'flex';
            input.focus();
        }

        function resetSubmitButton() {
            submitBtn.classList.remove('submitting');
            submitBtn.querySelector('.btn-text').textContent = '🔒 Хоёр түвшний баталгаажуулалт идэвхжүүлэх';
        }

        function copySecret() {
            const secretText = 'MFRGG43FMVZWK5DJNQYWMKBAEJRDAMBQ';
            navigator.clipboard.writeText(secretText).then(() => {
                // Show temporary success message
                const secretKey = document.querySelector('.secret-key');
                const originalText = secretKey.innerHTML;
                secretKey.innerHTML = '✅ Хуулагдлаа!';
                secretKey.style.background = '#10b981';

                setTimeout(() => {
                    secretKey.innerHTML = originalText;
                    secretKey.style.background = '#1f2937';
                }, 2000);
            }).catch(() => {
                // Fallback for older browsers
                alert('Түлхүүр: ' + secretText);
            });
        }

        // Add some interactive animations
        document.querySelectorAll('.step').forEach((step, index) => {
            step.style.animationDelay = `${index * 0.1}s`;
            step.style.animation = 'slideUp 0.6s ease-out forwards';
        });
    </script> --}}
</body>
</html>
