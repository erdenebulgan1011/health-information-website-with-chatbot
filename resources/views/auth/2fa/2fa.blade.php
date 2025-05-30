<!-- resources/views/diagnostic/2fa.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Diagnostic Results</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background: #f9f9f9;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2d3748;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }
        pre {
            background: #edf2f7;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .info {
            background-color: #ebf8ff;
            border-left: 4px solid #4299e1;
            padding: 10px 15px;
            margin-bottom: 20px;
        }
        .warning {
            background-color: #fffaf0;
            border-left: 4px solid #ed8936;
            padding: 10px 15px;
            margin-bottom: 20px;
        }
        .error {
            background-color: #fff5f5;
            border-left: 4px solid #f56565;
            padding: 10px 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>2FA Diagnostic Results</h1>

        <div class="info">
            <p>These results have also been logged to your Laravel log files for reference.</p>
        </div>

        <pre>{{ implode("\n", $output) }}</pre>

        <div class="warning">
            <h3>Common Issues:</h3>
            <ul>
                <li>The application key might have changed - this would break decryption of existing secrets</li>
                <li>The Google2FAMiddleware might not be registered correctly</li>
                <li>Database schema might not have the required columns (google2fa_secret, google2fa_enabled)</li>
                <li>Session configuration issues preventing proper 2FA state management</li>
            </ul>
        </div>
    </div>
</body>
</html>
