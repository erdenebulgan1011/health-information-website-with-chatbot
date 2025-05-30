{{-- @extends('vr-content.user.vsapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Two-Factor Authentication') }}</div>

                <div class="card-body">
                    <p>Please enter the authentication code from your Google Authenticator app:</p>

                    <form method="POST" action="{{ route('2fa.validate') }}">
    @csrf

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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify') }}
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
    <title>Хоёр түвшний баталгаажуулалт</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 450px;
        }

        .auth-card {
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
            padding: 30px;
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

        .card-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .security-icon {
            width: 60px;
            height: 60px;
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
            content: '🔐';
            font-size: 24px;
        }

        .card-body {
            padding: 40px 30px;
        }

        .instruction-text {
            text-align: center;
            color: #6b7280;
            margin-bottom: 30px;
            font-size: 1rem;
            line-height: 1.5;
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

        .input-container {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1.1rem;
            text-align: center;
            letter-spacing: 0.5em;
            transition: all 0.3s ease;
            background: #f9fafb;
            font-family: 'Courier New', monospace;
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
            padding: 16px 24px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
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

        .help-text {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .help-link {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .help-link:hover {
            color: #7c3aed;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .container {
                max-width: 100%;
                margin: 0 10px;
            }

            .card-header {
                padding: 25px 20px;
            }

            .card-body {
                padding: 30px 20px;
            }

            .form-input {
                font-size: 1rem;
                padding: 12px 16px;
            }
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
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="card-header">
                <div class="security-icon"></div>
                <h1>Хоёр түвшний баталгаажуулалт</h1>
            </div>

            <div class="card-body">
                <p class="instruction-text">
                    Google Authenticator аппликэйшнээс авсан баталгаажуулалтын кодыг оруулна уу:
                </p>

                <form id="authForm" method="POST" action="{{ route('2fa.validate') }}">
                    @csrf
                    <div class="form-group">
                        <label for="code" class="form-label">Баталгаажуулалтын код</label>
                        <div class="input-container">
                            <input
                                id="code"
                                type="text"
                                class="form-input"
                                name="code"
                                required
                                autocomplete="off"
                                autofocus
                                maxlength="6"
                                pattern="[0-9]{6}"
                                placeholder="000000"
                            >
                            <div id="error-message" class="error-message" style="display: none;">
                                Буруу код оруулсан байна. Дахин оролдоно уу.
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn">
                        <span class="loading"></span>
                        <span class="btn-text">Баталгаажуулах</span>
                    </button>
                </form>
                <div id="error-message" class="error-message" style="display: none;">...</div>
<div id="error-message" style="display: none; color: red;"></div>


                <div class="help-text">
                    Асуудал гарсан уу? <a href="#" class="help-link">Тусламж авах</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('authForm');
        const codeInput = document.getElementById('code');
        const submitBtn = document.getElementById('submitBtn');
        const errorMessage = document.getElementById('error-message');

        // Auto-format input and restrict to numbers only
        codeInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 6) {
                value = value.slice(0, 6);
            }
            e.target.value = value;

            // Clear error state when user starts typing
            if (codeInput.classList.contains('error')) {
                codeInput.classList.remove('error');
                errorMessage.style.display = 'none';
            }
        });

        // Auto-submit when 6 digits are entered
        codeInput.addEventListener('input', function(e) {
            if (e.target.value.length === 6) {
                setTimeout(() => {
                    form.dispatchEvent(new Event('submit'));
                }, 300);
            }
        });

        form.addEventListener('submit', function handleSubmit(e) {
    e.preventDefault();

    const code = codeInput.value.trim();

    if (code.length !== 6 || !/^\d{6}$/.test(code)) {
        showError('6 оронтой тоо оруулна уу');
        return;
    }

    submitBtn.classList.add('submitting');
    submitBtn.querySelector('.btn-text').textContent = 'Шалгаж байна...';

    // Infinite loop-ээс сэргийлэх
    form.removeEventListener('submit', handleSubmit);
    form.submit();
});



        function showError(message) {
            codeInput.classList.add('error');
            errorMessage.textContent = message;
            errorMessage.style.display = 'flex';
            codeInput.focus();
            codeInput.select();
        }

        function resetSubmitButton() {
            submitBtn.classList.remove('submitting');
            submitBtn.querySelector('.btn-text').textContent = 'Баталгаажуулах';
        }

        // Focus input on page load
        window.addEventListener('load', function() {
            codeInput.focus();
        });
    </script>
</body>
</html>
